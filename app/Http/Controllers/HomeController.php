<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        ->create();
        $database = $firebase->getDatabase();

        $createUser = $database->getReference('users')->getvalue();
        $createCat = $database->getReference('category')->getvalue();
        $createMenu = $database->getReference('menu')->getvalue();
        $createOrder = $database->getReference('orders')->getvalue();
        $user = 0;
        $category = 0;
        $menu = 0;
        $order = 0;
        foreach( $createUser as $Count){
            $user++;
        }    
        foreach( $createCat as $cat){
            $category++;
        }
           
        foreach( $createMenu as $menus){
            $menu++;
        }  
        
        foreach( $createOrder as $orders){
            $order++;
        }
        return view('home', compact('user', 'category', 'menu', 'order'));
    }
}
