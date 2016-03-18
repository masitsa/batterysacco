<?php
	$count = 1;
		
	$result = 
	'
	<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Loan type</th>
				<th>Purpose</th>
				<th>No. of repayments</th>
				<th>Requested amount</th>
				<th>Disbursed amount</th>
				<th>Application date</th>
				<th>Disbursed date</th>
				<th>Status</th>
				<th colspan="6">Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>'.$count.'</td>
				<td colspan="4">Brought forward</td>
				<td>'.number_format($outstanding_loan, 2).'</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			<tr>
	';
	
	if($individual_loan->num_rows() > 0)
	{
		
		foreach ($individual_loan->result() as $row)
		{
			$count++;
			$loans_plan_name = $row->loans_plan_name;
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
			$v_data['individual_loan_id'] = $individual_loan_id;
			$v_data['individual_id'] = $individual_id;
			$v_data['loan_amount'] = $proposed_amount;
			$v_data['no_of_repayments'] = $no_of_repayments;
			$v_data['first_date'] = $row->application_date;
			$v_data['interest_id'] = $interest_id;
			$v_data['interest_rate'] = $interest_rate;
			$v_data['installment_type_duration'] = $installment_type_duration;
			$v_data['loan_details'] = $this->individual_model->get_loan_details($individual_loan_id);
			$loan_payments = $this->load->view('individual/get_payments', $v_data, true);
			$loan_guarantors = $this->load->view('individual/get_guarantors', $v_data, true);
			$amortization_table = $this->load->view('individual/get_amortization_table', $v_data, true);
			$proposed_amount = number_format($proposed_amount, 2);
			$approved_amount = number_format($approved_amount, 2);
			$disbursed_amount = number_format($disbursed_amount, 2);
			//var_dump($loan_guarantors);die();
			if($approved_date == '1st Jan 1970')
			{
				$approved_date = '-';
			}
			
			if($disbursed_date == '1st Jan 1970')
			{
				$disbursed_date = '-';
			}
			
			if($personnel->num_rows() > 0)
			{
				foreach($personnel->result() as $res)
				{
					$personnel_id = $res->personnel_id;
					$personnel_fname = $res->personnel_fname;
					$personnel_onames = $res->personnel_onames;
					if($personnel_id == $created_by)
					{
						$created_by = $personnel_onames.' '.$personnel_fname;
					}
					if($personnel_id == $approved_by)
					{
						$approved_by = $personnel_onames.' '.$personnel_fname;
					}
					if($personnel_id == $disbursed_by)
					{
						$disbursed_by = $personnel_onames.' '.$personnel_fname;
					}
				}
			}
			
			//create deactivated status display
			if($individual_loan_status == 0)
			{
				$status = '<span class="label label-default">Pending approval</span>';
				$button = '<a class="btn btn-info" href="'.site_url().'microfinance/activate-individual-loan/'.$individual_loan_id.'/'.$individual_id.'" onclick="return confirm(\'Do you want to approve '.$loans_plan_name.'?\');" title="Approve '.$loans_plan_name.'"><i class="fa fa-thumbs-up"></i></a>';
			}
			//create activated status display
			else if($individual_loan_status == 1)
			{
				$status = '<span class="label label-success">Approved</span>';
				$button = '<a class="btn btn-default" href="'.site_url().'microfinance/disburse-individual-loan/'.$individual_loan_id.'/'.$individual_id.'" onclick="return confirm(\'Do you want to disburse '.$loans_plan_name.'?\');" title="Disburse '.$loans_plan_name.'"><i class="fa fa-thumbs-down"></i></a>';
			}
			//create activated status display
			else if($individual_loan_status == 2)
			{
				$status = '<span class="label label-success">Disbursed</span>';
				$button = '<a class="btn btn-default" href="'.site_url().'microfinance/deactivate-individual-loan/'.$individual_loan_id.'/'.$individual_id.'" onclick="return confirm(\'Do you want to deactivate '.$loans_plan_name.'?\');" title="Deactivate '.$loans_plan_name.'"><i class="fa fa-thumbs-down"></i></a>';
			}
			
			else
			{
				$status = '<span class="label label-warning">Unasigned</span>';
				$button = '';
			}
			
			$result .= 
			'
				<tr>
					<td>'.$count.'</td>
					<td>'.$loans_plan_name.'</td>
					<td>'.$purpose.'</td>
					<td>'.$no_of_repayments.'</td>
					<td>'.$proposed_amount.'</td>
					<td>'.$disbursed_amount.'</td>
					<td>'.$application_date.'</td>
					<td>'.$disbursed_date.'</td>
					<td>'.$status.'</td>
					<td>
						<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#more'.$individual_loan_id.'">
						<i class="fa fa-plus"></i>
						</button>
					<!-- Modal -->
					<div class="modal fade" id="more'.$individual_loan_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-dialog-wide" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">'.$loans_plan_name.'</h4>
								</div>
								<div class="modal-body">
									<!-- Nav tabs -->
									<ul class="nav nav-tabs nav-justified" role="tablist">
										<li role="presentation" class="active"><a href="#application" aria-controls="home" role="tab" data-toggle="tab">Loan details</a></li>
										<li role="presentation"><a href="#guarantors" aria-controls="profile" role="tab" data-toggle="tab">Guarantors</a></li>
										<li role="presentation"><a href="#amortization" aria-controls="settings" role="tab" data-toggle="tab">Amortization table</a></li>
										<li role="presentation"><a href="#repayment" aria-controls="settings" role="tab" data-toggle="tab">Repayment</a></li>
									</ul>
									
									<!-- Tab panes -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="application">
											<div class="row">
												<div class="col-md-4">
													<section class="panel">
														<header class="panel-heading">						
															<h2 class="panel-title">Application</h2>
														</header>
														<div class="panel-body">
															<table class="table table-bordered table-striped table-condensed">
																<tr>
																	<th>Loan name</th>
																	<td>'.$loans_plan_name.'</td>
																</tr>
																<tr>
																	<th>Requested amount</th>
																	<td>'.$proposed_amount.'</td>
																</tr>
																<tr>
																	<th>Loan purpose</th>
																	<td>'.$purpose.'</td>
																</tr>
																<tr>
																	<th>Application date</th>
																	<td>'.$application_date.'</td>
																</tr>
																<tr>
																	<th>Grace period</th>
																	<td>'.$grace_period.'</td>
																</tr>
																<tr>
																	<th>No. of repayments</th>
																	<td>'.$no_of_repayments.'</td>
																</tr>
																<tr>
																	<th>Applied by</th>
																	<td>'.$created_by.'</td>
																</tr>
															</table>
														</div>
													</section>
												</div>
												
												<div class="col-md-4">
													<section class="panel">
														<header class="panel-heading">						
															<h2 class="panel-title">Approval</h2>
														</header>
														<div class="panel-body">
															<table class="table table-bordered table-striped table-condensed">
																<tr>
																	<th>Approved amount</th>
																	<td>'.$approved_amount.'</td>
																</tr>
																<tr>
																	<th>Approved date</th>
																	<td>'.$approved_date.'</td>
																</tr>
																<tr>
																	<th>Approved by</th>
																	<td>'.$approved_by.'</td>
																</tr>
															</table>
														</div>
													</section>
												</div>
												
												<div class="col-md-4">
													<section class="panel">
														<header class="panel-heading">						
															<h2 class="panel-title">Disbursment</h2>
														</header>
														<div class="panel-body">
															<table class="table table-bordered table-striped table-condensed">
																<tr>
																	<th>Disbursed amount</th>
																	<td>'.$disbursed_amount.'</td>
																</tr>
																<tr>
																	<th>Disbursed date</th>
																	<td>'.$disbursed_date.'</td>
																</tr>
																<tr>
																	<th>Disbursed by</th>
																	<td>'.$disbursed_by.'</td>
																</tr>
															</table>
														</div>
													</section>
												</div>
											</div>
										</div>
										<div role="tabpanel" class="tab-pane" id="guarantors">
											'.$loan_guarantors.'
										</div>
										<div role="tabpanel" class="tab-pane" id="amortization">
											'.$amortization_table.'
										</div>
										<div role="tabpanel" class="tab-pane" id="repayment">
											'.$loan_payments.'
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
					<td><a href="'.site_url().'microfinance/edit-individual-plan/'.$individual_loan_id.'/'.$individual_id.'" class="btn btn-sm btn-success" title="Edit '.$loans_plan_name.'"><i class="fa fa-pencil"></i></a></td>
					<td><a href="'.site_url().'microfinance/add-guarantors/'.$individual_loan_id.'/'.$individual_id.'" class="btn btn-sm btn-warning" title="Add guarantors"><i class="fa fa-users"></i></a></td>
					<td><a href="'.site_url().'microfinance/add-loan-payment/'.$individual_loan_id.'/'.$individual_id.'" class="btn btn-sm btn-default" title="Add loan payment"><i class="fa fa-money"></i></a></td>
					<td>'.$button.'</td>
					<td><a href="'.site_url().'microfinance/delete-individual-plan/'.$individual_loan_id.'/'.$individual_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$loans_plan_name.'?\');" title="Delete '.$loans_plan_name.'"><i class="fa fa-trash"></i></a></td>
				</tr> 
			';
		}
	}
		
	$result .= 
	'
				  </tbody>
				</table>
	';
//repopulate data if validation errors occur
$validation_error = validation_errors();
				
$loans_plan_id = set_value('loans_plan_id');
$proposed_amount = set_value('proposed_amount');
$individual_loan_status = set_value('individual_loan_status');
$individual_loan_opening_balance = set_value('individual_loan_opening_balance');
$application_date = set_value('application_date');
$purpose = set_value('purpose');
$no_of_repayments = set_value('no_of_repayments');
$grace_period = set_value('grace_period');

?>
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Loans details</h2>
                </header>
                <div class="panel-body">
                <!-- Adding Errors -->
            
            
            <?php echo form_open('microfinance/loan-application/'.$individual_id, array("class" => "form-horizontal", "role" => "form"));?>
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            <label class="col-lg-5 control-label">Loan type: </label>
            
            <div class="col-lg-7">
            	<select class="form-control" name="loans_plan_id" id="update_loan_plan">
                	<option value="">--Select loan type--</option>
                	<?php
                    	if($loans_plans->num_rows() > 0)
						{
							$loans_plan = $loans_plans->result();
							
							foreach($loans_plan as $res)
							{
								$db_loans_plan_id = $res->loans_plan_id;
								$loans_plan_name = $res->loans_plan_name;
								
								if($db_loans_plan_id == $loans_plan_id)
								{
									echo '<option value="'.$db_loans_plan_id.'" selected>'.$loans_plan_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$db_loans_plan_id.'">'.$loans_plan_name.'</option>';
								}
							}
						}
					?>
                </select>
                <br/>
                <div id="loan_details"></div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Requested loan amount: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="proposed_amount" placeholder="Requested loan amount" value="<?php echo $proposed_amount;?>">
            </div>
        </div>
        
        
    </div>
     
	<div class="col-md-6">
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Loan purpose: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="purpose" placeholder="Loan purpose" value="<?php echo $purpose;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Number of repayments: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="no_of_repayments" placeholder="Number of repayments" value="<?php echo $no_of_repayments;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Grace period: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="grace_period" placeholder="Grace period" value="<?php echo $grace_period;?>">
            </div>
        </div>
        
    	<div class="form-group">
            <label class="col-lg-5 control-label">Application date: </label>
            
            <div class="col-lg-7">
            	<div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="application_date" placeholder="Application date" value="<?php echo $application_date;?>">
                </div>
            </div>
        </div>
        
	</div>
</div>
<div class="row" style="margin-top:10px;">
	<div class="col-md-12">
        <div class="form-actions center-align">
            <button class="btn btn-primary" type="submit">
               	Apply for loan
            </button>
        </div>
    </div>
</div>
            <?php 
				echo form_close();
			?>
			
            <h4>Loan payments</h4>
            
            <?php echo form_open('microfinance/add-loan-payment/'.$individual_id, array("class" => "form-horizontal", "role" => "form"));?>
<div class="row">
	<div class="col-md-4">
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Payment amount: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="payment_amount" placeholder="Payment amount">
            </div>
        </div>
        
        
    </div>
    
	<div class="col-md-4">
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Interest amount: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="payment_interest" placeholder="Interest amount">
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
                    <input data-format="yyyy-MM-dd" type="text" data-plugin-datepicker class="form-control" name="payment_date" placeholder="Payment date">
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
            <?php 
				echo form_close();
			?>
			
            <h4>Loans</h4>
            <?php 
				echo $result;
			?>
            
                    
                </div>
            </section>

<script type="text/javascript">
	$(document).on("change","select#update_loan_plan",function(e)
	{
		$( "#loan_details" ).html('');
		var loans_plan_id = $(this).val();
		
		//get department services
		$.get( "<?php echo site_url();?>microfinance/loans_plan/get_loan_details/"+loans_plan_id, function( data ) 
		{
			$( "#loan_details" ).html( data );
		});
	});
</script>