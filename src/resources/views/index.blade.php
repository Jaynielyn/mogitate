@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <aside class="sidebar">
        <h2 class="page__title">商品一覧</h2>
        <div class="search__box">
            <input type="text" placeholder="商品名で検索" class="search__input">
            <button class="search__button">検索</button>
        </div>
        <div class="sort__box">
            <label for="sort" class="sort__label">価格順で表示</label>
            <select id="sort" class="sort__select">
                <option class="sort__option" value="">価格で並べ替え</option>
                <option class="sort__option" value="asc">安い順</option>
                <option class="sort__option" value="desc">高い順</option>
            </select>
        </div>
    </aside>

    <div class="content">
        <div class="add__product">
            <a href="/products/register">
                <button>+ 商品を追加</button>
            </a>
        </div>
        <div class="card-grid">
            @foreach ($products as $product)
            <div class="card">
                <!-- 商品画像 -->
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>&yen;{{ number_format($product->price) }}</p>
            </div>
            @endforeach
        </div>
        <div class="pagination">
            <span class="page-number">&lt;</span>
            <span class="page-number active">1</span>
            <span class="page-number">2</span>
            <span class="page-number">3</span>
            <span class="page-number">&gt;</span>
        </div>
    </div>
</div>
@endsection