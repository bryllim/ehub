<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use SweetAlert;
use Hash;
use App\Notification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changepassword()
    {
        return view('changepassword');
    }

    public function allNotifications()
    {
        $notifications = Notification::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('notifications')->with(['notifications' => $notifications]);
    }

    public function readNotification(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user_id)
                                    ->where('read', false)
                                    ->update(['read' => true]);
        return 1;
    }

    public function passwordchange(Request $request)
    {
        $user = Auth::user();
        
        if(!(Hash::check($request->oldpassword, $user->password))){
            alert()->error(' ', 'Your current password is incorrect.');
            return back();
        }else if($request->newpassword != $request->confirmpassword){
            alert()->error(' ', 'Password does not match.');
            return back();
        }else if((Hash::check($request->newpassword, $user->password))){
            alert()->error(' ', 'New password cannot be the same as your old password.');
            return back();
        }else{
            $user->password = Hash::make($request->newpassword);
            $user->save();

            alert()->success(' ', 'Password successfully changed!');
            return redirect('home');
        }
    }
}
