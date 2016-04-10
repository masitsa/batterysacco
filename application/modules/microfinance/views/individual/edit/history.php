
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Savings Account Statement</h2>
    </header>
    <div class="panel-body">
    	<?php if(!isset($print)){?>
    	<a href="<?php echo site_url().'microfinance/individual/print_statement/'.$individual_id;?>" target="_blank" class="btn btn-primary">Print</a>
    	<a href="<?php echo site_url().'microfinance/individual/download_statement/'.$individual_id;?>" class="btn btn-danger">Download</a>
    	<a href="<?php echo site_url().'send-statement/'.$individual_id;?>" class="btn btn-success">SMS Statement</a>
        <?php }?>
    	<!-- Adding Errors -->
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
                    <td></td>
                </tr> 
                
				<?php
                //get all savings before date
				$total_credit = $running_balance = $total_savings;
                $result = '';
				
				if($savings_payments->num_rows() > 0)
                {
                    $count = 1;
                    $total_debit = 0;
                    $total_payments = 0;
                    foreach ($savings_payments->result() as $row2)
                    {
                        $savings_payment_id = $row2->savings_payment_id;
                        $payment_amount = $row2->payment_amount;
                        $payment_date = $row2->payment_date;
                        $total_payments += $payment_amount;
                        $running_balance += $payment_amount;
                        
						if($payment_amount > 0)
						{
							$count++;
							$result .= 
							'
								<tr>
									<td>'.date('d M Y',strtotime($payment_date)).' </td>
									<td>Shares deposit</td>
									<td></td>
									<td>'.number_format($payment_amount, 2).'</td>
									<td>'.number_format($running_balance, 2).'</td>
								</tr> 
							';
							$total_credit += $payment_amount;
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
                            <th>'.number_format($total_credit, 2).'</th>
                        </tr>
                    ';
                }
			
				echo $result;
				?>
			</table>
    </div>
</section>
            
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Loans Account Statement</h2>
    </header>
    <div class="panel-body">
    	<!-- Adding Errors -->
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
            <?php
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
								$total_credit += $payment_amount;
							}
						}
					}
					
					//display loan if disbursed
					if($individual_loan_status == 2)
					{
						$running_balance += $disbursed_amount;
						$total_debit += $disbursed_amount;
						
						$count++;
						$result .= 
						'
							<tr>
								<td>'.date('d M Y',strtotime($disbursed)).' </td>
								<td>'.$loans_plan_name.' disbursed</td>
								<td>'.number_format($disbursed_amount, 2).'</td>
								<td></td>
								<td></td>
								<td></td>
								<td>'.number_format($running_balance, 2).'</td>
							</tr> 
						';
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
									$total_credit += $payment_amount;
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
			
			echo $result;
			?>
        </table>
    </div>
</section>