@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                Stuff Goes Here
                <div id="store-coupons">
                    <coupons-component></coupons-component>
                </div>
                <div id="my-coupons">
                    <my-coupons-component></my-coupons-component>
                </div>
            </div>
            <div class="col-md-4" id="RegisterForm">
                <register-component></register-component>
            </div>
            <div class="col-md-4" id="LoginForm" style="display: none;">
                <login-component></login-component>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        $(document).ready(function(){
            $('#SignInLink').click(function(){
                $("#RegisterForm").hide();
                $("#LoginForm").show();
            });

            $('#RegisterLink').click(function(){
                $("#RegisterForm").show();
                $("#LoginForm").hide();
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

