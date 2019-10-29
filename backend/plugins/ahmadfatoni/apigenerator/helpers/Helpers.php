<?php namespace AhmadFatoni\ApiGenerator\Helpers;

Class Helpers {

	public function apiArrayResponseBuilder($statusCode = null, $message = null, $data = [], $errorMessage = null)
	{
		$arr = [
			'status_code' => (isset($statusCode)) ? $statusCode : 500,
			'message' => (isset($message)) ? $message : 'error'
		];
		if ($data) {
			$arr['data'] = $data;
		}
		$response = null;
		if($errorMessage)
			$response = response()->
						json($arr, $arr['status_code'], $errorMessage);
		else
			$response = response()->
						json($arr, $arr['status_code']);
		return $response;
	}
}