<?php

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}

	public function index()
	{
		if($this->input->post('register'))
		{
			$n=$this->input->post('name');
			$e=$this->input->post('email');
			$p=$this->input->post('password');
			$m=$this->input->post('mobile');
			$c=$this->input->post('course');

			$que=$this->db->query("select * from stud where email='".$e."'");
			$row=$que->num_rows();
			if($row)
			{
				$data['error']="<h3 style='color:red'>This user already exist</h3>";
			}else
			{
				$que=$this->db->query("insert into stud values ('','$n','$e','$p','$m','$c')");
				$data['error']="<h3 style='color:blue'>Your account created successfully</h3>";
			}
		}
		$this->load->view('stud_registration',@data);
	}

	public function login()
	{
		
		if($this->input->post('login'))
		{
			$e=$this->input->post('email');
			$p=$this->input->post('password');
	
			$que=$this->db->query("select * from stud where email='".$e."' and password='$p'");
			$row = $que->num_rows();
			if($row)
			{
				redirect('User/dashboard');
			}else
			{
				$data['error']="<h3 style='color:red'>Invalid login details</h3>";
			}	
		}
		$this->load->view('login',@$data);		
	}
	
	function dashboard()
	{
	$this->load->view('dashboard');
	}
}

?>