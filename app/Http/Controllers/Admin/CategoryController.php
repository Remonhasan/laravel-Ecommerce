<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function addCategory()
    {
        return view('admin.category.add');
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'   => 'required|unique:categories',
                'status' => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                Category::insert([
                    'name'   => $request->name,
                    'slug'   => strtolower(str_replace(' ', '-', $request->name)),
                    'status' => $request->status
                ]);

                DB::commit();

                return redirect()->route('all.category')->with('message', 'Category created successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function edit($id)
    {
        $categoryInfo = Category::findOrFail($id);

        return view('admin.category.edit', compact('categoryInfo'));
    }

    public function update(Request $request)
    {
        try {

            $categoryId = $request->category_id;

            $validator = Validator::make($request->all(), [
                'name'   => 'required|unique:categories',
                'status' => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                Category::findOrFail($categoryId)->update([
                    'name'   => $request->name,
                    'slug'   => strtolower(str_replace(' ', '-', $request->name)),
                    'status' => $request->status
                ]);

                DB::commit();

                return redirect()->route('all.category')->with('message', 'Category updated successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update category. Please try again.');
        }
    }

    public function delete ($id)
    {
        Category::findOrFail($id)->delete();
        
        return redirect()->route('all.category')->with('message', 'Category deleted successfully');
    }
}
