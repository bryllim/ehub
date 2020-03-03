<?php

namespace App\Http\Controllers;

use App\Acknowledgement;
use Illuminate\Http\Request;
use Auth;
use App\User;

class AcknowledgementController extends Controller
{
    public function newAcknowledgement(Request $request)
    {
        $acknowledgement = new Acknowledgement;
        $acknowledgement->post_id = $request->post_id;
        $acknowledgement->user_id = Auth::user()->id;
        $acknowledgement->save();        

        return Acknowledgement::where('post_id', '=', $request->post_id)->count();
    }

    public function fetchAcknowledgement(Request $request)
    {
        $acknowledged_users = Acknowledgement::where('post_id', $request->post_id)->get();
        $users = User::all();
    
        $acknowledged = [];
        $unacknowledged = [];
    
        foreach($users as $user){
            if($acknowledged_users->contains('user_id', $user->id)){
                array_push($acknowledged, $user->name);
            }else{
                array_push($unacknowledged, $user->name);
            }
        }
    
        $acknowledgements = [
            'acknowledged'      => $acknowledged,
            'unacknowledged'    => $unacknowledged
        ];
    
        return $acknowledgements;
        
    }
}
