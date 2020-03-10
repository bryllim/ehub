<?php

namespace App\Http\Controllers;

use App\Remark;
use Auth;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    public function newRemark(Request $request)
    {
        $remark = new Remark;
        $remark->content = $request->content;
        $remark->request_id = $request->request_id;
        $remark->user_id = Auth::user()->id;
        $remark->save();        
        
        return 1;
    }
}
