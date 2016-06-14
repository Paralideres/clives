<?php namespace App\Http\Requests\Resource;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceUploadRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'resource' => 'required|mimes:doc,docx,ppt,pptx,pdf,xls,xslx,otf|max:4000',
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
