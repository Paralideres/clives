<?php
namespace App\Http\Requests\Resource;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'title' => 'max:100',
            'review' => 'max:300',
            'content' => 'max:4000'
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
