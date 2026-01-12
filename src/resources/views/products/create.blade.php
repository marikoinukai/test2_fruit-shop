@extends('layouts.app')

@section('title', '商品登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')
<div class="page">
    <h1 class="page__title">商品登録</h1>

    <form class="form" action="{{ url('/products/register') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品名 --}}
        <div class="field">
            <div class="field__label">
                <label for="name">商品名</label>
                <span class="badge-required">必須</span>
            </div>
            <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 値段 --}}
        <div class="field">
            <div class="field__label">
                <label for="price">値段</label>
                <span class="badge-required">必須</span>
            </div>
            <input id="price" class="input" type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品画像 --}}
        <div class="field">
            <div class="field__label">
                <label for="image">商品画像</label>
                <span class="badge-required">必須</span>
            </div>

            <input id="image" class="file" type="file" name="image" accept=".png,.jpg,.jpeg">
            @error('image')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 季節 --}}
        <div class="field">
            <div class="field__label">
                <label>季節</label>
                <span class="badge-required">必須</span>
                <span class="badge-note">複数選択可</span>
            </div>

            <div class="seasons">
                @foreach($seasons as $season)
                <label class="season">
                    <input
                        type="checkbox"
                        name="seasons[]"
                        value="{{ $season->id }}"
                        @checked(in_array($season->id, old('seasons', [])))
                    >
                    <span>{{ $season->name }}</span>
                </label>
                @endforeach
            </div>

            @error('seasons')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="field">
            <div class="field__label">
                <label for="description">商品説明</label>
                <span class="badge-required">必須</span>
            </div>
            <textarea id="description" class="textarea" name="description" rows="6" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="actions">
            <a class="btn btn--gray" href="{{ url('/products') }}">戻る</a>
            <button class="btn btn--yellow" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection