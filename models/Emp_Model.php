<?php

class Emp_Model extends CI_Model
{
	function saverecords($name,$gender,$city,$contact,$email,$password)
	{
		$data = array(
			'name' => $name,
			'gender' => $gender,
			'city' => $city,
			'contact' => $contact,
			'email' => $email,
			'password' => $password
		);
		$this->db->insert('employee',$data);
	}

	function displayrecords()
	{
		$sql = $this->db->get('employee');
		return $sql->result();
	}

	function displayrecordsById($id)
	{
		$sql = $this->db->get_where('employee', array('id' => $id));
		return $sql->result();
	}

	function updaterecords($id,$name,$gender,$city,$contact,$email,$password)
	{
		$data = array(
			'name' => $name,
			'gender' => $gender,
			'city' => $city,
			'contact' => $contact,
			'email' => $email,
			'password' => $password
		);
		$this->db->where('id',$id);
		$this->db->update('employee',$data);
	}

	function deleterecords($id)
	{
		$this->db->delete('employee', array('id' => $id));
	}

	function emp_check($data)
	{
		$sql=$this->db->get_where('employee',$data);
		if($sql)
		{
			return $sql->row();
		}
		return false;
	}
}

?>