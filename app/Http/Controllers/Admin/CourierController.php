<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Courier;

class CourierController extends Controller
{
    public function list()
    {
        $couriers = Courier::all();
        $data['header_title'] = 'Kurir';
        return view('admin.courier.list', compact('couriers'), $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Kurir';
        return view('admin.courier.add', $data);
    }

    public function insert(Request $request)
    {

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'status'  => 'required|in:0,1', // 0 = Aktif, 1 = Nonaktif
        ]);

        Courier::create($validated);

        return redirect('admin/courier/list')->with('success', 'Kurir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['header_title'] = 'Edit Kurir';
        $courier = Courier::findOrFail($id);
        return view('admin.courier.edit', compact('courier'), $data);
    }

    public function update(Request $request, $id)
    {

        $courier = Courier::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'status'  => 'required|in:0,1',
        ]);

        $courier->update($validated);

        return redirect('admin/courier/list')->with('success', 'Kurir berhasil diperbarui!');
    }

    public function delete($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();

        return redirect()->back()->with('success', 'Kurir berhasil dihapus!');
    }
}
