<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'no_reg'     => 'required|min:12,max:13',
            'no_rm'      => 'required',
            'no_sep'     => 'required',
            'tgl_sep'    => 'required',
            // 'tgl_pulang' => 'required',
            'file_claim' => 'required|dokumen'
        ];

    }

    public function messages()
    {
        return [
            'no_reg.required' => 'No Reg harus di isi!',
            // 'no_reg.unique' => 'No Reg sudah ada mohon (untuk mengubah silahkan edit)!',
            'no_rm.required' => 'No RM harus di isi!',
            'no_sep.required' => 'No SEP Harus di isi!',
            'tgl_sep.required' => 'Tanggal SEP harus di isi!!',
            // 'tgl_pulang.required' => 'Tanggal Pulang harus di isi!!',
            // 'file_claim.required' => 'File Claim tidak boleh kosong!',
            'file_claim.mimes' => 'File tidak sesuai dengan aturan format (PDF,pdf)!'
		];
    }

    protected function getValidatorInstance()
	{
        $validator = parent::getValidatorInstance();

        $validator->addImplicitExtension('dokumen', function($attribute, $value, $parameters) {
            if($value) {
                return in_array($value->getClientOriginalExtension(), ['xls', 'xlsx', 'doc', 'docx', 'pdf', 'PDF']);
            }
            
            return false;
        });

        return $validator;
	}
}
