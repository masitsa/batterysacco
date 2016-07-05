<?php

class Messaging_model extends CI_Model 
{

	public function send_statement($individual_id)
	{
		$individual_data = $this->individual_model->get_individual($individual_id);

		$row = $individual_data->row();
		$outstanding_loan = $row->outstanding_loan;
		$total_savings = $row->total_savings;
		$individual_lname = $row->individual_lname;
		$individual_mname = $row->individual_mname;
		$individual_fname = $row->individual_fname;
		$individual_email = $row->individual_email;
		$individual_phone = $row->individual_phone;
		$individual_number = $row->individual_number;
				
		$individual_balance_data = $this->reports_model->get_individual_balance_data($individual_id, $total_savings, $outstanding_loan);
			
		$base_url = str_replace("http://", "", site_url());
		$base_url = str_replace("https://", "", $base_url);
		
		$contacts = $this->site_model->get_contacts();
		$savings_balance = $individual_balance_data['running_balance_savings'];
		$last_savings_date = $individual_balance_data['last_transaction_date'];
		$loan_balance = $individual_balance_data['running_balance_loans'];
		$last_loans_date = $individual_balance_data['last_loan_payment_date'];
		$message = 'Hello '.$individual_fname.'.';
		
		//savings
		$dates = explode("-",$last_savings_date);
		$total = count($dates);
		if($total > 0)
		{
			$last = $total-1;
			$year = $dates[0];
			if($year > 2015)
			{
				$message .= ' Total Savings KES. '.number_format($savings_balance,0).' as at '.date('M Y',strtotime($last_savings_date));
			}
		}
		
		//loans
		$dates = explode(" ",$last_loans_date);
		$total = count($dates);
		if($total > 0)
		{
			$last = $total-1;
			$year = $dates[$last];
			if($year > 2015)
			{
				$message .= ' Loan balance KES. '.number_format($loan_balance,0).' as at '.$last_loans_date;
			}
		}
		
		//message signature
		if($message != 'Hello '.$individual_fname.'.')
		{
			$message .= ' View full statement at '.$base_url.'member-login For enquiries contact moses@serenityservices.co.ke '.$contacts['company_name'];
			$response = $this->sms($individual_phone,$message);
		}
		
		else
		{
			$response = 'Member phone number not found';
		}
		
		//$message = 'Hello '.$individual_fname.'. Total Savings KES. '.number_format($individual_balance_data['running_balance_savings'],0).' as at '.date('d M Y',strtotime($individual_balance_data['last_transaction_date'])).' Loan balance KES. '.number_format($individual_balance_data['running_balance_loans'],0).' as at '.$individual_balance_data['last_loan_payment_date'].'. View full statement at '.$base_url.'member-login. For enquiries contact info@serenityservices.co.ke '.$contacts['company_name'];
		//$response = $this->sms($individual_phone,$message);
		return $response;
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