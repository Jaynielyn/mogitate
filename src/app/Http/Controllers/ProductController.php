<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

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
        // 指定された商品を取得
        $product = Product::findOrFail($productId);
        return view('product_detail', compact('product')); // 詳細ページにデータを渡す
    }

    public function edit($productId)
    {
        // 編集対象の商品を取得
        $product = Product::findOrFail($productId);
        return view('product_edit', compact('product')); // 編集ページ用のビュー
    }

    public function update(Request $request, $productId)
    {
        // 更新対象の商品を取得
        $product = Product::findOrFail($productId);

        // バリデーションルール
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'season' => 'nullable|array', // 季節は配列で受け取る
            'season.*' => 'in:春,夏,秋,冬', // 配列内の値を制限
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // 新しい画像を保存
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        // 季節データを処理（多対多リレーション）
        if ($request->has('season')) {
            $product->seasons()->sync($request->season); // 中間テーブルを更新
        }

        // 商品データを更新
        $product->update($validatedData);

        return redirect()->route('products.show', $productId)->with('success', '商品情報を更新しました！');
    }

    public function delete($id)
    {
        // 削除対象の商品を取得
        $product = Product::findOrFail($id);

        // ストレージから画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 商品を削除
        $product->delete();

        return redirect()->route('index')->with('success', '商品を削除しました！');
    }

}