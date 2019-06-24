@extends('layouts.app')

@section('content')

    <loyalty></loyalty>

    <!-- @php echo Session::get('UserToken') @endphp -->

    <script type="application/javascript">
        $(document).ready(function(){
            $('body').on('click', '#SignInLink', function(){
                $("#RegisterForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function() {
                        $("#LoginForm").fadeIn();
                    });
                });
            });
            $('body').on('click', '#RegisterLink', function(){
                $("#LoginForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function() {
                        $("#RegisterForm").fadeIn();
                    });
                });
            });
            $('body').on('click', '#ForgotPinLink', function(){
                $("#LoginForm").fadeOut( function() {
                    $("#RegisterForm").fadeOut( function() {
                        $("#ForgotPin").fadeIn();
                    });
                });
            });
            $('body').on('click', '#LoginLink', function(){
                $("#RegisterForm").fadeOut( function() {
                    $("#ForgotPin").fadeOut( function(){
                        $("#LoginForm").fadeIn();
                    });
                });
            });
        });
    </script>

@endsection

