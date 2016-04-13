<?php

//individual data
$row = $individual->row();

$individual_id = $row->individual_id;
$individual_lname = $row->individual_lname;
$individual_mname = $row->individual_mname;
$individual_fname = $row->individual_fname;
$individual_email = $row->individual_email;
$individual_phone = $row->individual_phone;
$individual_number = $row->individual_number;
$outstanding_loan = $row->outstanding_loan;
$total_savings = $row->total_savings;

$v_data['individual_id'] = $individual_id;
$v_data['outstanding_loan'] = $outstanding_loan;
$v_data['total_savings'] = $total_savings;
$v_data['print'] = 1;

$today = date('jS F Y H:i a',strtotime(date("Y:m:d h:i:s")));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $contacts['company_name'];?> | Statement</title>
        <!-- For mobile content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- IE Support -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
       
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
         <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/vendor/bootstrap/css/bootstrap.css" media="all"/>
        <link rel="stylesheet" href="<?php echo base_url()."assets/themes/porto-admin/1.4.1/";?>assets/stylesheets/theme-custom.css" media="all"/>
    </head>
    <body class="receipt_spacing">
    	<div class="row">
        	<div class="col-xs-12 center-align">
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
            	<strong>Member Statement</strong>
            </div>
        </div>
        
        <!-- Patient Details -->
    	<div class="row receipt_bottom_border" style="margin-bottom: 10px;">
        	<div class="col-md-6">
            	<div class="row">
                	<div class="col-md-6">
                    	
                    	<div class="title-item">Member Name:</div>
                        
                    	<?php echo $individual_fname.' '.$individual_mname.' '.$individual_lname; ?>
                    </div>
               
                	<div class="col-md-6">
                    	<div class="title-item">Member Number:</div> 
                        
                    	<?php echo $individual_number; ?>
                    </div>
                </div>
            
            </div>
            
        	<div class="col-md-6 ">
            	<div class="row">
                	<div class="col-md-12">
                    	<div class="title-item">Statement Date:</div>
                        
                    	<?php echo $today; ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    	<div class="row receipt_bottom_border">
        	<div class="col-md-12 center-align">
            	<strong>PARTICULARS</strong>
            </div>
        </div>
        
    	<div class="row">
        	<div class="col-md-10">
            	
                <?php echo $this->load->view('edit/history', $v_data, TRUE);?>
                
            </div>
        </div>
        
    </body>
    
</html>