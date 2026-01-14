<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    // 一覧    
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索（keyword）
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え（sort）
        if ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } else {
            $query->latest('id'); // 何も指定がなければ新しい順など
        }

        // 3×2 6件/ページ
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', compact('products'));
    }

    // 登録画面
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 登録処理
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // 画像保存
        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = 'storage/' . $path;

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'image' => $validated['image'],
            'description' => $validated['description'],
        ]);

        // 中間テーブル登録
        $product->seasons()->sync($validated['seasons']);

        return redirect('/products');
    }

    // 更新画面
    public function edit(Product $productId)
    {
        $product = $productId;

        $seasons = Season::all();
        $selectedSeasonIds = $product->seasons()->pluck('seasons.id')->toArray();

        return view('products.edit', compact('product', 'seasons', 'selectedSeasonIds'));
    }

    // 更新処理
    public function update(UpdateProductRequest $request, Product $productId)
    {
        $product = $productId;

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? $product->image,
            'description' => $validated['description'],
        ]);

        $product->seasons()->sync($validated['seasons']);

        return redirect('/products');
    }

    // 削除
    public function destroy(Product $productId)
    {
        $product = $productId;

        $product->seasons()->detach();
        $product->delete();

        return redirect('/products');
    }

    // 詳細
    public function show(Product $productId)
    {
        $product = $productId;
        return view('products.show', compact('product'));
    }
}
