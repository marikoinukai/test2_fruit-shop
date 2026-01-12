@extends('layouts.app')

@section('title', '商品更新')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/edit.css') }}">
@endsection

@section('content')
<div class="page">
    <p class="breadcrumb">
        <a href="{{ url('/products') }}">商品一覧</a> &gt; {{ $product->name }}
    </p>

    <form class="form" action="{{ url('/products/' . $product->id . '/update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid">
            {{-- 左：画像 --}}
            <div class="image-area">
                <div class="preview">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                </div>

                <input class="file" type="file" name="image" accept=".png,.jpg,.jpeg">
                @error('image')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 右：入力 --}}
            <div class="fields">

                <div class="field">
                    <label class="label" for="name">商品名</label>
                    <input id="name" class="input" type="text" name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label" for="price">値段</label>
                    <input id="price" class="input" type="text" name="price" value="{{ old('price', $product->price) }}">
                    @error('price')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <p class="label">季節</p>
                    <div class="seasons">
                        @foreach($seasons as $season)
                        <label class="season">
                            <input
                                type="checkbox"
                                name="seasons[]"
                                value="{{ $season->id }}"
                                {{ in_array($season->id, old('seasons', $selectedSeasonIds)) ? 'checked' : '' }}>
                            <span>{{ $season->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('seasons')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="field field--desc">
            <label class="label" for="description">商品説明</label>
            <textarea id="description" class="textarea" name="description" rows="7">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="actions">
            <a class="btn btn--gray" href="{{ url('/products') }}">戻る</a>
            <button class="btn btn--yellow" type="submit">変更を保存</button>

            {{-- 削除（ゴミ箱） --}}
            <button class="trash" type="submit" form="deleteForm" aria-label="delete">🗑</button>
        </div>
    </form>

    {{-- 削除用フォーム --}}
    <form id="deleteForm" action="{{ url('/products/' . $product->id . '/delete') }}" method="POST">
        @csrf
    </form>
</div>
@endsection