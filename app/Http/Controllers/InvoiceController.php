<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function printInvoice(Request $request)
    {
        $item = $request->input('item');
        $itemTotal = $request->input('itemTotal');
        /*  
  "title" => "Libero quis est rati"
  "subheading" => "Aut corrupti odio d"
  "companyName" => "Quas est tempore ac"
  "companyEmail" => "Iusto id eligendi od"
  "customerName" => "Maxime ad ea consequ"
  "invoiceDate" => "2018-04-17",
  "logo"=>"img",
  "dueDate" => "57",
  "orderNumber" => "Illum maiores sed a"
  "invoiceNumber" => "Quasi labore possimu"
  "footer" => "Impedit tempore ex"
  */

  if (!is_null($item) && is_array($item)) {
   
  
        $Details = array_filter($item, function ($key) {
            return is_string($key);
        }, ARRAY_FILTER_USE_KEY);
    
        $details = [
            "title" => $item['title'] ?? '',
            "subheading" => $item['subheading'] ?? '',
            "companyName" => $item['companyName'] ?? '',
            "companyEmail" => $item['companyEmail'] ?? '',
            "customerName" => $item['customerName'] ?? '',
            "invoiceDate" => $item['invoiceDate'] ?? '',
            "logo" => $item['logo'] ?? '',
            "dueDate" => $item['dueDate'] ?? '',
            "orderNumber" => $item['orderNumber'] ?? '',
            "invoiceNumber" => $item['invoiceNumber'] ?? '',
            "footer" => $item['footer'] ?? '',
        ];
        $itemDetails = array_filter($item, function ($key) {
            return is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);

        return view('components.documents.template.modern', compact('itemTotal', 'Details', 'itemDetails'));
    }
        return view('components.documents.template.modern', compact('itemTotal'));
    }
    
    
}
