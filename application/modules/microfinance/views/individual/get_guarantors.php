<?php
	
		$guarantors = $this->individual_model->get_guarantors($individual_loan_id);
		$source_individual_id = $individual_id;
		$individual_loan_id = $individual_loan_id;
		$individuals = $this->individual_model->all_individual($individual_id);
		$title = 'Add guarantor';
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
			$individual_lname = $row->individual_lname;
			$individual_mname = $row->individual_mname;
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
					<td>'.$individual_fname.' '.$individual_mname.' '.$individual_lname.'</td>
					<td>'.$guaranteed_amount.'</td>
					<td>'.$created.'</td>
					<td>'.$personnel_fname.' '.$personnel_onames.'</td>
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
?>
          <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Loans guarantors</h2>
                </header>
                <div class="panel-body">
            		
                    <?php 
                        echo $result;
                    ?>
                    
                </div>
            </section>