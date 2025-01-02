<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 価格で並べ替え
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('price', $request->sort);
        }

        // データを取得
        $products = $query->get();

        $products = $query->paginate(6);

        return view('index', compact('products'));
    }

    public function create()
    {
        $seasons = Season::all();

        return view('product_register', compact('seasons'));
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $product = Product::create($validatedData);

        if ($request->has('seasons')) {
            $product->seasons()->attach($request->seasons);
        }

        return redirect()->route('index')->with('success', '商品を登録しました！');
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product_detail', compact('product'));
    }

    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        return view('product_edit', compact('product'));
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'season' => 'nullable|array',
            'season.*' => 'in:春,夏,秋,冬',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        if ($request->has('season')) {
            $product->seasons()->sync($request->season);
        }

        $product->update($validatedData);

        return redirect()->route('products.show', $productId)->with('success', '商品情報を更新しました！');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('index')->with('success', '商品を削除しました！');
    }

}