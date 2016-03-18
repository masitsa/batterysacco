<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>#</th>
						<th><a href="'.site_url().'microfinance/loans/loans_plan_name/'.$order_method.'/'.$page.'">Name</a></th>
						<th><a href="'.site_url().'microfinance/loans/interest_name/'.$order_method.'/'.$page.'">Interest Type</a></th>
						<th><a href="'.site_url().'microfinance/loans/interest_rate/'.$order_method.'/'.$page.'">Interest Rate</a></th>
						<th><a href="'.site_url().'microfinance/loans/installment_type_name/'.$order_method.'/'.$page.'">Installment Type</a></th>
						<th><a href="'.site_url().'microfinance/loans/minimum_loan_amount/'.$order_method.'/'.$page.'">Min amount</a></th>
						<th><a href="'.site_url().'microfinance/loans/maximum_loan_amount/'.$order_method.'/'.$page.'">Max amount</a></th>
						<th><a href="'.site_url().'microfinance/loans/custom_loan_amount/'.$order_method.'/'.$page.'">Fixed amount</a></th>
						<th><a href="'.site_url().'microfinance/loans/loans_plan_status/'.$order_method.'/'.$page.'">Status</a></th>
						<th colspan="5">Actions</th>
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
				$loans_plan_id = $row->loans_plan_id;
				$loans_plan_status = $row->loans_plan_status;
				$interest_rate = $row->interest_rate;
				$installment_type_name = $row->installment_type_name;
				$interest_name = $row->interest_name;
				$interest_id =$row->interest_id;
				$loans_plan_name =$row->loans_plan_name;
				$maximum_loan_amount =$row->maximum_loan_amount;
				$minimum_loan_amount =$row->minimum_loan_amount;
				$custom_loan_amount =$row->custom_loan_amount;
				$installment_type_id =$row->installment_type_id;
				$grace_period_minimum =$row->grace_period_minimum;
				$grace_period_maximum =$row->grace_period_maximum;
				$grace_period_default =$row->grace_period_default;
				$charge_interest_over_grace_period =$row->charge_interest_over_grace_period;
				$maximum_number_of_installments =$row->maximum_number_of_installments;
				$minimum_number_of_installments =$row->minimum_number_of_installments;
				$custom_number_of_installments =$row->custom_number_of_installments;
				$minimum_late_fee_on_total_loan =$row->minimum_late_fee_on_total_loan;
				$maximum_late_fee_on_total_loan =$row->maximum_late_fee_on_total_loan;
				$custom_late_fee_on_total_loan =$row->custom_late_fee_on_total_loan;
				$minimum_late_fee_on_overdue_principal =$row->minimum_late_fee_on_overdue_principal;
				$maximum_late_fee_on_overdue_principal =$row->maximum_late_fee_on_overdue_principal; 
				$custom_late_fee_on_overdue_principal =$row->custom_late_fee_on_overdue_principal;  
				$minimum_late_fee_on_overdue_interest =$row->minimum_late_fee_on_overdue_interest;
				$maximum_late_fee_on_overdue_interest =$row->maximum_late_fee_on_overdue_interest;
				$custom_late_fee_on_overdue_interest =$row->custom_late_fee_on_overdue_interest;
				$maximum_number_of_guarantors =$row->maximum_number_of_guarantors;
				$minimum_number_of_guarantors =$row->minimum_number_of_guarantors;
				$custom_number_of_guarantors =$row->custom_number_of_guarantors;

				//create deactivated status display
				if($loans_plan_status == 0)
				{
					$status = '<span class="label label-default">Disabled</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'microfinance/activate-loans-plan/'.$loans_plan_id.'" onclick="return confirm(\'Do you want to activate '.$loans_plan_name.'?\');" title="Activate '.$loans_plan_name.'"><i class="fa fa-thumbs-up"></i></a>';
				}
				//create activated status display
				else if($loans_plan_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'microfinance/deactivate-loans-plan/'.$loans_plan_id.'" onclick="return confirm(\'Do you want to deactivate '.$loans_plan_name.'?\');" title="Deactivate '.$loans_plan_name.'"><i class="fa fa-thumbs-down"></i></a>';
				}
				
				if($charge_interest_over_grace_period == 1)
				{
					$charge_interest_over_grace_period = 'Yes';
				}
				else
				{
					$charge_interest_over_grace_period = 'No';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$loans_plan_name.'</td>
						<td>'.$interest_name.'</td>
						<td>'.$interest_rate.'</td>
						<td>'.$installment_type_name.'</td>
						<td>'.number_format($minimum_loan_amount, 2).'</td>
						<td>'.number_format($maximum_loan_amount, 2).'</td>
						<td>'.number_format($custom_loan_amount, 2).'</td>
						<td>'.$status.'</td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#more'.$loans_plan_id.'">
						  	<i class="fa fa-plus"></i>
							</button>
						<!-- Modal -->
						<div class="modal fade" id="more'.$loans_plan_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  	<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">'.$loans_plan_name.'</h4>
										</div>
										<div class="modal-body">
											<table class="table table-bordered table-striped table-condensed">
												<tr>
													<th>Loan name</th>
													<td>'.$loans_plan_name.'</td>
												</tr>
												<tr>
													<th>Loan status</th>
													<td>'.$status.'</td>
												</tr>
												<tr>
													<th>Interest type</th>
													<td>'.$interest_name.'</td>
												</tr>
												<tr>
													<th>Installment type</th>
													<td>'.$installment_type_name.'</td>
												</tr>
												<tr>
													<th>Minimum loan amount</th>
													<td>'.$minimum_loan_amount.'</td>
												</tr>
												<tr>
													<th>Maximum loan amount</th>
													<td>'.$maximum_loan_amount.'</td>
												</tr>
												<tr>
													<th>Fixed loan amount</th>
													<td>'.$custom_loan_amount.'</td>
												</tr>
												<tr>
													<th>Minimum grace period</th>
													<td>'.$grace_period_minimum.'</td>
												</tr>
												<tr>
													<th>Maximum grace period</th>
													<td>'.$grace_period_maximum.'</td>
												</tr>
												<tr>
													<th>Default grace period</th>
													<td>'.$grace_period_default.'</td>
												</tr>
												<tr>
													<th>Charge interest over grace period</th>
													<td>'.$charge_interest_over_grace_period.'</td>
												</tr>
												<tr>
													<th>Minimum number of installments</th>
													<td>'.$minimum_number_of_installments.'</td>
												</tr>
												<tr>
													<th>Maximum number of installments</th>
													<td>'.$maximum_number_of_installments.'</td>
												</tr>
												<tr>
													<th>Fixed number of installments</th>
													<td>'.$custom_number_of_installments.'</td>
												</tr>
												<tr>
													<th>Minimum late fee on total loan</th>
													<td>'.$minimum_late_fee_on_total_loan.'</td>
												</tr>
												<tr>
													<th>Maximum late fee on total loan</th>
													<td>'.$maximum_late_fee_on_total_loan.'</td>
												</tr>
												<tr>
													<th>Fixed late fee on total loan</th>
													<td>'.$custom_late_fee_on_total_loan.'</td>
												</tr>
												<tr>
													<th>Minimum late fee on overdue principal</th>
													<td>'.$minimum_late_fee_on_overdue_principal.'</td>
												</tr>
												<tr>
													<th>Maximum late fee on overdue principal</th>
													<td>'.$maximum_late_fee_on_overdue_principal.'</td>
												</tr>
												<tr>
													<th>Fixed late fee on overdue principal</th>
													<td>'.$custom_late_fee_on_overdue_principal.'</td>
												</tr>
												<tr>
													<th>Minimum late fee on overdue interest</th>
													<td>'.$minimum_late_fee_on_overdue_interest.'</td>
												</tr>
												<tr>
													<th>Maximum late fee on overdue interest</th>
													<td>'.$maximum_late_fee_on_overdue_interest.'</td>
												</tr>
												<tr>
													<th>Fixed late fee on overdue interest</th>
													<td>'.$custom_late_fee_on_overdue_interest.'</td>
												</tr>
												<tr>
													<th>Minimum number of guarantors</th>
													<td>'.$minimum_number_of_guarantors.'</td>
												</tr>
												<tr>
													<th>Maximum number of guarantors</th>
													<td>'.$maximum_number_of_guarantors.'</td>
												</tr>
												<tr>
													<th>Fixed number of guarantors</th>
													<td>'.$custom_number_of_guarantors.'</td>
												</tr>
											</table>
										</div>
									</div>
								</div>

							</div>

						</td>
						<td><a href="'.site_url().'microfinance/edit-loans-plan/'.$loans_plan_id.'" class="btn btn-sm btn-success" title="Edit '.$loans_plan_name.'"><i class="fa fa-pencil"></i></a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'microfinance/delete-loans-plan/'.$loans_plan_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$loans_plan_name.'?\');" title="Delete '.$loans_plan_name.'"><i class="fa fa-trash"></i></a></td>
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
			$result .= "There are no loans plans";
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
                            	<div class="row" style="margin-bottom:20px;">
                                    <div class="col-lg-2 col-lg-offset-8">
                                        <a href="<?php echo site_url();?>microfinance/export-loans-plan" class="btn btn-sm btn-success pull-right">Export</a>
                                    </div>
                                    <div class="col-lg-2">
                                    	<a href="<?php echo site_url();?>microfinance/add-loans-plan" class="btn btn-sm btn-info pull-right">Add loans plan</a>
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
