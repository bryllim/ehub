@extends('layouts.app')

@section('content')
<div class="card">
    <div class="header"><b>All Notifications</b></div>
    <div class="body">
        <ul class="list-group">
        @foreach($notifications as $notification)
            <li class="list-group-item">{{ $notification->content }}<span style="float:right"><i class="material-icons font-12 text-muted">access_time</i> <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small></span></li>
        @endforeach
        </ul>
    </div>
</div>

@endsection