<?php

class Employee extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('Emp_Model');
	}

	public function savedata()
	{
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('gender','Gender','required');
		$this->form_validation->set_rules('city','City','required');
		$this->form_validation->set_rules('contact','Contact','required');
		$this->form_validation->set_rules('email','E-mail','required|is_unique[employee.email]');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == false)
		{
			$this->load->view('emp_form');
		}
		else
		{
			$data=array(
				$name=$this->input->post('name'),
				$gender=$this->input->post('gender'),
				$city=$this->input->post('city'),
				$contact=$this->input->post('contact'),
				$email=$this->input->post('email'),
				$password=$this->input->post('password'),
			);
			$this->Emp_Model->saverecords($name,$gender,$city,$contact,$email,$password);
			redirect("Employee/displaydata");
		}
	}

	public function displaydata()
	{
		$result['data']=$this->Emp_Model->displayrecords();
		$this->load->view('emp_display',$result);
	}

	public function updatedata()
	{
		$id=$this->input->get('id');
		$result['data']=$this->Emp_Model->displayrecordsById($id);
		$this->load->view('emp_update',$result);

		if($this->input->post('update'))
		{
			$name=$this->input->post('name');
			$gender=$this->input->post('gender');
			$city=$this->input->post('city');
			$contact=$this->input->post('contact');
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$this->Emp_Model->updaterecords($id,$name,$gender,$city,$contact,$email,$password);
			redirect("Employee/displaydata");
		}
	}

	public function deletedata()
	{
		$id=$this->input->get('id');
		$this->Emp_Model->deleterecords($id);
		redirect("Employee/displaydata");
	}

	public function index()
	{
		$this->load->view('emp_login');
	}

	public function post_login()
	{
		$this->form_validation->set_rules('email','E-mail','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == false)
		{
			$this->load->view('emp_login');
		}
		else
		{
			$data=array(
				'email'=>$this->input->post('email'),
				'password'=>$this->input->post('password'),
			);

			$check=$this->Emp_Model->emp_check($data);

			if($check != false)
			{
				$user=array(
					'id'=>$check->id,
					'name'=>$check->name,
					'gender'=>$check->gender,
					'city'=>$check->city,
					'contact'=>$check->contact,
					'email'=>$check->email,
				);
				$this->session->set_userdata($user);
				redirect("Employee/dashboard");
			}
			$this->load->view('emp_login');
		}
	}

	public function dashboard()
	{
		$this->load->view('emp_dashboard');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect("Employee/post_login");
	}
}

?>