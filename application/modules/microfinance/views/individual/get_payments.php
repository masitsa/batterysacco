<?php
	
	$loan_details = $this->individual_model->get_individual_loan($individual_loan_id);
	$individual_loan_payments = $this->individual_model->get_loan_payments($individual_id);
	$total_payment_amount = 0;
	$total_payment_interest = 0;
	//echo 'payments = '. $individual_loan_payments->num_rows();
	if($individual_loan_payments->num_rows() > 0)
	{
		$count = 0;
			
		$result = 
		'
		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>#</th>
					<th>Payment date</th>
					<th>Payment amount</th>
					<th>Interest amount</th>
					<th>Added on</th>
					<th>Added by</th>
				</tr>
			</thead>
			  <tbody>
			  
		';
		$count = 0;
		foreach ($individual_loan_payments->result() as $row)
		{
			$loan_payment_id = $row->loan_payment_id;
			$personnel_fname = $row->personnel_fname;
			$personnel_onames = $row->personnel_onames;
			$payment_amount = $row->payment_amount;
			$payment_interest = $row->payment_interest;
			$total_payment_amount += $payment_amount;
			$total_payment_interest += $payment_interest;
			$payment_interest = number_format($payment_interest, 2);
			$payment_amount = number_format($payment_amount, 2);
			$created = date('jS M Y H:i:s',strtotime($row->created));
			$payment_date = date('jS M Y H:i:s',strtotime($row->payment_date));
			
			$count++;
			$result .= 
			'
				<tr>
					<td>'.$count.'</td>
					<td>'.$payment_date.'</td>
					<td>'.$payment_amount.'</td>
					<td>'.$payment_interest.'</td>
					<td>'.$created.'</td>
					<td>'.$personnel_fname.' '.$personnel_onames.'</td>
				</tr> 
			';
		}
		$result .= 
		'
			<tr>
				<td></td>
				<td></td>
				<th>'.number_format($total_payment_amount, 2).'</th>
				<th>'.number_format($total_payment_interest, 2).'</th>
				<td></td>
				<td></td>
			</tr> 
		';
		
		$result .= 
		'
					  </tbody>
					</table>
		';
	}
	
	else
	{
		$result = "<p>No payments added</p>";
	}

$row = $loan_details->row();

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
$application_date = date('jS M Y',strtotime($row->application_date));
$approved_date = date('jS M Y',strtotime($row->approved_date));
$disbursed_date = date('jS M Y',strtotime($row->disbursed_date));
$created_by = $row->created_by;
$approved_by = $row->approved_by;
$disbursed_by = $row->disbursed_by;
$individual_loan_status = $row->individual_loan_status;

$loan_amount = $proposed_amount;
$total_interest = 0;
$start_balance = $loan_amount;
$first_date = $row->application_date;

for($r = 0; $r < $no_of_repayments; $r++)
{
	$total_days = $installment_type_duration * $r;
	$count = $r+1;
	$payment_date = date('jS M Y', strtotime($first_date. ' + '.$total_days.' days'));
	
	//straight line
	if($interest_id == 1)
	{
		$total_interest += ($loan_amount * ($interest_rate/100));
	}
	
	//reducing balance
	else
	{
		$total_interest += ($start_balance * ($interest_rate/100));
	}
	$principal_payment = $loan_amount / $no_of_repayments;
	$start_balance -= $principal_payment;
}

?>
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Loans payments</h2>
                </header>
                <div class="panel-body">
                    
                    <table class="table table-condensed table-bordered table-striped table-hover">
                    	<tr>
                        	<th></th>
                        	<th>Principal</th>
                        	<th>Payments</th>
                        	<th>Balances</th>
                        </tr>
                    	<tr>
                        	<th>Amount</th>
                            <td><?php echo number_format($loan_amount, 2);?></td>
                            <td><?php echo number_format($total_payment_amount, 2);?></td>
                            <td><?php echo number_format(($loan_amount - $total_payment_amount), 2);?></td>
                        </tr>
                    	<tr>
                        	<th>Interest</th>
                            <td><?php echo number_format($total_interest, 2);?></td>
                            <td><?php echo number_format($total_payment_interest, 2);?></td>
                            <td><?php echo number_format(($total_interest - $total_payment_interest), 2);?></td>
                        </tr>
                    	<tr>
                        	<th>Total</th>
                            <th align="center"><?php echo number_format(($total_interest + $loan_amount), 2);?></th>
                            <th align="center"><?php echo number_format(($total_payment_interest + $total_payment_amount), 2);?></th>
                            <th align="center"><?php echo number_format((($total_interest + $loan_amount) - ($total_payment_interest + $total_payment_amount)), 2);?></th>
                        </tr>
                    </table>
                    <?php 
                        echo $result;
                    ?>
                </div>
            </section>