@extends('layouts.app')

@section('content')
<style>
.green:hover {
    color:forestgreen;
}
</style>
<div class="row">
    <div class="col-md-3 visible-xs visible-sm">
        <div class="card profile-card">
            <div class="profile-footer">
                <button type="button" class="btn btn-success btn-block waves-effect" data-toggle="modal" data-target="#newPost">
                    <i class="material-icons">post_add</i>
                    <span><b>Create New Post</b></span>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php $posts = App\Post::orderBy('created_at', 'desc')->paginate(3); ?>
        @if($posts->isEmpty())
        <div class="card">
            <div class="body">
                <h3>There are currently no posts.</h3>
            </div>
        </div>
        @else
        @foreach ($posts as $post) 
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <span style="float:right"><small><i class="material-icons font-12">access_time</i> {{ $post->created_at->diffForHumans() }}</small></span>
                            <p>{{ $post->user->name }}</p>
                        </h4>
                        {{ $post->user->position }}, <b>{{ $post->user->department->name }}</b>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="post">
                    <div class="post-heading">
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
            <?php $comments = App\Comment::where('post_id', '=', $post->id)->get(); ?>
            <div class="panel-footer">
                <ul>
                    <li>
                        <?php 
                            $acknowledgements = App\Acknowledgement::where('post_id', '=', $post->id)->get();
                            $isAcknowledged = ($acknowledgements->where('user_id', '=', Auth::user()->id)->first())?true:false;
                        ?>
                        <a href="javascript:void(0);" class="new_acknowledgement" post_id="{{ $post->id }}"
                        @if($isAcknowledged)
                        style="pointer-events: none; cursor: default; color:green"
                        @endif
                        >
                            <i class="material-icons green">thumb_up</i>
                        </a>
                        <a href="#" class="font-13 modalAcknowledgement" post_id="{{ $post->id }}" data-toggle="modal" data-target="#acknowledgements" id="acknowledgement_{{ $post->id }}">
                        @if($acknowledgements->count() == 1)
                        1 Acknowledgement
                        @elseif($acknowledgements->count() == 0)
                        No Acknowledgements
                        @else
                        {{ $acknowledgements->count() }} Acknowledgements
                        @endif
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#{{ $post->id }}comment">
                            <i class="material-icons">comment</i>
                           <span>
                            <span id="comment_count_{{ $post->id }}">
                            @if(count($comments) > 0)
                                {{count($comments)}}
                            @else
                                No
                            @endif
                            </span>
                            <span id="comment_plural_{{ $post->id }}">
                            @if(count($comments) != 1)
                            Comments
                            @else
                            Comment
                            @endif
                            </span>
                            </span>
                        </a>
                    </li>
                    <li></li>
                </ul>
                <hr>
                <div class="collapse" id="{{ $post->id }}comment">
                    @foreach($comments as $comment)
                    <div class="font-12 well" style="border-radius: 5px; padding-left:10px; padding-top:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">
                        <p><b>{{ $comment->user->name }}</b> <span class="text-muted" style="float:right"><small><i class="material-icons font-12">access_time</i> {{ $comment->created_at->diffForHumans() }}</small></span></p>
                        <p style="margin-top: -5px">{{ $comment->content }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control new_comment" id="{{ $post->id }}" placeholder="Write a comment...">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div style="text-align:center">{{ $posts->links() }}</div>
        @endif
    </div>
    <div class="col-md-3">
        <div class="card profile-card visible-md visible-lg">
            <div class="profile-footer">
                <button type="button" class="btn btn-success btn-block waves-effect" data-toggle="modal" data-target="#newPost">
                    <i class="material-icons">post_add</i>
                    <span><b>Create New Post</b></span>
                </button>
                <hr>
                <div class="list-group">
                    <a href="javascript:void(0);" class="list-group-item disabled" style="color:black !important">
                        <b>Online Employees</b>
                    </a>
                    <?php $user = new App\User; $onlineusers = $user->mostRecentOnline();?>
                    @if( count($onlineusers) > 1 )
                    @foreach($onlineusers as $onlineuser)
                        @if($onlineuser->id != Auth::user()->id)
                            <a href="javascript:void(0);" class="list-group-item font-12"><p><span class="badge bg-green"><small>ONLINE</small></span></p> {{$onlineuser->name}}</a>
                        @endif
                    @endforeach
                    @else
                    <br>
                    <p style="text-align:center"><small><i>No employees online.</i></small></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newPost" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Post</h4>
            </div>
            <form method="POST" action="{{ route('newPost') }}" id="postSubmit">
            @csrf
                <div class="modal-body" style="color:black !important">
                    <input type="hidden" name="content" id="content">
                    <div id="editor"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-link waves-effect">POST</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade in" id="acknowledgements" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-nav-right tab-col-green" role="tablist">
                    <li role="presentation" class="active"><a href="#acknowledged" data-toggle="tab" aria-expanded="true">ACKNOWLEDGED</a></li>
                    <li role="presentation" class=""><a href="#pending" data-toggle="tab" aria-expanded="false">PENDING</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="acknowledged">
                        <div class="list-group acknowledgedList">
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="pending">
                        <div class="list-group pendingList">
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<script>
//For realtime comments
    var pusher = new Pusher('378b727ac032138844eb', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('comment-channel');
    channel.bind('new-comment', function(data) {
        // fetchComments(data.message);
        alert("Received!");
    });

// New Post Rich Text Editor
var quill = new Quill('#editor', {
    modules: {
    toolbar: [
            ['bold', 'italic', 'underline', 'strike'],

            [{ 'header': 1 }, { 'header': 2 },],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }], 
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            ['clean'] 
        ]
  },
  placeholder: 'Write something here...',
  theme: 'snow'
  });

  $("#postSubmit").submit(function() {
    var myEditor = document.querySelector('#editor')
    var html = myEditor.children[0].innerHTML
    $("#content").val(html);
  });

// New Acknowledgement
$('.new_acknowledgement').click(function(){
    $(this).css('pointer-events', 'none');
    $(this).css('cursor', 'default');
    $(this).css('color', 'green');

    var post_id = $(this).attr('post_id');

    $.ajax({
        type:'POST',
        url:"{{ route('newAcknowledgement') }}",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: {post_id: post_id},
        success:function(data) {
           
            if(data != 1){
                $("#acknowledgement_"+post_id).text(data+ " Acknowledgements");
            }else{
                $("#acknowledgement_"+post_id).text(data+ " Acknowledgement");
            }
            swal({
                title: "Acknowledged!",
                text: " ",
                icon: "success",
                buttons: false
            });
        }
    });
});

// View Acknowledgements

$(".modalAcknowledgement").click(function(){
    var post_id = $(this).attr('post_id');
    // Setting up the preloader
    $(".acknowledgedList").empty();
    $(".pendingList").empty();
    $(".acknowledgedList").append(
        '<div class="preloader" style="margin-left:45%; margin-top: 10%">'+
            '<div class="spinner-layer pl-green">'+
                '<div class="circle-clipper left">'+
                    ' <div class="circle"></div>'+
                ' </div>'+
                '<div class="circle-clipper right">'+
                    ' <div class="circle"></div>'+
                '</div>'+
            '</div>'+
        '</div>'
    );
    $(".pendingList").append(
        '<div class="preloader" style="margin-left:45%; margin-top: 10%">'+
            '<div class="spinner-layer pl-green">'+
                '<div class="circle-clipper left">'+
                    ' <div class="circle"></div>'+
                ' </div>'+
                '<div class="circle-clipper right">'+
                    ' <div class="circle"></div>'+
                '</div>'+
            '</div>'+
        '</div>'
    );

    $.ajax({
        type:'POST',
        url:"{{ route('fetchAcknowledgement') }}",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: {post_id: post_id},
        success:function(data) {
            var acknowledged = data.acknowledged;
            var unacknowledged = data.unacknowledged;
            $(".acknowledgedList").empty();
            $(".pendingList").empty();

            if(acknowledged.length != 0){
                for (var i = 0; i < acknowledged.length; i++) {
                    $(".acknowledgedList").append(
                        '<a href="javascript:void(0);" class="list-group-item font-12">'+acknowledged[i]+'</a>'
                    );   
                }
            }else{
                $(".acknowledgedList").append(
                    '<br><p style="text-align:center"><i>There are currently no acknowledgements.</i></p>'
                );
            }
            
            if(unacknowledged.length != 0){
                for (var i = 0; i < unacknowledged.length; i++) {
                    $(".pendingList").append(
                        '<a href="javascript:void(0);" class="list-group-item font-12">'+unacknowledged[i]+'</a>'
                    );   
                }
            }else{
                $(".pendingList").append(
                    '<br><p style="text-align:center"><i>Everyone has acknowledged.</i></p>'
                );
            }
        }
    });

});

// New Comment
$('.new_comment').keypress(function(event){
    
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
        var comment = $(this);
        var post_id = comment.attr('id');
        var content = comment.val();
        comment.val('');

		$.ajax({
            type:'POST',
            url:"{{ route('newComment') }}",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {content: content, post_id: post_id},
            success:function(data) {
                fetchComments(post_id);
            }
        });

	}
});

function fetchComments($id) {

    // Refreshing the comments
    $("#"+$id+"comment").empty();
    $("#"+$id+"comment").collapse();

    // Setting up the preloader
    $("#"+$id+"comment").append(
        '<div class="preloader" style="margin-left:45%">'+
            '<div class="spinner-layer pl-green">'+
                '<div class="circle-clipper left">'+
                    ' <div class="circle"></div>'+
                ' </div>'+
                '<div class="circle-clipper right">'+
                    ' <div class="circle"></div>'+
                '</div>'+
            '</div>'+
        '</div>'
    );

    // Actually getting the data
    $.ajax({
        type:'POST',
        url:"{{ route('fetchComments') }}",
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        data: {id: $id},
        success:function(data) {
            $("#"+$id+"comment").empty();
            for (i = 0; i < data.length; i++) {
                $("#"+$id+"comment").append(
                    '<div class="font-12 well" style="border-radius: 5px; padding-left:10px; padding-top:10px; padding-bottom:2px; padding-right:10px; margin-bottom:3px">'+
                        '<p><b>'+data[i].user+'</b> <span class="text-muted" style="float:right"><small><i class="material-icons font-12">access_time</i> '+data[i].date+'</small></span></p>'+
                        '<p style="margin-top: -5px">'+data[i].content+'</p>'+
                    '</div>'
                );
                $("#comment_count_"+$id).text( data.length );
                $("#comment_plural_"+$id).text(( data.length == 1)?"Comment":"Comments");
            }
        }
    });
}
</script>
@endsection
