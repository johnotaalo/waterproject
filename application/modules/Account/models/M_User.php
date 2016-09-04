<?php

(defined('BASEPATH')) or exit("No direct script access allowed");

class M_User extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_all_users($user_id = NULL)
	{
		if($user_id != NULL)
		{
			$this->db->where('id != ', $user_id);
		}
		$query = $this->db->get('user');

		return $query->result();
	}

	function get_users_by_phrase($phrase)
	{
		if ($phrase != "") {
			$sql = "SELECT * FROM user WHERE username LIKE '%{$phrase}%' OR emailaddress LIKE '%{$phrase}%'";

			$query = $this->db->query($sql);

			return $query->result();
		}
		else
		{
			return NULL;
		}
	}

	function update_user($user_id, $update_data)
	{
		if (is_array($update_data) && $update_data) {
			$this->db->where('id', $user_id);
			return $this->db->update('user', $update_data);
		}
	}
}