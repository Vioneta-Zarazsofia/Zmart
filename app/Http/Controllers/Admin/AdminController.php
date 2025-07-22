<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Admin';
        return view('admin.admin.list', $data);
    }

    public function add()
    {
        $data['header_title'] = 'Add Admin';
        return view('admin.admin.add', $data);
    }
    public function insert(Request $request)
    {
        $request->validate([
            'email'=> 'required|email|unique:users,email',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->is_admin = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin added successfully');
    }

    public function edit($id)
    {
        $data['getRecord'] = User::getSingle($id);
        $data['header_title'] = 'Edit Admin';
        return view('admin.admin.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email'=> 'required|email|unique:users,email,'.$id]);
        $user = User::getSingle($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->is_admin = 1;
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Daata berhasil diperbarui');
    }
    public function delete($id)
    {
        $user = User::getSingle($id);
        if ($user) {
            $user->delete();
            return redirect('admin/admin/list')->with('success','Data berhasil dihapus');
        } else {
            return redirect('admin/admin/list')->with('danger', 'Data tidak ditemukan');
        }
    }

    public function customer_list()
    {
        $data['getRecord'] = User::getCustomer();
        $data['header_title'] = 'Customer';
        return view('admin.customer.list', $data);
    }
    public function customer_delete($id)
    {
        $user = User::getSingle($id);
        if ($user) {
            $user->delete();
            return redirect('admin/customer/list')->with('success','Data berhasil dihapus');
        } else {
            return redirect('admin/customer/list')->with('danger', 'Data tidak ditemukan');
}
    }
}
