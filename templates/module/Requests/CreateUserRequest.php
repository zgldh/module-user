<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class CreateUserRequest extends FormRequest
{
    use HasWithParameter;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = User::$rules;
        $rules['name'] = 'required|unique:users';
        $rules['email'] = 'required|email|unique:users';
        return $rules;
    }

    public function attributes()
    {
        return __('module_user::t.models.user.fields');
    }
}
