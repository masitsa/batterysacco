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
				
				$individual_balance_data = $this->reports_model->get_individual_balance_data($individual_id, $total_savings, $outstanding_loan);
				
				$count_individual++;
				$result .= 
				'
					<tr>
						<td>'.$count_individual.'</td>
						<td>'.$individual_number.'</td>
						<td>'.$individual_type_name.'</td>
						<td>'.$individual_lname.' '.$individual_fname.' '.$individual_mname.'</td>
						<td>'.number_format($individual_balance_data['running_balance_savings'],0).'</td>
						<td>'.date('d M Y',strtotime($individual_balance_data['last_transaction_date'])).'</td>
						<td>'.number_format($individual_balance_data['running_balance_loans'],0).'</td>
						<td>'.$individual_balance_data['last_loan_payment_date'].'</td>
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