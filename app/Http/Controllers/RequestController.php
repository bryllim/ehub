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
        return redirect('servicerequests');
    }

    public function viewRequest($id)
    {
        $request = ServiceRequest::findOrFail($id);
        return view('viewrequest')->with(['request' => $request]);
    }

    public function accept($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "In-progress";
        $request->save();
        return back();
    }

    public function decline($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Declined";
        $request->save();
        return back();
    }

    public function complete($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Completed";
        $request->save();
        return back();
    }

    public function cancel($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Cancelled";
        $request->save();
        return back();
    }

}
