@extends('layouts.app')

@section('content')

<test-component text="My Button Text" type="submit"></test-component>




<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Register For Loyalty Program</div>
        <div class="panel-body">
            <form action="{{ action('RSAController@validate_user') }}" method="post">
                {{csrf_field()}}
            <div class="form-group">
                <label for="UserName">User Name</label>
                <input class="form-control" name="UserName" type="text" id="UserName">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="Password" id="Password" class="form-control">
                <input type="hidden" name="store_code" value="3501">
            </div>
            <div class="form-group">
                <button type="submit" id="SubmitButton">Register</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Register For Loyalty</div>
        <div class="panel-body">
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
                    <label for="zipcode">Password</label>
                    <input class="form-control" id="zipcode" name="ZipCode" type="text">
                </div>
                <input type="submit">
            </form>
        </div>
    </div>

    <div>
    </div>

</div>

-----------------------------------------------

<div class="container">
    <form action="" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label>Get Coupons</label>

            <input type="hidden" name="UserToken" value="873b0a64-9760-4de3-8115-774d5641ae1d">
        </div>
        <input type="submit">
    </form>

    <div>
        @if(isset($response))
            @php print_r($response) @endphp
        @endif
    </div>

</div>



------------------------------------------

<div class="container">
    <form action="{{action('RSAController@validate_user')}}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label>Get User Clipped Coupons</label>

            <input type="hidden" name="UserToken" value="873b0a64-9760-4de3-8115-774d5641ae1d">
        </div>
        <input type="submit">
    </form>

    <div>
        @if(isset($response))
            @php print_r($response) @endphp
        @endif
    </div>

</div>


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
