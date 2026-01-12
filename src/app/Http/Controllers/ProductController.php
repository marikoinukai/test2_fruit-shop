<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 一覧    
    public function index(Request $request)
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // 登録画面
    public function create()
    {
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    // 登録処理
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'integer', 'min:0', 'max:10000'],
                'image' => ['required', 'file', 'mimes:png,jpg,jpeg'],
                'description' => ['required', 'string', 'max:120'],
                'seasons' => ['required', 'array'],
                'seasons.*' => ['integer', 'exists:seasons,id'],
            ],
            [
                'name.required' => '商品名を入力してください',
                'price.required' => '値段を入力してください',
                'price.integer' => '数値で入力してください',
                'price.min' => '0-10000円以内で入力してください',
                'price.max' => '0-10000円以内で入力してください',
                'image.required' => '商品画像を登録してください',
                'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
                'seasons.required' => '季節を選択してください',
                'description.required' => '商品説明を入力してください',
                'description.max' => '120文字以内で入力してください',
            ]
        );

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
    public function edit(Product $product)
    {
        $seasons = Season::all();
        $selectedSeasonIds = $product->seasons()->pluck('seasons.id')->toArray();

        return view('products.edit', compact('product', 'seasons', 'selectedSeasonIds'));
    }

    // 更新処理
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'price' => ['required', 'integer', 'min:0', 'max:10000'],
                'image' => ['nullable', 'file', 'mimes:png,jpg,jpeg'],
                'description' => ['required', 'string', 'max:120'],
                'seasons' => ['required', 'array'],
                'seasons.*' => ['integer', 'exists:seasons,id'],
            ],
            [
                'name.required' => '商品名を入力してください',
                'price.required' => '値段を入力してください',
                'price.integer' => '数値で入力してください',
                'price.min' => '0-10000円以内で入力してください',
                'price.max' => '0-10000円以内で入力してください',
                'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
                'seasons.required' => '季節を選択してください',
                'description.required' => '商品説明を入力してください',
                'description.max' => '120文字以内で入力してください',
            ]
        );

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
    public function destroy(Product $product)
    {
        $product->seasons()->detach();
        $product->delete();

        return redirect('/products');
    }
}
