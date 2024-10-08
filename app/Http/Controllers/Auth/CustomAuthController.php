<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    //
    public function adualt()
    {
        return view('customAuth.index');
    }

    public function site()
    {
        return view('site');
    }

    public function admin()
    {
        return view('admin');
    }
    public function adminlogin()
    {
        return view('auth.adminLogin');
    }
    public function checkadminlogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email'));
    }
}
