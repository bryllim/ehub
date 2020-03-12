@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header" style="color:black; padding-top: 1px; padding-bottom: 1px">
                <h3>Messages</h3>
            </div>
            <div class="body">
                <?php
                        $users = new App\User;
                        $onlineusers = $users->mostRecentOnline();
                    ?>
                    @foreach($onlineusers as $onlineuser)
                        @if($onlineuser->id != Auth::user()->id)
                        <a href="{{ url('message').'/'.$onlineuser->id }}" class="list-group-item font-12">
                            <p style="margin-bottom:0">
                                <b>{{ $onlineuser->name }}</b> 
                                <span class="badge bg-green" style="float:right"><small>ONLINE</small></span>
                                <?php
                                    $unread = App\Message::where('user_id', $onlineuser->id)->where('recepient_id', Auth::user()->id)->where('read', false)->count();
                                ?>
                                @if($unread>0)
                                <span class="badge bg-red" style="float:right; margin-right:3px"><small>{{ $unread }} UNREAD</small></span>
                                @endif
                            </p>
                            <small>{{ $onlineuser->position }}, <b>{{ $onlineuser->department->name }}</b></small>
                        </a>
                        @endif
                    @endforeach
                    <?php
                        $users = App\User::all();
                    ?>
                    @foreach($users as $user)  
                        <?php 
                            $online = App\User::find($user->id);
                        ?>
                        @if(!$online->isOnline())
                            <a href="{{ url('message').'/'.$user->id }}" class="list-group-item font-12">
                                <p style="margin-bottom:0"><b>{{ $user->name }}</b>
                                <?php
                                    $unread = App\Message::where('user_id', $user->id)->where('recepient_id', Auth::user()->id)->where('read', false)->count();
                                ?>
                                @if($unread>0)
                                <span class="badge bg-red" style="float:right; margin-right:3px"><small>{{ $unread }} UNREAD</small></span>
                                @endif
                                </p>
                                <small>{{ $user->position }}, <b>{{ $user->department->name }}</b></small>
                            </a>
                        @endif
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection