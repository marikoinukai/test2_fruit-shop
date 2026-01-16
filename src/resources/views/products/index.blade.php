@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')
<div class="container">

    <div class="page-head">
        <h1 class="page-title">
            @if(request()->filled('keyword'))
            “{{ request('keyword') }}”の商品一覧
            @else
            商品一覧
            @endif
        </h1>

        @if (!request()->filled('keyword'))
        <a class="btn btn--add" href="{{ route('products.create') }}">
            ＋ 商品を追加
        </a>
        @endif
    </div>

    <div class="layout">

        {{-- 左：サイドバー --}}
        <aside class="sidebar">
            <form class="search" method="GET" action="{{ route('products.search') }}">
                <input
                    class="input"
                    type="text"
                    name="keyword"
                    placeholder="商品名で検索"
                    value="{{ request('keyword') }}">
                <button class="btn btn--yellow" type="submit">検索</button>

                <div class="sort">
                    <p class="sort__label">価格順で表示</p>
                    <div class="select-wrap">
                        <select id="sortSelect" class="select {{ request('sort') ? 'is-selected' : '' }}" name="sort">
                            <option value="" disabled {{ !request()->filled('sort') ? 'selected' : '' }}>価格で並べ替え</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>安い順に表示</option>
                        </select>
                    </div>
                    @if(request()->filled('sort'))
                    <a class="chip" href="{{ url('/products') . '?' . http_build_query(request()->except('sort')) }}">
                        {{ request('sort')==='price_desc' ? '高い順に表示' : '安い順に表示' }}
                    </a>
                    @endif
                </div>
            </form>
        </aside>

        {{-- 右：商品カード --}}
        <section class="content">
            <div class="grid">
                @foreach($products as $product)
                <a class="card" href="{{ route('products.edit', ['productId' => $product->id]) }}">
                    <div class="card__image">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('sortSelect');
        if (!select) return;

        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
</script>

@endsection