<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
            $this->load->model('mymodel');
    }

	public function index()
	{

		$this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');

        if ($this->form_validation->run() == FALSE)
        {
                $this->load->view('regg');
        }
        else
        {
        	$data = $this->input->post();
        	echo "<pre>";
        	print_r($data);
        	$this->mymodel->form_insert($data);
        	exit;
            $this->load->view('formsuccess');

        }
	}

	public function list(){
		echo "<pre>";

		$list = $this->db->get('student');
		print_r($list);
		exit;
	}


	public function postdata(){
		$data = $this->input->post();
		$this->mymodel->form_insert($data);
	}
}
