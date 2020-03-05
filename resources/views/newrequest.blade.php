@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('servicerequests') }}"><i class="material-icons">assignment</i> Service Requests</a></li>
            <li class="active">Create New Service Request</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Create New Service Request</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('storeRequest') }}" id="requestSubmit">
                @csrf
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" class="form-control" placeholder="Title of Service Request" name="title" required>
                        </div>
                    </div>
                    <input type="hidden" name="description" id="description">
                    <div id="editor"></div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="department">Department Assigned: &nbsp;</label>
                                <?php $departments = App\Department::all() ?>
                                <select class="selectpicker" id="department" name="department" required>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="datetime">Deadline: &nbsp;</label>
                                <div class="form-line">
                                    <input type="datetime-local" class="form-control" id="datetime" name="deadline" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-block btn-lg btn-success waves-effect"><b>Submit</b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$("#requestSubmit").submit(function() {
    var myEditor = document.querySelector('#editor')
    var html = myEditor.children[0].innerHTML
    $("#description").val(html);
});

// Rich Text Editor
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
  placeholder: 'Enter service request description here...',
  theme: 'snow'
  });
</script>

@endsection