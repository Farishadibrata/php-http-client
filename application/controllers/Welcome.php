<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$excluded = ['unprotected'];
		$method = $this->router->fetch_method();
		if(!in_array($method, $excluded)){
			if(!$this->checkHasToken()){
				echo 'error no token';
				die();
			}
		}
	}
	function http_login($username, $password)
	{

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "3000",
			CURLOPT_URL => "http://127.0.0.1:3000/login",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "username=" . $username . "&password=" . $password,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}
	function checkTokenValidity()
	{
		$token = getallheaders()['token'];
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_PORT => "3000",
			CURLOPT_URL => "http://127.0.0.1:3000/checkJWT",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"token: " . $token
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			if (strlen($response) < 1) {
				return false;
			} else {
				return true;
			}
		}
		curl_close($curl);
	}
	function checkHasToken()
	{
		$headers = getallheaders();
		if (isset($headers['token'])) {
			return true;
		} else {
			return false;
		}
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function login()
	{
		$body = $this->input->post();
		if (isset($body['username']) && isset($body['password'])) {
			$this->http_login($body['username'], $body['password']);
		} else {
			echo json_encode(array('error' => 'invalid creds'));
		}
	}
	public function protected_function()
	{
		echo 'Protected : You have token';
	}
	public function another_protected(){
		echo 'Another : You have token';
	}
	public function unprotected(){
		echo 'Success';
	}
}
