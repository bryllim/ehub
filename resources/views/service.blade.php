@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php $assignedRequests = App\ServiceRequest::where('department_id', '=', Auth::user()->department->id)->get() ?>
            @if(count($assignedRequests)>0)
            <div class="body table-responsive">
                <h3 class="visible-md visible-lg" style="margin-bottom: -30px;">Assigned Service Requests</h3>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="assigned_table" role="grid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>From</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedRequests as $assignedRequest)
                        <tr>
                            <td>{{ $assignedRequest->id }}</td>
                            <td><a href="{{ url('request').'/'.$assignedRequest->id }}">{{ $assignedRequest->title }}</a></td>
                            <td><small>{{ $assignedRequest->user->department->name }}</small></td>
                            <td>{{ date("F j, Y g:h A", strtotime($assignedRequest->deadline)) }}</td>
                            <td>
                                @if((date("F j, Y g:h A") > strtotime($assignedRequest->deadline)) && ($assignedRequest->status != "Cancelled" || $assignedRequest->status != "Declined"))
                                <span class="label bg-red"><small>OVERDUE</small></span>
                                @endif
                                @if($assignedRequest->status == "Pending")
                                <span class="label bg-blue">Pending</span>
                                @elseif($assignedRequest->status == "Completed")
                                <span class="label bg-green">Completed</span>
                                @elseif($assignedRequest->status == "In-progress")
                                <span class="label bg-orange">In-progress</span>
                                @elseif($assignedRequest->status == "Cancelled")
                                <span class="label bg-red">Cancelled</span>
                                @elseif($assignedRequest->status == "Declined")
                                <span class="label bg-red">Declined</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <br>
                <hr>
                <h3 class="text-center">You're currently not assigned to any service requests.</h3>
                <hr>
                <br>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a type="button" class="btn btn-success waves-effect btn-block" href="{{ route('newRequest') }}">
            <i class="material-icons">add</i>
            <span><strong>Create New Service Request</strong></span>
        </a>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-secondary btn-block" style="pointer-events: none;">
            <i class="material-icons text-muted">assignment_turned_in</i>
            <span>Service Requests Completed:&nbsp; <b>23</b></span>
        </button>
    </div>
    <div class="col-md-4">
        <button type="button" class="btn btn-secondary btn-block" style="pointer-events: none;">
            <i class="material-icons text-muted">assignment</i>
            <span>My Service Requests:&nbsp; <b>145</b></span>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?php $myRequests = App\ServiceRequest::where('user_id', '=', Auth::user()->id)->get() ?>
            @if(count($myRequests) > 0 )
            <div class="body table-responsive">
                <h3 class="visible-md visible-lg" style="margin-bottom: -30px;">My Service Requests</h3>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="my_table" role="grid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Department Assigned</th>
                            <th>Deadline</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myRequests as $myRequest)
                        <tr>
                        <td>{{ $myRequest->id }}</td>
                            <td><a href="{{ url('request').'/'.$myRequest->id }}">{{ $myRequest->title }}</a></td>
                            <td><small>{{ $myRequest->department->name }}</small></td>
                            <td>{{ date("F j, Y g:h A", strtotime($myRequest->deadline)) }}</td>
                            <td>
                                @if((date("F j, Y g:h A") > strtotime($myRequest->deadline)) && ($myRequest->status != "Cancelled" || $myRequest->status != "Declined"))
                                <span class="label bg-red"><small>OVERDUE</small></span>
                                @endif
                                @if($myRequest->status == "Pending")
                                <span class="label bg-blue">Pending</span>
                                @elseif($myRequest->status == "Completed")
                                <span class="label bg-green">Completed</span>
                                @elseif($myRequest->status == "In-progress")
                                <span class="label bg-orange">In-progress</span>
                                @elseif($myRequest->status == "Cancelled")
                                <span class="label bg-red">Cancelled</span>
                                @elseif($myRequest->status == "Declined")
                                <span class="label bg-red">Declined</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <br>
                <hr>
                <h3 class="text-center">You don't have any service requests.</h3>
                <hr>
                <br>
            @endif
        </div>
    </div>
</div>
<script>
    $('#assigned_table').DataTable({
        "bLengthChange": false,
    });
    $('#my_table').DataTable({
        "bLengthChange": false,
    });
</script>

@endsection