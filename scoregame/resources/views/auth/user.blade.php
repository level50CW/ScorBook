<?php
use \Illuminate\Support\Facades\Auth;
use \App\Helpers\LocalDateTime;
$user = Auth::user();
?>

<div class="ui-user">
    @if(isset($user))
        <div>
            Welcome {{$user->Firstname}} {{$user->Lastname}}. <a href="{{action('Auth\AuthController@getLogout')}}" style="text-decoration: underline;font-weight: bold;color: #caf1b0;">Logout</a><br/>
            Last Login: {!!LocalDateTime::fromCarbon(Session::get('login.time'),'DD-MMM-YYYY HH:mm:ss')!!}
        </div>
    @endif
</div>