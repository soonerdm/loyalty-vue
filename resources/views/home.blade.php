@extends('layouts.app')

@section('content')

    <loyalty></loyalty>

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
        $('#top-link-block').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });
    </script>

@endsection

