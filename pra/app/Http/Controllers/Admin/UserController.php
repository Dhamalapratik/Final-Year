<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class UserController extends Controller
{
    public function index()
    {

        $users = User::where('role', 'user')->get();
        return view('admin.user.index-user', compact('users'));
    }

    public function displayHome(){
        $products = Product::orderBy("id", "desc")->paginate(5);
        $categories = Category::all();
        return view('HomePage',compact('products','categories'));
    }

    public function deleteUser($id)
    {
        try {
            // Find the category by ID
            $user = User::findOrFail($id);

            // Delete the category
            $user->delete();

            return redirect()->route('admin.users')->with('message', 'Sucessfully Deleted');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->route('admin.users')->with('message', 'Unsucessfull');
        }
    }
}
