<?php namespace AhmadFatoni\ApiGenerator\Helpers;

Class Helpers {

	public function apiArrayResponseBuilder($statusCode = null, $message = null, $data = [])
	{
		$arr = [
			'status_code' => (isset($statusCode)) ? $statusCode : 500,
			'message' => (isset($message)) ? $message : 'error'
		];
		if ($data) {
			$arr['data'] = $data;
		}

		return response()->json($arr, $arr['status_code']);
		//return $arr;
		
	}
}