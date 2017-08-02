<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class UpdateUserRequest extends FormRequest
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
        $user = User::find($this->route()->parameters['user']);
        $user_id = $user->id;

        $rules = User::$rules;
        $rules['name'] = 'required|unique:users,name,' . $user_id;
        $rules['email'] = 'email|unique:users,email,' . $user_id;
        unset($rules['password']);
        return $rules;
    }
}
