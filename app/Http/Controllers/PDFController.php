<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use PDF;

class PDFController extends Controller
{
    // public function preview($id)
    // {
    //     $payment = Payment::findorFail($id);
    //     return view('backend.payment.paymentpreview', compact('payment'));
    // }

    public function generatePDF($id)
    {
        $payment = Payment::findorFail($id);
        $pdf = PDF::loadView('backend.payment.paymentpreview', compact('payment'));
        return $pdf->download('payment_invoice.pdf');
    }
}
