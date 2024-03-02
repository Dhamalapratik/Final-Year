<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy("id","desc")->paginate(10);
        return view('admin.product.index-product', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'category_id' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'full_description' => 'required',

                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('productimages'), $image_name);

            $image_path = $image_name;


            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->category = $request->category_id;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->full_description = $request->full_description;
            $product->image = $image_path;
            $product->save();


            return redirect()->route('admin.products')->with('message', 'Product created successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view('admin.product.edit-product', compact('product', 'categories'));
    }


    public function update(Request $request, $id){
        try{
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'category_id' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'full_description' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if(request()->hasFile('image')){
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('productimages'), $image_name);
                $image_path = $image_name;
            }else{
                $image_path = $product->image;
            }

            $product->name = $request->name;
            $product->price = $request->price;
            $product->category = $request->category_id;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->full_description = $request->full_description;
            $product->image = $image_path;
            $product->save();
            return redirect()->route('admin.products')->with('message', 'Product updated successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }


    }


    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.products')->with('message', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
