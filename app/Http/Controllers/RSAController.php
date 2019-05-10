<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class RSAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function register_user(Request $request){

        $data = $request->toArray();

        $data['SecurityKey']    = ENV('RSA_SecurityKey');
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');
        $data['ClientStore']    = 1;

        $data = json_encode($data);

        $url =  $this->build_url('buyforlessok', 'RegisterUser');

        echo  $response = $this->curl_post($url, $data);

        //return view('loyalty.index', compact('response'));

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

        $url = $this->build_url('buyforlessok', 'ValidateUser');

        $data['SecurityKey']    = ENV('RSA_SecurityKey');//$brand->loyalty_security_id;
        $data['EnterpriseId']   = ENV('RSA_EnterpriseId');//$brand->loyalty_enterprise_id;



        $data = json_encode($data);

        print_r($data);

        $response = $this->curl_post($url, $data);

        // die(print_r($response));
        echo $response;

    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function get_coupons(Request $request){

        $data = $request->toArray();

        $data['SecurityKey']    = $this->brand->loyalty_security_id;
        $data['EnterpriseId']   = $this->brand->loyalty_enterprise_id;
        $data = json_encode($data);
        $url = $this->build_url($this->brand->loyalty_url, 'GetRSAOffers');

        $response = $this->curl_post($url, $data);

        $response = json_decode($response);

        return view('loyalty.coupons', compact('response'));
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    public function clip_offer(Request $request){

        $request->SecurityKey = $this->security_key($this->brand);
        $request->EnterpriseId = $this->enterprise_id($this->brand);

        $data = json_encode($request);

        $url = $this->build_url($this->brand->loyalty_url, 'ClipOffer');

        $response = $this->curl_post($url, $data);
        return $response;

    }

    /**
     * @param Request $request
     * POST UserToken
     * returns users clipped coupons
     */
    public function get_user_clips(Request $request){

        $url = $this->build_url($this->brand->loyalty_url, 'GetUserClips');

        $SecurityKey    = $this->brand->loyalty_security_id;
        $EnterpriseId   = $this->brand->loyalty_enterprise_id;

        $url = $url."/".$request->UserToken."/".$EnterpriseId."/".$SecurityKey;

        $response = $this->curl_get($url);

        return $response;

    }

    /**
     * @param $url
     * @param $data
     * @return bool|string
     */
    public function curl_post($url, $data){
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
    public function get_brand($store_code){

        $data = Brand::join('stores', 'stores.brand_id', '=', 'brands.id')->where('stores.store_code', '=', $store_code)->first();

        return $data;
    }

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
            echo $response;
        }
    }

}
