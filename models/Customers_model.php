<?php

class Customers_model extends CI_Model {
	public function get_customer($id){
		$data['id'] = 3;
		$data['first_name'] = 'Gohil';
		$data['last_name'] = 'Mahavirsinh';
		$data['address'] = 'Bhavnagar';

		return $data;
	}
}

?>