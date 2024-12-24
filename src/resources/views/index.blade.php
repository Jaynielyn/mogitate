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
            <a href="/">
                <button>+ 商品を追加</button>
            </a>
        </div>
        <div class="card-grid">
            <div class="card">
                <img src="kiwi.jpg" alt="キウイ">
                <h3>キウイ</h3>
                <p>&yen;800</p>
            </div>
            <div class="card">
                <img src="strawberry.jpg" alt="ストロベリー">
                <h3>ストロベリー</h3>
                <p>&yen;1200</p>
            </div>
            <div class="card">
                <img src="orange.jpg" alt="オレンジ">
                <h3>オレンジ</h3>
                <p>&yen;850</p>
            </div>
            <div class="card">
                <img src="watermelon.jpg" alt="スイカ">
                <h3>スイカ</h3>
                <p>&yen;700</p>
            </div>
            <div class="card">
                <img src="peach.jpg" alt="ピーチ">
                <h3>ピーチ</h3>
                <p>&yen;1000</p>
            </div>
            <div class="card">
                <img src="grape.jpg" alt="シャインマスカット">
                <h3>シャインマスカット</h3>
                <p>&yen;1400</p>
            </div>
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