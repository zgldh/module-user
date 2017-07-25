<?php namespace $NAME$\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use $NAME$\User\Models\Role;

class UpdateRoleRequest extends FormRequest
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
        $role = Role::find($this->route()->parameters['role']);
        $roleId = $role->id;

        $rules = Role::$rules;
        $rules['name'] = 'required|unique:roles,name,' . $roleId;
        $rules['label'] = 'required|unique:roles,label,' . $roleId;
        return $rules;
    }
}
