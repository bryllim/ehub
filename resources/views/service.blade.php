@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body table-responsive">
                <h3 class="visible-md visible-lg" style="margin-bottom: -30px;">Assigned Service Requests</h3>
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="assigned_table" role="grid">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>From</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>23</td>
                            <td><a href="#">Purchase request of new monitors</a></td>
                            <td><small>Information and Communications Technology Department</small></td>
                            <td><span class="badge bg-red"><small>OVERDUE</small></span> 11:30 AM March 22, 2020</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                        <?php $myRequests = App\ServiceRequest::where('user_id', '=', Auth::user()->id)->get() ?>
                        @foreach($myRequests as $myRequest)
                        <tr>
                        <td>{{ $myRequest->id }}</td>
                            <td><a href="#">{{ $myRequest->title }}</a></td>
                            <td><small>{{ $myRequest->department->name }}</small></td>
                            <td>{{ $myRequest->deadline }}</td>
                            <td><span class="label bg-blue">{{ $myRequest->status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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