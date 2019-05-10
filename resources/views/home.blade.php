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
        @if(isset($reponse))
            <?php print_r($response)?>
        @endif
    </div>

</div>



<script>

    /*
    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://buyforlessok.rsaamerica.com/PartnerApi/SSWebRestApi.svc/RegisterUser",
        "method": "POST",
        "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
            "Postman-Token": "1a6ba060-e727-4b37-b98f-1e3edb6736ea",
            "Access-Control-Allow-Origin":  "http://127.0.0.1:8000",
            "Access-Control-Allow-Methods": "POST",
            "Access-Control-Allow-Headers": "Content-Type, Authorization"
        },
        "processData": false,
        "data": { "ZipCode": "60646", "UserName": "User10@gmail.com", "FirstName": "John", "LastName": "Doe", "Password": "1234", "ClientStoreId": 2, "EnterpriseId": "A07DC24C-B545-4FED-A840-3632CBD5F0F5", "SecurityKey": "ED2559CF-6927-4A3B-811A-E223808D98CD" }
    };
    */

/*
    $(document).ready(function(){
        $("#SubmitButton").click(function(){
            $.ajax(settings).done(function (response) {
                console.log(response);
            });

           // $("p").slideToggle();
        });
    });
*/

</script>
@endsection
