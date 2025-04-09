<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ArticleModel;
use Illuminate\Support\Facades\Gate;

class deleteArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $article = ArticleModel::find($this->route('id'));
        return $article && Gate::allows('delete', $article);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:articles,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id.required' => 'ID bài viết là bắt buộc.',
            'id.integer' => 'ID bài viết phải là số nguyên.',
            'id.exists' => 'Bài viết không tồn tại.',
        ];
    }
}