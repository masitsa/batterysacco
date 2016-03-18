<?php
//loans_plan data
$row = $loans_plan->row();

$loans_plan_id = $row->loans_plan_id;
$loans_plan_status = $row->loans_plan_status;
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
$interest_rate =$row->interest_rate;

//repopulate data if validation errors occur
$validation_error = validation_errors();
				
if(!empty($validation_error))
{
	$interest_id = set_value('interest_id');
	$loans_plan_name = set_value('loans_plan_name');
	$installment_type_id = set_value('installment_type_id');
	$grace_period_minimum = set_value('grace_period_minimum');
	$grace_period_maximum = set_value('grace_period_maximum');
	$grace_period_default = set_value('grace_period_default');
	$charge_interest_over_grace_period = set_value('charge_interest_over_grace_period');
	$maximum_loan_amount = set_value('maximum_loan_amount');
	$minimum_loan_amount = set_value('minimum_loan_amount');
	$custom_loan_amount = set_value('custom_loan_amount');
	$maximum_number_of_installments = set_value('maximum_number_of_installments');
	$minimum_number_of_installments = set_value('minimum_number_of_installments');
	$custom_number_of_installments = set_value('custom_number_of_installments');
	$minimum_late_fee_on_total_loan = set_value('minimum_late_fee_on_total_loan');
	$maximum_late_fee_on_total_loan = set_value('maximum_late_fee_on_total_loan');
	$custom_late_fee_on_total_loan = set_value('custom_late_fee_on_total_loan');
	$minimum_late_fee_on_overdue_principal = set_value('minimum_late_fee_on_overdue_principal');
	$maximum_late_fee_on_overdue_principal = set_value('maximum_late_fee_on_overdue_principal'); 
	$custom_late_fee_on_overdue_principal = set_value('custom_late_fee_on_overdue_principal');  
	$minimum_late_fee_on_overdue_interest = set_value('minimum_late_fee_on_overdue_interest');
	$maximum_late_fee_on_overdue_interest = set_value('maximum_late_fee_on_overdue_interest');
	$custom_late_fee_on_overdue_interest = set_value('custom_late_fee_on_overdue_interest');
	$maximum_number_of_guarantors = set_value('maximum_number_of_guarantors');
	$minimum_number_of_guarantors = set_value('minimum_number_of_guarantors');
	$custom_number_of_guarantors = set_value('custom_number_of_guarantors');
	$interest_rate = set_value('interest_rate');
}

?>          
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title"><?php echo $title;?></h2>
                </header>
                <div class="panel-body">
                	<div class="row" style="margin-bottom:20px;">
                        <div class="col-lg-12">
                            <a href="<?php echo site_url();?>microfinance/loans" class="btn btn-info pull-right">Back to loans plans</a>
                        </div>
                    </div>
                        
                    <!-- Adding Errors -->
                    <?php
                    if(isset($error)){
                        echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
                    }
                    
                    $validation_errors = validation_errors();
                    
                    if(!empty($validation_errors))
                    {
                        echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
                    }
                    ?>
                    
                    <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            <label class="col-lg-5 control-label">Name: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="loans_plan_name" placeholder="Name" value="<?php echo $loans_plan_name;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Installment type: </label>
            
            <div class="col-lg-7">
                 <select class="form-control" name="installment_type_id">
                    <option value="" >--Select installment type--</option>
                    <?php
                        if($installments->num_rows() > 0)
                        {
                                                    
                                // print_r($interest_scheme->result());
                            foreach($installments->result() as $res)
                            {
                                $inst_type_id = $res->installment_type_id;
                                $installment_type_name = $res->installment_type_name;
                                if($inst_type_id == $installment_type_id)
                                {
                                    echo '<option value="'.$inst_type_id.'" selected>'.$installment_type_name.'</option>';
                                }
                                
                                else
                                {
                                    echo '<option value="'.$inst_type_id.'">'.$installment_type_name.'</option>';
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Interest type </label>
            <div class="col-lg-7">
                <select class="form-control" name="interest_id">
                	<option value="">--Select interest type--</option>
                    <?php
                        if($interest_scheme->num_rows() > 0)
                        {
                            foreach($interest_scheme->result() as $res)
                            {
                                $int_id = $res->interest_id;
                                $interest_name = $res->interest_name;
                                if($interest_id == $int_id)
                                {
                                    echo '<option value="'.$int_id.'" selected>'.$interest_name.'</option>';
                                }
                                
                                else
                                {
                                    echo '<option value="'.$int_id.'">'.$interest_name.'</option>';
                                }
                            }
                        }
                    ?>
                </select>
            </div>
            
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Interest rate: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="interest_rate" placeholder="Interest rate" value="<?php echo $interest_rate;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Loan Amount: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_loan_amount" placeholder="Mininum Loan Amount" value="<?php echo $minimum_loan_amount;?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Loan Amount: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_loan_amount" placeholder="Maximum Loan Amount" value="<?php echo $maximum_loan_amount;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed Loan Amount </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_loan_amount" placeholder="Custom/Actual Loan Amount" value="<?php echo $custom_loan_amount;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Grace Period Min: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="grace_period_minimum" placeholder="Grace Period Minimum" value="<?php echo $grace_period_minimum;?>">
            </div>
        </div>

         <div class="form-group">
            <label class="col-lg-5 control-label">Grace Period Max: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="grace_period_maximum" placeholder="Grace Period Maximum" value="<?php echo $grace_period_maximum;?>">
            </div>
        </div>
        
         <div class="form-group">
            <label class="col-lg-5 control-label">Grace Period Default: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="grace_period_default" placeholder="Grace Period Default" value="<?php echo $grace_period_default;?>">
            </div>
        </div>

         <div class="form-group">
            <label class="col-lg-5 control-label">Charge Interest over Grace Period: </label>
            
            <div class="col-lg-3">
                <div class="radio">
                    <label>
                        <input type="radio" name="charge_interest_over_grace_period" value="1" checked="checked">
                        Yes
                    </label>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="radio">
                    <label>
                        <input type="radio" name="charge_interest_over_grace_period" value="0" >
                        No
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Number of Installments: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_number_of_installments" placeholder="Mininum Number of Installments" value="<?php echo $minimum_number_of_installments;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Number of Installments</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_number_of_installments" placeholder="Maximum Number of Installments" value="<?php echo $maximum_number_of_installments;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed Number of Installments </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_number_of_installments" placeholder="Custom Number of Installments" value="<?php echo $custom_number_of_installments;?>">
            </div>
        </div>
	</div>
    
    <div class="col-md-6">
        
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Late Fees On Total Loan </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_late_fee_on_total_loan" placeholder="Minimum Late Fees On Total Loan" value="<?php echo $minimum_late_fee_on_total_loan;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Late Fees on Total Loan </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_late_fee_on_total_loan" placeholder="Maximum Late Fees on Total Loan" value="<?php echo $maximum_late_fee_on_total_loan;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed Late Fees on Total Loan </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_total_loan" placeholder="Custom/Default Late Fees on Total Loan" value="<?php echo $custom_late_fee_on_total_loan;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Late Fees on Overdue Principal: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_late_fee_on_overdue_principal" placeholder="Minimum Late Fees on Overdue Principal" value="<?php echo $minimum_late_fee_on_overdue_principal;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Late Fees on Overdue Principal </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_late_fee_on_overdue_principal" placeholder="Maximum Late Fees on Overdue Principal" value="<?php echo $maximum_late_fee_on_overdue_principal;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed Late Fees on Overdue Principal </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_overdue_principal" placeholder="Custom Late Fees on Overdue Principal " value="<?php echo $custom_late_fee_on_overdue_principal;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Late Fees on Overdue interest </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_late_fee_on_overdue_interest" placeholder="Minimum Late Fees on Overdue interest" value="<?php echo $minimum_late_fee_on_overdue_interest;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Late Fees on Overdue interest </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_late_fee_on_overdue_interest" placeholder="Maximum Late Fees on Overdue interest" value="<?php echo $maximum_late_fee_on_overdue_interest;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed Late Fees on Overdue interest</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_overdue_interest" placeholder="Custom Late Fees on Overdue interest" value="<?php echo $custom_late_fee_on_overdue_interest;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum number of guarantors </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_number_of_guarantors" placeholder="Mininum number of guarantors" value="<?php echo $minimum_number_of_guarantors;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum number of guarantors </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_number_of_guarantors" placeholder="Maxinum number of guarantors" value="<?php echo $maximum_number_of_guarantors;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Fixed number of guarantors </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_number_of_guarantors" placeholder="Custom/Actual number of guarantors" value="<?php echo $custom_number_of_guarantors;?>">
            </div>
        </div>
        
        
    </div>
</div>
<div class="row" style="margin-top:10px;">
	<div class="col-md-12">
        <div class="form-actions center-align">
            <button class="submit btn btn-primary" type="submit">
                Edit loan plan
            </button>
        </div>
    </div>
</div>
                    <?php echo form_close();?>
                </div>
            </section>