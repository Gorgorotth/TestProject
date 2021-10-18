<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        if (auth()->user()){
            return redirect(route('file.index'));
        }
        else {
            return view('index');
        }
    }

    public function store(LoginStoreRequest $request) {

        if (! auth()->attempt($request->except('_token'))){
            return back()->withInput()->withErrors(['password' => 'Wrong email or password']);
        }

        return redirect(route('file.index'))->with('success', 'Logged in successfully');

    }
    public function destroy() {
        auth()->logout();
        return redirect('/')->with('success', 'Logged out');
    }
}
