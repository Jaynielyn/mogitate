@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <aside class="sidebar">
        <h2 class="page__title">商品一覧</h2>
        <form method="GET" action="{{ route('index') }}">
            <div class="search__box">
                <input
                    type="text"
                    name="search"
                    placeholder="商品名で検索"
                    class="search__input"
                    value="{{ request('search') }}">
                <button type="submit" class="search__button">検索</button>
            </div>
            <div class="sort__box">
                <label for="sort" class="sort__label">価格順で表示</label>
                <select id="sort" name="sort" class="sort__select" onchange="this.form.submit()">
                    <option value="">価格で並べ替え</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>安い順</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順</option>
                </select>
            </div>
        </form>
    </aside>

    <div class="content">
        <div class="add__product">
            <a href="/products/register">
                <button>+ 商品を追加</button>
            </a>
        </div>
        <div class="card-grid">
            @foreach ($products->chunk(3) as $chunk)
            <div class="card-row">
                @foreach ($chunk as $product)
                <a href="{{ route('products.show', $product->id) }}" class="card">
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    <h3>{{ $product->name }}</h3>
                    <p>&yen;{{ number_format($product->price) }}</p>
                </a>
                @endforeach
            </div>
            @endforeach
        </div>

        <!-- ページネーションリンク -->
        <div class="pagination">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection