@extends('layouts.app')

@section('content')

    <loyalty></loyalty>

    <script type="application/javascript">
        $(document).ready(function(){
            $('#SignInLink').click(function(){
                $("#RegisterForm").hide();
                $("#LoginForm").show();
                $("#ForgotPin").hide();
            });
            $('#RegisterLink').click(function(){
                $("#RegisterForm").show();
                $("#LoginForm").hide();
                $("#ForgotPin").hide();
            });
            $('#ForgotPinLink').click(function(){
                $("#RegisterForm").hide();
                $("#LoginForm").hide();
                $("#ForgotPin").show();
            });
            $('#ForgotPinLink2').click(function(){
                $("#RegisterForm").hide();
                $("#LoginForm").hide();
                $("#ForgotPin").show();
            });
            $('#LoginLink').click(function(){
                $("#RegisterForm").hide();
                $("#LoginForm").show();
                $("#ForgotPin").hide();
            });
            $('#MyClipsLink').click(function(){
                $('#store-coupons').hide();
                $('#my-coupons').show();
            });
            $('#AllCouponsLink').click(function() {
                $('#store-coupons').show();
                $('#my-coupons').hide();
            })
        });
    </script>

@endsection

