<?php namespace $NAME$\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use $NAME$\User\Models\Role;

class CreateRoleRequest extends FormRequest
{

    /**
     * Determine if the role is authorized to make this request.
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
        $rules = Role::$rules;
        $rules['name'] = 'required|unique:roles';
        $rules['label'] = 'required|unique:roles';
        return $rules;
    }
}
