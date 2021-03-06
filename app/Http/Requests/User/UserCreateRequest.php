<?php namespace App\Http\Requests\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Response;

class UserCreateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
        		'username' => 'required|max:30|alpha_num|unique:users,username,NULL,id,deleted_at,NULL',
        		'email' => 'required|email|unique:users,username,NULL,id,deleted_at,NULL',
        		'password' => 'required|confirmed|min:7'
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
