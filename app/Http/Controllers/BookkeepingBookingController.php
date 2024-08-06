<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookkeepingBookingRequest;
use App\Http\Resources\BookkeepingBookingResource;
use App\Models\BookkeepingBooking;

class BookkeepingBookingController extends Controller
{
    public function index()
    {
        $bookings = BookkeepingBooking::with('tax')
            ->with('account_credit')
            ->with('account_debit')
            ->with('range_document_number')
            //->where('account_id_credit', 1800)
            //->orWhere('account_id_debit', 1800)
            ->orderBy('date')
            ->orderBy('id')->paginate(50);

        return BookkeepingBookingResource::collection($bookings);
    }

    public function store(BookkeepingBookingRequest $request)
    {
        return new BookkeepingBookingResource(BookkeepingBooking::create($request->validated()));
    }

    public function show(BookkeepingBooking $bookkeepingBooking)
    {
        return new BookkeepingBookingResource($bookkeepingBooking);
    }

    public function update(BookkeepingBookingRequest $request, BookkeepingBooking $bookkeepingBooking)
    {
        $bookkeepingBooking->update($request->validated());

        return new BookkeepingBookingResource($bookkeepingBooking);
    }

    public function destroy(BookkeepingBooking $bookkeepingBooking)
    {
        $bookkeepingBooking->delete();

        return response()->json();
    }
}
