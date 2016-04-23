<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use \Response;
class RuleRequest extends Request {

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
			'amount' => 'numeric|required'
		];
	}

	public function forbiddenResponse()
    {
        return Response::make('Sorry!',403);
    }

    public function messages()
    {
        return [
        ];
    }

}
