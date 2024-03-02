<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminController extends Controller
{
    // public function displayCategory(){
    //     return view('admin.category.category');
    // }


    public function displayDashboard(){
        return view('admin.HomePage');
    }


    public function addCategory(){
        return view('admin.category.create-category');
    }


    public function storeCategory(Request $request){
        try{
            $request->validate([
                'name'=> 'required|string',
                'description' => 'nullable|string'
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return redirect()->route('admin.category')->with('message','Successfully Added');

        }
        catch(\Exception $e){
            return redirect()->back()->with('error', "something went wrong try agin later.");
        }
    }
}
