<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function list()
    {
        $suppliers = SupplierModel::all();
        $data['header_title'] = 'Suplier';
        return view('admin.supplier.list', compact('suppliers'), $data);
    }

    public function add()
    {
        $data['header_title'] = 'Tambah Suplier';
        return view('admin.supplier.add', $data);
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        SupplierModel::create($validated);
        return redirect('admin/supplier/list')->with('success', 'Suplier berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['header_title'] = 'Edit Suplier';
        $supplier = SupplierModel::findOrFail($id);
        return view('admin.supplier.edit', compact('supplier'), $data);
    }

    public function update(Request $request, $id)
    {
        $supplier = SupplierModel::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        $supplier->update($validated);
        return redirect('admin/supplier/list')->with('success', 'Suplier berhasil diperbarui!');
    }

    public function delete($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $supplier->delete();
        return redirect()->back()->with('success', 'Suplier berhasil dihapus!');
    }
}
