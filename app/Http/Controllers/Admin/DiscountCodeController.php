<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCodeModel;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function list()
    {
        $data['getRecord'] = DiscountCodeModel::getRecord();
        $data['header_title'] = 'Discount Code';
        return view('admin.discountcode.list', $data);
    }
    public function add()
    {
        $data['header_title'] = 'Add New Discount Code';
        return view('admin.discountcode.add', $data);
    }
    public function insert(Request $request)
    {
        $DiscountCode = new DiscountCodeModel;
        $DiscountCode->name = trim($request->name);
        $DiscountCode->type = trim($request->type);
        $DiscountCode->percent_amount = trim($request->percent_amount);
        $DiscountCode->expire_date = trim($request->expire_date);
        $DiscountCode->status = trim($request->status);
        $DiscountCode->save();
        return redirect('admin/discountcode/list')->with('success', 'Discount Code berhasil ditambahkan');
    }
    public function edit($id)
    {
        $data['getRecord'] = DiscountCodeModel::getSingle($id);
        $data['header_title'] = 'Edit Discount Code';
        return view('admin.discountcode.edit', $data);
    }
    public function update($id, Request $request)
    {
        $DiscountCode = DiscountCodeModel::getSingle($id);
        $DiscountCode->name = trim($request->name);
        $DiscountCode->type = trim($request->type);
        $DiscountCode->percent_amount = trim($request->percent_amount);
        $DiscountCode->expire_date = trim($request->expire_date);
        $DiscountCode->status = trim($request->status);
        $DiscountCode->save();
        return redirect('admin/discountcode/list')->with('success', 'Discount Code berhasil diperbarui');
    }
    public function delete($id)
    {
        $DiscountCode = DiscountCodeModel::getSingle($id);
        $DiscountCode->is_delete = 1;
        $DiscountCode->save();
        return redirect()->back()->with('success', 'Discount Code berhasil dihapus');
    }
    
}