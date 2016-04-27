<?php

class Auth_model extends CI_Model 
{
	/*
	*	Validate a personnel's login request
	*
	*/
	public function validate_personnel()
	{
		//select the personnel by username from the database
		$this->db->select('*');
		$this->db->where(
			array(
				'personnel_username' => $this->input->post('personnel_username'), 
				'personnel_status' => 1, 
				'personnel_password' => md5($this->input->post('personnel_password'))
			)
		);
		$this->db->join('branch', 'branch.branch_id = personnel.branch_id');
		$query = $this->db->get('personnel');
		
		//if personnel exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();

			// get an active branch

			//$branch_details = $this->get_active_branch();

			//create personnel's login session
			$newdata = array(
                   'login_status'     			=> TRUE,
                   'first_name'     			=> $result[0]->personnel_fname,
                   'username'     				=> $result[0]->personnel_username,
                   'personnel_id'  				=> $result[0]->personnel_id,
                   'branch_id'  				=> $result[0]->branch_id,
                   'branch_code'  				=> $result[0]->branch_code,
                   'branch_name'  				=> $result[0]->branch_name,
				   'authorize_invoice_changes'	=> $result[0]->authorize_invoice_changes,
				   'authorize_supervisor_changes'	=> $result[0]->authorize_supervisor_changes
               );

			$this->session->set_userdata($newdata);
			
			//update personnel's last login date time
			$this->update_personnel_login($result[0]->personnel_id);
			return TRUE;
		}
		
		//if personnel doesn't exist
		else
		{
			return FALSE;
		}
	}

	public function get_active_branch()
	{
		$this->db->where('branch_status = 1');
		$this->db->from('branch');
		$query = $this->db->get();
		
		$result = $query->row();

		return $result;
	}
	
	/*
	*	Update personnel's last login date
	*
	*/
	private function update_personnel_login($personnel_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('personnel_id', $personnel_id);
		$this->db->update('personnel', $data); 
	}
	
	/*
	*	Reset a personnel's password
	*
	*/
	public function reset_password($personnel_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['personnel_password'] = md5($new_password);
		$this->db->where('personnel_id', $personnel_id);
		$this->db->update('personnel', $data); 
		
		return $new_password;
	}
	
	/*
	*	Check if a has logged in
	*
	*/
	public function check_login()
	{
		if($this->session->userdata('login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_personnel_roles($personnel_id)
	{
	}
	
	/*
	*	Validate a individual's login request
	*
	*/
	public function validate_individual()
	{
		//select the individual by username from the database
		$this->db->select('*');
		$this->db->where(
			array(
				'individual_username' => $this->input->post('individual_username'), 
				'individual_status' => 1, 
				'individual_password' => md5($this->input->post('individual_password'))
			)
		);
		
		$query = $this->db->get('individual');
		
		//if individual exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();

			// get an active branch

			//$branch_details = $this->get_active_branch();

			//create individual's login session
			$newdata = array(
                   'member_login_status'     	=> TRUE,
                   'first_name'     			=> $result[0]->individual_surname,
                   'username'     				=> $result[0]->individual_username,
                   'individual_id'  			=> $result[0]->individual_id
               );

			$this->session->set_userdata($newdata);
			
			//update individual's last login date time
			$this->update_individual_login($result[0]->individual_id);
			return TRUE;
		}
		
		//if individual doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update individual's last login date
	*
	*/
	private function update_individual_login($individual_id)
	{
		$data['last_login'] = date('Y-m-d H:i:s');
		$this->db->where('individual_id', $individual_id);
		$this->db->update('individual', $data); 
	}
	
	/*
	*	Activate an individual
	*
	*/
	public function activate_individual()
	{
		$individual_number = $this->input->post('individual_number');
		$individual_username = $this->input->post('individual_username');
		$individual_email = $this->input->post('individual_email');
		$individual_phone = $this->input->post('individual_phone');
		
		//create individual's password
		$password = $this->auth_model->create_password($individual_number);
		
		//update other details
		$update_data = array(
				'individual_username' => $individual_username,
				'individual_phone' => $individual_phone,
				'individual_status' => 1, 
				'individual_password' => md5($password)
			);
		
		if(!empty($individual_email))
		{
			$update_data['individual_email'] = $individual_email;
		}
		//select the individual by username from the database
		$this->db->where('individual_number', $individual_number);
		if($this->db->update('individual', $update_data))
		{
			//SMS password to member
			if($this->messaging_model->sms($individual_phone, 'Your account has been activated. Please log in at www.omnis.co.ke/batterysacco/member-login with your username and this password: '.$password))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Create an individual's password
	*
	*/
	public function create_password($individual_number)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s').$individual_number), 0, 8);
		
		return $new_password;
	}
}
?>