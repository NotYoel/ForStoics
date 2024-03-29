<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller{

    // Redirects to the register page
    public function register() {
        return view('user.register');
    }

    // Redirects to the login page
    public function login() {
        return view('user.login');
    }

    // Redirects to the manage profile page
    public function manage_profile(Request $request) {
        return view('user.profile', [
            'user' => auth()->user(),
            'rank_data' => auth()->user()->getRankData()
        ]);
    }

    public function show(User $user) {
        return view('user.profile', [
            'user' => $user,
            'rank_data' => $user->getRankData()
        ]);
    }

    public function showPosts(User $user) {
        return view('user.posts', [
            'user' => $user,
            'posts' => $user->posts
        ]);
    }

    // Adds a new user/row to the users database
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'unique:users', 'min:3', 'max:25'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'max:24'],
            'profile_picture' => ['mimes:jpeg,png', 'max:5120'] // only accept jpegs and pngs and files <= 5MB
        ]);

        $data['password'] = bcrypt($data['password']);

        if($request->hasFile('profile_picture')){
            // We store profile pictures in: /storage/profile_pictures
            $data['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create($data);

        auth()->login($user);

        return redirect('/');
    }

    // Attempts a login for a user after they've submitted login form data.
    public function attemptLogin(Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($data)) {
            $request->session()->regenerate();

            return redirect('/')->with('flash-message', 'Successfully logged in.');
        }

        /* 
            In the case that the user gets the email (or password) incorrectly, 
            we bring them back to the login page with an error message. 
        */
        return back()->withErrors(['email' => 'Invalid E-mail or password', 'password' => 'Invalid E-mail or password'])->onlyInput('email');
    }

    // Logs the user out
    public function logout() {
        auth()->logout();

        // This is recommended. You should regenerate the user's csrf token once they log out.
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/')->with('flash-message', 'Successfully logged out.');
    }

    // Changes the user's profile picture
    public function changeProfilePicture(Request $request) {
        $data = $request->validate([
            'profile_picture' => ['mimes:jpeg,png', 'max:5120'] // only accept jpegs and pngs and files <= 5MB
        ]);

        // Delete old profile picture from storage (if there is one)
        if($request->user()->profile_picture){
            Storage::disk('public')->delete($request->user()->profile_picture);
        }            

        // Set new profile picture dir
        $data['profile_picture'] = $request->hasFile('profile_picture') ? $request->file('profile_picture')->store('profile_pictures', 'public') : null; // if they didn't upload a new image, we upload null.

        $request->user()->update($data);

        return redirect('/user/manage-profile')->with('flash-message', 'Successfully changed your profile picture.');
    }
}
