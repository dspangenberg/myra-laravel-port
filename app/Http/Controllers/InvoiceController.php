<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\PdfService;
use Mpdf\MpdfException;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::query()
            ->orderBy('issued_on', 'desc')
            ->orderBy('invoice_number', 'desc')
            ->with('contact')
            ->with('project')
            ->with('lines')
            ->with('payment_deadline')
            ->withSum('lines', 'amount')
            ->withSum('lines', 'tax')
            ->paginate();

        return InvoiceResource::collection($invoices);
    }

    public function store(InvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->validated()));
    }

    /**
     * @throws MpdfException
     */
    public function createPdf(Invoice $invoice)
    {
        $invoice = Invoice::query()
            ->with('contact')
            ->with('project')
            ->with('lines')
            ->with('payment_deadline')
            ->withSum('lines', 'amount')
            ->withSum('lines', 'tax')
            ->where('id', $invoice->id)
            ->first();

        $pdfContent = PdfService::createPdf('invoice', 'pdf.invoice.index', ['invoice' => $invoice], ['pdfA' => true, 'hide' => true]);

        return response($pdfContent);
    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return new InvoiceResource($invoice);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json();
    }
}
