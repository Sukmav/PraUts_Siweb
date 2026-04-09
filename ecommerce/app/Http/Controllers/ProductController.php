<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function landing()
    {
        $products = Product::with('categories')->get();
        return view('index', compact('products'));
    }

    public function index()
    {
        $products = Product::with('categories')->get();
        return view('welcome', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'nullable|array'
        ]);

        $product = Product::create([
            'name' => $request->name,
        ]);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('product_edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
        ]);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        } else {
            $product->categories()->detach(); 
        }

        return redirect()->route('product')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->categories()->detach();

        $product->delete();

        return redirect()->route('product')->with('success', 'Produk berhasil dihapus');
    }
}