<?php

namespace App\Http\Requests\Poll;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PollCreateRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|max:100',
            'active' => 'required|boolean',
            'date_from' => 'required|date_format:d/m/Y',
            'date_to' => 'required|date_format:d/m/Y|after:date_from',
            'options' => 'required|array',
        ];
    }

    public function authorize()
    {
        return Auth::user()->hasRole('admin');
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
