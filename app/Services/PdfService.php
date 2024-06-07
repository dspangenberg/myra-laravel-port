<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;
use Mpdf\Config\FontVariables;
use Illuminate\Support\Str;

class PdfService
{
  /**
   * @throws MpdfException
   */
  static public function createPdf(String $layoutName, String $view, Array $data, Array $config): string {

    $layouts = Storage::disk('system')->json('layouts/layouts.json');
    $letterheads = Storage::disk('system')->json('letterheads/letterheads.json');
    $fonts = Storage::disk('system')->json('fonts/fonts.json');

    $layoutsCollection = collect($layouts['layouts']);
    $letterheadsCollection = collect($letterheads['letterheads']);

    $layout = $layoutsCollection->where('name', $layoutName)->first();
    $letterhead = $letterheadsCollection->where('name', $layout['letterhead'])->first();

    $defaultLayoutCss = Storage::disk('system')->get('layouts/default.css');
    $layoutCss = Storage::disk('system')->get('layouts/'.$layout['css-file']);

    $defaultLetterheadCss = Storage::disk('system')->get('letterheads/default.css');
    $letterheadCss = Storage::disk('system')->get('letterheads/'.$letterhead['css-file']);
    $letterheadPdfFile = storage_path('system/letterheads/'.$letterhead['pdf-file']);

    $styles = [
      'layout_default_css' => $defaultLayoutCss,
      'layout_css' => $layoutCss,
      'letterhead_default_css' => $defaultLetterheadCss,
      'letterhead_css' => $letterheadCss
    ];

    $defaultConfig = [
      'title' => '',
      'hide' => false
    ];

    $data['pdf_footer'] = array_merge($defaultConfig, $config);
    $data['styles'] = $styles;
    $html = View::make($view, $data)->render();

    $customFontData = [];
    foreach ($fonts['fonts'] as $value) {
      $customFontData[$value['alias']] = $value['filenames'];
    }

    $tmpDir = storage_path('system/tmp');

    $defaultFontConfig = (new FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new Mpdf([
      'tempDir' => $tmpDir,
      'fontdata' => $fontData + $customFontData
    ]);

    $mpdf->AddFontDirectory(storage_path('system/fonts'));

    $mpdf->SetDocTemplate($letterheadPdfFile,true);
    $mpdf->WriteHTML($html);
    $mpdf->SetTitle( $data['pdf_footer']['title']);
    $mpdf->SetCreator('twiceware_myra');


    $content = $mpdf->Output('', Destination::STRING_RETURN);

    return Str::toBase64($content);
  }
}
