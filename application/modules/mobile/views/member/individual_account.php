<?php
//individual data
$row = $individual->row();

$individual_lname = $row->individual_lname;
$individual_mname = $row->individual_mname;
$individual_fname = $row->individual_fname;
$individual_email = $row->individual_email;
$individual_phone = $row->individual_phone;
$individual_number = $row->individual_number;
$outstanding_loan = $row->outstanding_loan;
$total_savings = $row->total_savings;

?>
<div class="page" data-page="account">
    <div class="page-content">
        <div class="content-block">
			<div class="content-block-inner">
                <div class="last-sale">
                    <h2 class="sale-title"><?php echo $individual_fname.' '.$individual_mname.' '.$individual_lname;?></h2>
                    <h3 class="sale-title">Savings Account Statement</h3>
                    <div class="sale-list">
                        <ul>
                            <li>
                                <span class="sale-text">Description</span>
                                <span class="sale-price">Amount</span>
                            </li>
                            
                            <?php 
                            
                            /**********
                            *
                            *	SAVINGS
                            *
                            ***********/
                            if($total_savings > 0)
                            {
                                ?>
                                <li>
                                    <span class="sale-text">Savings balance b/f</span>
                                    <span class="sale-price"><?php echo number_format($total_savings, 2);?></span>
                                </li>
                                <!--<li>
                                    <span class="sale-text">Running balance</span>
                                    <span class="sale-price"><?php echo number_format($total_savings, 2);?></span>
                                </li>-->
                                <?php
                            }
                            
                            //get all savings before date
                            $total_credit = $running_balance = $total_savings;
                            $result = '';
                            $total_debit = $total_credit = 0;
                            if($all_savings_payments->num_rows() > 0)
                            {
                                $count = 1;
                                $total_payments = 0;
                                foreach ($all_savings_payments->result() as $row2)
                                {
                                    $savings_payment_id = $row2->savings_payment_id;
                                    $payment_amount = $row2->payment_amount;
                                    $payment_date = $row2->payment_date;
                                    $payment_type = $row2->payment_type;
                                    $description = $row2->description;
                                    $cheque_number = $row2->cheque_number;
                                    $debit = $credit= '';
                                    if(empty($description))
                                    {
                                        $description = 'Shares deposit';
                                    }
                                    if ($payment_type == 1)
                                    {
                                        $debit = number_format($payment_amount, 2);
                                        $running_balance -= $payment_amount;
                                        $total_credit += $payment_amount;	
                                        $amount = '('.$debit.')';
                                    }
                                    else
                                    {
                                        $credit = number_format($payment_amount, 2);
                                        $running_balance += $payment_amount;
                                        $total_credit += $payment_amount;	
                                        $amount = $credit;
                                    }
                                    $payments = $this->individual_model->get_loan_payments($individual_id);
                                                        
                                    if($payment_amount > 0)
                                    {
                                        $count++;
                                        ?>
                                        <li>
                                            <span class="sale-date"><?php echo date('d M Y',strtotime($payment_date));?></span>
                                        </li>
                                        <li>
                                            <span class="sale-text"><?php echo $description.' '.$cheque_number;?></span>
                                            <span class="sale-price"><?php echo $amount;?></span>
                                        </li>
                                        <?php
                                    }
                                }
                            	?>
                                <li>
                                    <span class="sale-text">Savings balance</span>
                                    <span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <h3 class="sale-title" style="margin-top:40px;">Loans Account Statement</h3>
                    <div class="sale-list">
                        <ul>
                            <li>
                                <span class="sale-text">Description</span>
                                <span class="sale-price">Amount</span>
                            </li>
                            
                            <!-- Savings bf -->
                            <?php 
                            if($outstanding_loan > 0)
                            {
                                ?>
                                <li>
                                    <span class="sale-text">Loan balance b/f</span>
                                    <span class="sale-price"><?php echo number_format($outstanding_loan, 2);?></span>
                                </li>
                                <!--<li>
                                    <span class="sale-text">Running balance</span>
                                    <span class="sale-price"><?php echo number_format($outstanding_loan, 2);?></span>
                                </li>-->
                                <?php
                            }
                            
                            /**********
                            *
                            *	LOANS
                            *
                            ***********/
                            $last_date = '';
                            $payments = $this->individual_model->get_loan_payments($individual_id);
                            
                            $result = '';
                            $count = 1;
                            $total_debit = $running_balance = $outstanding_loan;
                            $total_credit = 0;
                            $total_disbursments = $disbursments->num_rows();
                            $disbursments_count = 0;
                            if($total_disbursments > 0)
                            {
                                foreach ($disbursments->result() as $row)
                                {
                                    $disbursement_date = $row->dibursement_date;
                                    $cheque_amount = $row->cheque_amount;
                                    $cheque_number = $row->cheque_number;
                                    //$disbursed_date = date('jS d M Y',strtotime($disbursement_date));
                                    $disbursments_count++;
                                    
                                    //get all loan deductions before date
                                    if($payments->num_rows() > 0)
                                    {
                                        foreach ($payments->result() as $row2)
                                        {
                                            $loan_payment_id = $row2->loan_payment_id;
                                            $personnel_fname = $row2->personnel_fname;
                                            $personnel_onames = $row2->personnel_onames;
                                            $payment_amount = $row2->payment_amount;
                                            $payment_interest = $row2->payment_interest;
                                            $created = date('jS M Y H:i:s',strtotime($row2->created));
                                            $payment_date = $row2->payment_date;
                                            
                                            if(($payment_date <= $disbursement_date) && ($payment_date > $last_date) && ($payment_amount > 0))
                                            {
                                                $count++;
                                                $running_balance -= $payment_amount;
                                                ?>
                                                <li>
                                                    
                                                    <span class="sale-date"><?php echo date('d M Y',strtotime($payment_date));?></span>
                                                </li>
                                                <li>
                                                    <span class="sale-text">Loan repayment</span>
                                                    <span class="sale-price"><?php echo number_format($payment_amount, 2);?></span>
                                                </li>
                                                <!--<li>
                                                	<span class="sale-text">Running balance</span>
                                                    <span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
                                                </li>-->
                                                <?php
                                                $total_credit += $payment_amount;
                                            }
                                        }
                                    }
                                    
                                    //display disbursment if cheque amount > 0
                                    if($cheque_amount > 0)
                                    {
                                        $running_balance += $cheque_amount;
                                        $total_debit += $cheque_amount;
                                        
                                        $count++;
                                        ?>
                                        <li>
                                            <span class="sale-date"><?php echo date('d M Y',strtotime($disbursement_date));?></span>
                                        </li>
                                        <li>
                                            <span class="sale-text">Disbursed cheque <?php echo $cheque_number;?></span>
                                            <span class="sale-price">(<?php echo number_format($cheque_amount, 2);?>)</span>
                                        </li>
                                        <!--<li>
                                        	<span class="sale-text">Running balance</span>
                                            <span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
                                        </li>-->
                                        <?php
                                    }
                                    
                                    //check if there are any more payments
                                    if($total_disbursments == $disbursments_count)
                                    {
                                        //get all loan deductions before date
                                        if($payments->num_rows() > 0)
                                        {
                                            foreach ($payments->result() as $row2)
                                            {
                                                $loan_payment_id = $row2->loan_payment_id;
                                                $personnel_fname = $row2->personnel_fname;
                                                $personnel_onames = $row2->personnel_onames;
                                                $payment_amount = $row2->payment_amount;
                                                $payment_interest = $row2->payment_interest;
                                                $created = date('jS M Y H:i:s',strtotime($row2->created));
                                                $payment_date = $row2->payment_date;
                                                
                                                if(($payment_date > $disbursement_date) && ($payment_amount > 0))
                                                {
                                                    $count++;
                                                    $running_balance -= $payment_amount;
                                                    ?>
                                                    <li>
                                                        <span class="sale-date"><?php echo date('d M Y',strtotime($payment_date));?></span>
                                                    </li>
                                                    <li>
                                                        <span class="sale-text">Loan repayment</span>
                                                        <span class="sale-price"><?php echo number_format($payment_amount, 2);?></span>
                                                    </li>
                                                    <!--<li>
                                                		<span class="sale-text">Running balance</span>
                                                        <span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
                                                    </li>-->
                                                    <?php
                                                    $total_credit += $payment_amount;
                                                }
                                            }
                                        }
                                    }
                                    $last_date = $disbursement_date;
                                }
                            }
                            
                            else
                            {
                                //get all loan deductions before date
                                if($payments->num_rows() > 0)
                                {
                                    foreach ($payments->result() as $row2)
                                    {
                                        $loan_payment_id = $row2->loan_payment_id;
                                        $personnel_fname = $row2->personnel_fname;
                                        $personnel_onames = $row2->personnel_onames;
                                        $payment_amount = $row2->payment_amount;
                                        $payment_interest = $row2->payment_interest;
                                        $created = date('jS M Y H:i:s',strtotime($row2->created));
                                        $payment_date = $row2->payment_date;
                                        $running_balance -= $payment_amount;
                                        
                                        $count++;
                                        if($payment_amount > 0)
                                        {
                                            ?>
                                            <li>
                                                <span class="sale-date"><?php echo date('d M Y',strtotime($payment_date));?></span>
                                            </li>
                                            <li>
                                                <span class="sale-text">Loan repayment</span>
                                                <span class="sale-price"><?php echo number_format($payment_amount, 2);?></span>
                                            </li>
                                            <!--<li>
                                            	<span class="sale-text">Running balance</span>
                                                <span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
                                            </li>-->
                                            <?php
                                            $total_credit += $payment_amount;
                                        }
                                    }
                                }
                            }
							?>
							<li>
								<span class="sale-text">Loan balance</span>
								<span class="sale-price"><?php echo number_format($running_balance, 2);?></span>
							</li>
							<?php
                            
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>