<?php

class Individual_model extends CI_Model 
{
	public function upload_image($path, $location, $resize, $name, $upload, $edit = NULL)
	{
		if(!empty($_FILES[$upload]['tmp_name']))
		{
			$image = $this->session->userdata($name);
			
			if((!empty($image)) || ($edit != NULL))
			{
				if($edit != NULL)
				{
					$image = $edit;
				}
				
				//delete any other uploaded image
				if($this->file_model->delete_file($path."\\".$image, $location))
				{
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($path."\\thumbnail_".$image, $location);
				}
				
				else
				{
					$this->file_model->delete_file($path."/".$image, $location);
					$this->file_model->delete_file($path."/thumbnail_".$image, $location);
				}
			}
			//Upload image
			$response = $this->file_model->upload_file($path, $upload, $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
					
				//Set sessions for the image details
				$this->session->set_userdata($name, $file_name);
			
				return TRUE;
			}
		
			else
			{
				$this->session->set_userdata('upload_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('upload_error_message', '');
			return FALSE;
		}
	}
	
	/*
	*	Retrieve all individual
	*
	*/

	public function add_cheque_disbursement($individual_id)
	{
		$data = array(
			'created'=> date('Y-m-d H:i:s'),
			'deleted' => 0,
			'deleted_on'=> date('Y-m-d H:i:s'),
			'individual_id'=>$individual_id,
			'created_by'=> $this->session->userdata('personnel_id'),
			'modified_by'=> $this->session->userdata('personnel_id'),
			'deleted_by'=> $this->session->userdata('personnel_id'),
			'cheque_number'=>$this->input->post('cheque_number'),
			'cheque_amount'=>$this->input->post('cheque_amount'),
			'dibursement_date'=>$this->input->post('disbursement_date')
			);
			if($this->db->insert('disbursement', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	public function all_individual($individual_id = NULL)
	{
		$where = 'individual_status = 0';
		
		if($individual_id != NULL)
		{
			$where .= ' AND individual.individual_id <> '.$individual_id;
		}
		$this->db->where($where);
		$this->db->order_by('individual_fname');
		$query = $this->db->get('individual');
		
		// var_dump($query);
		return $query;
	}
	
	/*
	*	Retrieve all parent individual
	*
	*/
	public function all_parent_individual($order = 'individual_name')
	{
		$this->db->where('individual_status = 1 AND individual_parent = 0');
		$this->db->order_by($order, 'ASC');
		$query = $this->db->get('individual');
		
		return $query;
	}
	/*
	*	Retrieve all children individual
	*
	*/
	public function all_child_individual()
	{
		$this->db->where('individual_status = 1 AND individual_parent > 0');
		$this->db->order_by('individual_name', 'ASC');
		$query = $this->db->get('individual');
		
		return $query;
	}
	
	/*
	*	Retrieve all individual
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_individual($table, $where, $per_page, $page, $order = 'individual_name', $order_method = 'ASC')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by($order, $order_method);
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_individual()
	{
		$data = array(
			'individual_mname'=>ucwords(strtolower($this->input->post('individual_mname'))),
			'individual_lname'=>ucwords(strtolower($this->input->post('individual_lname'))),
			'individual_fname'=>ucwords(strtolower($this->input->post('individual_fname'))),
			'individual_dob'=>$this->input->post('individual_dob'),
			'individual_email'=>$this->input->post('individual_email'),
			'gender_id'=>$this->input->post('gender_id'),
			'individual_phone'=>$this->input->post('individual_phone'),
			'individual_phone2'=>$this->input->post('individual_phone2'),
			'civilstatus_id'=>$this->input->post('civil_status_id'),
			'individual_address'=>$this->input->post('individual_address'),
			'individual_locality'=>$this->input->post('individual_locality'),
			'kra_pin'=>$this->input->post('kra_pin'),
			'title_id'=>$this->input->post('title_id'),
			'individual_number'=>$this->input->post('individual_number'),
			'individual_city'=>$this->input->post('individual_city'),
			'individual_post_code'=>$this->input->post('individual_post_code'),
			'individual_email2'=>$this->input->post('individual_email2'),
			'document_id'=>$this->input->post('document_id'),
			'document_number'=>$this->input->post('document_number'),
			'document_place'=>$this->input->post('document_place')
		);
		
		if($this->db->insert('individual', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing individual
	*	@param string $image_name
	*	@param int $individual_id
	*
	*/
	public function edit_individual($individual_id, $image, $signature)
	{
		$data = array(
			'individual_mname'=>ucwords(strtolower($this->input->post('individual_mname'))),
			'individual_lname'=>ucwords(strtolower($this->input->post('individual_lname'))),
			'individual_fname'=>ucwords(strtolower($this->input->post('individual_fname'))),
			'individual_dob'=>$this->input->post('individual_dob'),
			'individual_email'=>$this->input->post('individual_email'),
			'gender_id'=>$this->input->post('gender_id'),
			'individual_phone'=>$this->input->post('individual_phone'),
			'individual_phone2'=>$this->input->post('individual_phone2'),
			'civilstatus_id'=>$this->input->post('civil_status_id'),
			'individual_address'=>$this->input->post('individual_address'),
			'individual_locality'=>$this->input->post('individual_locality'),
			'kra_pin'=>$this->input->post('kra_pin'),
			'title_id'=>$this->input->post('title_id'),
			'individual_city'=>$this->input->post('individual_city'),
			'image'=>$image,
			'signature'=>$signature,
			'individual_email2'=>$this->input->post('individual_email2'),
			'document_id'=>$this->input->post('document_id'),
			'document_number'=>$this->input->post('document_number'),
			'document_place'=>$this->input->post('document_place')
		);
		
		$this->db->where('individual_id', $individual_id);
		if($this->db->update('individual', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	function upload_inividual_image($individual_id, $image)
	{
		$data = array(
			'document_name'=> $image,
			'created_by'=> $this->session->userdata('personnel_id'),
			'modified_by'=> $this->session->userdata('personnel_id'),
			'created'=> date('Y-m-d H:i:s'),
			'individual_id'=>$individual_id
		);
		
		if($this->db->insert('individual_identification', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function upload_individual_documents($individual_id, $document)
	{
		$data = array(
			'document_name'=> $this->input->post('document_item_name'),
			'document_upload_name'=> $document,
			'created_by'=> $this->session->userdata('personnel_id'),
			'modified_by'=> $this->session->userdata('personnel_id'),
			'created'=> date('Y-m-d H:i:s'),
			'individual_id'=>$individual_id
		);
		
		if($this->db->insert('document_uploads', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function get_individual_identifications($individual_id)
	{
		$this->db->from('individual_identification');
		$this->db->select('*');
		$this->db->where('individual_id = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	function get_document_uploads($individual_id)
	{
		$this->db->from('document_uploads');
		$this->db->select('*');
		$this->db->where('individual_id = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's children
	*	@param int $individual_id
	*
	*/
	public function get_sub_individual($individual_id)
	{
		//retrieve all users
		$this->db->from('individual');
		$this->db->select('*');
		$this->db->where('individual_parent = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's details
	*	@param int $individual_id
	*
	*/
	public function get_individual($individual_id)
	{
		//retrieve all users
		$this->db->from('individual');
		$this->db->select('*');
		$this->db->where('individual_id = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing individual
	*	@param int $individual_id
	*
	*/
	public function delete_individual($individual_id)
	{
		//delete parent
		if($this->db->delete('individual', array('individual_id' => $individual_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated individual
	*	@param int $individual_id
	*
	*/
	public function activate_individual($individual_id)
	{
		$data = array(
				'individual_status' => 1
			);
		$this->db->where('individual_id', $individual_id);
		

		if($this->db->update('individual', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated individual
	*	@param int $individual_id
	*
	*/
	public function deactivate_individual($individual_id)
	{
		$data = array(
				'individual_status' => 0
			);
		$this->db->where('individual_id', $individual_id);
		
		if($this->db->update('individual', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve gender
	*
	*/
	public function get_gender()
	{
		$this->db->order_by('gender_name');
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	/*
	*	Retrieve title
	*
	*/
	public function get_title()
	{
		$this->db->order_by('title_name');
		$query = $this->db->get('title');
		
		return $query;
	}
	
	/*
	*	Retrieve civil_status
	*
	*/
	public function get_civil_status()
	{
		$this->db->order_by('civil_status_name');
		$query = $this->db->get('civil_status');
		
		return $query;
	}
	
	/*
	*	Retrieve religion
	*
	*/
	public function get_religion()
	{
		$this->db->order_by('religion_name');
		$query = $this->db->get('religion');
		
		return $query;
	}
	
	/*
	*	Retrieve relationship
	*
	*/
	public function get_relationship()
	{
		$this->db->order_by('relationship_name');
		$query = $this->db->get('relationship');
		
		return $query;
	}
	
	/*
	*	Select get_job_titles
	*
	*/
	public function get_job_titles()
	{
		$this->db->select('*');
		$this->db->order_by('job_title_name', 'ASC');
		$query = $this->db->get('job_title');
		
		return $query;
	}
	
	/*
	*	get a single individual's details
	*	@param int $individual_id
	*
	*/
	public function get_emergency_contacts($individual_id)
	{
		//retrieve all users
		$this->db->from('individual_emergency, relationship');
		$this->db->select('*');
		$this->db->where('individual_emergency.individual_id = '.$individual_id.' AND individual_emergency.relationship_id = relationship.relationship_id');
		$this->db->order_by('individual_emergency_fname');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's details
	*	@param int $individual_id
	*
	*/
	public function get_individual_dependants($individual_id)
	{
		//retrieve all users
		$this->db->from('individual_dependant');
		$this->db->select('*');
		$this->db->where(array('individual_dependant.individual_id' => $individual_id, 'individual_dependant.relationship_id' => 'relationship.relationship_id'));
		$this->db->order_by('individual_dependant_fname');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's details
	*	@param int $individual_id
	*
	*/
	public function get_individual_jobs($individual_id)
	{
		//retrieve all users
		$this->db->from('individual_job');
		$this->db->select('individual_job.*');
		$this->db->order_by('employment_date', 'DESC');
		$this->db->where(array('individual_job.individual_id' => $individual_id));
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_leave_types()
	{
		$table = "leave_type";
		$where = "leave_type_status = 0";
		$items = "leave_type_id, leave_type_name";
		$order = "leave_type_name";
		
		$this->db->where($where);
		$this->db->order_by($order);
		$result = $this->db->get($table);
		
		return $result;
	}
	
	/*
	*	get a single individual's leave details
	*	@param int $individual_id
	*
	*/
	public function get_individual_leave($individual_id)
	{
		//retrieve all users
		$this->db->from('leave_duration, leave_type');
		$this->db->select('leave_duration.*, leave_type.leave_type_name');
		$this->db->order_by('start_date', 'DESC');
		$this->db->where(array('leave_duration.individual_id' => $individual_id, 'leave_duration.leave_type_id' => 'leave_type.leave_type_id'));
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's roles
	*	@param int $individual_id
	*
	*/
	public function get_individual_roles($individual_id)
	{
		//retrieve all users
		$this->db->from('individual_section, section');
		$this->db->select('individual_section.*, section.section_name, section.section_position');
		$this->db->order_by('section_position', 'ASC');
		$this->db->where(array('individual_section.individual_id' => $individual_id, 'individual_section.section_id' => 'section.section_id'));
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_individual_savings_plans($individual_id)
	{
		$this->db->from('individual_savings, savings_plan');
		$this->db->select('individual_savings.*, savings_plan.savings_plan_name');
		$this->db->order_by('created', 'DESC');
		$this->db->where('individual_savings.individual_id = '.$individual_id.' AND individual_savings.savings_plan_id = savings_plan.savings_plan_id');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_individual_plan($individual_id) 
	{
		$data = array(
			'individual_id'=>$individual_id,
			'savings_plan_id'=>$this->input->post('savings_plan_id'),
			'individual_savings_status'=>$this->input->post('individual_savings_status'),
			'individual_savings_opening_balance'=>$this->input->post('individual_savings_opening_balance'),
			'start_date'=>$this->input->post('start_date'),
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('individual_savings', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a individual plan
	*	@param int $individual_savings_id
	*
	*/
	public function activate_individual_plan($individual_savings_id)
	{
		$data = array(
				'individual_savings_status' => 1
			);
		$this->db->where('individual_savings_id', $individual_savings_id);
		

		if($this->db->update('individual_savings', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate a individual plan
	*	@param int $individual_savings_id
	*
	*/
	public function deactivate_individual_plan($individual_savings_id)
	{
		$data = array(
				'individual_savings_status' => 0
			);
		$this->db->where('individual_savings_id', $individual_savings_id);
		

		if($this->db->update('individual_savings', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_position($individual_id)
	{
		$data = array(
			'employer'=>$this->input->post('employer'),
			'job_title'=>$this->input->post('job_title'),
			'employment_date'=>$this->input->post('employment_date'),
			'individual_id'=>$individual_id,
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('individual_job', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a individual plan
	*	@param int $individual_savings_id
	*
	*/
	public function activate_individual_position($individual_job_id)
	{
		$data = array(
				'individual_job_status' => 1
			);
		$this->db->where('individual_job_id', $individual_job_id);

		if($this->db->update('individual_job', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate a individual plan
	*	@param int $individual_savings_id
	*
	*/
	public function deactivate_individual_position($individual_job_id)
	{
		$data = array(
				'individual_job_status' => 0
			);
		$this->db->where('individual_job_id', $individual_job_id);

		if($this->db->update('individual_job', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_emergency($individual_id)
	{
		$data = array(
			'individual_emergency_onames'=>ucwords(strtolower($this->input->post('individual_emergency_onames'))),
			'individual_emergency_fname'=>ucwords(strtolower($this->input->post('individual_emergency_fname'))),
			'individual_emergency_dob'=>$this->input->post('individual_emergency_dob'),
			'individual_emergency_email'=>$this->input->post('individual_emergency_email'),
			'individual_emergency_phone'=>$this->input->post('individual_emergency_phone'),
			'individual_emergency_phone2'=>$this->input->post('individual_emergency_phone2'),
			'individual_emergency_address'=>$this->input->post('individual_emergency_address'),
			'individual_emergency_city'=>$this->input->post('individual_emergency_city'),
			'individual_emergency_post_code'=>$this->input->post('individual_emergency_post_code'),
			'individual_emergency_email2'=>$this->input->post('individual_emergency_email2'),
			'share_percentage'=>$this->input->post('share_percentage'),
			'document_id'=>$this->input->post('document_id'),
			'document_number'=>$this->input->post('document_number'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'individual_id'=>$individual_id
		);
		
		if($this->db->insert('individual_emergency', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function edit_emergency($individual_id,$individual_emergency_id)
	{
		$data = array(
			'individual_emergency_onames'=>ucwords(strtolower($this->input->post('individual_emergency_onames'))),
			'individual_emergency_fname'=>ucwords(strtolower($this->input->post('individual_emergency_fname'))),
			'individual_emergency_dob'=>$this->input->post('individual_emergency_dob'),
			'individual_emergency_email'=>$this->input->post('individual_emergency_email'),
			'individual_emergency_phone'=>$this->input->post('individual_emergency_phone'),
			'individual_emergency_phone2'=>$this->input->post('individual_emergency_phone2'),
			'individual_emergency_address'=>$this->input->post('individual_emergency_address'),
			'individual_emergency_city'=>$this->input->post('individual_emergency_city'),
			'individual_emergency_post_code'=>$this->input->post('individual_emergency_post_code'),
			'individual_emergency_email2'=>$this->input->post('individual_emergency_email2'),
			'share_percentage'=>$this->input->post('share_percentage'),
			'document_id'=>$this->input->post('document_id'),
			'document_number'=>$this->input->post('document_number'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'individual_id'=>$individual_id
		);
		$this->db->where('individual_emergency_id = '.$individual_emergency_id);
		if($this->db->update('individual_emergency', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Delete an existing individual
	*	@param int $individual_id
	*
	*/
	public function delete_emergency($individual_emergency_id)
	{
		//delete children
		if($this->db->delete('individual_emergency', array('individual_emergency_id' => $individual_emergency_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_loan_repayment_amount($individual_id)
	{
		$this->db->from('savings_withdrawal');
		$this->db->select('savings_withdrawal.*');
		$this->db->where('individual_id = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	public function get_individual_loans($individual_id)
	{
		$this->db->from('individual_loan, disbursement');
		$this->db->select('individual_loan.*, loans_plan.loans_plan_name, disbursement.cheque_amount');
		$this->db->join('loans_plan', 'loans_plan.loans_plan_id = individual_loan.loans_plan_id', 'left');
		$this->db->order_by('disbursed_date', 'ASC');
		$this->db->where('individual_loan.individual_id = disbursement.individual_id ='.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_individual_loan($individual_id) 
	{
		$loans_plan_id = $this->input->post('loans_plan_id');
		
		//get loan details
		$this->db->select('loans_plan.interest_id, loans_plan.interest_rate, installment_type.installment_type_duration');
		$this->db->where('loans_plan_id', $loans_plan_id);
		$this->db->join('installment_type', 'installment_type.installment_type_id = loans_plan.installment_type_id', 'left');
		$query = $this->db->get('loans_plan');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$interest_id = $row->interest_id;
			$interest_rate = $row->interest_rate;
			$installment_type_duration = $row->installment_type_duration;
		}
		
		else
		{
			$interest_id = 0;
			$installment_type_duration = 0;
			$interest_rate = 0;
		}
		
		$data = array(
			'interest_rate'=>$interest_rate,
			'individual_id'=>$individual_id,
			'loans_plan_id'=>$loans_plan_id,
			'interest_rate'=>$interest_rate,
			'interest_id'=>$interest_id,
			'installment_type_duration'=>$installment_type_duration,
			'individual_loan_status'=>$this->input->post('individual_loan_status'),
			'individual_loan_opening_balance'=>$this->input->post('individual_loan_opening_balance'),
			'start_date'=>$this->input->post('start_date'),
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('individual_loan', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a individual plan
	*	@param int $individual_loan_id
	*
	*/
	public function activate_individual_loan($individual_loan_id)
	{
		$data = array(
				'individual_loan_status' => 1
			);
		$this->db->where('individual_loan_id', $individual_loan_id);
		

		if($this->db->update('individual_loan', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate a individual plan
	*	@param int $individual_loan_id
	*
	*/
	public function deactivate_individual_loan($individual_loan_id)
	{
		$data = array(
				'individual_loan_status' => 0
			);
		$this->db->where('individual_loan_id', $individual_loan_id);
		

		if($this->db->update('individual_loan', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function loan_application($individual_id) 
	{
		$loans_plan_id = $this->input->post('loans_plan_id');
		
		//get loan details
		$this->db->select('loans_plan.interest_id, loans_plan.interest_rate, installment_type.installment_type_duration');
		$this->db->where('loans_plan_id', $loans_plan_id);
		$this->db->join('installment_type', 'installment_type.installment_type_id = loans_plan.loans_plan_id', 'left');
		$query = $this->db->get('loans_plan');
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$interest_id = $row->interest_id;
			$interest_rate = $row->interest_rate;
			$installment_type_duration = $row->installment_type_duration;
		}
		
		else
		{
			$interest_id = 0;
			$installment_type_duration = 0;
			$interest_rate = 0;
		}
		
		$data = array(
			'interest_rate'=>$interest_rate,
			'individual_id'=>$individual_id,
			'loans_plan_id'=>$loans_plan_id,
			'interest_rate'=>$interest_rate,
			'interest_id'=>$interest_id,
			'installment_type_duration'=>$installment_type_duration,
			'proposed_amount'=>$this->input->post('proposed_amount'),
			'no_of_repayments'=>$this->input->post('no_of_repayments'),
			'grace_period'=>$this->input->post('grace_period'),
			'purpose'=>$this->input->post('purpose'),
			'application_date'=>$this->input->post('application_date'),
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('individual_loan', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	public function get_guarantors($individual_loan_id)
	{
		$this->db->from('individual, loan_guarantor');
		$this->db->select('individual.individual_fname, individual.individual_mname, individual.individual_lname, loan_guarantor.loan_guarantor_id, loan_guarantor.created_by, loan_guarantor.created, loan_guarantor.guaranteed_amount, personnel.personnel_fname, personnel.personnel_onames');
		$this->db->order_by('individual_fname', 'DESC');
		$this->db->join('personnel', 'personnel.personnel_id = loan_guarantor.created_by', 'left');
		$this->db->where('loan_guarantor.loan_guarantor_delete <> 1 AND individual.individual_id = loan_guarantor.individual_id AND loan_guarantor.individual_loan_id = '.$individual_loan_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_guarantors($individual_loan_id) 
	{
		$data = array(
			'individual_loan_id'=>$individual_loan_id,
			'individual_id'=>$this->input->post('individual_id'),
			'guaranteed_amount'=>$this->input->post('guaranteed_amount'),
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('loan_guarantor', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	public function delete_loan_guarantor($loan_guarantor_id)
	{
		$data = array(
			'loan_guarantor_delete'=>1,
			'deleted_on'=>date('Y-m-d H:i:s'),
			'deleted_by'=>$this->session->userdata('personnel_id')
		);
		
		$this->db->where('loan_guarantor_id', $loan_guarantor_id);
		if($this->db->update('loan_guarantor', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_loan_details($individual_loan_id)
	{
		$where = 'individual_loan.individual_loan_id = '.$individual_loan_id;
		$this->db->select('loans_plan.*');
		$this->db->where($where);
		$query = $this->db->get('loans_plan, individual_loan');
		
		// var_dump($query);
		return $query;
	}
	
	public function get_loan_payments($individual_id)
	{
		$this->db->from('loan_payment');
		$this->db->select('loan_payment.*, personnel.personnel_fname, personnel.personnel_onames');
		$this->db->order_by('loan_payment.payment_date', 'ASC');
		$this->db->join('personnel', 'personnel.personnel_id = loan_payment.created_by', 'left');
		$this->db->where('loan_payment.loan_payment_delete <> 1 AND loan_payment.individual_id = '.$individual_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Add a new individual
	*	@param string $image_name
	*
	*/
	public function add_loan_payment($individual_id) 
	{
		$data = array(
			'individual_id'=>$individual_id,
			'payment_amount'=>$this->input->post('payment_amount'),
			'payment_interest'=>$this->input->post('payment_interest'),
			'payment_date'=>$this->input->post('payment_date'),
			'created'=>date('Y-m-d H:i:s'),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('loan_payment', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	public function delete_loan_payment($loan_payment_id)
	{
		$data = array(
			'loan_payment_delete'=>1,
			'deleted_on'=>date('Y-m-d H:i:s'),
			'deleted_by'=>$this->session->userdata('personnel_id')
		);
		
		$this->db->where('loan_payment_id', $loan_payment_id);
		if($this->db->update('loan_payment', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_individual_loan($individual_loan_id)
	{
		$this->db->from('individual_loan');
		$this->db->where('individual_loan.individual_loan_id = '.$individual_loan_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single individual's details
	*	@param int $individual_id
	*
	*/
	
	public function get_savings_withdrawals($individual_id)
	{
		//retrieve all users
		$this->db->from('savings_payment');
		$this->db->select('*');
		$this->db->where('savings_payment.individual_id = '.$individual_id.' AND savings_payment.savings_payment_delete = 0 AND payment_type = 1');
		$this->db->order_by('payment_date', 'DESC');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_savings_payments($individual_id)
	{
		//retrieve all users
		$this->db->from('savings_payment');
		$this->db->select('*');
		$this->db->where('savings_payment.individual_id = '.$individual_id.' AND savings_payment.savings_payment_delete = 0 AND savings_payment.payment_type= 0');
		$this->db->order_by('payment_date', 'ASC');
		$query = $this->db->get();
		
		return $query;
	}
	public function get_all_savings_payments($individual_id)
	{
		//retrieve all users
		$this->db->from('savings_payment');
		$this->db->select('*');
		$this->db->where('savings_payment.individual_id = '.$individual_id.' AND savings_payment.savings_payment_delete = 0');
		$this->db->order_by('payment_date', 'ASC');
		$query = $this->db->get();
		
		return $query;
	}
	
	
	public function get_individual_types()
	{
		//retrieve all users
		$this->db->from('individual_type');
		$this->db->select('*');
		$this->db->order_by('individual_type_name', 'ASC');
		$query = $this->db->get();
		
		return $query;
	}
}
?>