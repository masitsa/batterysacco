<?php
$result = '';

if($loan_amount > 0)
{
	$result .= '
	<table class="table table-condensed table-striped table-hover table-bordered">
		<tr>
			<th>#</th>
			<th>Dates of repayment</th>
			<th>Start bal.</th>
			<th>Interest</th>
			<th>Principal payment</th>
			<th>End bal.</th>
			<th>Cummulative interest</th>
			<th>Cummulative payments</th>
		</tr>
	';
	$cummulative_interest = 0;
	$cummulative_principal = 0;
	$start_balance = $loan_amount;
	$total_days = 0;
	
	//display all payment dates
	for($r = 0; $r < $no_of_repayments; $r++)
	{
		$total_days += $installment_type_duration;
		$count = $r+1;
		$payment_date = date('jS M Y', strtotime($first_date. ' + '.$total_days.' days'));
		
		//straight line
		if($interest_id == 1)
		{
			//$interest_payment = ($loan_amount * ($interest_rate/100)) / $no_of_repayments;
			$interest_payment = ($loan_amount * ($interest_rate/100));
		}
		
		//reducing balance
		else
		{
			//$interest_payment = ($start_balance * ($interest_rate/100)) / $no_of_repayments;
			$interest_payment = ($start_balance * ($interest_rate/100));
		}
		$principal_payment = $loan_amount / $no_of_repayments;
		$end_balance = $start_balance - $principal_payment;
		$cummulative_interest += $interest_payment;
		$cummulative_principal += $principal_payment;
		
		$result .= '
		<tr>
			<td>'.$count.'</td>
			<td>'.$payment_date.'</td>
			<td>'.number_format($start_balance, 2).'</td>
			<td>'.number_format($interest_payment, 2).'</td>
			<td>'.number_format($principal_payment, 2).'</td>
			<td>'.number_format($end_balance, 2).'</td>
			<td>'.number_format($cummulative_interest, 2).'</td>
			<td>'.number_format($cummulative_principal, 2).'</td>
		</tr>
		';
		$start_balance -= $principal_payment;
	}
	
	$result .= '
	</table>
	';
}
?>
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Amortization table</h2>
    </header>
    <div class="panel-body">
        
        <?php 
            echo $result;
        ?>
        
    </div>
</section>