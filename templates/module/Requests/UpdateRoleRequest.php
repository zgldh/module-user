<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class UpdateRoleRequest extends FormRequest
{
    use HasWithParameter;

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
