<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Get corresponding subcategories
     * by selecting category
     * @param  mixed $categoryId
     * @return void
     */
    public function getSubcategories($categoryId)
    {
        $subcategories = Subcategory::where('category_id', $categoryId)->where('status', 1)->get();

        return response()->json($subcategories);
    }

    /**
     * Get all list of items
     *
     * @return void
     */
    public function index()
    {
        $productModel = new Product();
        $products     = $productModel->geProductList();

        return view('admin.product.index', compact('products'));
    }

    /**
     * View for add new record
     *
     * @return void
     */
    public function addProduct()
    {
        $categories    = Category::latest()->where('status', 1)->get();
        $subcategories = Subcategory::latest()->where('status', 1)->get();
        return view('admin.product.add', compact('categories', 'subcategories'));
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
                'name'              => 'required|unique:products',
                'short_description' => 'required',
                'long_description'  => 'required',
                'price'             => 'integer|required',
                'quantity'          => 'integer|required',
                'category_id'       => 'integer|required',
                'subcategory_id'    => 'integer|required',
                'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status'            => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                // Image
                $image     = $request->file('image');
                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path('upload'), $imageName);
                $imageUrl = 'upload/' . $imageName;

                $categoryId    = $request->category_id;
                $subcategoryId = $request->subcategory_id;

                Product::insert([
                    'name'              => $request->name,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,
                    'price'             => $request->price,
                    'quantity'          => $request->quantity,
                    'category_id'       => $categoryId,
                    'subcategory_id'    => $subcategoryId,
                    'image'             => $imageUrl,
                    'slug'              => strtolower(str_replace(' ', '-', $request->name)),
                    'status'            => $request->status
                ]);

                Category::where('id', $categoryId)->increment('product_count', 1);
                Subcategory::where('id', $subcategoryId)->increment('product_count', 1);

                DB::commit();

                return redirect()->route('all.product')->with('message', 'Product created successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to create product. Please try again.');
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
        $productInfo   = Product::findOrFail($id);
        $categories    = Category::latest()->where('status', 1)->get();
        $subcategories = Subcategory::latest()->where('status', 1)->get();

        return view('admin.product.edit', compact('productInfo', 'categories', 'subcategories'));
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

            $productId = $request->product_id;

            $validator = Validator::make($request->all(), [
                'name'              => 'required|unique:products',
                'short_description' => 'required',
                'long_description'  => 'required',
                'price'             => 'integer|required',
                'quantity'          => 'integer|required',
                'category_id'       => 'integer|required',
                'subcategory_id'    => 'integer|required',
                'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status'            => 'integer|required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {

                DB::beginTransaction();

                // Image
                $image     = $request->file('image');
                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $request->image->move(public_path('upload'), $imageName);
                $imageUrl = 'upload/' . $imageName;

                $categoryId    = $request->category_id;
                $subcategoryId = $request->subcategory_id;

                Product::findOrFail($productId)->update([
                    'name'              => $request->name,
                    'short_description' => $request->short_description,
                    'long_description'  => $request->long_description,
                    'price'             => $request->price,
                    'quantity'          => $request->quantity,
                    'category_id'       => $categoryId,
                    'subcategory_id'    => $subcategoryId,
                    'image'             => $imageUrl,
                    'slug'              => strtolower(str_replace(' ', '-', $request->name)),
                    'status'            => $request->status
                ]);

                DB::commit();

                return redirect()->route('all.product')->with('message', 'Product updated successfully');
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update product. Please try again.');
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
        $categoryId    = Product::where('id', $id)->value('category_id');
        $subcategoryId = Product::where('id', $id)->value('subcategory_id');

        Product::findOrFail($id)->delete();

        Category::where('id', $categoryId)->decrement('product_count', 1);
        Subcategory::where('id', $subcategoryId)->decrement('product_count', 1);

        return redirect()->route('all.product')->with('message', 'Product deleted successfully');
    }
}
