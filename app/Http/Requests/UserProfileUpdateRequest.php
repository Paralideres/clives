<?php namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\UserProfile;
use Response;

class UserProfileUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      	return [
            'fullname' => 'max:100',
            'country' => 'max:100|regex:/^[(a-zA-Z\s)]+$/u',
            'city' => 'max:100|regex:/^[(a-zA-Z\s)]+$/u',
            'birthdate' => 'date',
            'description' => 'max:300',
            'image' => 'max:100',
            'social_facebook' => 'max:50',
            'social_twitter' => 'max:50',
            'social_youtube' => 'max:20',
            'social_instagram' => 'max:50',
            'social_snapchat' => 'max:30'
      	];
    }

    public function authorize()
    {

        // Only logged users
        if ( Auth::user()->hasRole('admin'))
        {
            return true;
        }

        return Auth::id() === $this->route('id');
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
