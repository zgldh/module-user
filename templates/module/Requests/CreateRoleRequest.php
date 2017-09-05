<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class CreateRoleRequest extends FormRequest
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
        $rules = Role::$rules;
        $rules['name'] = 'required|unique:roles';
        $rules['label'] = 'required|unique:roles';
        return $rules;
    }

    public function attributes()
    {
        return __('module_user::t.models.role.fields');
    }
}
