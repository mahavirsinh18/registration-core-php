<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
            $this->load->model('mymodel');
    }

	public function index()
	{

		$data['title'] = "Page";

		$this->load->view('pages', $data);
	}

	public function getpage($id){
		echo $id;
		echo "Hello";
		exit;
	}
}
