<?php
	
	$total_payment_amount = 0;
	$total_payment_interest = 0;
	if($payments->num_rows() > 0)
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
					<th>Actions</th>
				</tr>
			</thead>
			  <tbody>
			  
		';
		$count = 0;
		foreach ($payments->result() as $row)
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
					<td><a href="'.site_url().'microfinance/delete-loan-payment/'.$individual_loan_id.'/'.$source_individual_id.'/'.$loan_payment_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this payment?\');" title="Delete this payment?"><i class="fa fa-trash"></i></a></td>
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
//repopulate data if validation errors occur
$validation_error = validation_errors();
				
$payment_date2 = set_value('payment_date');
$payment_amount = set_value('payment_amount');
$payment_interest = set_value('payment_interest');

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
            
					<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
                        <div class="row">
                             
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Payment amount: </label>
                                    
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" name="payment_amount" placeholder="Payment amount" value="<?php echo $payment_amount;?>" autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                             
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Payment interest: </label>
                                    
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" name="payment_interest" placeholder="Payment interest" value="<?php echo $payment_interest;?>" autocomplete="off">
                                    </div>
                                </div>
                                
                            </div>
                             
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Payment date: </label>
                                    
                                    <div class="col-lg-7">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="payment_date" placeholder="Payment date" value="<?php echo $payment_date2;?>" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-actions center-align">
                                    <button class="btn btn-primary" type="submit">
                                        Add payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                    
                    <a href="<?php echo site_url();?>microfinance/edit-individual/<?php echo $source_individual_id;?>" class="btn btn-sm btn-info pull-right">Back to loan</a>
                    <h4>Statement</h4>
                    
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
                    <h4>Payments</h4>
                    <?php 
                        echo $result;
                    ?>
                </div>
            </section>