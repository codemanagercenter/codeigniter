<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	// 构造
	public function __construct()
	{
		parent::__construct();
		$this->load->library('curl');
		$this->load->library('session');
	}

	// 保修列表
	public function index()
	{

		$url = "http://lws.lohas-deco.com/Internal_DD.svc/GetDepartList";
		$result = $this->curl->doGet($url);
		header("Content-type:application/json;charset=utf-8");
		$output_json = json_encode($result);
		var_dump($output_json);exit;

		echo $output_json;
	}
}
