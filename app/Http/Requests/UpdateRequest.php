<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
        return [
            'no_rm'      => 'required',
            'no_sep'     => 'required',
            'tgl_sep'    => 'required',
            'file_claim' => 'required|dokumen'
        ];
    }

    public function messages()
    {
        return [
            'no_rm.required' => 'No RM harus di isi!',
            'no_sep.required' => 'No SEP Harus di isi!',
            'tgl_sep.required' => 'Tanggal SEP harus di isi!!',
            // 'file_claim.required' => 'File Claim tidak boleh kosong!',
            'file_claim.dokumen' => 'File tidak sesuai dengan aturan format (PDF,pdf)!'
		];
    }

    protected function getValidatorInstance()
	{
        $validator = parent::getValidatorInstance();

        $validator->addImplicitExtension('dokumen', function($attribute, $value, $parameters) {
            if($value) {
                return in_array($value->getClientOriginalExtension(), ['xls', 'xlsx', 'doc', 'docx', 'pdf']);
            }

            return false;
        });

        return $validator;
	}
}
