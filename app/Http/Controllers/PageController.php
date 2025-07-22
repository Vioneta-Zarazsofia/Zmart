<?php

namespace App\Http\Controllers;
use App\Models\SystemSettingModel;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ContactUsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\ContactUsMail;

class PageController extends Controller

{
    public function faq()
{
    $faqs = Faq::latest()->get();
    return view('page.faq', compact('faqs'));
}
    public function system_setting()
{
    $data['getRecord'] = SystemSettingModel::getSingle();
    $data['header_title']= 'System Setting';
    return view('admin.setting.system_setting', $data);
}

public function update_system_setting(Request $request)
{
    $save = SystemSettingModel::find(1);

    if (!$save) {
        $save = new SystemSettingModel();
        $save->id = 1;
    }

    $save->website_name = trim($request->website_name);
    $save->footer_description = trim($request->footer_description);
    $save->address = trim($request->address);
    $save->phone = trim($request->phone);
    $save->phone_2 = trim($request->phone_2);
    $save->submit_contact_email = trim($request->submit_contact_email);
    $save->email = trim($request->email);
    $save->email_2 = trim($request->email_2);
    $save->working_hours  = trim($request->working_hours );
    $save->updated_at = now();
    $save->updated_at = now();
    $save->contact_title = trim($request->contact_title);
$save->contact_description = trim($request->contact_description);

if ($request->hasFile('contact_image')) {
    $file = $request->file('contact_image');
    $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
    $file->move('upload/setting/', $filename);
    $save->contact_image = $filename;
}


    // Upload logic tetap
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move('upload/setting/', $filename);
        $save->logo = $filename;
    }

    if ($request->hasFile('favicon')) {
        $file = $request->file('favicon');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move('upload/setting/', $filename);
        $save->favicon = $filename;
    }

    if ($request->hasFile('footer_payment_icon')) {
        $file = $request->file('footer_payment_icon');
        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move('upload/setting/', $filename);
        $save->footer_payment_icon = $filename;
    }

    $save->save();

    return redirect()->back()->with('success', 'System Setting Updated Successfully');
}
public function contact()
{

    $first_number = mt_rand(0,9);
    $second_number = mt_rand(0,9);
    Session::put('total_sum', $first_number + $second_number);


    $data['first_number'] = $first_number;
    $data['second_number'] = $second_number;
    $data['meta_title'] = 'Contact';
    $data['meta_description'] = '';
    $data['meta_keyword'] = '';
    $data['getStemSettingApp'] = SystemSettingModel::getSingle();

    return view('page.contact', $data);
}
public function submit_contact(Request $request)
{
    if(trim($request->verification) && trim(Session::get('total_sum')))
    {
       if(trim(Session::get('total_sum')) == trim($request->verification))
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    $save = new ContactUsModel();
    if (Auth::check()) {
        $save->user_id = Auth::id();
    }
    $save->name = trim($request->name);
    $save->email = trim($request->email);
    $save->phone = trim($request->phone);
    $save->subject = trim($request->subject);
    $save->message = trim($request->message);
    $save->created_at = now();
    $save->updated_at = now();
    $save->save();

    $getStemSettingApp = SystemSettingModel::getSingle();
    $recipient = $getStemSettingApp->submit_contact_email ?? config('mail.from.address');

    try {
        Mail::to($recipient)->send(new ContactUsMail($save));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Pesan berhasil disimpan, tetapi gagal mengirim email.');
    }

    return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
    else
    {
        return redirect()->back()->with('error', 'Verifikasi penjumlahan salah. Silakan coba lagi.');
    }
}
}
public function contactus()
{
    $data['getRecord'] = ContactUsModel::getRecord();
    $data['header_title'] = 'Contact Us';
    return view('admin.contactus.list', $data);
}
public function contactus_delete($id)
{
    ContactUsModel::where('id','=', $id)->delete();
    return redirect()->back()->with('success', 'Data Contact Us berhasil dihapus.');
}
}