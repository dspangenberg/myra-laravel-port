<x-layout :styles="$styles" :footer="$pdf_footer">

    <div id="recipient">
    {!! nl2br($invoice->address) !!}
    </div>

    <div id="letter">
        <h2>Rechnung</h2>


        <table style="font-size: 13px;" border-spacing="0" cellspacing="0">

            <tr>
                <td style="width:25mm;"><strong>Rechnungsnr.</strong></td>
                <td style="width:45mm;"><strong>{{ $invoice->formated_invoice_number }}</strong></td>
                <td style="width:25mm;">Rechnungsdatum</td>
                <td>{{ $invoice->issued_on->format('d.m.Y') }}</td>

            </tr>

            <tr>
                <td style="width:25mm;"><strong>Kundennr.</strong></td>
                <td style="width:45mm;"><strong>{{ number_format($invoice->contact->debtor_number, 0, ',', '.')}}</strong></td>
                <td style="width:25mm;">Seite</td>
                <td>1/1


                </td>

            </tr>


            <tr>
                <td colspan="2">
                    Bei Zahlung bitte unbedingt angeben.
                </td>
                <td style="width:35mm;">Leistungserbringung</td>
                <td><?=$invoice->service_provision;?></td>
            </tr>

        </table>




        <br/><br/>

    </div>

</x-layout>
