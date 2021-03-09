<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Position;
use App\Models\SalaryPayment;
use App\Models\Staff;
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
        $payment = SalaryPayment::findorFail($id);
        $staff = Staff::findorFail($payment->staff_id);
        $multiplying_factor = $staff->allocated_salary / 30;
        $attendance = Attendance::where('monthyear', $payment->monthyear)->where('staff_id', $staff->id)->get();
        $position = Position::findorFail($staff->position_id);
        $pdf = PDF::loadView('backend.payment.paymentpreview', compact('payment', 'multiplying_factor', 'position', 'staff', 'attendance'));
        return $pdf->download('payment_invoice.pdf');
    }
}
