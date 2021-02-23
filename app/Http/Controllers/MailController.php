<?php

namespace App\Http\Controllers;

use App\Mail\CustomerMail;
use App\Models\MailMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function staffmail()
    {
        if(checkpermission(Auth::user()->role_id, 17)){
            $messagetostaff = MailMessage::first();
            return view('backend.MailMessage.staffmail.mail', compact('messagetostaff'));
        }else{
            return redirect()->route('home')->with('failure', 'You do not have permission for this.');
        }
    }

    public function editStaffMessage()
    {
        $messagetostaff = MailMessage::first();
        return view('backend.MailMessage.staffmail.editmessage', compact('messagetostaff'));
    }
    public function editClientMessage()
    {
        $messagetostaff = MailMessage::first();
        return view('backend.MailMessage.staffmail.editClientMessage', compact('messagetostaff'));
    }

    public function editThirdMessage()
    {
        $messagetostaff = MailMessage::first();
        return view('backend.MailMessage.staffmail.editThirdMessage', compact('messagetostaff'));
    }

    public function updatestaffmessage(Request $request)
    {
        $message = MailMessage::first();

        $data = $this->validate($request, [
            'messagetostaff' => 'required',
        ]);
        $message->update([
            'mailtostaff' => $data['messagetostaff'],
        ]);

        return redirect()->route('admin.staffmail')->with('success', 'Mail message updated successfully.');
    }

    public function updateclientmessage(Request $request)
    {
        $message = MailMessage::first();

        $data = $this->validate($request, [
            'messagetoclient' => 'required',
        ]);
        $message->update([
            'mailtoclient' => $data['messagetoclient'],
        ]);

        return redirect()->route('admin.staffmail')->with('success', 'Mail message updated successfully.');
    }

    public function updatethirdmessage(Request $request)
    {
        $message = MailMessage::first();

        $data = $this->validate($request, [
            'messagetothirdparty' => 'required',
        ]);
        $message->update([
            'mailtothirdparty' => $data['messagetothirdparty'],
        ]);

        return redirect()->route('admin.staffmail')->with('success', 'Mail message updated successfully.');
    }

    public function customerEmail(Request $request)
    {
        $total_receiptant = count($request['email']);

        for ($i=0 ; $i < $total_receiptant; $i++) {
            $email = $request['email'][$i];
            $data = $this->validate($request, [
                'subject' => 'required',
                'message' => 'required'
            ]);

            Mail::to($email)->send(new CustomerMail($data));
        }

        return redirect()->route('admin.staffmail')->with('success', 'Mail has been sent successfully to concerned staff.');
    }

    public function clientEmail(Request $request)
    {
        // dd($request['email']);
        $total_receiptant = count($request['email']);

        for ($i=0 ; $i < $total_receiptant; $i++) {
            $email = $request['email'][$i];
            $data = $this->validate($request, [
                'subject' => 'required',
                'message' => 'required'
            ]);

            Mail::to($email)->send(new CustomerMail($data));
        }

        return redirect()->route('admin.staffmail')->with('success', 'Mail has been sent successfully to concerned client.');
    }
    public function thirdpartyEmail(Request $request)
    {
        // dd($request['email']);
        $total_receiptant = count($request['email']);

        for ($i=0 ; $i < $total_receiptant; $i++) {
            $email = $request['email'][$i];
            $data = $this->validate($request, [
                'subject' => 'required',
                'message' => 'required'
            ]);

            Mail::to($email)->send(new CustomerMail($data));
        }

        return redirect()->route('admin.staffmail')->with('success', 'Mail has been sent successfully to concerned personal.');
    }
}
