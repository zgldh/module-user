<?php namespace $NAME$\User\Requests;

use $NAME$\User\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;
use zgldh\Scaffold\Traits\HasWithParameter;

class CreatePermissionRequest extends FormRequest
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
        $rules = Permission::$rules;
        $rules['name'] = 'required|unique:permissions';
        $rules['label'] = 'required|unique:permissions';
        return $rules;
    }
}
