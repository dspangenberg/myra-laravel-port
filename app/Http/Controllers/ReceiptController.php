<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Http\Resources\ReceiptResource;
use App\Models\Contact;
use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'list');

        if ($type === 'list') {
            return ReceiptResource::collection(Receipt::query()
                ->with('contact')
                ->with('category')
                ->orderBy('issued_on')
                ->paginate(25)
            );
        } else {
            $creditors = Contact::query()->where('is_debtor', 1)->orderBy('name')->paginate(25);

            $receipts = Receipt::query()
                ->with('contact')
                ->with('category')
                ->whereIn('contact_id', $creditors->select('id')->flatten()->toArray())
                ->orderBy('issued_on', 'asc')
                ->get();

            $groupedReceipts = [];

            $receipts->transform(function ($receipt) {
                $receipt['sort'] = strtoupper($receipt->contact->name);

                return $receipt;
            });

            $creditorNames = $creditors->pluck('name', 'id');

            foreach ($receipts->groupBy('contact.id') as $key => $value) {
                $groupedReceipts[$key]['entries'] = $value;
                $groupedReceipts[$key]['name'] = $creditorNames->get($key);
                $groupedReceipts[$key]['sort'] = strtoupper($creditorNames->get($key));
                $groupedReceipts[$key]['sum_amount_to_pay'] = $value->sum('amount_to_pay');
                $groupedReceipts[$key]['sum_gross'] = $value->sum('gross');
                $groupedReceipts[$key]['sum_net'] = $value->sum('net');
                $groupedReceipts[$key]['sum_tax'] = $value->sum('tax');
                $groupedReceipts[$key]['sum_tax_81'] = $value->where('tax_code_number', 81)->sum('tax');
                $groupedReceipts[$key]['sum_tax_21'] = $value->where('tax_code_number', 21)->sum('tax');
                $groupedReceipts[$key]['sum_tax_67'] = $value->where('tax_code_number', 67)->sum('tax');
                $groupedReceipts[$key]['sum_tax_85'] = $value->where('tax_code_number', 85)->sum('tax');
            }

            return response()->json([
                'grouped' => collect($groupedReceipts)->sortBy('sort', SORT_NATURAL)->values()->all(),
                'meta' => $creditors,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceiptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {

        $receipt->load('contact');
        $receipt->load('category');

        return ReceiptResource::make($receipt);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receipt $receipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        //
    }
}
