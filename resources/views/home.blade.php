@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="store-coupons">
                    @if(!empty(Session::get('MemberNumber')))
                        <a href='#' id="MyClipsLink">My Clipped Coupon</a>
                    @endif
                    <coupons-component></coupons-component>
                </div>
                <div id="my-coupons" style="display: none;">
                    <a href="#" id="AllCouponsLink">All Coupons</a>
                    <my-coupons-component></my-coupons-component>
                </div>
            </div>
            <div class="col-md-4" id="RegisterForm">
                <register-component></register-component>
                <a href="#" class="float-right" id="ForgotPinLink">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="LoginForm" style="display: none;">
                <login-component></login-component>
                <a href="#" class="float-right" id="ForgotPinLink2">Forgot Pin</a>
            </div>
            <div class="col-md-4" id="ForgotPin" style="display: none;">
                <forgot-pin-component></forgot-pin-component>
            </div>
        </div>
    </div>

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

    {{-- Forms Below --}}

    {{---------------------------------------------------}}

    {{--<div class="container">--}}
    {{--    <form action="" method="post">--}}
    {{--        {{ csrf_field() }}--}}

    {{--        <div class="form-group">--}}
    {{--            <label>Get Coupons</label>--}}

    {{--            <input type="hidden" name="UserToken" value="873b0a64-9760-4de3-8115-774d5641ae1d">--}}
    {{--        </div>--}}
    {{--        <input type="submit">--}}
    {{--    </form>--}}

    {{--    <div>--}}
    {{--        @if(isset($response))--}}
    {{--            @php print_r($response) @endphp--}}
    {{--        @endif--}}
    {{--    </div>--}}

    {{--</div>--}}



    {{----------------------------------------------}}

    {{--<div class="container">--}}
    {{--    <form action="{{action('RSAController@validate_user')}}" method="post">--}}
    {{--        {{ csrf_field() }}--}}

    {{--        <div class="form-group">--}}
    {{--            <label>Get User Clipped Coupons</label>--}}

    {{--            <input type="hidden" name="UserToken" value="873b0a64-9760-4de3-8115-774d5641ae1d">--}}
    {{--        </div>--}}
    {{--        <input type="submit">--}}
    {{--    </form>--}}

    {{--    <div>--}}
    {{--        @if(isset($response))--}}
    {{--            @php print_r($response) @endphp--}}
    {{--        @endif--}}
    {{--    </div>--}}

    {{--</div>--}}


    {{--<div class="container">--}}
    {{--    @foreach($response->Offers as $o)--}}
    {{--        {{$o->Title}}<br>--}}
    {{--        {{$o->Details}}<br>--}}
    {{--        {{$o->DiscountAmount}}<br>--}}
    {{--        <img src="{{$o->ImagePath}}" alt="Discount Offer - {{$o->DiscountAmount}}" width="200"><br>--}}
    {{--        Click Here {{$o->RSAOfferId}}<br>--}}
    {{--        {{$o->ProductName}}<br>--}}
    {{--        ------------------------<br>--}}
    {{--    @endforeach--}}

    {{--</div>--}}

    {{--[1] => stdClass Object ( [CategoryDescription] => UPC Promotion [CategoryId] => 5 [DepartmentName] =>--}}
    {{--[Details] => Buy 1 Doll Kind get 1 free [DiscountAmount] => 100 [ExpiresOn] => /Date(1555891140000+0000)/--}}
    {{--[ImagePath] => https://s3.amazonaws.com/buyforlessok/SpecialsImages/IMG_04172019_185426226.jpg [IsDiscountPercentage] => 1 [IsFeatured] =>--}}
    {{--[ProductName] => Group [RSAOfferId] => 579 [Title] => Doll Kind BOGO [ValidFrom] => /Date(1555462800000+0000)/ )--}}


@endsection

