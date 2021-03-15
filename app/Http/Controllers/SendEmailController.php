<?php

namespace App\Http\Controllers;

use App\Mail\CeoMail;
use App\Mail\CustomerMail;
use App\Models\MailFiles;
use App\Models\SendEmail;
use App\Models\SentMail;
use Illuminate\Http\Request;

use DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SendEmail::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $editurl = route('admin.mail.edit', $row->id);
                        $showurl = route('admin.mail.show', $row->id);
                        $deleteurl = route('admin.mail.destroy', $row->id);
                        $csrf_token = csrf_token();
                        $btn = "<a href='$showurl' class='edit btn btn-info btn-sm'>View and Send</a>
                                <a href='$editurl' class='edit btn btn-primary btn-sm'>Edit</a>
                               <form action='$deleteurl' method='POST' style='display:inline;'>
                                <input type='hidden' name='_token' value='$csrf_token'>
                                <input type='hidden' name='_method' value='DELETE' />
                                   <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                               </form>
                               ";

                                return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('backend.sendmail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sendmail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $mailformat = SendEmail::create([
            'title' => $data['title'],
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        $mailformat->save();
        return redirect()->route('admin.mail.index')->with('success', 'Mail Format is saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SendEmail  $sendEmail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mailformat = SendEmail::findorFail($id);
        return view('backend.sendmail.show', compact('mailformat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SendEmail  $sendEmail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mailformat = SendEmail::findorFail($id);
        return view('backend.sendmail.edit', compact('mailformat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SendEmail  $sendEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mailformat = SendEmail::findorFail($id);
        $data = $this->validate($request, [
            'title' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $mailformat->update([
            'title' => $data['title'],
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        return redirect()->route('admin.mail.index')->with('success', 'Mail Format is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SendEmail  $sendEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mailformat = SendEmail::findorFail($id);
        $mailformat->delete();

        return redirect()->route('admin.mail.index')->with('success', 'Mail Format is deleted successfully.');
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

            $sentmail = SentMail::create([
                'sent_to' => $email,
                'subject' => $data['subject'],
                'message' => $data['message'],
            ]);
            $sentmail->save();

            $file_name = '';
            if($request->hasfile('files')){
                $files = $request->file('files');
                foreach($files as $file){
                    $file_name = $file->store('mail_files', 'uploads');
                    $realname = $file->getClientOriginalName();

                    $mail_file = MailFiles::create([
                        'mail_id' => $sentmail->id,
                        'file_name' => $file_name,
                        'file_path' => $realname,
                    ]);
                    $mail_file->save();
                }
            }

            $mailings = MailFiles::where('mail_id', $sentmail->id)->get();
            $mailfilespath = [];
            foreach ($mailings as $mails) {
                array_push($mailfilespath, 'uploads/'.$mails->file_name);
            }

            $mailData = [
                'mailto' => $email,
                'message' => $data['message'],
            ];
            $emailto = 'blancmanandhar@gmail.com';

            set_time_limit(300);
            Mail::to($email)->send(new CustomerMail($data, $mailfilespath));
            Mail::to($emailto)->send(new CeoMail($mailData, $mailfilespath));
        }

        return redirect()->back()->with('success', 'Mail has been sent successfully to concerned personal.');
    }
}
