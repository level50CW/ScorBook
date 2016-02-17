<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Northwood</title>
    @include('ui.blueprint')
    @include('ui.jquery-ui')
    @include('ui.bootstrap')
    @include('ui.moment')
    @include('ui.main')
    @yield('header')
</head>
<body>
    <div class="container">
        <div class="ui-header">
            <a href="/"><div class="ui-logo"><img src="{{url('/images/Northwoods_League_Logo.png')}}"></div> </a>
        </div>

        @include('auth.user')

        <div class="container">
            <div class="span-24">
                <div class="ui-content">
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
    @yield('menu')
    <div class="ui-footer">
        Copyright © {{date('Y')}} Northwoods League. All Rights Reserved.<br><br>
        <hr style="width:200px; margin:0 auto; height: 1px;">
    </div>
    @yield('script')
</body>
</html>