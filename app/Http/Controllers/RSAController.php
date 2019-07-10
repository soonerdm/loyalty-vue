<?php

namespace App\Http\Controllers;

use App\Brand;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Hocza\Sendy\Facades\Sendy;

class RSAController extends Controller
{

    public $brand;

   public function __construct()
   {
        $url = explode('.', $_SERVER['HTTP_HOST'])[1];

        $this->brand = $this->get_brand($url);
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $brand = $this->brand;

        switch ($this->brand) {
            case 'buyforlessok':
                $brand = 'Buy For Less / SuperMercado';
        break;
            case 'smartsaverok':
                $brand = 'Smart Saver';
        break;
            case 'uptowngroceryco':
                $brand = 'Uptown Grocery';
        break;
            default:
                $brand = 'Buy For Less / SuperMercado';
        }

        return view('home', compact('brand'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * Register new user
     * @return @JSON response
     */

    public function register_user(Request $request)
    {
        $data = $request->toArray();

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');
        $data['ClientStore']    = $request->ClientStore;

        $data = json_encode($data);

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url =  $this->build_url($brand, 'RegisterUser');

        $response = $this->curl_post($url, $data);

        $data = json_decode($response);

       if($data->ErrorMessage->ErrorCode == 1){
           $loggedInRaw = $this->get_user($request->UserName, $request->Password);

           $loggedIn = json_decode($loggedInRaw);

           Session::put('MemberNumber', $loggedIn->MemberNumber);
           Session::put('UserId', $loggedIn->UserId);
           Session::put('UserToken', $loggedIn->UserToken);

           //Add to Sendy List
           $list_id = 'dwPhRy3UuuVLNgn1u1iRJA';
           $name = $request->FirstName . ' ' . $request->LastName;

           if ($this->brand == 'smartsaverok') {
               $list_id = 'bARzZutqxyHGZ8U7Sr6DVQ';
           } elseif ($this->brand == 'uptowngroceryco') {
               $list_id = 'ViKqF1OGzY6BZ8IGc72A7w';
           }

           Sendy::setListId($list_id)->subscribe([
               'email' => $request->UserName,
               'name' => $name
           ]);

           return $loggedInRaw;
      }
       else return $response;

    }

    public function get_user($UserName, $Password){

        $data['UserName'] = $UserName;
        $data['Password'] = $Password;

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'ValidateUser');

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');

        $data = json_encode($data);

        $response = $this->curl_post($url, $data);

        return  $response;
    }




    /**
     * @param Request $request
     * validate user AKA login
     * returns user profile
     */
    public function validate_user(Request $request){

        //  dd($request);
        // $url = $this->build_url($this->get_brand($request->store_code)->loyalty_url, 'ValidateUser');

      //  $brand = $this->get_brand($request->store_code);

        //dd($brand);

        $data['UserName'] = $request->UserName;
        $data['Password'] = $request->Password;

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'ValidateUser');

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');



        $data = json_encode($data);

       // print_r($data);

        $response = $this->curl_post($url, $data);

        $jr = json_decode($response);

        if($jr->ErrorMessage->ErrorCode ==1){
            Session::put('MemberNumber', $jr->MemberNumber);
            Session::put('UserId', $jr->UserId);
            Session::put('UserToken', $jr->UserToken);
        }

        return $response;

    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function get_coupons()
    {
        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');
        if(empty(Session::get('UserToken'))){
            $data['UserToken'] = Session::get('UserToken');
        }

        $data = json_encode($data);

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'GetRSAOffers');

        $response = $this->curl_post($url, $data);

        return $response;
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function clip_offer(Request $request){

        $data['RSAOfferId']     = $request->RSAOfferId;
        $data['CategoryId']     = $request->CategoryId;

      // die("Member Num ". Session::get('MemberNumber'));

        if(empty(Session::get('MemberNumber'))){
            $data['ErrorMessage'] = "No MemberNumber";
            return json_encode($data);
        }

        $data['MemberNumber']   = Session::get('MemberNumber');
        $data['UserToken']      = Session::get('UserToken');

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');

        $data = json_encode($data);

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'ClipOffer');

        $response = $this->curl_post($url, $data);
        return $response;

    }

    /**
     *
     * Session UserToken
     * returns users clipped coupons
     */
    public function get_user_clips(){

        if(empty(Session::get('UserToken'))){
            return json_encode($data['ErrorMessage'] = "Not Logged In" );
        }

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'GetUserClips');

        $url = $url."/".Session::get('UserToken')."/".ENV('RSA_EnterpriseId')."/".ENV('RSA_SecurityKey');

       // echo $url;

        $response = $this->curl_get($url);

        return $response;

    }

    public function forgot_pin(Request $request){

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');
        $data['UserName']       = $request->UserName;

        $data = json_encode($data);

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'ForgotPin');

        $response = $this->curl_post($url, $data);
        return $response;
    }

    /**
     * get all stores for brand
     */
    public function getStores(){

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');

        $brand = $this->brand;

        if ($this->brand == 'smartsaverok') {
            $brand = 'buyforlessok';
        }

        $url = $this->build_url($brand, 'GetClientStores');

        $url = $url."/".ENV('RSA_EnterpriseId')."/".ENV('RSA_SecurityKey');

        $response = $this->curl_get($url);

        return $response;
    }


    /**
     *
     */
    public function get_brand($url){

        $domain['buyforlessok'] = 'buyforlessok';
        $domain['uptowngroceryco'] = 'uptowngroceryco';
        $domain['smartsaverok'] = 'smartsaverok';

        if (!isset($domain[$url])){
            return 'buyforlessok';
        }
        else {
            return $domain[$url];
        }


    }


    /**
     * @param $url
     * @param $data
     * @return bool|string
     */
    public function curl_post($url, $data){
        /*
        $client = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'Content-type' => 'application/json',
                "cache-control: no-cache"]
        ]);

        $response = $client->post($url,
            ['json' => $data]
        );

        return $response;
        */

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    /**
     * @param $brand //Pass the brand we want to service
     * @param $service // Pass the service we want to use
     * @return string
     */
    public function build_url($brand, $service){
        return 'https://'.$brand.'.rsaamerica.com/PartnerApi/SSWebRestApi.svc/'.$service;
    }


    /**
     * @param $store_code
     * @return mixed
     */
    public function curl_get($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }

        //        $client = new Client();
//        $response = $client->get($url);
//        $answer = $response->getBody()->getContents();
//        return $answer;


    }




    public function logout(){
        Session::flush();
        $response ='';

        return back();
    }

}
