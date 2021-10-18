<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginStoreRequest;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        if (auth()->user()) {
            return redirect(route('file.index'));
        } else {
            return view('index');
        }
    }

    /**
     * @param LoginStoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LoginStoreRequest $request)
    {
        if (!auth()->attempt($request->except('_token'))) {
            return back()->withInput()->withErrors(['password' => 'Wrong email or password']);
        }
        return redirect(route('file.index'))->with('success', 'Logged in successfully');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logged out');
    }
}
