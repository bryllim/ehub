<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\ServiceRequest;
use Auth;
use App\Remark;
use App\Notification;

class RequestController extends Controller
{
    public function index()
    {
        $completed   = ServiceRequest::where('status', 'Completed')->where('department_id', Auth::user()->department->id)->count();
        $myrequests  = ServiceRequest::where('user_id', Auth::user()->id)->count();
        return view("service")->with(['completed' => $completed, 'myrequests' => $myrequests]);
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
        $remarks = Remark::where('request_id', $id)->get();
        return view('viewrequest')->with(['request' => $request, 'remarks' => $remarks]);
    }

    public function accept($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "In-progress";
        $request->save();
        
        $notification = new Notification;
        $notification->content = Auth::user()->name." accepted your service request.";
        $notification->user_id = $request->user->id;
        $notification->save();

        return back();
    }

    public function decline($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Declined";
        $request->save();

        $notification = new Notification;
        $notification->content = Auth::user()->name." declined your service request.";
        $notification->user_id = $request->user->id;
        $notification->save();

        alert()->success(' ', 'Service Request declined!');
        return redirect('servicerequests');
    }

    public function complete($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Completed";
        $request->save();

        $notification = new Notification;
        $notification->content = Auth::user()->name." completed your service request.";
        $notification->user_id = $request->user->id;
        $notification->save();
        
        alert()->success(' ', 'Service Request completed!');
        return redirect('servicerequests');
    }

    public function cancel($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->status = "Cancelled";
        $request->save();

        $notification = new Notification;
        $notification->content = Auth::user()->name." cancelled your service request.";
        $notification->user_id = $request->user->id;
        $notification->save();
        
        alert()->success(' ', 'Service Request cancelled!');
        return redirect('servicerequests');
    }

    public function delete($id)
    {
        $request = ServiceRequest::findOrFail($id);
        $request->delete();

        alert()->success(' ', 'Service Request deleted!');
        return redirect('servicerequests');
    }

}
