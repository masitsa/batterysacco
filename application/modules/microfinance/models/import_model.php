<?php

class Import_model extends CI_Model 
{
	/*
	*	Import individuals template
	*
	*/
	function import_individuals_template()
	{
		$this->load->library('Excel');
		
		$title = 'Individual Members Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Member Number';
		$report[$row_count][1] = 'Member first name';
		$report[$row_count][2] = 'Member middle name';
		$report[$row_count][3] = 'Member last name';
		$report[$row_count][4] = 'Title (i.e. Mr. Mrs. Miss Doc)';
		$report[$row_count][5] = 'Date of Birth (i.e. YYYY-MM-DD)';
		$report[$row_count][6] = 'Civil Status (Divorced Married Single Widowed)';
		$report[$row_count][7] = 'Address';
		$report[$row_count][8] = 'Postal Code';
		$report[$row_count][9] = 'City';
		$report[$row_count][10] = 'Primary Phone Number';
		$report[$row_count][11] = 'Alternate Phone Number';
		$report[$row_count][12] = 'Primary Email';
		$report[$row_count][13] = 'Other Email';
		$report[$row_count][14] = 'Residence';
		$report[$row_count][15] = 'Gender (i.e. M or F)';
		$report[$row_count][16] = 'Document type (National ID or Passport';
		$report[$row_count][17] = 'Document Number';
		$report[$row_count][18] = 'Place of issue';
		$report[$row_count][19] = 'Member type';
		$report[$row_count][20] = 'Loan Balance';
		$report[$row_count][21] = 'Savings Balance';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	public function import_csv_individuals($upload_path)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_individual_data($array);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	public function sort_individual_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 22))
		{
			$items['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Member Number</th>
						  <th>First Name</th>
						  <th>Other Names</th>
						  <th>Loan Balance</th>
						  <th>Savings Balance</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$current_individual_number = $items['individual_number'] = $array[$r][0];
				$items['individual_fname'] = mysql_real_escape_string(ucwords(strtolower($array[$r][1])));
				$items['individual_mname'] = mysql_real_escape_string(ucwords(strtolower($array[$r][2])));
				$items['individual_lname'] = mysql_real_escape_string(ucwords(strtolower($array[$r][3])));
				$title = $array[$r][4];
				$items['individual_dob'] = date('Y-m-d',strtotime($array[$r][5]));
				$civil_status_id = $array[$r][6];
				$items['individual_address'] = $array[$r][7];
				$items['individual_post_code'] = $array[$r][8];
				$items['individual_city'] = $array[$r][9];
				$items['individual_phone'] = $array[$r][10];
				$items['individual_phone2'] = $array[$r][11];
				$items['individual_email'] = $array[$r][12];
				$items['individual_email2'] = $array[$r][13];
				$items['individual_locality'] = $array[$r][14];
				$gender = $array[$r][15];
				$document_type = $array[$r][16];
				$individual_document_number = $array[$r][17];
				$items['document_place'] = $array[$r][18];
				$items['individual_type_id'] = $array[$r][19];
				$items['outstanding_loan'] = $array[$r][20];
				$items['total_savings'] = $array[$r][21];
				$items['created'] = date('Y-m-d H:i:s');
				$items['modified_by'] = $this->session->userdata('personnel_id');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['branch_code'] = $this->session->userdata('branch_code');
				$comment = '';
				
				$individual_document_number = ucwords(strtolower($individual_document_number));
				
				if($individual_document_number == 'National id')
				{
					$items['document_id'] = 1;
				}
				
				else if($individual_document_number == 'Passport')
				{
					$items['document_id'] = 2;
				}
				
				if(isset($gender))
				{
					if($gender == 'M')
					{
						$items['gender_id'] = 1;
					}
					else if($gender == 'F')
					{
						$items['gender_id'] = 2;
					}else
					{
						$gender_id = '';
					}
				}
				
				if(isset($title))
				{
					$title = ucwords(strtolower($title));
					if(($title == 'Mr') || ($title == 'Mr.'))
					{
						$items['title_id'] = 1;
					}
					else if(($title == 'Mrs') || ($title == 'Mrs.'))
					{
						$items['title_id'] = 2;
					}
					else if(($title == 'Miss') || ($title == 'Miss.'))
					{
						$items['title_id'] = 3;
					}
					else if(($title == 'Doc') || ($title == 'Doc.') || ($title == 'Dr') || ($title == 'Dr.'))
					{
						$items['title_id'] = 4;
					}
					else if(($title == 'Prof') || ($title == 'Prof.'))
					{
						$items['title_id'] = 5;
					}
					else if(($title == 'Fr') || ($title == 'Fr.'))
					{
						$items['title_id'] = 6;
					}
					else if(($title == 'Sr') || ($title == 'Sr.'))
					{
						$items['title_id'] = 7;
					}
					else if(($title == 'Br') || ($title == 'Br.'))
					{
						$items['title_id'] = 8;
					}
				}
				$items['individual_status'] = 1;
				/*$items['individual_number'] = $this->create_individual_number();
				$items['current_individual_number'] = $current_individual_number;*/
				if(!empty($current_individual_number))
				{
					// check if the number already exists
					if($this->check_current_number_exisits($current_individual_number))
					{
						//number exists
						$comment .= '<br/>Duplicate member number entered';
						$class = 'danger';
					}
					else
					{
						// number does not exisit
						//save product in the db
						if($this->db->insert('individual', $items))
						{
							$comment .= '<br/>Member successfully added to the database';
							$class = 'success';
						}
						
						else
						{
							$comment .= '<br/>Internal error. Could not add member to the database. Please contact the site administrator';
							$class = 'warning';
						}
					}
				}
				
				else
				{
					$comment .= '<br/>Not saved ensure you have a member number entered';
					$class = 'danger';
				}
				
				
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$items['individual_number'].'</td>
							<td>'.$items['individual_fname'].'</td>
							<td>'.$items['individual_mname'].' '.$items['individual_lname'].'</td>
							<td>'.$items['outstanding_loan'].'</td>
							<td>'.$items['total_savings'].'</td>
							<td>'.$comment.'</td>
						</tr> 
				';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		
		//if no products exist
		else
		{
			$return['response'] = 'Member data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
	
	public function check_current_number_exisits($individual_number)
	{
		$this->db->where('individual_number', $individual_number);
		
		$query = $this->db->get('individual');
		
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_branches()
	{
		$this->db->where('branch_status = 1');
		$this->db->order_by('branch_name', 'ASC');
		return $this->db->get('branch');
	}
	
	/*
	*	Import savings template
	*
	*/
	function import_savings_template()
	{
		$this->load->library('Excel');
		
		$title = 'Member Savings Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Member Number';
		$report[$row_count][1] = 'Payment date (i.e. YYYY-MM-DD)';
		$report[$row_count][2] = 'Payment amount';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
		function import_cheque_disbursed_template()
		{
		$this->load->library('Excel');
		
		$title = 'Cheque Disbursement Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Cheque Number';
		$report[$row_count][1] = 'Disbursement date (i.e. YYYY-MM-DD)';
		$report[$row_count][2] = 'Cheque Amount';
		$report[$row_count][3] = 'Member Number';
		$report[$row_count][4] = 'Type';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
		}
	public function import_csv_savings($upload_path)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_saving_data($array);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	
	public function import_csv_disbursements($upload_path)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_disbursement_data($array);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	
	public function sort_saving_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 3))
		{
			$items['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Member Number</th>
						  <th>Member Name</th>
						  <th>Payment Date</th>
						  <th>Payment Amount</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$individual_number = $array[$r][0];
				$items['payment_date'] = date('Y-m-d',strtotime($array[$r][1]));
				$items['payment_amount'] = $array[$r][2];
				$items['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['modified_by'] = $this->session->userdata('personnel_id');
				$items['branch_code'] = $this->session->userdata('branch_code');
				$comment = '';
				//$items['saving_status'] = 1;
				
				//get member
				$this->db->where('individual_number', $individual_number);
				$query = $this->db->get('individual');
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					
					$individual_id = $row->individual_id;
					$items['individual_id'] = $individual_id;
					$individual_fname = $row->individual_fname;
					$individual_mname = $row->individual_mname;
					$individual_lname = $row->individual_lname;
					
					$member_name = $individual_lname.' '.$individual_fname.' '.$individual_mname;
					if($this->db->insert('savings_payment', $items))
					{
						$comment .= '<br/>Payment successfully added to the database';
						$class = 'success';
					}
					
					else
					{
						$comment .= '<br/>Internal error. Could not add payment to the database. Please contact the site administrator';
						$class = 'warning';
					}
				}
				
				else
				{
					$comment .= '<br/>Member not found. Please ensure that you have registered them';
					$member_name = '';
					$class = 'danger';
				}
				
				
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$individual_number.'</td>
							<td>'.$member_name.'</td>
							<td>'.$items['payment_date'].'</td>
							<td>'.$items['payment_amount'].'</td>
							<td>'.$comment.'</td>
						</tr> 
				';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		
		//if no products exist
		else
		{
			$return['response'] = 'Savings payments data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
	
	//sort out disbursement data
	public function sort_disbursement_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 5))
		{
			$item['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Cheque Number</th>
						  <th>Member Name</th>
						  <th>Member Number</th>
						  <th>Disbursement Date</th>
						  <th>Cheque Amount</th>
						  <th>Type</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$member_number = $array[$r][3];
				$item['dibursement_date'] = date('Y-m-d',strtotime($array[$r][1]));
				$item['cheque_amount'] = $array[$r][2];
				$item['cheque_number'] = $array[$r][0];
				$item['description'] = $array[$r][4];
				$item['created'] = date('Y-m-d H:i:s');
				$item['modified'] = date('Y-m-d H:i:s');
				$item['created_by'] = $this->session->userdata('personnel_id');
				$item['modified_by'] = $this->session->userdata('personnel_id');
				$comment = '';
				//$items['saving_status'] = 1;
				
				//get member
				$this->db->where('individual_number', $member_number);
				$query = $this->db->get('individual');
				$individual_fname = $individual_mname = $individual_lname = '';
				
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					
					$individual_id = $row->individual_id;
					$item['individual_id']=$individual_id;
					$individual_fname = $row->individual_fname;
					$individual_mname = $row->individual_mname;
					$individual_lname = $row->individual_lname;
					
					$member_name = $individual_lname.' '.$individual_fname.' '.$individual_mname;
					if($this->db->insert('disbursement', $item))
					{
						$comment .= '<br/>Cheque successfully added to the database';
						$class = 'success';
					}
					
					else
					{
						$comment .= '<br/>Internal error. Could not add cheque to the database. Please contact the site administrator';
						$class = 'warning';
					}
				}
				
				else
				{
					$comment .= '<br/>Member not found. Please ensure that you have registered them';
					$member_name = '';
					$class = 'danger';
				}
				
				
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$item['cheque_number'].'</td>
							<td>'.$individual_fname.' '.$individual_mname.' '.$individual_lname.'</td>
							<td>'.$member_number.'</td>
							<td>'.$item['dibursement_date'].'</td>
							<td>'.$item['cheque_amount'].'</td>
							<td>'.$item['description'].'</td>
							<td>'.$comment.'</td>
						</tr> 
				';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		
		//if no products exist
		else
		{
			$return['response'] = 'Cheque Disbursement data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
	
	
	/*
	*	Import loans template
	*
	*/
	function import_loans_template()
	{
		$this->load->library('Excel');
		
		//get active loans plans
		$loans_plans = $this->loans_plan_model->all_loans_plan();
		$plans = '';
		if($loans_plans->num_rows() > 0)
		{
			foreach($loans_plans->result() as $row)
			{
				$plan_name = $row->loans_plan_name;
				$plans .= $plan_name.' ';
			}
		}
		
		$title = 'Member Loans Import Template';
		$count=1;
		$row_count=0;
		$cell = 0;
		$report[$row_count][$cell] = 'Member Number';
		$cell++;
		$report[$row_count][$cell] = 'Loan Type ('.$plans.')';
		$cell++;
		$report[$row_count][$cell] = 'Applicaton date (i.e. YYYY-MM-DD)';
		$cell++;
		$report[$row_count][$cell] = 'Loan Amount';
		$cell++;
		$report[$row_count][$cell] = 'Loan Purpose';
		$cell++;
		$report[$row_count][$cell] = 'Repayments';
		$cell++;
		$report[$row_count][$cell] = 'Number of Repayments';
		$cell++;
		$report[$row_count][$cell] = 'Grace Period';
		$cell++;
		$report[$row_count][$cell] = 'Loan Status (Pending approval, Approved, Disbursed, Disapproved)';
		$cell++;
		$report[$row_count][$cell] = 'Approved Amount';
		$cell++;
		$report[$row_count][$cell] = 'Approved Date';
		$cell++;
		$report[$row_count][$cell] = 'Disbursed Amount';
		$cell++;
		$report[$row_count][$cell] = 'Disbursed Date';
		$cell++;
		$report[$row_count][$cell] = 'Repayment';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 1';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 1';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 2';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 2';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 3';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 3';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 4';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 4';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 5';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 5';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 6';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 6';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 7';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 7';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 8';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 8';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 9';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 9';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 10';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 10';
		$cell++;
		$report[$row_count][$cell] = 'Guarantor 11';
		$cell++;
		$report[$row_count][$cell] = 'Guaranteed amount 11';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	public function import_csv_loans($upload_path)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_loan_data($array);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	public function sort_loan_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 36))
		{
			$items['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Member Number</th>
						  <th>Member Name</th>
						  <th>Loan Amount</th>
						  <th>Application Date</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			$comment = '';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$individual_number = $array[$r][0];
				$loans_plan_name = $array[$r][1];
				$items['application_date'] = date('Y-m-d',strtotime($array[$r][2]));
				$items['proposed_amount'] = $array[$r][3];
				$items['purpose'] = $array[$r][4];
				$items['proposed_repayment_amount'] = $array[$r][5];
				$items['no_of_repayments'] = $array[$r][6];
				$items['grace_period'] = $array[$r][7];
				$items['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $this->session->userdata('personnel_id');
				$items['modified_by'] = $this->session->userdata('personnel_id');
				$items['branch_code'] = $this->session->userdata('branch_code');
				$items['individual_loan_status'] = 2;
				$comment = '';
				$loan_status = ucwords(strtolower($array[$r][8]));
				$items['approved_amount'] = $array[$r][9];
				$items['approved_date'] = date('Y-m-d',strtotime($array[$r][10]));
				$items['disbursed_amount'] = $array[$r][11];
				$items['disbursed_date'] = date('Y-m-d',strtotime($array[$r][12]));
				$items['repayment_amount'] = $array[$r][13];
				
				//guarantors
				$marker = 14;
				for($s = 1; $s < 12; $s++)
				{
					$guarantor['guarantor'.$s] = $array[$r][$marker];
					$marker++;
					$guarantor['guaranteed_amount'.$s] = $array[$r][$marker];
					$marker++;
				}
				
				//get loan status
				if($loan_status == 'Pending Approval')
				{
					$items['individual_loan_status'] = 0;
				}
				
				else if($loan_status == 'Approved')
				{
					$items['individual_loan_status'] = 1;
				}
				
				else if($loan_status == 'Disbursed')
				{
					$items['individual_loan_status'] = 2;
				}
				
				else if($loan_status == 'Disapproved')
				{
					$items['individual_loan_status'] = 3;
				}
				
				else
				{
					$loan_status = '';
				}
				
				//do not import with empty status
				if(!empty($loan_status))
				{
					//get loan details
					$this->db->select('loans_plan.loans_plan_id, loans_plan.interest_id, loans_plan.interest_rate, installment_type.installment_type_duration');
					$this->db->where('loans_plan_name', $loans_plan_name);
					$this->db->join('installment_type', 'installment_type.installment_type_id = loans_plan.installment_type_id', 'left');
					$query = $this->db->get('loans_plan');
					
					if($query->num_rows() > 0)
					{
						$row = $query->row();
						$interest_id = $row->interest_id;
						$loans_plan_id = $row->loans_plan_id;
						$interest_rate = $row->interest_rate;
						$installment_type_duration = $row->installment_type_duration;
						
						$items['interest_rate'] = $interest_rate;
						$items['interest_id'] = $interest_id;
						$items['installment_type_duration'] = $installment_type_duration;
						
						if($items['approved_amount'] > 30000)
						{
							$items['loans_plan_id'] = 4;
						}
						
						else
						{
							$items['loans_plan_id'] = 3;
						}
					
						//get member
						$this->db->where('individual_number', $individual_number);
						$query = $this->db->get('individual');
						if($query->num_rows() > 0)
						{
							$row = $query->row();
							
							$individual_id = $row->individual_id;
							$items['individual_id'] = $individual_id;
							$individual_fname = $row->individual_fname;
							$individual_mname = $row->individual_mname;
							$individual_lname = $row->individual_lname;
							$db_outstanding_loan = $row->outstanding_loan;
							$db_total_savings = $row->total_savings;
							
							$member_name = $individual_lname.' '.$individual_fname.' '.$individual_mname;
							if($this->db->insert('individual_loan', $items))
							{
								$comment .= '<br/>Loan successfully added to the database';
								$class = 'success';
								
								//update savings opening balances
								/*$outstanding_loan = $array[$r][13];
								$total_savings = $array[$r][14];*/
								
								$individual_loan_id = $this->db->insert_id();
								
								//save guarantors
								for($s = 1; $s < 12; $s++)
								{
									$guarantor_number = $guarantor['guarantor'.$s];
									$guarantor_amount = $guarantor['guaranteed_amount'.$s];
									
									if(!empty($guarantor_number))
									{
										//get individual id
										$this->db->where('individual_number', $guarantor_number);
										$query2 = $this->db->get('individual');
										if($query2->num_rows() > 0)
										{
											$row2 = $query2->row();
											$guarantor_individual_id = $row2->individual_id;
											
											//save
											$items2['individual_id'] = $guarantor_individual_id;
											$items2['individual_loan_id'] = $individual_loan_id;
											$items2['created'] = date('Y-m-d H:i:s');
											$items2['guaranteed_amount'] = $guarantor_amount;
											
											if($this->db->insert('loan_guarantor', $items2))
											{
												$comment .= '<br/>Guarantor added successfully - '.$guarantor_number;
											}
										}
										
										else
										{
											$comment .= '<br/>Unable to find guarantor with payroll number '.$guarantor_number;
											$class = 'warning';
										}
									}
								}
							}
							
							else
							{
								$comment .= '<br/>Internal error. Could not add loan to the database. Please contact the site administrator';
								$class = 'warning';
							}
						}
						
						else
						{
							$comment .= '<br/>Member not found. Please ensure that you have registered them';
							$member_name = '';
							$class = 'danger';
						}
					}
					
					else
					{
						$comment .= 'Unable to find loan plan. Please check your plans then try uploading again.';
						$class = 'danger';
						$member_name = '';
					}
				}
					
				else
				{
					$comment .= 'Please select a valid loan status (Pending approval, Approved, Disbursed).';
					$class = 'danger';
					$member_name = '';
				}
				
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$individual_number.'</td>
							<td>'.$member_name.'</td>
							<td>'.$items['proposed_amount'].'</td>
							<td>'.$items['application_date'].'</td>
							<td>'.$comment.'</td>
						</tr> 
				';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		
		//if no products exist
		else
		{
			$return['response'] = 'Loans data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
	
	/*
	*	Import loan_payments template
	*
	*/
	function import_loan_payments_template()
	{
		$this->load->library('Excel');
		
		//get active loans
		/*$this->db->where('individual_loan.individual_loan_status = 2 AND individual_loan.individual_id = individual.individual_id');
		$this->db->select('individual_loan.individual_loan_id, individual.individual_number, individual.individual_fname, individual.individual_mname, individual.individual_lname, individual_loan.disbursed_amount, individual_loan.disbursed_date');
		$query = $this->db->get('individual_loan, individual');*/
		
		$title = 'Member Loans Payments Import Template';
		$count=1;
		$row_count=0;
		/*$report[$row_count][0] = 'Member Number';
		$report[$row_count][1] = 'Member Name';
		$report[$row_count][2] = 'Disbursed amount';
		$report[$row_count][3] = 'Disbursed Date';
		$report[$row_count][4] = 'Payment Date (i.e. YYYY-MM-DD)';
		$report[$row_count][5] = 'Payment Amount';
		$report[$row_count][6] = 'Payment Interest';*/
		$report[$row_count][0] = 'Member Number';
		$report[$row_count][1] = 'Payment Date (i.e. YYYY-MM-DD)';
		$report[$row_count][2] = 'Payment Amount';
		$report[$row_count][3] = 'Payment Interest';
		$report[$row_count][4] = 'Balance BF';
		$report[$row_count][5] = 'Savings';
		$report[$row_count][6] = 'Savings BF';
		
		$row_count++;
		
		/*if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$individual_loan_id = $row->individual_loan_id;
				$individual_number = $row->individual_number;
				$individual_fname = $row->individual_fname;
				$individual_mname = $row->individual_mname;
				$individual_lname = $row->individual_lname;
				$disbursed_amount = $row->disbursed_amount;
				$disbursed_date = date('jS M Y',strtotime($row->disbursed_date));
				
				//check loan payments
				$this->db->where('loan_payment.individual_loan_id = '.$individual_loan_id);
				$this->db->select('SUM(loan_payment.payment_amount) AS total_payments');
				$query2 = $this->db->get('loan_payment');
				$total_payments = 0;
				
				if($query2->num_rows() > 0)
				{
					$row2 = $query2->row();
					$total_payments = $row2->total_payments;
				}
				
				//display only if payments are incomplete
				if($disbursed_amount > $total_payments)
				{
					$report[$row_count][0] = $individual_number;
					$report[$row_count][1] = $individual_fname.' '.$individual_mname.' '.$individual_lname;
					$report[$row_count][2] = $disbursed_amount;
					$report[$row_count][3] = $disbursed_date;
					$row_count++;
				}
			}
		}
		
		else
		{
			$report[$row_count][0] = 'No active loans found. Please ensure you have added loans and disbursed them.';
		}*/
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	public function import_csv_loan_payments($upload_path)
	{
		//load the file model
		$this->load->model('admin/file_model');
		/*
			-----------------------------------------------------------------------------------------
			Upload csv
			-----------------------------------------------------------------------------------------
		*/
		$response = $this->file_model->upload_csv($upload_path, 'import_csv');
		
		if($response['check'])
		{
			$file_name = $response['file_name'];
			
			$array = $this->file_model->get_array_from_csv($upload_path.'/'.$file_name);
			//var_dump($array); die();
			$response2 = $this->sort_loan_payment_data($array);
		
			if($this->file_model->delete_file($upload_path."\\".$file_name, $upload_path))
			{
			}
			
			return $response2;
		}
		
		else
		{
			$this->session->set_userdata('error_message', $response['error']);
			return FALSE;
		}
	}
	public function sort_loan_payment_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 7))
		{
			$items['modified_by'] = $this->session->userdata('personnel_id');
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Payment Date</th>
						  <th>Member Number</th>
						  <th>Member Name</th>
						  <th>Balance BF</th>
						  <th>Payment Amount</th>
						  <th>Interest Amount</th>
						  <th>Savings Amount</th>
						  <th>Savings BF</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			$comment = '';
			
			//retrieve the data from array
			for($r = 1; $r < $total_rows; $r++)
			{
				$individual_number = $array[$r][0];
				$items['payment_date'] = $items2['payment_date'] = date('Y-m-d',strtotime($array[$r][1]));
				$items['payment_amount'] = $array[$r][2];
				$items['payment_interest'] = $array[$r][3];
				$balance_bf = $array[$r][4];
				$items2['payment_amount'] = $array[$r][5];
				$savings_bf = $array[$r][6];
				$items['created'] = $items2['created'] = date('Y-m-d H:i:s');
				$items['created_by'] = $items2['created_by'] = $this->session->userdata('personnel_id');
				$items['modified_by'] = $items2['modified_by'] = $this->session->userdata('personnel_id');
				$comment = '';
				
				//get member
				$where = 'individual.individual_number = \''.$individual_number.'\'';//echo $where; die();
				$this->db->where($where);
				$this->db->select('*');
				$query = $this->db->get('individual');
				if($query->num_rows() > 0)
				{
					$row = $query->row();
					
					$individual_id = $row->individual_id;
					$individual_id = $row->individual_id;
					$individual_id = $row->individual_id;
					$member_name = $row->individual_fname.' '.$row->individual_mname.' '.$row->individual_lname;
					$items['individual_id'] = $items2['individual_id'] = $individual_id;
					//$items2['individual_savings_status'] = 1;
					
					//save loan repayment
					if($this->db->insert('loan_payment', $items))
					{
						$comment .= '<br/>Loan payment successfully added to the database';
						$class = 'success';
						
						/*if($items['payment_date'] == '2015-01-30')
						{
							//save balance bf
							if(!empty($balance_bf) && ($balance_bf > 0))
							{
								$items3['outstanding_loan'] = $balance_bf;
							}
							
							if(!empty($savings_bf) && ($savings_bf > 0))
							{
								$items3['total_savings'] = $savings_bf;
							}
							
							$this->db->where('individual_id', $individual_id);
							if($this->db->update('individual', $items3))
							{
								$comment .= '<br/>Balance bf added successfully';
							}
							
							else
							{
								$comment .= '<br/>Balance bf not added';
								$class = 'warning';
							}
						}*/
					}
					
					else
					{
						$comment .= '<br/>Internal error. Could not add loan_payment to the database. Please contact the site administrator';
						$class = 'warning';
					}
					
					//save savings
					if($this->db->insert('savings_payment', $items2))
					{
						$comment .= '<br/>Savings successfully added to the database';
						$class = 'success';
					}
					
					else
					{
						$comment .= '<br/>Internal error. Could not add savings to the database. Please contact the site administrator';
						$class = 'warning';
					}
				}
				
				else
				{
					$comment .= '<br/>Member not found. Please ensure that the member has been added '.$individual_number;
					$member_name = '';
					$class = 'danger';
				}
				
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$items['payment_date'].'</td>
							<td>'.$individual_number.'</td>
							<td>'.$member_name.'</td>
							<td>'.$balance_bf.'</td>
							<td>'.$items['payment_amount'].'</td>
							<td>'.$items['payment_interest'].'</td>
							<td>'.$items2['payment_amount'].'</td>
							<td>'.$savings_bf.'</td>
							<td>'.$comment.'</td>
						</tr> 
				';
			}
			
			$response .= '</table>';
			
			$return['response'] = $response;
			$return['check'] = TRUE;
		}
		
		//if no products exist
		else
		{
			$return['response'] = 'Loans data not found ';
			$return['check'] = FALSE;
		}
		
		return $return;
	}
}
?>