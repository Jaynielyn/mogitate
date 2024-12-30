@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main class="product__register-container">
    <h2>商品登録</h2>
    <form class="product__register-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <label for="product__name" class="form__label">商品名 <span class="required">必須</span></label>
            <input type="text" name="name" id="product__name" placeholder="商品名を入力" value="{{ old('name') }}">
            @error('name')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- 値段 -->
        <div class="form__group">
            <label for="product__price" class="form__label">値段 <span class="required">必須</span></label>
            <input type="number" name="price" id="product__price" placeholder="値段を入力" value="{{ old('price') }}">
            @if ($errors->has('price'))
            <span class="text-danger">{!! nl2br(e($errors->first('price'))) !!}</span>
            @endif
        </div>

        <!-- 商品画像 -->
        <div class="form__group">
            <label for="product__image" class="form__label">商品画像 <span class="required">必須</span></label>
            <div id="image-preview-container" style="margin-top: 10px;">
                <img id="image-preview" src="" alt="プレビュー画像" style="max-width: 100%; height: auto; display: none;">
            </div>
            <input type="file" name="image" id="product__image" accept="image/*">
            @if ($errors->has('image'))
            <span class="text-danger">{!! nl2br(e($errors->first('image'))) !!}</span>
            @endif
        </div>

        <!-- 季節 -->
        <div class="form__group">
            <label class="form__label">季節 <span class="required">必須</span> <span class="optional">複数選択可</span></label>
            <div class="season__checkboxes" style="display: flex; gap: 10px;">
                @foreach($seasons as $season)
                <label style="display: flex; align-items: center; gap: 5px; cursor: pointer;" onclick="toggleCheckbox(this)">
                    <!-- チェックボックス -->
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}" style="display: none;">
                    <!-- 状態を示すアイコン -->
                    <img src="{{ asset('fruits-img/circle-regular.svg') }}"
                        alt="{{ $season->name }}"
                        style="width: 20px; height: 20px;">
                    <span>{{ $season->name }}</span>
                </label>
                @endforeach
            </div>
            @error('seasons')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div class="form__group">
            <label for="description" class="form__label">商品説明 <span class="required">必須</span></label>
            <textarea id="description" name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
            <span class="text-danger">{!! nl2br(e($errors->first('description'))) !!}</span>
            @endif
        </div>
        <!-- ボタン -->
        <div class="action__buttons">
            <button type="button" class="btn back__btn" onclick="history.back()">戻る</button>
            <button type="submit" class="btn register__btn">登録</button>
        </div>
    </form>
</main>

<script>
    document.getElementById('product__image').addEventListener('change', function(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // プレビューを表示
            };

            reader.readAsDataURL(file); // 画像をデータURLとして読み込む
        } else {
            preview.style.display = 'none'; // ファイルが選択されていない場合は非表示
        }
    });

    function toggleCheckbox(label) {
        const checkbox = label.querySelector('input[type="checkbox"]');
        const icon = label.querySelector('img');

        // チェック状態をトグル
        checkbox.checked = !checkbox.checked;

        // アイコン画像を切り替え
        icon.src = checkbox.checked ?
            "{{ asset('fruits-img/circle-check-solid.svg') }}" // チェック状態
            :
            "{{ asset('fruits-img/circle-regular.svg') }}"; // 未チェック状態
    }

    // ページ読み込み時に初期アイコン設定
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        const icon = checkbox.nextElementSibling; // アイコンを取得
        icon.src = checkbox.checked ?
            "{{ asset('fruits-img/circle-check-solid.svg') }}" // チェック済み
            :
            "{{ asset('fruits-img/circle-regular.svg') }}"; // 未チェック
    });
</script>
@endsection