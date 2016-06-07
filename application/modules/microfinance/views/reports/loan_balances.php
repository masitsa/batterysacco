<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count_individual = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th>Member number</th>
						<th>Member Type</th>
						<th>Member Name</th>
						<th>Share Balance</th>
						<th>Last Share Contribution Date</th>
						<th>Loan Balance</th>
						<th>Last Repayment Date</th>

					</tr>
				</thead>
				  <tbody>
				  
			';
			
			//get all administrators
			$administrators = $this->users_model->get_active_users();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$individual_id = $row->individual_id;
				$individual_fname = $row->individual_fname;
				$individual_mname = $row->individual_mname;
				$individual_lname = $row->individual_lname;
				$individual_username = $row->individual_username;
				$individual_phone = $row->individual_phone;
				$individual_email = $row->individual_email;
				$individual_status = $row->individual_status;
				$individual_number = $row->individual_number;
				$individual_type_name = $row->individual_type_name;
				$individual_name = $individual_fname.' '.$individual_lname;
				$outstanding_loan = $row->outstanding_loan;
				$total_savings = $row->total_savings;
				
				//last transaction date
				$last_transaction_date = '';

				$individual_data = $this->individual_model->get_individual($individual_id);
				$savings_payments = $this->individual_model->get_savings_payments($individual_id);
				$individual_loan = $this->individual_model->get_individual_loans($individual_id);

				
				//status
				if($individual_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($individual_status == 0)
				{
					$status = '<span class="label label-default">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'microfinance/activate-individual/'.$individual_id.'" onclick="return confirm(\'Do you want to activate '.$individual_name.'?\');" title="Activate '.$individual_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($individual_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'microfinance/deactivate-individual/'.$individual_id.'" onclick="return confirm(\'Do you want to deactivate '.$individual_name.'?\');" title="Deactivate '.$individual_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}



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
			
				$counter = 1;
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
									$counter++;
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
				
				$count_individual++;
				$result .= 
				'
					<tr>
						<td>'.$count_individual.'</td>
						<td>'.$individual_number.'</td>
						<td>'.$individual_type_name.'</td>
						<td>'.$individual_lname.' '.$individual_fname.' '.$individual_mname.'</td>
						<td>'.number_format($total_savings,0).'</td>
						<td>'.$last_transaction_date.'</td>
						<td>'.$loan_balance.'</td>
						<td>'.$last_date.'</td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no individuals";
		}
?>


<section class="panel">
	<header class="panel-heading">						
		<h2 class="panel-title"><?php echo $title;?></h2>
	</header>
	<div class="panel-body">
    	<?php
        $success = $this->session->userdata('success_message');

		if(!empty($success))
		{
			echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
			$this->session->unset_userdata('success_message');
		}
		
		$error = $this->session->userdata('error_message');
		
		if(!empty($error))
		{
			echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
			$this->session->unset_userdata('error_message');
		}
		?>
    	<div class="row " style="margin-bottom:20px;">
            <div class="col-lg-2 col-lg-offset-8 pull-right">
                <a href="<?php echo site_url();?>export-individual-balances" class="btn btn-sm btn-success pull-right">Export Loan Balances</a>
            </div>
        </div>
		<div class="table-responsive">
        	
			<?php echo $result;?>
	
        </div>
	</div>
    <div class="panel-footer">
    	<?php if(isset($links)){echo $links;}?>
    </div>
</section>