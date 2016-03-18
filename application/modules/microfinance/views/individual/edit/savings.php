<?php
	$total_payments = $total_savings;
	$count = 1;
		
	$result = 
	'
	<table class="table table-bordered table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Payment date</th>
				<th>Payment amount</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>'.$count.'</td>
				<td>Brought forward</td>
				<td>'.number_format($total_savings, 2).'</td>
				<td></td>
			</tr> 
		  
	';
	
	if($savings_payments->num_rows() > 0)
	{
		foreach ($savings_payments->result() as $row)
		{
			$count++;
			$savings_payment_id = $row->savings_payment_id;
			$payment_amount = $row->payment_amount;
			$payment_date = date('M Y',strtotime($row->payment_date));
			$total_payments += $payment_amount;
			
			$result .= 
			'
				<tr>
					<td>'.$count.'</td>
					<td>'.$payment_date.'</td>
					<td>'.number_format($payment_amount, 2).'</td>
					<td><a href="'.site_url().'microfinance/delete-savings-payment/'.$savings_payment_id.'/'.$individual_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this payment?\');" title="Delete payment"><i class="fa fa-trash"></i></a></td>
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
				
if(!empty($validation_error))
{
	$savings_plan_id = set_value('savings_plan_id');
	$individual_savings_status = set_value('individual_savings_status');
	$individual_savings_opening_balance = set_value('individual_savings_opening_balance');
	$start_date = set_value('start_date');
}

else
{
	$savings_plan_id = '';
	$individual_savings_status = '';
	$individual_savings_opening_balance = 0;
	$start_date = '';
}
?>
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Savings details</h2>
                </header>
                <div class="panel-body">
                <!-- Adding Errors -->
            
            
            <?php echo form_open('microfinance/add-savings-payment/'.$individual_id, array("class" => "form-horizontal", "role" => "form"));?>
<div class="row">
	<div class="col-md-6">
        
        <div class="form-group">
            <label class="col-lg-5 control-label">Payment amount: </label>
            
            <div class="col-lg-7">
            	<input type="text" class="form-control" name="payment_amount" placeholder="Payment amount">
            </div>
        </div>
        
        
    </div>
     
	<div class="col-md-6">
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
			
            <h4>All payments</h4>
            <!-- statistics -->
            <div class="row">
            	<div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-secondary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Payments</h4>
                                        <div class="info">
                                            <strong class="amount"><?php echo $savings_payments->num_rows();?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <!--<a class="text-muted text-uppercase">(withdraw)</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-tertiary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Saved</h4>
                                        <div class="info">
                                            <strong class="amount">Kes <?php echo number_format($total_payments, 2);?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <!--<a class="text-muted text-uppercase">(statement)</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- end statistics -->
            <?php 
				echo $result;
			?>
            
                    
                </div>
            </section>