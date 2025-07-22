<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    // Menampilkan daftar FAQ
    public function index()
    {
        $data['getRecord'] = Faq::orderBy('id', 'desc')->get();
        $data['header_title'] = 'Daftar FAQ';
        return view('admin.faq.index', $data);
    }

    // Form tambah FAQ
    public function create()
    {
        $data['header_title'] = 'Tambah FAQ';
        return view('admin.faq.create', $data);
    }

    // Simpan data FAQ baru
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect('admin/faq')->with('success', 'FAQ berhasil ditambahkan.');
    }

    // Form edit FAQ
    public function edit($id)
    {
        $faq = Faq::find($id);
        if (!$faq) {
            return redirect('admin/faq')->with('danger', 'FAQ tidak ditemukan.');
        }

        $data['faq'] = $faq;
        $data['header_title'] = 'Edit FAQ';
        return view('admin.faq.edit', $data);
    }

    // Update data FAQ
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq = Faq::find($id);
        if (!$faq) {
            return redirect('admin/faq')->with('danger', 'FAQ tidak ditemukan.');
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect('admin/faq')->with('success', 'FAQ berhasil diperbarui.');
    }

    // Hapus FAQ
    public function destroy($id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            $faq->delete();
            return redirect('admin/faq')->with('success', 'FAQ berhasil dihapus.');
        } else {
            return redirect('admin/faq')->with('danger', 'FAQ tidak ditemukan.');
        }
    }
}