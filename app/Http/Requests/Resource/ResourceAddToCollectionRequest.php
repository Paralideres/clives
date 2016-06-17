<?php

namespace App\Http\Requests\Resource;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceAddToCollectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'collection_id' => 'required|numeric|exists:collections,id',
        ];
    }

    public function authorize()
    {
        $resource = Auth::user()->resources()->find($this->route('id'));

        // Only logged users
        if ( Auth::user()->hasRole('admin'))
        {
            return true;
        }

        if ($resource) {
          return true;
        }

        return false;
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
