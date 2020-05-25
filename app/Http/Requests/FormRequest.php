<?php

namespace Modules\core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    protected $fieldId = 'id';

    public function response(array $errors)
    {
        if ($this->expectsJson()) {
            return response()->json($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get($this->fieldId);
        $rules = $this->rules;
        if (!$id) {
            return $rules;
        }

        foreach ($rules as $field => $rule) {
            if (is_string($rule)) {
                $rules[$field] = $rule = explode('|', $rule);
            }
            foreach ($rule as $k => $v) {
                if (strpos($v, "unique:") !== false) {
                    $rules[$field][$k] = $v . "," . $id . "," . $this->fieldId;
                }
            }
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }
}
