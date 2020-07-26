<?php

namespace App\Http\Requests\Admin\User;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
/**
 * Class ManageUserRequest.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => ['required', Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            // 'mobile_number' => 'required|regex:/(01)[0-9]{9}/',
            'mobile_number' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'max:255'],
            'email' => ['required', 'max:255', 'email', Rule::unique('users')],
            'password' => ['min:8','max:100', PasswordRules::register($this->email)],
            'active' => ['sometimes', 'in:1'],
            'email_verified' => ['sometimes', 'in:1'],
            'send_confirmation_email' => ['sometimes', 'in:1'],
        ];
    }
}
