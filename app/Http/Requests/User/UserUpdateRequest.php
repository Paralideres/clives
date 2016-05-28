<?php namespace App\Http\Requests\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
        		'username' => 'required_if:email,NULL|max:30|alpha_num|unique:users,username,NULL,id,deleted_at,NULL',
        		'email' => 'required_if:username,NULL|email|unique:users,username,NULL,id,deleted_at,NULL',
        		'password' => 'required'
      	];
    }

    public function authorize()
    {
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
