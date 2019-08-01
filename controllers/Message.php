<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
	public function index(){
		$this->load->view('wel_message');
		$this->load->model('customers_model');
		$data['customer'] = $this->customers_model->get_customer(3);
		$this->load->view('wel_message',$data);
	}
}

?>