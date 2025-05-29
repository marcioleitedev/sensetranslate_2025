<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generate(Request $request)
    {
        $content = $request->input('content'); // HTML do Quill
        $name = $request->input('name'); // Nome do cliente

        $pdf = Pdf::loadView('pdf.orcamento', [
            'content' => $content,
            'name' => $name,
        ]);

        $fileName = 'orcamento_' . time() . '.pdf';
        $pdfPath = 'orcamentos/' . $fileName;

        Storage::disk('public')->put($pdfPath, $pdf->output());

        return response()->json([
            'url' => asset('storage/' . $pdfPath),
        ]);
    }
}
