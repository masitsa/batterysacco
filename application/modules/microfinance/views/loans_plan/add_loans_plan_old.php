<?php
//loans_plan data
// $loans_plan_name = set_value('loans_plan_name');
// $loans_plan_min_opening_balance = set_value('loans_plan_min_opening_balance');
// $loans_plan_min_account_balance = set_value('loans_plan_min_account_balance');
// $charge_withdrawal = set_value('charge_withdrawal');
// $compounding_period_name = set_value('compounding_period_name');
$interest_name = set_value('interest_name');
$loans_plan_name = set_value('loans_plan_name');
$installment_type = set_value('installment_type');
$grace_period_minimum = set_value('grace_period_minimum');
$grace_period_maximum = set_value('grace_period_maximum');
$grace_period_default = set_value('grace_period_default');
$charge_interest_over_grace_period = set_value('charge_interest_over_grace_period');
// echo $charge_interest_over_grace_period;
// $interest_scheme = set_value('interest_scheme');
$funding_line = set_value('funding_line');
$maximum_loan_amount = set_value('maximum_loan_amount');
$minimum_loan_amount = set_value('minimum_loan_amount');
$custom_loan_amount  = set_value('custom_loan_amount');
$annual_minimum_interest = set_value('annual_minimum_interest');
$annual_maximum_interest = set_value('annual_maximum_interest');
$annual_custom_interest = set_value('annual_custom_interest');
$maximum_number_of_installments = set_value('maximum_number_of_installments');
$minimum_number_of_installments = set_value('minimum_number_of_installments');
$custom_number_of_installments = set_value('custom_number_of_installments');
$minimum_late_fee_on_total_loan = set_value('minimum_late_fee_on_total_loan');
$maximum_late_fee_on_total_loan = set_value('maximum_late_fee_on_total_loan');
$custom_late_fee_on_total_loan = set_value('custom_late_fee_on_total_loan');
$minimum_late_fee_on_overdue_principal = set_value('minimum_late_fee_on_overdue_principal');
$maximum_late_fee_on_overdue_principal = set_value('maximum_late_fee_on_overdue_principal');  
$custom_late_fee_on_overdue_principal = set_value('custom_late_fee_on_overdue_principal');
$minimum_late_fee_on_olb = set_value('minimum_late_fee_on_olb');
$maximum_late_fee_on_olb = set_value('maximum_late_fee_on_olb');
$custom_late_fee_on_olb = set_value('custom_late_fee_on_olb');
$minimum_late_fee_on_overdue_interest = set_value('minimum_late_fee_on_overdue_interest');
$maximum_late_fee_on_overdue_interest = set_value('maximum_late_fee_on_overdue_interest');
$custom_late_fee_on_overdue_interest = set_value('custom_late_fee_on_overdue_interest');
$atr_minimum_fees = set_value('atr_minimum_fees');
$atr_maximum_fees = set_value('atr_maximum_fees');
$atr_custom_fees = set_value('atr_custom_fees');
$apr_minimum_fees = set_value('apr_minimum_fees');
$apr_maximum_fees = set_value('apr_maximum_fees');
$apr_custom_fees = set_value('apr_custom_fees');
$base_for_apr_fees = set_value('base_for_apr_fees');
$base_for_atr_fees = set_value('base_for_atr_fees');
$use_line_of_credit = set_value('use_line_of_credit');
$minimum_line_of_credit_amount = set_value('minimum_line_of_credit_amount');
$maximum_line_of_credit_amount = set_value('maximum_line_of_credit_amount');
$custom_line_of_credit_amount = set_value('custom_line_of_credit_amount');
$minimum_number_of_tranches = set_value('minimum_number_of_tranches');
$maximum_number_of_tranches = set_value('maximum_number_of_tranches');
$custom_number_of_tranches = set_value('custom_number_of_tranches');
$use_gc = set_value('use_gc');
$min_gc = set_value('min_gc');
$set_sep_gc = set_value('set_sep_gc');
$min_guarantors = set_value('min_guarantors');
$min_collateral = set_value('min_collateral');
$use_compulsory_savings = set_value('use_compulsory_savings');
$compulsory_savings_minimum = set_value('compulsory_savings_minimum');
$compulsory_savings_maximum = set_value('compulsory_savings_maximum');
$compulsory_savings_custom = set_value('compulsory_savings_custom');
// var_dump($installments);

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
            	<input type="text" class="form-control" name="loans_plan_name" placeholder="Name" value="<?php echo $interest_name;?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Installment type: </label>
            
            <div class="col-lg-7">
                 <select class="form-control" name="installment_type">
                    <option value="Select installment type" >Select installment type</option>
                    <?php
                        if($installments->num_rows() > 0)
                        {
                                                    
                                // print_r($interest_scheme->result());
                            foreach($installments->result() as $res)
                            {
                                $inst_id = $res->id;
                                $inst_name = $res->name;
                                if($inst_id == $installment_type)
                                {
                                    echo '<option value="'.$inst_id.'" selected>'.$inst_name.'</option>';
                                }
                                
                                else
                                {
                                    echo '<option value="'.$inst_name.'">'.$inst_name.'</option>';
                                }
                            }
                        }
                    ?>
                </select>
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
                <input type="radio" class="form-control" name="charge_interest_over_grace_period" value="1">
            </div>
            <div class="col-lg-3">
                <input type="radio" class="form-control" name="charge_interest_over_grace_period" value="0">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Interest Scheme </label>
            <div class="col-lg-7">
                <select class="form-control" name="interest_scheme">
                    <?php
                        if($interest_scheme->num_rows() > 0)
                        {
                                                    
                                // print_r($interest_scheme->result());
                            foreach($interest_scheme->result() as $res)
                            {
                                $interest_id = $res->id;
                                $interest_name = $res->name;
                                if($interest_id == $interest_scheme)
                                {
                                    echo '<option value="'.$interest_id.'" selected>'.$interest_name.'</option>';
                                }
                                
                                else
                                {
                                    echo '<option value="'.$interest_id.'">'.$interest_name.'</option>';
                                }
                            }
                        }
                    ?>
                </select>
            </div>
            
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Funding Line </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="funding_line" placeholder="Specify funding line" value="<?php echo $funding_line;?>">
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
            <label class="col-lg-5 control-label">Custom/Actual Loan Amount </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_loan_amount" placeholder="Custom/Actual Loan Amount" value="<?php echo $custom_loan_amount;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Annual Minimum Interest </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="annual_minimum_interest" placeholder="Annual Minimum Interest" value="<?php echo $annual_minimum_interest;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Annual Maximum Interest </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="annual_maximum_interest" placeholder="Annual Maximum Interest" value="<?php echo $annual_maximum_interest;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Annual Custom Interest</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="annual_custom_interest" placeholder="Annual Custom Interest" value="<?php echo $annual_custom_interest;?>">
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
            <label class="col-lg-5 control-label">Custom Number of Installments </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_number_of_installments" placeholder="Custom Number of Installments" value="<?php echo $custom_number_of_installments;?>">
            </div>
        </div>
        
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
            <label class="col-lg-5 control-label">Custom/Default Late Fees on Total Loan </label>
            
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
            <label class="col-lg-5 control-label">Custom Late Fees on Overdue Principal </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_overdue_principal" placeholder="Custom Late Fees on Overdue Principal " value="<?php echo $custom_late_fee_on_overdue_principal;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Late Fees on OLB </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_late_fee_on_olb" placeholder="Minimum Late Fees on OLB" value="<?php echo $minimum_late_fee_on_olb;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Late Fees on OLB </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_late_fee_on_olb" placeholder="Maximum Late Fees on OLB" value="<?php echo $maximum_late_fee_on_olb;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Custom Late Fees on OLB</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_olb" placeholder="Custom Late Fees on OLB" value="<?php echo $custom_late_fee_on_olb;?>">
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
            <label class="col-lg-5 control-label">Custom Late Fees on Overdue interest</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_late_fee_on_overdue_interest" placeholder="Custom Late Fees on Overdue interest" value="<?php echo $custom_late_fee_on_overdue_interest;?>">
            </div>
        </div>
	</div>
    
    <div class="col-md-6">
        
         <div class="form-group">
            <label class="col-lg-5 control-label">ATR Fees Minimum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="atr_minimum_fees" placeholder="ATR Fees Minimum" value="<?php echo $atr_minimum_fees;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">ATR Fees Maximum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="atr_maximum_fees" placeholder="ATR Fees Maximum" value="<?php echo $atr_maximum_fees;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Custom ATR Fees: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="atr_custom_fees" placeholder="ATR Fees Custom" value="<?php echo $atr_custom_fees;?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label">APR Fees Minimum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="apr_minimum_fees" placeholder="APR Fees Minimum" value="<?php echo $apr_minimum_fees;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">APR Fees Maximum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="apr_maximum_fees" placeholder="APR Fees Maximum" value="<?php echo $apr_maximum_fees;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Custom APR Fees: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="apr_custom_fees" placeholder="APR Fees Custom" value="<?php echo $apr_custom_fees;?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label">Base for ATR Fees  </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="base_for_atr_fees" placeholder="Base for ATR Fees" value="<?php echo $base_for_atr_fees;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Use Line of Credit </label>
            
            <div class="col-lg-7">
                <input type="checkbox" class="form-control" name="use_line_of_credit" placeholder="Use line of credit" value="<?php echo $use_line_of_credit;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum Line of Credit Amount </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_line_of_credit_amount" placeholder="Mininum Line of Credit Amount" value="<?php echo $minimum_line_of_credit_amount;?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-5 control-label">Maximum Line of Credit Amount </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_line_of_credit_amount" placeholder="Maximum Line of Credit Amount" value="<?php echo $maximum_line_of_credit_amount;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Custom Value/Real Credit Amount: </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_line_of_credit_amount" placeholder="Custom Value/Real Credit Amount" value="<?php echo $custom_line_of_credit_amount;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum number of tranches </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="minimum_number_of_tranches" placeholder="Mininum number of tranches" value="<?php echo $minimum_number_of_tranches;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Maximum number of tranches </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="maximum_number_of_tranches" placeholder="Maxinum number of tranches" value="<?php echo $maximum_number_of_tranches;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Custom/Actual number of tranches </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="custom_number_of_tranches" placeholder="Custom/Actual number of tranches" value="<?php echo $custom_number_of_tranches;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Use guarantors and collateral </label>
            
            <div class="col-lg-7">
                <input type="checkbox" class="form-control" name="use_gc" placeholder="Use guarantors and collateral" value="<?php echo $use_gc;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum percentage of guarantors + collaterals </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="min_gc" placeholder="Mininum percentage of guarantors + collaterals" value="<?php echo $min_gc;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Set separate values for guarantors and collaterals</label>
            
            <div class="col-lg-7">
                <input type="checkbox" class="form-control" name="set_sep_gc" placeholder="Set separate values for guarantors and collaterals" value="<?php echo $set_sep_gc;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum percentage for guarantors</label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="min_guarantors" placeholder="Minimum percentage for guarantors" value="<?php echo $min_guarantors;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Minimum percentage for collaterals </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="min_collateral" placeholder="Minimum percentage for collateral" value="<?php echo $min_collateral;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Use compulsory savings </label>
            
            <div class="col-lg-7">
                <input type="checkbox" class="form-control" name="use_compulsory_savings" placeholder="Use compulsory savings" value="<?php echo $use_compulsory_savings;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Compulsory saving account minimum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="compulsory_savings_minimum" placeholder="Compulsory saving account minimum" value="<?php echo $compulsory_savings_minimum;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Compulsory saving account maximum </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="compulsory_savings_maximum" placeholder="Compulsory saving account maximum" value="<?php echo $compulsory_savings_maximum;?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-5 control-label">Compulsory saving custom/actual amount </label>
            
            <div class="col-lg-7">
                <input type="text" class="form-control" name="compulsory_savings_custom" placeholder="Compulsory custom/actual account minimum" value="<?php echo $compulsory_savings_custom;?>">
            </div>
        </div>
        
        
    </div>
</div>
<div class="row" style="margin-top:10px;">
	<div class="col-md-12">
        <div class="form-actions center-align">
            <button class="submit btn btn-primary" type="submit">
                Add loans plan
            </button>
        </div>
    </div>
</div>
                    <?php echo form_close();?>
                </div>
            </section>