<?php
	$today = date('jS F Y H:i a',strtotime(date("Y:m:d h:i:s")));
?>
<?php
	$total_cost_of_goods_sold = $total_interest = $total_expenses = 0;
	
	if($interests->num_rows() > 0)
	{
		foreach ($interests->result() as $row2)
		{
			$payment_interest = $row2->payment_interest;
			
			$total_interest += $payment_interest;
		}
	}
	?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $contacts['company_name'];?> | <?php echo $title;?></title>
        <!-- For mobile content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- IE Support -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/vendor/bootstrap/css/bootstrap.css" media="all"/>
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/stylesheets/theme-custom.css" media="all"/>
        <style type="text/css">
			.receipt_spacing{letter-spacing:0px; font-size: 12px;}
			.center-align{margin:0 auto; text-align:center;}
			
			.receipt_bottom_border{border-bottom: #888888 medium solid;}
			.row .col-md-12 table {
				border:solid #000 !important;
				border-width:1px 0 0 1px !important;
				font-size:10px;
			}
			.row .col-md-12 th, .row .col-md-12 td {
				border:solid #000 !important;
				border-width:0 1px 1px 0 !important;
			}
			.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td
			{
				 padding: 2px;
			}
			
			.row .col-md-12 .title-item{float:left;width: 130px; font-weight:bold; text-align:right; padding-right: 20px;}
			.title-img{float:left; padding-left:30px;}
			img.logo{max-height:70px; margin:0 auto;}
			.panel, .table{margin-bottom:0;}
		</style>
    </head>
    <body class="receipt_spacing">
    	<div class="row">
        	<div class="col-xs-12">
            	<img src="<?php echo base_url().'assets/logo/'.$contacts['logo'];?>" alt="<?php echo $contacts['company_name'];?>" class="img-responsive logo"/>
            </div>
        </div>
    	<div class="row">
        	<div class="col-md-12 center-align receipt_bottom_border">
            	<strong>
                	<?php echo $contacts['company_name'];?><br/>
                    P.O. Box <?php echo $contacts['address'];?> <?php echo $contacts['post_code'];?>, <?php echo $contacts['city'];?><br/>
                    E-mail: <?php echo $contacts['email'];?>. Tel : <?php echo $contacts['phone'];?><br/>
                    <?php echo $contacts['location'];?>, <?php echo $contacts['building'];?>, <?php echo $contacts['floor'];?><br/>
                </strong>
            </div>
        </div>
        
      <div class="row receipt_bottom_border" >
        	<div class="col-md-12 center-align">
            	<strong>Profit and Loss Statement</strong>
            </div>
        </div>
        
    	<div class="row receipt_bottom_border">
        	<div class="col-md-12 center-align">
            	<strong>PARTICULARS</strong>
            </div>
        </div>
        
    	<div class="row">
        	<div class="col-md-12">
            	
                <section class="panel">
                    <div class="panel-body">
                        <!-- Adding Errors -->
                        <table class="table table-striped table-hover table-condensed">
                            <tr>
                                <th style="text-align:left" colspan="4">Ordinary Income/ Expense</th>
                            </tr>
                            <tr>
                                <th style="text-align:center" colspan="4">Income</th>
                            </tr>
                            <tr>
                                <th style="text-align:right" colspan="3">Loan interests</th>
                                <td style="text-align:left"><?php echo number_format($total_interest, 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:right" colspan="3">Total income</th>
                                <td style="text-align:right"><?php echo number_format($total_interest, 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:center" colspan="4">Cost of goods sold</th>
                            </tr>
                            <tr>
                                <th style="text-align:right" colspan="3">Cost of goods sold</th>
                                <td style="text-align:left"><?php echo number_format($total_cost_of_goods_sold, 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:right" colspan="3">Total cost of goods sold</th>
                                <td style="text-align:right"><?php echo number_format($total_cost_of_goods_sold, 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:left" colspan="3">Gross profit</th>
                                <td style="text-align:right"><?php echo number_format(($total_interest - $total_cost_of_goods_sold), 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:center" colspan="4">Expenses</th>
                            </tr>
                            <?php
                            if($expenses->num_rows() > 0)
							{
								foreach ($expenses->result() as $row2)
								{
									$creditor_name = $row2->creditor_name;
									$expense_amount = $row2->expense_amount;
									
									$total_expenses += $expense_amount;
									
									?>
                                    <tr>
                                        <th style="text-align:right" colspan="3"><?php echo $creditor_name;?></th>
                                        <td style="text-align:left"><?php echo number_format($expense_amount, 2);?></td>
                                    </tr>
                                    <?php
								}
							}
							?>
                            <tr>
                                <th style="text-align:left" colspan="3">Total expenses</th>
                                <td style="text-align:right"><?php echo number_format($total_expenses, 2);?></td>
                            </tr>
                            <tr>
                                <th style="text-align:left" colspan="3">Net income</th>
                                <td style="text-align:right"><?php echo number_format(($total_interest - $total_expenses), 2);?></td>
                            </tr>
                        </table>
                    </div>
                </section>
                
            </div>
        </div>
        
    </body>
    
</html>