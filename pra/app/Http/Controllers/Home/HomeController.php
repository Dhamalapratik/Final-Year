<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use Exception;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $userType = Auth::user()->role;

            if ($userType == 'admin') {
                return view('admin.HomePage');
            }
            else if ($userType == 'user') {
                $products = Product::orderBy("id", "desc")->paginate(4);
                $categories = Category::all();
                return view('HomePage', compact('products', 'categories'));
            } else {
                redirect()->route('login');
            }
        }
    }
    public function display_Products(){
        // try{
            $products = $products = Product::orderBy("id", "desc")->paginate(5);
            $categories = Category::all();
            return view('filter_page', compact('products', 'categories'));

        // }
        // catch(
        //  Exception e
        // )

    }
}
