<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class employeeController extends Controller
{
    private $viewPath = "employee.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/nomada.json');
        // $firebase = (new Factory)
        // ->withServiceAccount($serviceAccount)
        // ->withDatabaseUri('https://nomada-7f903.firebaseio.com')
        // ->create();
        // $database = $firebase->getDatabase();
        // $employees = $database->getReference('users')->getvalue();
        return view($this->viewPath."index");
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
            'name' => "required|string"
        ]);
        //store category in firebase here
        $name = $request->input("name");
        $newPost = self::$database
            ->getReference('categories')
            ->push([
                'name' => $name
            ]);
        return redirect()->route("categories.index")->with("success", "category $name added");
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

    public function getEmployee() : array {
        $categoriesFromFirebase = $this->database->getReference(self::$reference)->getValue();
        $categories = [];
        foreach ($categoriesFromFirebase as $key => $value) {
            $category = new Category();
            $category->key = $key;
            $category->name = $value['name'];
            $category->no_of_clothing = count(self::$database->getReference(ClothingController::$reference)
                ->orderByChild('category_key')
                ->equalTo($key)
                ->getValue());
            array_push($categories, $category);
        }
        return $categories;
    }
}
