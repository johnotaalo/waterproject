<?php



class M_Account extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addUser($user_details_array)
	{
		$this->db->insert('user', $user_details_array);
	}

	function getUser($email)
	{
		$this->db->where('emailaddress', $email);
		$query = $this->db->get('user');
		return $query->row();
	}

	function getUserById($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		return $query->row();
	}

}