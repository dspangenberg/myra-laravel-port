<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\PdfService;
use App\Settings\InvoicingSettings;
use Illuminate\Support\Str;
use MediaUploader;
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
     * @throws MpdfException|\Spatie\TemporaryDirectory\Exceptions\PathAlreadyExists
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

        $bank_account = (object) [
            'iban' => app(InvoicingSettings::class)->invoice_iban,
            'bic' => app(InvoicingSettings::class)->invoice_bic,
            'account_owner' => app(InvoicingSettings::class)->invoice_account_owner,
            'bank_name' => app(InvoicingSettings::class)->invoice_bank_name,
        ];

        if ($invoice->is_draft && $invoice->hasMedia('pdf')) {
            $pdfContent = PdfService::createPdf('invoice', 'pdf.invoice.index', ['invoice' => $invoice, 'bank_account' => $bank_account], ['pdfA' => true, 'hide' => true]);
        } else {
            $media = $invoice->firstMedia('pdf');
            $pdfContent = Str::toBase64($media->contents());
        }

        if (! $invoice->hasMedia('preview')) {
            $pdf = $invoice->firstMedia('pdf');
            $pngFile = PdfService::createPreview($pdfContent);

            $media = MediaUploader::fromSource($pngFile)
                ->toDisk('s3')
                ->toDirectory('Previews/Invocing/Invoices/2021')
                ->makePrivate()
                ->useFilename($pdf->filename.'.png')
                ->upload();

            $invoice->attachMedia($media, 'preview');
        }

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
