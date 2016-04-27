<?php
//individual data
$row = $individual->row();

$individual_lname = $row->individual_lname;
$individual_mname = $row->individual_mname;
$individual_fname = $row->individual_fname;
$individual_email = $row->individual_email;
$individual_phone = $row->individual_phone;
$individual_number = $row->individual_number;
$v_data['outstanding_loan'] = $row->outstanding_loan;
$v_data['total_savings'] = $row->total_savings;
?>
      	<div class="row">
        
          <section class="panel">

                <header class="panel-heading">
                	<div class="row">
	                	<div class="col-md-6">
		                    <h2 class="panel-title">Edit <?php echo $individual_fname.' '.$individual_mname.' '.$individual_lname;?></h2>
		                    <i class="fa fa-user"/></i>
		                    <span id="work_email"><?php echo $individual_number;?></span>
		                    <i class="fa fa-phone"/></i>
		                    <span id="mobile_phone"><?php echo $individual_phone;?></span>
		                    <i class="fa fa-envelope"/></i>
		                    <span id="work_email"><?php echo $individual_email;?></span>

		                </div>
	                </div>
                </header>
                <div class="panel-body">
                	<?php
					$validation_errors = validation_errors();
					if(!empty($validation_errors))
					{
						echo '<div class="alert alert-danger"> '.$validation_errors.' </div>';
					}
					
					$success = $this->session->userdata('success_message');
		
					if(!empty($success))
					{
						echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
						$this->session->unset_userdata('success_message');
					}
					
					$error = $this->session->userdata('error_message');
					
					if(!empty($error))
					{
						echo '<div class="alert alert-danger"> '.$error.' </div>';
						$this->session->unset_userdata('error_message');
					}
					?>
                    
                    <div class="row">
                    	<div class="col-md-12">
                        	<div class="tabs">
								<ul class="nav nav-tabs nav-justified">
									<li class="active">
										<a class="text-center" data-toggle="tab" href="#history">Statement</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="history">
										<?php echo $this->load->view('edit/history', $v_data,  TRUE);?>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </section>