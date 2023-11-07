<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Get all list of items
     *
     * @return void
     */
    public function index()
    {
        $subcategoryModel = new Subcategory();
        $subcategories    = $subcategoryModel->geSubcategoryList();

        return view('admin.subCategory.index', compact('subcategories'));
    }

    /**
     * View for add new record
     *
     * @return void
     */
    public function addSubCategory()
    {
        $categories = Category::latest()->where('status', 1)->get();
        return view('admin.subCategory.add', compact('categories'));
    }

    /**
     * Store new record
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'        => 'required|unique:subcategories',
                'category_id' => 'required',
                'status'      => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                $categoryId = $request->category_id;

                Subcategory::insert([
                    'name'        => $request->name,
                    'category_id' => $categoryId,
                    'slug'        => strtolower(str_replace(' ', '-', $request->name)),
                    'status'      => $request->status
                ]);

                Category::where('id', $categoryId)->increment('subcategory_count', 1);

                DB::commit();

                return redirect()->route('all.subcategory')->with('message', 'SubCategory created successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to create subcategory. Please try again.');
        }
    }

    /**
     * View for edit existing record
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id)
    {
        $subcategoryInfo = Subcategory::findOrFail($id);
        $categories      = Category::latest()->where('status', 1)->get();
        return view('admin.subCategory.edit', compact('subcategoryInfo', 'categories'));
    }

    /**
     * Update existig record
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        try {

            $subcategoryId = $request->subcategory_id;

            $validator = Validator::make($request->all(), [
                'name'        => 'required|unique:subcategories',
                'category_id' => 'required',
                'status'      => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                $categoryId = $request->category_id;

                Subcategory::findOrFail($subcategoryId)->update([
                    'name'        => $request->name,
                    'category_id' => $categoryId,
                    'slug'        => strtolower(str_replace(' ', '-', $request->name)),
                    'status'      => $request->status
                ]);

                DB::commit();

                return redirect()->route('all.subcategory')->with('message', 'Subcategory updated successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update subcategory. Please try again.');
        }
    }

    /**
     * Delete record
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        $categoryId = Subcategory::where('id', $id)->value('category_id');

        Subcategory::findOrFail($id)->delete();

        Category::where('id', $categoryId)->decrement('subcategory_count', 1);

        return redirect()->route('all.subcategory')->with('message', 'Subcategory deleted successfully');
    }
}
