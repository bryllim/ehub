@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header" style="color:black; padding-top:5px; padding-bottom:5px">
                <h4>{{ $user->name }}
                    @if($user->isOnline())
                    <span class="badge bg-green" style="float:right"><small>ONLINE</small></span>
                    @endif
                </h4>
                <small>{{ $user->position }}, <b>{{ $user->department->name }}</b></small>
            </div>
            <div class="body">
            <div class="card-body" style="min-height:340px; max-height:340px; overflow-y:auto; padding:15px" id="conversation">
                @foreach($messages as $message)
                    @if($message->recepient_id == Auth::user()->id)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="font-12 well" style="border-radius: 5px; padding-left:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">
                                    <p style="margin-top: -5px">{{$message->message}}</p>
                                </div>
                                <small class="text-muted" style="font-size:70%; float:right"> &nbsp; {{date('g:i:s A F j, Y', strtotime($message->created_at))}}</small>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6 visible-md visible-lg"></div>
                            <div class="col-md-6">
                                <div class="font-12 well bg-green" style="border-radius: 5px; padding-left:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">
                                    <p style="margin-top: -5px">{{$message->message}}</p>
                                </div>
                                <small class="text-muted" style="font-size:70%;"> &nbsp; {{date('g:i:s A F j, Y', strtotime($message->created_at))}}</small>
                            </div>
                        </div>
                    @endif
                @endforeach                    
                </div>
                <hr>
                <div class="card-footer">
                    <div class="row" style="margin-bottom:0">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="form-line" >
                                    <input type="text" class="form-control new_message" id="{{ $user->id }}" placeholder="Write your message...">
                                </div>
                                <small class="text-muted" style="float:right; margin-top: 8px">Press "Enter" to send your message.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<script>
$('#conversation').scrollTop($('#conversation')[0].scrollHeight);

var messageID = 0;
// New Message
$('.new_message').keypress(function(event){
    
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
        var message = $(this);
        var recepient_id = message.attr('id');
        var content = message.val();
        message.val('');

        $("#conversation").append(
            '<div class="row">'+
                '<div class="col-md-6 visible-md visible-lg"></div>'+
                '<div class="col-md-6">'+
                    '<div class="font-12 well bg-green" style="border-radius: 5px; padding-left:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">'+
                        '<p style="margin-top: -5px">'+content+'</p>'+
                    '</div>'+
                    '<small class="text-muted" style="font-size:70%;" id="sendingLoading' + messageID +'"> &nbsp; Sending...</small>'+
                '</div>'+
            '</div>'
        );       

        $('#conversation').scrollTop($('#conversation')[0].scrollHeight); 

		$.ajax({
            type:'POST',
            url:"{{ route('newMessage') }}",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {message: content, recepient_id: recepient_id},
            success:function(data) {
                $("#sendingLoading"+messageID++).text(new Date().toLocaleTimeString());
                broadcastMessage(data);
            }
        });

	}
});

function broadcastMessage($message_id){
    $.ajax({
        type:'GET',
        url:"{{ URL::to('/') }}/broadcastMessage/"+$message_id
    });
}

var pusher = new Pusher('378b727ac032138844eb', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('comment-channel');
    channel.bind('new-message', function(data) {
        if(data.recepient_id == {{ Auth::user()->id }} && data.user_id == {{ $user->id }})
        {
            $("#conversation").append(
                '<div class="row">'+
                    '<div class="col-md-6">'+
                        '<div class="font-12 well" style="border-radius: 5px; padding-left:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">'+
                            '<p style="margin-top: -5px">'+data.message+'</p>'+
                        '</div>'+
                        '<small class="text-muted" style="font-size:70%; float:right;"> &nbsp; '+new Date().toLocaleTimeString()+'</small>'+
                    '</div>'+
                '</div>'
            );    
            
            $('#conversation').scrollTop($('#conversation')[0].scrollHeight);
        }
    });            

</script>
@endsection