<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SepRequest extends FormRequest
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
            'jnsPelayanan' => 'required',
            'noKartu' => 'required|min:8',
            'noMR' => 'required',
            'cob' => 'required',
            'no_reg' => 'required',
            'noRujukan' => 'required|min:10',
            'ppkRujukan' => 'required',
            'asalRujukan' => 'required',
            'tglRujukan' => 'required',
            'diagAwal' => 'required',
            'tujuan' => 'required',
            'eksekutif' => 'required',
            'noTelp' => 'required',
            'noSurat' => 'required',
            'kodeDPJP' => 'required',
            'catatan' => 'required',
            'katarak' => 'required',
            'lakaLantas' => 'required',
            'penjamin' => 'required',
            'suplesi' => 'required',
            'noSepSuplesi' => 'required',
            'tglKejadian' => 'required',
            'kdPropinsi' => 'required',
            'kdKabupaten' => 'required',
            'kdKecamatan' => 'required'
            //
        ];
    }
}
