<?php
namespace App\Http\Requests\Resource;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class ResourceCreateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'title' => 'required|max:100',
            'review' => 'required|max:300'
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
