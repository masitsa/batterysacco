<?php 
$customer_id    = set_value('customer_id');

// var_dump($customers);
?>
  
<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo $title;?></h2>
    </header>
    <div class="panel-body">
            
        <!-- Adding Errors -->
        <?php
        if(isset($error_message)){
        	echo '<div class="alert alert-danger">\'$error_message;\'</div>';
        }
        if(isset($success_message)){
        	echo '<div class="alert alert-success">\'$error_message;\'</div>';
        }
        
        if(isset($error)){
            echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
        }

        
        $validation_errors = validation_errors();
        
        if(!empty($validation_errors))
        {
            echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
        }
        ?>
        
        <?php echo form_open('microfinance/show-group-payment', array("class" => "form-horizontal", "role" => "form"));?>
    	<div class="row">
    		<div class="col-md-8">
    			<div class="form-group ">
					<label class="col-lg-5 control-label">Name: </label>

					<div class="col-lg-7">
						<select id="cname" class="form-control" name="customer_id" >
							<option value="" >Select group:</option>
							<?php
		                        if($customers->num_rows() > 0)
		                        {
		                                                    
		                                // print_r($interest_scheme->result());
		                            foreach($customers->result() as $customer)
		                            {
		                                 $inst_id = $customer->group_id;
		                                $inst_name = $customer->group_name;
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
    		</div>
    	</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-md-12">
		        <div class="form-actions center-align">
		            <button class="submit btn btn-primary" type="submit">
		                List group payments
		            </button>
		        </div>
		    </div>
		</div>
		<?php echo form_close();?>
    </div>
</section>
