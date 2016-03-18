<?php
	
	if($guarantors->num_rows() > 0)
	{
		$count = 0;
			
		$result = 
		'
		<table class="table table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>#</th>
					<th>Guarantor name</th>
					<th>Guaranteed amount</th>
					<th>Added on</th>
					<th>Added by</th>
					<th>Actions</th>
				</tr>
			</thead>
			  <tbody>
			  
		';
		$total_guarnateed_amount = 0;
		$count = 0;
		foreach ($guarantors->result() as $row)
		{
			$loan_guarantor_id = $row->loan_guarantor_id;
			$individual_fname = $row->individual_fname;
			$individual_onames = $row->individual_onames;
			$personnel_fname = $row->personnel_fname;
			$personnel_onames = $row->personnel_onames;
			$guaranteed_amount = $row->guaranteed_amount;
			$total_guarnateed_amount += $guaranteed_amount;
			$guaranteed_amount = number_format($guaranteed_amount, 2);
			$created = date('jS M Y H:i:s',strtotime($row->created));
			
			$count++;
			$result .= 
			'
				<tr>
					<td>'.$count.'</td>
					<td>'.$individual_fname.' '.$individual_onames.'</td>
					<td>'.$guaranteed_amount.'</td>
					<td>'.$created.'</td>
					<td>'.$personnel_fname.' '.$personnel_onames.'</td>
					<td><a href="'.site_url().'microfinance/delete-guarantor/'.$individual_loan_id.'/'.$source_individual_id.'/'.$loan_guarantor_id.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$individual_fname.' '.$individual_onames.'?\');" title="Delete '.$individual_fname.' '.$individual_onames.'"><i class="fa fa-trash"></i></a></td>
				</tr> 
			';
		}
		$result .= 
		'
			<tr>
				<td></td>
				<td></td>
				<th>'.number_format($total_guarnateed_amount, 2).'</th>
				<td></td>
				<td></td>
			</tr> 
		';
		
		$result .= 
		'
					  </tbody>
					</table>
		';
	}
	
	else
	{
		$result = "<p>No guarantors added</p>";
	}
//repopulate data if validation errors occur
$validation_error = validation_errors();
				
$individual_id = set_value('individual_id');
$guaranteed_amount = set_value('guaranteed_amount');

?>
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Loans guarantors</h2>
                </header>
                <div class="panel-body">
            
					<?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Guarantor: </label>
                                    
                                    <div class="col-lg-7">
                                        <select class="form-control custom-select" name="individual_id" id="individual_id">
                                            <option value="">--Select guarantor--</option>
                                            <?php
                                                if($individuals->num_rows() > 0)
                                                {
                                                    $query = $individuals->result();
                                                    
                                                    foreach($query as $res)
                                                    {
                                                        $individual_number = $res->individual_number;
                                                        $individual_fname = $res->individual_fname;
                                                        $individual_onames = $res->individual_onames;
                                                        $db_individual_id = $res->individual_id;
                                                        
                                                        if($db_individual_id == $individual_id)
                                                        {
                                                            echo '<option value="'.$db_individual_id.'" selected>'.$individual_fname.' '.$individual_onames.' - '.$individual_number.'</option>';
                                                        }
                                                        
                                                        else
                                                        {
                                                            echo '<option value="'.$db_individual_id.'">'.$individual_fname.' '.$individual_onames.' - '.$individual_number.'</option>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             
                            <div class="col-md-6">
                                
                                
                                
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Guaranteed amount: </label>
                                    
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" name="guaranteed_amount" placeholder="Guaranteed amount" value="<?php echo $guaranteed_amount;?>">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-actions center-align">
                                    <button class="btn btn-primary" type="submit">
                                        Add guarantor
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php echo form_close();?>
                    
                    <a href="<?php echo site_url();?>microfinance/edit-individual/<?php echo $source_individual_id;?>" class="btn btn-sm btn-info pull-right">Back to loan</a>
                    <h4>Guarantors</h4>
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
                        echo $result;
                    ?>
                    
                </div>
            </section>

<script type="text/javascript">
$(document).ready(function(){

	$(function() {
		$("#individual_id").customselect();
	});
});
</script>
