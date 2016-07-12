
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Savings Account Statement</h2>
    </header>
    <div class="panel-body">
    	<?php
        if(isset($member_account) && ($member_account == TRUE))
		{
			?>
    		<a href="<?php echo site_url().'microfinance/member/print_statement';?>" target="_blank" class="btn btn-primary">Print</a>
            <?php
		}
		
		else
		{
		?>
    	<?php if(!isset($print)){?>
    	<a href="<?php echo site_url().'microfinance/individual/print_statement/'.$individual_id;?>" target="_blank" class="btn btn-primary">Print</a>
    	<a href="<?php echo site_url().'microfinance/individual/download_statement/'.$individual_id;?>" class="btn btn-danger">Download</a>
    	<a href="<?php echo site_url().'send-statement/'.$individual_id;?>" class="btn btn-success">SMS Statement</a>
        <?php }}?>
    	<!-- Adding Errors -->
                
				<?php
                //get all savings before date
				$total_credit = $running_balance = $total_savings;
                $result = '';
                $total_debit = $total_credit = 0;
				$current_year = date('Y');
				
				if($all_savings_payments->num_rows() > 0)
                {
                    $count = 1;
                    $total_payments = 0;
					//var_dump($all_savings_payments->result());die();
                    foreach ($all_savings_payments->result() as $row2)
                    {
                        $savings_payment_id = $row2->savings_payment_id;
                        $payment_amount = $row2->payment_amount;
                        $payment_date = $row2->payment_date;
						$payment_type = $row2->payment_type;
						$description = $row2->description;
						$cheque_number = $row2->cheque_number;
						$debit = $credit= '';
						
						//get year portion of payment date
						$split = explode('-', $payment_date);
						
						if(is_array($split))
						{
							$year = $split[0];
						}
						else
						{
							$year = 0;
						}
						if(empty($description))
						{
							$description = 'Shares deposit';
						}
						if ($payment_type == 1)
						{
							$debit = number_format($payment_amount, 2);
							$running_balance -= $payment_amount;
							$total_debit += $payment_amount;	
						}
						else
						{
						 	$credit = number_format($payment_amount, 2);
							$running_balance += $payment_amount;
							$total_credit += $payment_amount;	
						}
						//$payments = $this->individual_model->get_loan_payments($individual_id);
											
						if($payment_amount > 0)
						{
							$count++;
							if ($running_balance > 0)
							{
							}
							
							if($year == $current_year)
							{
								$result .= 
								'
									<tr>
										<td>'.date('d M Y',strtotime($payment_date)).' </td>
										<td>'.$description.' '.$cheque_number.'</td>
										<td>'.$debit.'</td>
										<td>'.$credit.'</td>
										<td>'.number_format($running_balance, 2).'</td>
									</tr> 
								';
							}
							
							else
							{
								$total_savings += $payment_amount;
							}
							
						}
				
					}	
                        
                    //display loan
                    $result .= 
                    '
                        <tr>
                            <td></td>
                            <th>Total</th>
                            <td></td>
                            <td></td>
                            <th>'.number_format(($running_balance), 2).'</th>
                        </tr>
                    ';
                }
			
				
				?>
    	<table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center" rowspan=3>Date</th>
                    <th rowspan=2>Description</th>
                    <th colspan=3 style="text-align:center;">Amount</th>
                </tr>
                <tr>
                    <th style="text-align:left">Debit</th>
                    <th style="text-align:left">Credit</th>
                    <th style="text-align:left">Savings Running Balance</th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                    <td></td>
                    <td>Savings balance b/f</td>
                    <td></td>
                    <td><?php echo number_format($total_savings, 2);?></td>
                </tr>
                <?php echo $result;?>
            </tbody>
		</table>
    </div>
</section>
            
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Loans Account Statement</h2>
    </header>
    <div class="panel-body">
    	<!-- Adding Errors -->
            <?php
			$last_date = '';
			$payments = $this->individual_model->get_loan_payments($individual_id);
			
			$result = '';
			$count = 1;
			$total_debit = $running_balance = $outstanding_loan;
			$total_credit = 0;
			$total_disbursments = $disbursments->num_rows();
			$disbursments_count = 0;
			
            if($total_disbursments > 0)
			{
				foreach ($disbursments->result() as $row)
				{
					$disbursement_date = $row->dibursement_date;
					$cheque_amount = $row->cheque_amount;
					$cheque_number = $row->cheque_number;
					//$disbursed_date = date('jS d M Y',strtotime($disbursement_date));
					$disbursments_count++;
					
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
							$split = explode('-', $payment_date);
							
							if(is_array($split))
							{
								$year = $split[0];
							}
							else
							{
								$year = 0;
							}
							
							if(($payment_date <= $disbursement_date) && ($payment_date > $last_date) && ($payment_amount > 0))
							{
								$count++;
								$running_balance -= $payment_amount;
							
								if($year == $current_year)
								{
									$result .= 
									'
										<tr>
											<td>'.date('d M Y',strtotime($payment_date)).' </td>
											<td>Loan repayment</td>
											<td></td>
											<td>'.number_format($payment_amount, 2).'</td>
											<td>'.number_format($payment_interest, 2).'</td>
											<td>'.number_format(($payment_amount + $payment_interest), 2).'</td>
											<td>'.number_format($running_balance, 2).'</td>
										</tr> 
									';
								}
								
								else
								{
									$outstanding_loan -= $payment_amount;
								}
								$total_credit += $payment_amount;
							}
						}
					}
					
					//display disbursment if cheque amount > 0
					if($cheque_amount > 0)
					{
						$running_balance += $cheque_amount;
						$total_debit += $cheque_amount;
						
						$split = explode('-', $disbursement_date);
							
						if(is_array($split))
						{
							$year = $split[0];
						}
						else
						{
							$year = 0;
						}
						
						$count++;
							
						if($year == $current_year)
						{
							$result .= 
							'
								<tr>
									<td>'.date('d M Y',strtotime($disbursement_date)).' </td>
									<td>Disbursed cheque '.$cheque_number.'</td>
									<td>'.number_format($cheque_amount, 2).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td>'.number_format($running_balance, 2).'</td>
								</tr> 
							';
						}
						
						else
						{
							$outstanding_loan += $cheque_amount;
						}
					}
					
					//check if there are any more payments
					if($total_disbursments == $disbursments_count)
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
								$split = explode('-', $payment_date);
								
								if(is_array($split))
								{
									$year = $split[0];
								}
								else
								{
									$year = 0;
								}
								
								if(($payment_date > $disbursement_date) && ($payment_amount > 0))
								{
									$count++;
									$running_balance -= $payment_amount;
							
									if($year == $current_year)
									{
										$result .= 
										'
											<tr>
												<td>'.date('d M Y',strtotime($payment_date)).' </td>
												<td>Loan repayment</td>
												<td></td>
												<td>'.number_format($payment_amount, 2).'</td>
												<td>'.number_format($payment_interest, 2).'</td>
												<td>'.number_format(($payment_amount + $payment_interest), 2).'</td>
												<td>'.number_format($running_balance, 2).'</td>
											</tr> 
										';
									}
									
									else
									{
										$outstanding_loan -= $payment_amount;
									}
									$total_credit += $payment_amount;
								}
							}
						}
					}
					$last_date = $disbursement_date;
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
						$split = explode('-', $payment_date);
						
						if(is_array($split))
						{
							$year = $split[0];
						}
						else
						{
							$year = 0;
						}
						
						$count++;
						if($payment_amount > 0)
						{
							if($year == $current_year)
							{
								$result .= 
								'
									<tr>
										<td>'.date('d M Y',strtotime($payment_date)).' </td>
										<td>Loan repayment</td>
										<td></td>
										<td>'.number_format($payment_amount, 2).'</td>
										<td>'.number_format($payment_interest, 2).'</td>
										<td>'.number_format(($payment_amount + $payment_interest), 2).'</td>
										<td>'.number_format($running_balance, 2).'</td>
									</tr> 
								';
							}
							
							else
							{
								$outstanding_loan -= $payment_amount;
							}
							$total_credit += $payment_amount;
						}
					}
				}
			}
					
			//display loan
			$result .= 
			'
				<tr>
					<th colspan="2">Total</th>
					<th>'.number_format($total_debit, 2).'</th>
					<th></th>
					<th></th>
					<th>'.number_format($total_credit, 2).'</th>
					<th></th>
				</tr> 
				<tr>
					<th colspan="5">Balance</th>
					<th></th>
					<th>'.number_format($total_debit - $total_credit, 2).'</th>
				</tr> 
			';
			
			
			?>
    	<table class="table table-striped table-hover table-condensed">
            <thead>
                <tr>
                    <th style="text-align:center" rowspan=3>Date</th>
                    <th rowspan=2>Description</th>
                    <th colspan=5 style="text-align:center;">Amount</th>
                </tr>
                <tr>
                    <th rowspan=2 style="text-align:left">Debit</th>
                    <th colspan=6 style="text-align:center">Credit</th>
                </tr>
                <tr>
                    <th colspan=2 style="text-align:left"></th>
                    <th style="text-align:left">Principal Repayment</th>
                    <th style="text-align:left">Interest Payment</th>
                    <th style="text-align:left">Repayment</th>
                    <th style="text-align:left">Loan Running Balance</th>
                </tr>
            </thead>
            <tbody>
            	<tr>
                    <td></td>
                    <td>Loan balance b/f</td>
                    <td><?php echo number_format($outstanding_loan, 2);?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> 
                <?php echo $result;?>
            </tbody>
        </table>
    </div>
</section>