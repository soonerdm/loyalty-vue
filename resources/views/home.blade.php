@extends('layouts.app')

@section('content')

    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container" id="top">
            <a class="navbar-brand" href="{{ url('/') }}">
                @if( (URL::to('') == 'http://loyalty.test:8000') )
                    <img src="/img/buyforlessok.png" height="50" />
                @else
                    <img src='/img/@php echo explode('.', $_SERVER['HTTP_HOST'])[1]; @endphp.png' height="50" />
                @endif
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                </ul>
            </div>
        </div>
    </nav>

    <loyalty></loyalty>

    <!-- Scroll to Top Affix -->
    <span id="top-link-block"><small>
        <a href="#top" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
            top <i class="fa fa-chevron-up"></i>
        </a></small>
    </span>

    <script type="application/javascript">
        $(document).ready(function(){
            $('body').on('click', '#SignInLink', function(){
                $("#RegisterForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function() {
                        $("#LoginForm").fadeIn();
                    });
                });
            }).on('click', '#RegisterLink', function(){
                $("#LoginForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function() {
                        $("#RegisterForm").fadeIn();
                    });
                });
            }).on('click', '#ForgotPinLink', function(){
                $("#LoginForm").fadeOut( function() {
                    $("#RegisterForm").fadeOut( function() {
                        $("#ForgotPin").fadeIn();
                    });
                });
            }).on('click', '#LoginLink', function(){
                $("#RegisterForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function(){
                        $("#LoginForm").fadeIn();
                    });
                });
            });
        });
        // Scroll to top affix
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('#top-link-block').fadeIn();
            } else {
                $('#top-link-block').fadeOut();
            }
        });
    </script>

@endsection

