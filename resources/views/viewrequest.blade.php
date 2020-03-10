@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('servicerequests') }}"><i class="material-icons">assignment</i> Service Requests</a></li>
            <li class="active">{{ $request->title }}</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header" style="color:black; padding-top: 1px; padding-bottom: 1px">
            
            <h3>{{ $request->title }}</h3>
            <hr>
            <div class="row">
                <div class="col-md-7">
                @if(Auth::user()->department->id == $request->user->department->id)
                    <p>To: <b>{{ $request->department->name }}</b></p>
                @else
                    <p>From: <b>{{ $request->user->department->name }}</b></p>
                @endif
                    <p>Deadline: <b>{{ date("F j, Y g:h A", strtotime($request->deadline)) }}</b></p>
                </div>
                <div class="col-md-5">
                    <p>Status: 
                    @if((date('Y-m-d H:i:s') > $request->deadline) && ($request->status != "Cancelled" || $request->status != "Declined"))
                    <span class="label bg-red"><small>OVERDUE</small></span>
                    @endif
                    @if($request->status == "Pending")
                    <span class="label bg-blue">Pending</span>
                    @elseif($request->status == "Completed")
                    <span class="label bg-green">Completed</span>
                    @elseif($request->status == "In-progress")
                    <span class="label bg-orange">In-progress</span>
                    @elseif($request->status == "Cancelled")
                    <span class="label bg-red">Cancelled</span>
                    @elseif($request->status == "Declined")
                    <span class="label bg-red">Declined</span>
                    @endif
                    </p>
                    @if(Auth::user()->department->id != $request->user->department->id)
                        @if($request->status == "Pending")
                        Actions: <a href="{{ url('accept').'/'.$request->id }}" style="color:forestgreen"><b>ACCEPT</b></a> or <a href="{{ url('decline').'/'.$request->id }}" style="color:gray"><b>DECLINE</b></a>
                        @elseif($request->status == "In-progress")
                        Actions: <a href="{{ url('complete').'/'.$request->id }}" style="color:forestgreen"><b>COMPLETE</b></a> or <a href="{{ url('cancel').'/'.$request->id }}" style="color:gray"><b>CANCEL</b></a>
                        @endif
                    @else
                        @if($request->status == "Pending")
                        Actions: <a href="{{ url('delete').'/'.$request->id }}" style="color:red"><b>DELETE</b></a>
                        @endif
                    @endif
                </div>
            </div>
            </div>
            <div class="body">
                {!! $request->description !!}
                @if(count($remarks)>0)
                <hr>
                @foreach($remarks as $remark)
                <div class="font-12 well" style="border-radius: 5px; padding-left:10px; padding-top:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">
                    <p><b>{{ $remark->user->name }}</b> <span class="text-muted" style="float:right"><small><i class="material-icons font-12">access_time</i> {{ $remark->created_at->diffForHumans() }}</small></span></p>
                    <p style="margin-top: -5px">{{ $remark->content }}</p>
                </div>
                @endforeach
                @endif
                <hr>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control new_comment" placeholder="Write a comment...">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// New Comment
$('.new_comment').keypress(function(event){
    
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
        var comment = $(this);
        var request_id = {{$request->id}};
        var content = comment.val();
        comment.val('');

		$.ajax({
            type:'POST',
            url:"{{ route('newRemark') }}",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {content: content, request_id: request_id},
            success:function(data) {
                location.reload();
            }
        });

	}
});
</script>
@endsection