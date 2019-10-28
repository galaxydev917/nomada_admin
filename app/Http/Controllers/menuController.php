<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class menuController extends Controller
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

    public function category()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        ->create();

        $database = $firebase->getDatabase();

        $categories = $database->getReference('category')->getvalue();
        // foreach ($categories as $category) {
        //     print_r($category);
        //     //$menu = $database->getReference('menu/'.$category->category)
        // }
        return view('category',compact('categories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listMenu()
    {       
        return view('menuList');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        // $firebase = (new Factory)
        // ->withServiceAccount($serviceAccount)
        // ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        // ->create();

        // $database = $firebase->getDatabase();

        // $users = $database->getReference('users')->getvalue();
        // foreach ($categories as $category) {
        //     print_r($category);
        //     //$menu = $database->getReference('menu/'.$category->category)
        // }
        return view('users');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('menu', compact('id'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order()
    {
        return view('order');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat()
    {
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        // $firebase = (new Factory)
        // ->withServiceAccount($serviceAccount)
        // ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        // ->create();

        // $database = $firebase->getDatabase();

        // $messages = $database->getReference('users')->getvalue();
        return view('chatList');
    }
    public function conversation($id)
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        ->create();

        $database = $firebase->getDatabase();

        $messages = $database->getReference('messages/'.$id)->getvalue();

       return view('chat', compact('messages'));
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
}
