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

    public function create()
    {
        //
    }

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

        return view('contact-confirm', compact('brand'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
