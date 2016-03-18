<?php 
	$total_members = number_format($this->reports_model->get_total_members(), 0, '.', ',');
	$month_interest_payments = number_format($this->reports_model->month_interest_payments(), 0, '.', ',');
	$month_loans_payments = number_format($this->reports_model->month_loan_payments(), 0, '.', ',');
	$month_savings_payments = number_format($this->reports_model->month_savings_payments(), 0, '.', ',');
 ?>
 <div class="row">
    <div class="col-md-3 col-lg-3 col-xl-3">
        <section class="panel panel-featured-left panel-featured-tertiary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-tertiary">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Total members</h4>
                            <div class="info">
                                <strong class="amount"><?php echo $total_members;?></strong>
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
    <div class="col-md-3 col-lg-3 col-xl-3">
        <section class="panel panel-featured-left panel-featured-quartenary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-quartenary">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Month's Interest Revenue</h4>
                            <div class="info">
                                <strong class="amount"><?php echo $month_interest_payments;?></strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <!--<a class="text-muted text-uppercase" href="<?php echo base_url()."data/reports/patients.php";?>">(report)</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-3 col-lg-3 col-xl-3">
        <section class="panel panel-featured-left panel-featured-secondary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-secondary">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Month's loan payments</h4>
                            <div class="info">
                                <strong class="amount">Kes <?php echo $month_loans_payments;?></strong>
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
    <div class="col-md-3 col-lg-3 col-xl-3">
        <section class="panel panel-featured-left panel-featured-primary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title">Month's savings payments</h4>
                            <div class="info">
                                <strong class="amount">Kes <?php echo $month_savings_payments;?></strong>
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
</div>
         