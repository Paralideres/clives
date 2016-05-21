<?php
namespace App\Http\Requests\Category;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class CategoryCreateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'label' => 'required|max:30|alpha',
            'slug' => 'required|unique:categories,slug|max:30|alpha_dash'
      	];
    }

    public function authorize()
    {
        return true;
    }

    public function forbiddenResponse()
    {
        return new JsonResponse('Access Forbiden', 403);
    }

    public function response(array $errors)
    {
        return new JsonResponse($errors, 422);
    }
}
