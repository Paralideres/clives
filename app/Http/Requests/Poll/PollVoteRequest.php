<?php

namespace App\Http\Requests\Poll;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PollVoteRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option' => 'required|integer',
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
