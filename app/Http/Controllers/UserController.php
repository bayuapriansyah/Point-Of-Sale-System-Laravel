<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        confirmDelete('Apakah anda yakin menghapus data ini?');
        return view('users.index', compact('users'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.unique' => 'Email sudah digunakan'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password')
        ]);
        toast()->success('User berhasil ditambahkan');
        return redirect()->route('users.index');
    }
    public function edit($id)
    {
        $users = User::find($id);
        return view('users.edit', compact('users'));
    }


    public function destroy($id)
    {
        if (Auth::id() == $id) {
            toast()->error('Tidak dapat menghapus user yang sedang login');
            return redirect()->route('users.index');
        }

        $user = User::find($id);
        $user->delete();
        toast()->success('User berhasil di hapus');
        return redirect()->route('users.index');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid'
        ]);
        $user->update($validatedData);
        toast()->success('User berhasil di update');
        return redirect()->route('users.index');
    }

    public function changePasswordForm()
    {
        return view('users.formchangepassword');
    }

    public function updatePassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',

        ], [
            'password_lama.required' => 'Password lama tidak boleh kosong',
            'password_baru.required' => 'Password baru tidak boleh kosong',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sesuai',
        ]);
        $user = User::find(Auth::id());

        if (!Hash::check($request->password_lama, $user->password)) {
            toast()->error('Password lama tidak sesuai');
            return redirect()->route('users.change-password-form');
        }
        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);
        toast()->success('Password berhasil di update');
        return redirect()->route('dashboard');
    }
}
