<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public $brand;

    public function __construct()
    {
        $url = explode('.', $_SERVER['HTTP_HOST'])[1];

        $this->brand = $this->get_brand($url);
    }

    public function get_brand($url)
    {
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

        return view('contact', compact('brand'));
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
        $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email',
            'message'  => 'required'
        ]);

        Mail::send('contact-email', ['request' => $request], function ($m) use ($request) {
            $m->from('digital@buyforlessok.com', 'Uptown Grocery - Digital Marketing');
            $m->to('help@buyforlessok.com')
                ->replyTo($request->email)
                ->subject("[Loyalty Program] Message From " . $request->name);
        });

        return view('contact-confirm');
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
}
