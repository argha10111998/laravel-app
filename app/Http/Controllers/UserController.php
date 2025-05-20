<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function submitRegisterationForm(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'address1' => 'required',
            'address2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        // Save the form data to the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        if($user)
        {

            // dd($user);
            UserProfile::create([
                'user_id' =>  $user->id,
                'address1' => $validatedData['address1'],
                'address2' => $validatedData['address2'],
                'state' => $validatedData['state'],
                'city' => $validatedData['city'],
                'zip' => $validatedData['zip'],
            ]);
        }

        // Redirect to a success page
        return redirect('/registeration')->with('success', 'Registration successful!');
    }

    public function submitLoginForm(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        Auth::guard('admin')->logout(); // Logout admin if logging in as user
        Auth::guard('web')->logout();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'Login successful!');
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Admin logged in!');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }
}
