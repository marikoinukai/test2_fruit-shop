@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="layout">

        {{-- 左：サイドバー --}}
        <aside class="sidebar">
            <h1 class="page-title">商品一覧</h1>

            <form class="search" method="GET" action="{{ url('/products') }}">
                <input
                    class="input"
                    type="text"
                    name="keyword"
                    placeholder="商品名で検索"
                    value="{{ request('keyword') }}">
                <button class="btn btn--yellow" type="submit">検索</button>

                <div class="sort">
                    <p class="sort__label">価格順で表示</p>

                    <select class="select" name="sort" onchange="this.form.submit()">
                        <option value="">価格で並べ替え</option>
                        <option value="price_desc" @selected(request('sort')==='price_desc' )>高い順に表示</option>
                        <option value="price_asc" @selected(request('sort')==='price_asc' )>安い順に表示</option>
                    </select>

                    @if(request()->filled('sort'))
                    <a class="chip" href="{{ url('/products') . '?' . http_build_query(request()->except('sort')) }}">
                        {{ request('sort')==='price_desc' ? '高い順に表示' : '安い順に表示' }} ✕
                    </a>
                    @endif
                </div>
            </form>
        </aside>

        {{-- 右：商品カード --}}
        <section class="content">
            @php
            // いまは見た目確認用のダミーデータ（あとでDBに差し替え）
            $products = [
            ['name'=>'キウイ','price'=>800,'img'=>'images/kiwi.jpg'],
            ['name'=>'ストロベリー','price'=>1200,'img'=>'images/strawberry.jpg'],
            ['name'=>'オレンジ','price'=>850,'img'=>'images/orange.jpg'],
            ['name'=>'スイカ','price'=>700,'img'=>'images/watermelon.jpg'],
            ['name'=>'ピーチ','price'=>1000,'img'=>'images/peach.jpg'],
            ['name'=>'シャインマスカット','price'=>1400,'img'=>'images/grape.jpg'],
            ];
            @endphp

            <div class="grid">
                @foreach($products as $product)
                <article class="card">
                    <div class="card__image">
                        <img src="{{ asset($product['img']) }}" alt="{{ $product['name'] }}">
                    </div>

                    <div class="card__body">
                        <p class="card__name">{{ $product['name'] }}</p>
                        <p class="card__price">¥{{ number_format($product['price']) }}</p>
                    </div>
                </article>
                @endforeach
            </div>

            <nav class="pagination">
                <a class="page-btn" href="#" aria-label="prev">&lt;</a>
                <a class="page-num is-active" href="#">1</a>
                <a class="page-num" href="#">2</a>
                <a class="page-num" href="#">3</a>
                <a class="page-btn" href="#" aria-label="next">&gt;</a>
            </nav>
        </section>

    </div>
</div>
@endsection