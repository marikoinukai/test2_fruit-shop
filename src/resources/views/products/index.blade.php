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

            <form class="search" method="GET" action="{{ route('products.index') }}">
                <input
                    class="input"
                    type="text"
                    name="keyword"
                    placeholder="商品名で検索"
                    value="{{ request('keyword') }}">
                <button class="btn btn--yellow" type="submit">検索</button>

                <div class="sort">
                    <p class="sort__label">価格順で表示</p>

                    <select class="select {{ request('sort') ? 'is-selected' : '' }}" name="sort" onchange="this.form.submit()">
                        <option value="" disabled {{ request('sort') ? '' : 'selected' }}>価格で並べ替え</option>
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

            <div class="grid">
                @foreach($products as $product)
                <a class="card" href="{{ url('/products/' . $product->id . '/update') }}">
                    <div class="card__image">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </div>

                    <div class="card__body">
                        <p class="card__name">{{ $product->name }}</p>
                        <p class="card__price">¥{{ number_format($product->price) }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            @if ($products->hasPages())
            <nav class="pagination">
                {{-- 前へ --}}
                @if ($products->onFirstPage())
                <span class="page-btn is-disabled" aria-disabled="true">&lt;</span>
                @else
                <a class="page-btn" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="prev">&lt;</a>
                @endif

                {{-- ページ番号 --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                <span class="page-num is-active">{{ $page }}</span>
                @else
                <a class="page-num" href="{{ $url }}">{{ $page }}</a>
                @endif
                @endforeach

                {{-- 次へ --}}
                @if ($products->hasMorePages())
                <a class="page-btn" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="next">&gt;</a>
                @else
                <span class="page-btn is-disabled" aria-disabled="true">&gt;</span>
                @endif
            </nav>
            @endif

        </section>

    </div>
</div>
@endsection