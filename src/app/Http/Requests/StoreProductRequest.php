<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,10000',
            'image' => 'nullable',
            'seasons' => 'nullable',
            'description' => 'required|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値を入力してください',
            'price.between' => '0~10000円以内で入力してください',
            'image.required' => '商品画像を登録してください。',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'description.required' => '商品説明を入力してください。',
            'description.max' => '商品説明は120文字以内で入力してください。',
            'seasons.required' => '季節を選択してください。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 値段のエラーチェック
            $price = $this->input('price');
            $priceErrors = [];
            if (is_null($price) || $price === '') {
                $priceErrors[] = '値段を入力してください。';
                $priceErrors[] = '数値を入力してください。';
                $priceErrors[] = '0~10000円以内で入力してください。';
            } else {
                if (!is_numeric($price)) {
                    $priceErrors[] = '数値を入力してください。';
                }
                if (is_numeric($price) && ($price < 0 || $price > 10000)) {
                    $priceErrors[] = '0~10000円以内で入力してください。';
                }
            }
            if (!empty($priceErrors)) {
                $validator->errors()->add('price', implode("\n", $priceErrors));
            }

            // 商品画像のエラーチェック
            $image = $this->file('image');
            $imageErrors = [];
            if (!$image) {
                $imageErrors[] = '商品画像を登録してください。';
                $imageErrors[] = '「.png」または「.jpeg」形式でアップロードしてください。';
            } else {
                if (!$image->isValid()) {
                    $imageErrors[] = 'アップロードされた画像が無効です。';
                }
                $extension = $image->getClientOriginalExtension();
                if (!in_array($extension, ['jpeg', 'png'])) {
                    $imageErrors[] = '「.png」または「.jpeg」形式でアップロードしてください。';
                }
                if ($image->getSize() > 2048 * 1024) {
                    $imageErrors[] = '画像サイズは2MB以下でアップロードしてください。';
                }
            }
            if (!empty($imageErrors)) {
                $validator->errors()->add('image', implode("\n", $imageErrors));
            }

            // 季節のエラーチェック
            $seasons = $this->input('seasons');
            if (!is_array($seasons) || empty($seasons)) {
                $validator->errors()->add('seasons', '季節を選択してください。');
            }

            // 商品説明のエラーチェック
            $description = $this->input('description');
            $descriptionErrors = [];
            if (is_null($description) || trim($description) === '') {
                $descriptionErrors[] = '商品説明を入力してください。';
                $descriptionErrors[] = '商品説明は120文字以内で入力してください。';
            } else {
                if (mb_strlen($description) > 120) {
                    $descriptionErrors[] = '商品説明は120文字以内で入力してください。';
                }
            }
            if (!empty($descriptionErrors)) {
                $validator->errors()->add('description', implode("\n", $descriptionErrors));
            }
        });
    }
}
