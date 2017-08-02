<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class UpdatePermissionRequest extends FormRequest
{
    use HasWithParameter;

    /**
     * Determine if the permission is authorized to make this request.
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
        $permission = Permission::find($this->route()->parameters['permission']);
        $permissionId = $permission->id;

        $rules = Permission::$rules;
        $rules['name'] = 'required|unique:permissions,name,' . $permissionId;
        $rules['label'] = 'required|unique:permissions,label,' . $permissionId;
        return $rules;
    }
}
