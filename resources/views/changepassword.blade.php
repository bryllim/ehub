@extends('layouts.app')

@section('content')
<div class="card">
    <div class="header"><b>Change your password</b></div>
    <div class="body">
        <form method="POST" action="{{ route('passwordchange') }}">
        @csrf
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control" placeholder="Enter your current password" name="oldpassword" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control" placeholder="Enter new password" name="newpassword" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-line">
                        <input type="password" class="form-control" placeholder="Confirm new password" name="confirmpassword" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-block btn-lg btn-success waves-effect"><b>Change Password</b></button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection