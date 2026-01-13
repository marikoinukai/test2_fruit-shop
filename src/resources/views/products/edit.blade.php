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

                <label class="file-btn" for="image">
                    ファイルを選択
                </label>
                <span class="file-name" id="file-name">
                    {{ basename($product->image) }}
                </span>

                <input
                    id="image"
                    class="file-input"
                    type="file"
                    name="image"
                    accept=".png,.jpg,.jpeg"
                    onchange="showFileName(this)">

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
        <div class="field field--desc field--with-trash">
            <label class="label" for="description">商品説明</label>
            <textarea id="description" class="textarea" name="description" rows="7">{{ old('description', $product->description) }}</textarea>

            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="actions">
            <div class="actions__center">
                <a class="btn btn--gray" href="{{ url('/products') }}">戻る</a>
                <button class="btn btn--yellow" type="submit">変更を保存</button>
            </div>

            {{-- 削除（ゴミ箱） --}}
            <form class="trash-form" action="{{ url('/products/' . $product->id . '/delete') }}" method="POST">
                @csrf
                <button class="trash" type="submit" aria-label="delete">🗑</button>
            </form>
        </div>
    </form>
</div>
@endsection