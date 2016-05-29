<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use \Response;
class ItemRequest extends Request {

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
			'name' => 'required',
			'cost_price' => 'numeric|required',
			'selling_price' => 'numeric|required',
			'category'	=> 'required'
		];
	}

	public function forbiddenResponse()
    {
        return Response::make('Sorry!',403);
    }
    
    public function messages()
    {
        return [
            'avatar.mimes' => 'Not a valid file type. Valid types include jpeg, bmp and png.'
        ];
    }

}
