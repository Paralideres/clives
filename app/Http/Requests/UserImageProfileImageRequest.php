<?php namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserImageProfileImageRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'image' => 'required|mimes:jpeg,bmp,png|size:4000',
      	];
    }

    public function authorize()
    {
        // Only logged users
        if ( Auth::user()->hasRole('admin'))
        {
            return true;
        }

        return Auth::id() == $this->route('user_id');
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
