@extends('layouts.app')

@section('content')
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
        @if(isset($reponse))
            <?php print_r($response)?>
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
        @if(isset($reponse))
            <?php print_r($response)?>
        @endif
    </div>

</div>


@endsection
