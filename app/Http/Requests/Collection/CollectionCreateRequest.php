<?php

namespace App\Http\Requests\Collection;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\Request;

class CollectionCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required|max:100',
            'category' => 'required|numeric'
      	];
    }

    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
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
