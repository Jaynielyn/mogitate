@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail__page">
    <!-- パンくずリスト -->
    <div class="breadcrumb">
        <a href="{{ route('index') }}">商品一覧</a> &gt; {{ $product->name }}
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="product__detail">
            <!-- 商品画像 -->
            <div class="product__image">
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                <input type="file" name="image" class="form__control mt__2">
            </div>

            <!-- 商品情報 -->
            <div class="product__info">
                <!-- 商品名 -->
                <div class="form__group">
                    <label for="name">商品名</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form__control">
                </div>

                <!-- 値段 -->
                <div class="form__group">
                    <label for="price">値段</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="form__control">
                </div>

                <!-- 季節 -->
                <div class="form__group">
                    <label>季節</label>
                    <div style="display: flex; gap: 10px;">
                        @foreach (['春', '夏', '秋', '冬'] as $season)
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="seasons[]" value="{{ $season }}"
                                {{ in_array($season, $product->seasons->pluck('name')->toArray()) ? 'checked' : '' }}
                                style="display: none;">
                            <img src="{{ in_array($season, $product->seasons->pluck('name')->toArray()) ? asset('fruits-img/circle-check-solid.svg') : asset('fruits-img/circle-regular.svg') }}"
                                alt="{{ $season }}"
                                style="width: 20px; height: 20px; cursor: pointer;"
                                onclick="toggleCheckbox(this)">
                            <span>{{ $season }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- 商品説明 -->
        <div class="product__description">
            <div class="form__group">
                <label for="description">商品説明</label>
                <textarea id="description" name="description" class="form__control">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- ボタン -->
            <div class="form__actions">
                <button type="submit" class="btn btn__warning">変更を保存</button>
                <a href="{{ route('index') }}" class="btn btn__secondary">戻る</a>

                <form action="/products/{{ $product->id }}/delete" method="POST" onsubmit="return confirm('本当に削除しますか？')" style="display: inline;">
                    @csrf
                    @method('POST')
                    <button type="submit" style="border: none; background: none;">
                        <img src="{{ asset('fruits-img/trash-can-regular.svg') }}" alt="削除" style="width: 24px; height: 24px; cursor: pointer;">
                    </button>
                </form>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleCheckbox(icon) {
        const checkbox = icon.previousElementSibling; // 対応するチェックボックス
        checkbox.checked = !checkbox.checked; // チェック状態をトグル

        // アイコン画像の切り替え
        if (checkbox.checked) {
            icon.src = "{{ asset('fruits-img/circle-check-solid.svg') }}";
        } else {
            icon.src = "{{ asset('fruits-img/circle-regular.svg') }}";
        }
    }

    // 初期状態でアイコンを適切に設定
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        const icon = checkbox.nextElementSibling;
        icon.src = checkbox.checked ?
            "{{ asset('fruits-img/circle-check-solid.svg') }}" :
            "{{ asset('fruits-img/circle-regular.svg') }}";
    });
</script>
@endsection