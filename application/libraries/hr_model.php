<?php

class Hr_model extends CI_Model 
{	
	public function add_job_title()
	{
		$data['job_title_name'] = $this->input->post('job_title_name');
		
		if($this->db->insert('job_title', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function edit_job_title($job_title_id)
	{
		$data['job_title_name'] = $this->input->post('job_title_name');
		
		$this->db->where('job_title_id', $job_title_id);
		if($this->db->update('job_title', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function delete_job_title($job_title_id)
	{
		$this->db->where('job_title_id', $job_title_id);
		if($this->db->delete('job_title'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	public function get_non_personnel_roles($personnel_id)
	{
		$this->db->where('inventory_level_status.inventory_level_status_id NOT IN (SELECT personnel_approval.approval_status_id FROM personnel_approval WHERE personnel_id = '.$personnel_id.')');
		$query = $this->db->get('inventory_level_status');

		return $query;
	}

	public function get_personnel_approvals($personnel_id)
	{
		$this->db->where('inventory_level_status.inventory_level_status_id = personnel_approval.approval_status_id AND personnel_approval.personnel_id = '.$personnel_id);
		$query = $this->db->get('inventory_level_status,personnel_approval');

		return $query;
	}
	public function get_non_assigned_stores($personnel_id)
	{
		$this->db->where('store.store_id NOT IN (SELECT personnel_store.store_id FROM personnel_store WHERE personnel_id = '.$personnel_id.')');
		$query = $this->db->get('store');

		return $query;
	}
	public function get_personnel_stores($personnel_id)
	{
		$this->db->where('store.store_id = personnel_store.store_id AND personnel_store.personnel_id = '.$personnel_id);
		$query = $this->db->get('store,personnel_store');

		return $query;
	}
	
	//payroll template
	public function import_payroll_template()
	{
		$this->load->library('Excel');
		
		$title = 'Payroll Import Template';
		$count=1;
		$row_count=0;
		
		$report[$row_count][0] = 'Employee Number';
		$report[$row_count][1] = 'Payment Type';
		$report[$row_count][2] = 'Amount';
		
		$row_count++;
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
	
	public function import_csv_payroll($upload_path)
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
			$response2 = $this->sort_payroll_data($array);
		
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
	
	//sort the payroll data
	public function sort_payroll_data($array)
	{
		//count total rows
		$total_rows = count($array);
		$total_columns = count($array[0]);//var_dump($array);die();
		
		//if products exist in array
		if(($total_rows > 0) && ($total_columns == 3))
		{
			$response = '
				<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Member Number</th>
						  <th>Type</th>
						  <th>Amount</th>
						  <th>Comment</th>
						</tr>
					  </thead>
					  <tbody>
			';
			
			//retrieve the data from array
			
			for($r = 1; $r < $total_rows; $r++)
			{
				$items = $items1 = $items2 = $items3 = $items4 = array();
				$personnel_number = $items['personnel_number'] = $array[$r][0];
				$personnel_id = $this->get_personnel_id($personnel_number);
				$items1['personnel_id'] = $items2['personnel_id'] = $items3['personnel_id'] = $items4['personnel_id'] = $personnel_id;
				$check = $array[$r][1];
				$amount = $array[$r][2];
				$comment = '';
				
				if($amount != 0)
				{
					if(!empty($amount))
					{
						if(!empty($personnel_number))
						{
							if($check == "Basic Pay")
							{
								$items1['payment_id'] = 1;
								$items1['personnel_payment_amount'] = $amount;
								
								if($this->db->insert('personnel_payment', $items1))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							
							else if($check == "HELB Deduction")
							{
								$items3['deduction_id'] = 3;
								$items3['personnel_deduction_amount'] = $amount;
								
								if($this->db->insert('personnel_deduction', $items3))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Safaricom Sacco")
							{
								$items4['other_deduction_id'] = 2;
								$items4['personnel_other_deduction_amount'] = $amount;
								
								if($this->db->insert('personnel_other_deduction', $items4))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Overtime")
							{
								$items2['allowance_id'] = 1;
								$items2['personnel_allowance_amount'] = $amount;
								
								if($this->db->insert('personnel_allowance', $items2))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Leave Pay")
							{
								$items2['allowance_id'] = 2;
								$items2['personnel_allowance_amount'] = $amount;
								
								if($this->db->insert('personnel_allowance', $items2))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Arrears Pay")
							{
								$items2['allowance_id'] = 3;
								$items2['personnel_allowance_amount'] = $amount;
								
								if($this->db->insert('personnel_allowance', $items2))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Commission Pay")
							{
								$items2['allowance_id'] = 4;
								$items2['personnel_allowance_amount'] = $amount;
								
								if($this->db->insert('personnel_allowance', $items2))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							else if($check == "Notice Pay")
							{
								$items2['allowance_id'] = 5;
								$items2['personnel_allowance_amount'] = $amount;
								
								if($this->db->insert('personnel_allowance', $items2))
								{
									$comment .= '<br/>Payroll Data successfully added to the database';
									$class = 'success';
								}
								
								else
								{
									$comment .= '<br/>Internal error. Could not add payroll data to the database. Please contact the site administrator';
									$class = 'warning';
								}
							}
							
							else
							{
								$comment .= 'The account type cannot be found';
								$class = 'danger';
							}
						}
						
						else
						{
							$comment .= 'The personnel cannot be found';
							$class = 'danger';
						}
					}
					
					else
					{
						$comment .= 'The amount cannot be empty';
						$class = 'danger';
					}
				}
				
				else
				{
					$comment .= 'The amount cannot be 0';
					$class = 'danger';
				}
				
					
				$response .= '
					
						<tr class="'.$class.'">
							<td>'.$r.'</td>
							<td>'.$items['personnel_number'].'</td>
							<td>'.$check.'</td>
							<td>'.$amount.'</td>
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
	
	public function get_personnel_id($personnel_number)
	{
		$this->db->where('personnel_number = "'.$personnel_number.'"');
		$this->db->select('personnel_id');
		$result = $this->db->get('personnel');
		$personnelid = 0;
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $personnel)
			{
				$personnelid = $personnel->personnel_id;
			}
		}
		return $personnelid;
	}
}
?>