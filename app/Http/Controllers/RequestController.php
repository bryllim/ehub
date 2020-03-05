<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ServiceRequest;
use Auth;

class RequestController extends Controller
{
    public function index()
    {
        return view("service");
    }

    public function newRequest()
    {
        return view("newrequest");
    }

    public function storeRequest(Request $request)
    {
        $service = new ServiceRequest;
        $service->title = $request->title;
        $service->description = $request->description;
        $service->deadline = $request->deadline;
        $service->user_id = Auth::user()->id;
        $service->department_id = $request->department;
        $service->status = "Pending";
        $service->save();

        alert()->success(' ', 'Service Request created!');
        return view("service");
    }

}
