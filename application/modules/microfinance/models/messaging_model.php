<?php

class Messaging_model extends CI_Model 
{

	public function send_statement($individual_id)
	{
		$individual_data = $this->individual_model->get_individual($individual_id);
		$savings_payments = $this->individual_model->get_savings_payments($individual_id);
		$individual_loan = $this->individual_model->get_individual_loans($individual_id);

		$row = $individual_data->row();
		$outstanding_loan = $row->outstanding_loan;
		$total_savings = $row->total_savings;
		$individual_lname = $row->individual_lname;
		$individual_mname = $row->individual_mname;
		$individual_fname = $row->individual_fname;
		$individual_email = $row->individual_email;
		$individual_phone = $row->individual_phone;
		$individual_number = $row->individual_number;
		$outstanding_loan = $row->outstanding_loan;
		$total_savings = $row->total_savings;
		
		//last transaction date
		$last_transaction_date = '';
		if(!empty($individual_phone))
		{
			// savings
			if($savings_payments->num_rows() > 0)
			{
				foreach ($savings_payments->result() as $row2)
				{
					$savings_payment_id = $row2->savings_payment_id;
					$payment_amount = $row2->payment_amount;
					$payment_date = $row2->payment_date;
					
					if(empty($last_transaction_date))
					{
						$last_transaction_date = $payment_date;
					}
					
					else
					{
						if($last_transaction_date < $payment_date)
						{
							$last_transaction_date = $payment_date;
						}
					}
					
					if($payment_amount > 0)
					{
						$total_savings += $payment_amount;
					}
				}
				
			}
	
			// get loan balance 
			$last_date = '';
			$payments = $this->individual_model->get_loan_payments($individual_id);
			$result = '';
			$count = 1;
			$total_debit = $running_balance = $outstanding_loan;
			$total_credit = 0;
			$total_loans = $individual_loan->num_rows();
			$loans_count = 0;
			
			if($total_loans > 0)
			{
				foreach ($individual_loan->result() as $row)
				{
					$loans_plan_name = $row->loans_plan_name;
					$individual_loan_status = $row->individual_loan_status;
					$individual_loan_id = $row->individual_loan_id;
					$proposed_amount = $row->proposed_amount;
					$approved_amount = $row->approved_amount;
					$disbursed_amount = $row->disbursed_amount;
					$purpose = $row->purpose;
					$installment_type_duration = $row->installment_type_duration;
					$no_of_repayments = $row->no_of_repayments;
					$interest_rate = $row->interest_rate;
					$interest_id = $row->interest_id;
					$grace_period = $row->grace_period;
					$disbursed_date = date('jS d M Y',strtotime($row->disbursed_date));
					$disbursed = $row->disbursed_date;
					$created_by = $row->created_by;
					$approved_by = $row->approved_by;
					$disbursed_by = $row->disbursed_by;
					$loans_count++;
					
					//get all loan deductions before date
					if($payments->num_rows() > 0)
					{
						foreach ($payments->result() as $row2)
						{
							$loan_payment_id = $row2->loan_payment_id;
							$personnel_fname = $row2->personnel_fname;
							$personnel_onames = $row2->personnel_onames;
							$payment_amount = $row2->payment_amount;
							$payment_interest = $row2->payment_interest;
							$created = date('jS M Y H:i:s',strtotime($row2->created));
							$payment_date = $row2->payment_date;
							
							if(($payment_date <= $disbursed) && ($payment_date > $last_date) && ($payment_amount > 0))
							{
								$count++;
								$running_balance -= $payment_amount;
								$total_credit += $payment_amount;
					
								if(empty($last_transaction_date))
								{
									$last_transaction_date = $payment_date;
								}
								
								else
								{
									if($last_transaction_date < $payment_date)
									{
										$last_transaction_date = $payment_date;
									}
								}
							}
						}
					}
					
					//display loan if disbursed
					if($individual_loan_status == 2)
					{
						$running_balance += $disbursed_amount;
						$total_debit += $disbursed_amount;
						
						$count++;
					}
					
					//check if there are any more payments
					if($total_loans == $loans_count)
					{
						//get all loan deductions before date
						if($payments->num_rows() > 0)
						{
							foreach ($payments->result() as $row2)
							{
								$loan_payment_id = $row2->loan_payment_id;
								$personnel_fname = $row2->personnel_fname;
								$personnel_onames = $row2->personnel_onames;
								$payment_amount = $row2->payment_amount;
								$payment_interest = $row2->payment_interest;
								$created = date('jS M Y H:i:s',strtotime($row2->created));
								$payment_date = $row2->payment_date;
								
								if(($payment_date > $disbursed) && ($payment_amount > 0))
								{
									$count++;
									$running_balance -= $payment_amount;
									$total_credit += $payment_amount;
					
									if(empty($last_transaction_date))
									{
										$last_transaction_date = $payment_date;
									}
									
									else
									{
										if($last_transaction_date < $payment_date)
										{
											$last_transaction_date = $payment_date;
										}
									}
								}
							}
						}
					}
					$last_date = $disbursed;
				}
			}
			
			else
			{
				//get all loan deductions before date
				if($payments->num_rows() > 0)
				{
					foreach ($payments->result() as $row2)
					{
						$loan_payment_id = $row2->loan_payment_id;
						$personnel_fname = $row2->personnel_fname;
						$personnel_onames = $row2->personnel_onames;
						$payment_amount = $row2->payment_amount;
						$payment_interest = $row2->payment_interest;
						$created = date('jS M Y H:i:s',strtotime($row2->created));
						$payment_date = $row2->payment_date;
						$running_balance -= $payment_amount;
						
						$count++;
						if($payment_amount > 0)
						{
							$total_credit += $payment_amount;
					
							if(empty($last_transaction_date))
							{
								$last_transaction_date = $payment_date;
							}
							
							else
							{
								if($last_transaction_date < $payment_date)
								{
									$last_transaction_date = $payment_date;
								}
							}
						}
					}
				}
			}
			$loan_balance = number_format($total_debit - $total_credit, 0);
			
			$base_url = str_replace("http://", "", site_url());
			$base_url = str_replace("https://", "", $base_url);
			
			$contacts = $this->site_model->get_contacts();
			
			$message = 'Hello '.$individual_fname.'. Total Savings KES. '.number_format($total_savings).' Loan balance KES. '.$loan_balance.' as at '.date('jS M Y',strtotime($last_transaction_date)).'. View full statement at '.$base_url.'member-login '.$contacts['company_name'];
			$response = $this->sms($individual_phone,$message);
			return $response;
		}
		
		else
		{
			return 'Member phone number not found';
		}
	}

	public function sms($phone,$message)
	{
        // This will override any configuration parameters set on the config file
		// max of 160 characters
		// to get a unique name make payment of 8700 to Africastalking/SMSLeopard
		// unique name should have a maximum of 11 characters
		
		if (substr($phone, 0, 1) === '0') 
		{
			$phone = ltrim($phone, '0');
		}
		
		$phone_number = '+254'.$phone;
		//$phone_number = $phone;
		// get items 

		$configuration = $this->admin_model->get_configuration();

		$mandrill = '';
		$configuration_id = 0;
		
		if($configuration->num_rows() > 0)
		{
			$res = $configuration->row();
			$configuration_id = $res->configuration_id;
			$mandrill = $res->mandrill;
			$sms_key = $res->sms_key;
			$sms_user = $res->sms_user;

			$actual_message = $message;
			// var_dump($actual_message); die();
			// get the current branch code
			$params = array('username' => $sms_user, 'apiKey' => $sms_key);  
	
			$this->load->library('africastalkinggateway', $params);
			// var_dump($params)or die();
			// Send the message
			try 
			{
				//$results = $this->africastalkinggateway->sendMessage($phone_number, $actual_message, $sms_from=22384);
				$results = $this->africastalkinggateway->sendMessage($phone_number, $actual_message);
				
				//var_dump($results);die();
				$number = $phone_number;
				$status = 'unsent';
				
				foreach($results as $result) 
				{
					$number = $result->number;
					$status = $result->status;
					$messageId = $result->messageId;
					$cost = $result->cost;
					// status is either "Success" or "error message"
					// echo " Number: " .$result->number;
					// echo " Status: " .$result->status;
					// echo " MessageId: " .$result->messageId;
					// echo " Cost: "   .$result->cost."\n";
				}
				$save_data = array(
					"sms_result_message" => $actual_message,
					"sms_result_phone" => $phone_number,
					"message_id" => $messageId,
					"sms_result_cost" => $cost,
					"created" => date('Y-m-d H:i:s')
				);
					
				if($this->db->insert('sms_result', $save_data))
				{
					return $status.' sent to '.$number;
				}
				else
				{
					return $status.' sent to '.$number.'. Response not saved';
				}
			}
			
			catch(AfricasTalkingGatewayException $e)
			{
				// echo "Encountered an error while sending: ".$e->getMessage();
				return $e->getMessage();
			}
	       
		}
	    else
	    {
	        return 'Configuration not set';
	    }
    }
}
?>