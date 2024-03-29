
<?php
class Hello extends CI_Controller 	
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('Hello_Model');
	}

	// public function index()
 //    {
 //        $this->load->helper(array('form', 'url'));
 //        $this->load->library('form_validation');
 //        if ($this->form_validation->run() == FALSE)
 //        {
 //        	$this->load->view('registration');
 //        }
 //        else
 //        {
 //        	$this->load->view('formsuccess');
 //        }

 //        $this->form_validation->set_rules('name', 'Name', 'required');
	// 	$this->form_validation->set_rules('email', 'Email', 'required');
	// 	$this->form_validation->set_rules('mobile', 'Mobile', 'required');
 //    }

	public function savedata()
	{
		$this->load->view('registration');
		if($this->input->post('save'))
		{
			$n=$this->input->post('name');
			$e=$this->input->post('email');
			$m=$this->input->post('mobile');
			$this->Hello_Model->saverecords($n,$e,$m);		
			redirect("Hello/dispdata");
		}
	}

	public function dispdata()
	{
		$result['data']=$this->Hello_Model->displayrecords();
		$this->load->view('display_records',$result);
	}

	public function deletedata()
	{
		$id=$this->input->get('id');
		$this->Hello_Model->deleterecords($id);
		redirect("Hello/dispdata");
	}

	public function updatedata()
	{
		$id=$this->input->get('id');
		$result['data']=$this->Hello_Model->displayrecordsById($id);
		$this->load->view('update_records',$result);	
	
		if($this->input->post('update'))
		{
			$n=$this->input->post('name');
			$e=$this->input->post('email');
			$m=$this->input->post('mobile');
			$this->Hello_Model->updaterecords($n,$e,$m,$id);
			redirect("Hello/dispdata");
		}
	}
}
?>