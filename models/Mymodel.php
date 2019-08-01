<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model	 {

	public function __construct()
    {
            $this->load->database();
    }

	function form_insert($data){
		$this->db->insert('student', $data);
	}
}
