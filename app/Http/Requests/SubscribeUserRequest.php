<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeUserRequest extends FormRequest {

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
		    'username'              => ['required','regex:/^[a-zA-Z]+$/','max:32','unique:account_data,name'],
			'pseudo'                => 'required|unique:account_data,pseudo|max:32',
			'password'              => 'required|min:8|confirmed',
			'password_confirmation' => 'required',
			'email'                 => 'required|email|unique:account_data,email'
		];
	}

}
