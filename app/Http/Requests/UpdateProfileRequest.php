<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:6',
            'role' => 'nullable|string|in:admin,user,author,reader'
        ];
    }

    protected function checkCategoryExists($id)
    {
        return Validator::make(['id' => $id], [
            'id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
        ])->passes();
    }
}
