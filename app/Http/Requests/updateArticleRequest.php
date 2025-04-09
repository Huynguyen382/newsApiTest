<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class updateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id',
            'author_id' => 'required|integer|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bài viết là bắt buộc.',
            'content.required' => 'Nội dung bài viết là bắt buộc.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'author_id.required' => 'Tác giả là bắt buộc.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'author_id.exists' => 'Tác giả không tồn tại.',
        ];
    }
    public function checkArticleExists($id)
    {
        return Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:articles,id',
            Rule::exists('articles', 'id'),
        ])->passes();
    }
}

