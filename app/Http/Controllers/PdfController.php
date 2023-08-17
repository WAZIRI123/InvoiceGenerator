<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfController extends Controller
{
public function printPdf(){
    $results=session()->get('results');

    return view('pdf',compact('results'));
}
}
