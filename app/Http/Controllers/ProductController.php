<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 5;

        if(!empty($keyword)){
            $products = Product::where('name', 'LIKE', "%$keyword%")
                ->orWhere('category', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }
        // $products = Product::orderby('created_at')->get();
        return view('products.index', ['products' => $products])->with('i', (request()->input('page', 1) - 1) *$perPage);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(request $request)
    {
        // return $request->all();

        $request->validate([
                'name' => 'required',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028',
        ]);

        $product = new Product();

        $file_name = time() . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);  
        // if (request()->hasFile('imagePath')){
        //     $uploadedImage = $request->file('imagePath');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images/productImages/');
        //     $uploadedImage->move($destinationPath, $imageName);
        //     $image->imagePath = $destinationPath . $imageName;
        // }

        $product->name = $request->name;
        $product->description = $request->description;
        // $product->image = $request->image;
        $product->image = $file_name;
        $product->category = $request->category;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product created successfully.');

        // https://www.youtube.com/watch?v=MJp8ycjNW5s 45,56
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        return view('products.edit',['product' => $product]);
    }

    public function update(Request $request, Product $product){
            $request->validate([
                'name' => 'required',
            ]);

            $file_name = $request->hidden_product_image;

            if($request->image != ''){
                $file_name = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images'), $file_name);   
            }

            $product = Product::find($request->hidden_id);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->image = $file_name;
            $product->category = $request->category;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->save();

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id) {
        $product = Product::findOrFail($id);
        $image_path = public_path()."/images";
        $image = $image_path . $product->image;
        if(file_exists($image)){
            @unlink($image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}