@extends('layouts.app')

@section('content')

    <script>
        var coupons = <?php echo $coupons;?>

        console.log(coupons);

    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                Stuff Goes Here
{{--                {{dd($coupons)}}--}}
                @php $z = 1; @endphp
                @if(isset($mmmmmmmm))
                @foreach ($coupons->Offers as $i => $c)
                    @php if($z == 4){$z = 1;} @endphp
                    @if($z == 1)
                        <div class="row">
                    @endif
                    <div class="col">
                        <div class="product_box">
                            <img src="{{$c->ImagePath}}" width="200" class="responsive">
                        {{ ($c->Title) }}

                        </div>
                    </div>
                    @if($z ==3)
                    </div>
                    @endif
                    @php $z++ @endphp
                @endforeach
            @if($z != 4)
                </div>
            @endif
            @endif
            </div>

            <div class="col-md-4" id="RegisterForm">
                <div class="card">
                    <div class="card-header bg-primary">Register Here
                        <span class="float-right"><a href="#" id="SignInLink" style="color: #FFF;">Sign In</a></span>
                    </div>
                    <div class="card-body">
                        <form action="{{action('RSAController@register_user')}}" method="post">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="FirstName">First Name</label>
                                <input class="form-control" name="FirstName" id="FirstName" type="text">
                            </div>
                            <div class="form-group">
                                <label for="LastName">Last Name</label>
                                <input name="LastName" class="form-control" id="LastName" type="text">
                            </div>
                            <div class="form-group">
                                <label for="UserName">User Name</label>
                                <input class="form-control" name="UserName" id="UserName" type="text">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" id="password" name="Password" type="password">
                            </div>
                            <div class="form-group">
                                <label for="zipcode">Zip Code</label>
                                <input class="form-control" id="zipcode" name="ZipCode" type="text">
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4" id="LoginForm" style="display: none;">
                <div class="card">
                    <div class="card-header bg-primary">Login Here
                        <span class="float-right" title="No Login? Register here"><a href="#" style="color: #FFF" id="RegisterLink">Register</a></span>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('RSAController@validate_user') }}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="UserName">User Name</label>
                                <input class="form-control" name="UserName" type="text" id="UserName_Login">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="Password" id="Password_Login" class="form-control">
                                <input type="hidden" name="store_code_login" value="3501">
                            </div>
                            <div class="form-group">
                                <button type="submit" id="SubmitButton" class="btn btn-primary">Register</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

<script>
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