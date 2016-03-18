<?php 
$customer_id    = set_value('customer_id');
$payment_type   = set_value('payment_type');
$payment_amount = set_value('payment_amount');
$slip_number    = set_value('slip_number');
$date_paid      = set_value('date_paid');
$payment_month  = set_value('payment_month');

// var_dump($customers);
?>
  
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo $title;?></h2>
    </header>
    <div class="panel-body">
            
        <!-- Adding Errors -->
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
        <?php
       
        
        
        
        $validation_errors = validation_errors();
        
        if(!empty($validation_errors))
        {
            echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
        }
        ?>
        
        <?php echo form_open('microfinance/payments/add_individual_payment', array("class" => "form-horizontal", "role" => "form"));?>
    	<div class="row">
    		<div class="col-md-8">
    			<div class="form-group ">
					<label class="col-lg-5 control-label">Name: </label>

					<div class="col-lg-7">
						<select id="cname" class="form-control" name="customer_id" >
							<option value="" >Select customer name:</option>
							<?php
		                        if($customers->num_rows() > 0)
		                        {
		                                                    
		                                // print_r($interest_scheme->result());
		                            foreach($customers->result() as $customer)
		                            {
		                                echo $inst_id = $customer->individual_id;
		                                $inst_name = $customer->individual_onames;
		                                if($inst_id == $customer_id)
		                                {
		                                    echo '<option value="'.$inst_id.'" selected>'.$inst_name.'</option>';
		                                }
		                                
		                                else
		                                {
		                                    echo '<option value="'.$inst_id.'">'.$inst_name.'</option>';
		                                }
		                            }
		                        }

		                    ?>

						</select>
					</div>
    			</div>
    			
    			<div class="form-group ">
					<label class="col-lg-5 control-label">Payment Amount: </label>

					<div class="col-lg-7">
						<input type="number" id="payment_amount" class="form-control" name="payment_amount" value="<?php echo $payment_amount; ?>">
					</div>
    			</div>
    			<div class="form-group ">
					<label class="col-lg-5 control-label">Payment Slip Number: </label>

					<div class="col-lg-7">
						<input type="text" id="slip_number" class="form-control" name="slip_number" value="<?php echo $slip_number;?> ">
					</div>
    			</div>
    			<div class="form-group ">
					<label class="col-lg-5 control-label"> Date Paid: </label>

					<div class="col-lg-7">
						<input type="datetime-local" id="date_paid" class="form-control" name="date_paid" value="<?php echo $date_paid;?> ">
					</div>
    			</div>
    			<div class="form-group ">
					<label class="col-lg-5 control-label">Month Payment is for: </label>

					<div class="col-lg-7">
						<input type="month" id="payment_month" class="form-control" name="payment_month" value="<?php echo $payment_month;?>">
					</div>
    			</div>
    		</div>
    	</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-md-12">
		        <div class="form-actions center-align">
		            <button class="submit btn btn-primary" type="submit">
		                Add individual payment
		            </button>
		        </div>
		    </div>
		</div>
		<?php echo form_close();?>
    </div>
</section>
