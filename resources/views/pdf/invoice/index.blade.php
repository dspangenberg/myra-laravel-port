<x-layout :styles="$styles" :footer="$pdf_footer">


    <htmlpageheader name="first_header">
        <div id="recipient">
            {!! nl2br($invoice->address) !!}
        </div>

        <div id="infobox-first-page">
        <table style="font-size: 13px;" >
            <tr>
                <td>
                    Rechnungsdatum:
                </td>
            <td class="right">
                {{ $invoice->issued_on->format('d.m.Y') }}
            </td>
            </tr>
            <tr>
                <td>
                    Rechnungsnummer:&nbsp;&nbsp;
                </td>
                <td class="right">
                    {{ $invoice->formated_invoice_number }}
                </td>
            </tr>
            <tr>
                <td>
                    Kundennummer:&nbsp;&nbsp;
                </td>
                <td class="right">
                    {{ number_format($invoice->contact->debtor_number, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>
                    Seite:&nbsp;&nbsp;
                </td>
                <td class="right">
                    {PAGENO}/{nbpg}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>Leistungszeitraum:&nbsp;&nbsp;
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    01.06.2024 - 30.06.2024
                </td>

            </tr>



        </table>
    </div>
    </htmlpageheader>
    <htmlpageheader name="header">
        <div id="infobox">
            <table style="font-size: 13px;" >
                <tr>
                    <td>
                        Rechnungsdatum:
                    </td>
                    <td class="right">
                        {{ $invoice->issued_on->format('d.m.Y') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Rechnungsnummer:&nbsp;&nbsp;
                    </td>
                    <td class="right">
                        {{ $invoice->formated_invoice_number }}
                    </td>
                </tr>

                <tr>
                    <td>
                        Seite:&nbsp;&nbsp;
                    </td>
                    <td class="right">
                        {PAGENO}/{nbpg}
                    </td>
                </tr>
            </table>
        </div>
    </htmlpageheader>

        <h2>Rechnung</h2>

        <p>
            Sehr geehrte Damen und Herren,
        </p>
        <p>
            wir bedanken uns für die Zusammenarbeit und erlauben uns wie folgt abzurechnen:
        </p>


        <table style="font-size: 13px;" border-spacing="0" cellspacing="0">

            <tr>
                <td style="width:25mm;">Projekt: </td>
                <td style="width:45mm;"><strong>{{$invoice->project->name}}</strong></td>
            </tr>

        </table>
<pagebreak>
        <strong>
            Der Rechnungsbetrag ist ohne Abzug sofort zahlbar.<br/><br/>
        </strong>
        <div style="float: left; width: 2cm;">
            <img src="{{ $invoice->qr_code }}" style="width: 1.5cm;">
        </div>
        <div style="float: left;text-align: justify;">
            Bitte überweisen Sie den Rechnungsbetrag unter Angabe der Rechnungs- und Kundennummer kurzfristig auf
            unser Konto <strong>{{ iban_to_human_format($bank_account->iban) }}</strong> bei der <strong>{{ $bank_account->bank_name }}</strong> ({{ $bank_account->bic }}).<br/><br/>
        </div>





</x-layout>
