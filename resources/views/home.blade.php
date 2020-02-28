@extends('layouts.app')

@section('content')
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
        <div class="infinite-scroll" data-infinite-scroll='{ "path": ".pagination__next", "append": ".panel", "history": false }'>
            @for ($i = 0; $i < 15; $i++)
            <div class="panel panel-default panel-post">
                <div class="panel-heading">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">
                                <span style="float:right"><small><i class="material-icons font-12">access_time</i> 11:45 AM - Feb 26, 2020</small></span>
                                <p>Cris Lawrence Adrian Militante</p>
                            </h4>
                            Director, <b>Information and Communications Technology Department</b>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="post">
                        <div class="post-heading">
                            <p>I am a very simple wall post. I am good at containing <a href="#">#small</a> bits of <a href="#">#information</a>. I require little more information to use effectively.
                            These are some more sample random text.</p>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="material-icons">thumb_up</i>
                                <span>12 Acknowledgements</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="material-icons">comment</i>
                                <span>5 Comments</span>
                            </a>
                        </li>
                        <li></li>
                    </ul>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="Write a comment...">
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
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
                    <a href="javascript:void(0);" class="list-group-item font-12"><p><span class="badge bg-green"><small>ONLINE</small></span></p> Cris Lawrence Adrian Militante</a>
                    <a href="javascript:void(0);" class="list-group-item font-12"><p><span class="badge bg-green"><small>ONLINE</small></span></p> Cris Lawrence Adrian Militante</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newPost" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create New Post</h4>
            </div>
            <div class="modal-body" style="color:black !important">
                <div id="editor"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCEL</button>
                <button type="button" class="btn btn-link waves-effect">POST</button>
            </div>
        </div>
    </div>
</div>
<!-- Requires pagination -->
<script src="https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js"></script>
<script>
var quill = new Quill('#editor', {
    modules: {
    toolbar: [
            ['bold', 'italic', 'underline', 'strike'],

            [{ 'header': 1 }, { 'header': 2 },],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],       // text direction
            ['clean']                                         // remove formatting button
        ]
  },
  placeholder: 'Write something here...',
  theme: 'snow'  // or 'bubble'
  });
</script>
@endsection
