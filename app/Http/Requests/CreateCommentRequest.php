<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'content' => 'required|string|max:1000',
            'article_id' => 'required|exists:articles,id',
            'user_id' => 'required|exists:users,id'
        ];  
    }
    public function messages(): array
    {
        return [
            'content.required' => 'Nội dung bình luận là bắt buộc.',
            'content.string' => 'Nội dung bình luận phải là chuỗi.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
            'article_id.required' => 'Bài viết là bắt buộc.',
            'article_id.exists' => 'Bài viết không tồn tại.',
            'user_id.required' => 'Người dùng là bắt buộc.',
            'user_id.exists' => 'Người dùng không tồn tại.'
        ];
    }
}
