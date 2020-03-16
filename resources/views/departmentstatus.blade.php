@extends('layouts.app')

@section('content')
<div class="row clearfix">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-grey hover-expand-effect">
            <div class="icon">
                <i class="material-icons">assignment_late</i>
            </div>
            <div class="content">
                <div class="text">PENDING SERVICE REQUESTS</div>
                <div class="number count-to" data-from="0" data-to="{{ $pending }}" data-speed="1000" data-fresh-interval="20">{{ $pending }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">assignment_ind</i>
            </div>
            <div class="content">
                <div class="text">IN-PROGRESS SERVICE REQUESTS</div>
                <div class="number count-to" data-from="0" data-to="{{ $progress }}" data-speed="1000" data-fresh-interval="20">{{ $progress }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">assignment_turned_in</i>
            </div>
            <div class="content">
                <div class="text">COMPLETED SERVICE REQUESTS</div>
                <div class="number count-to" data-from="0" data-to="{{ $progress }}" data-speed="1000" data-fresh-interval="20">{{ $pending }}</div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="body">
        <div class="table-responsive">
            <table class="table table-hover dashboard-task-infos">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Pending</th>
                        <th>In-Progress</th>
                        <th>Completed</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->name }}</td>
                        <td>{{ $department->servicerequest->where('status', 'Pending')->count() }}</td>
                        <td>{{ $department->servicerequest->where('status', 'In-Progress')->count() }}</td>
                        <td>{{ $department->servicerequest->where('status', 'Completed')->count() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection