<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    public function displayCategory()
    {
        $categories = Category::paginate(10);
        return view('admin.category.category', compact('categories'));
    }

    public function editCategory($id)
    {
        try {
            $category = Category::findOrFail($id);

            return view('admin.category.edit-category', compact('category'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong.");
        }
    }


    public function updateCategory(Request $request, $id)
    {
        try {
            // Find the category by ID
            $category = Category::findOrFail($id);

            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
            ]);

            // Update the category properties
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save(); // Use save() instead of update()

            return redirect()->route('admin.category')->with("message", "Category is successfully updated.");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Something went wrong.");
        }
    }

    public function deleteCategory($id)
    {
        try {
            // Find the category by ID
            $category = Category::findOrFail($id);

            // Delete the category
            $category->delete();

            return redirect()->route('admin.category')->with('message','Sucessfully Deleted');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->route('admin.category')->with('message','Unsucessfull');
        }
    }
}
