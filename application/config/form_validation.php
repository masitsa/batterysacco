<?php 

$config = array(
	'loans' => array(
			array(
				'field' => 'loans_plan_name',
				'label' => 'Loan Plan Name',
				'rules' => 'required'
			),
			array(
				'field' => 'interest_scheme',
				'label' => 'Interest Scheme',
				'rules' => 'required'
			),
			array(
				'field' => 'grace_period_minimum',
				'label' => 'Grace Period Minimum must be a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'grace_period_maximum',
				'label' => 'Grace Period Maximum must be a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'grace_period_default',
				'label' => 'Grace Period Default must be a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'funding_line',
				'label' => 'Funding line',
				'rules' => 'alpha_numeric_spaces'
			),
			array(
				'field' => 'maximum_loan_amount',
				'label' => 'Maximum Loan amount is a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'minimum_loan_amount',
				'label' => 'Minimum Loan amount is a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'custom_loan_amount',
				'label' => 'Custom Loan amount is a number and required',
				'rules' => 'required|numeric'
			),
			array(
				'field' => 'annual_minimum_interest',
				'label' => 'Annual minimum interest must be a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'annual_maximum_interest',
				'label' => 'Annual maximum interest must be a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'annual_custom_interest',
				'label' => 'Annual Custom  must be a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_number_of_installments',
				'label' => 'Maximum number of installments is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_number_of_installments',
				'label' => 'Minimum number of installments is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_number_of_installments',
				'label' => 'Custom  number of installments is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_late_fee_on_total_loan',
				'label' => 'Minimum late fee on total  loan is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_late_fee_on_total_loan',
				'label' => 'Maximum late fee on total loan is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_late_fee_on_total_loan',
				'label' => 'Custom late fee on total loan is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_late_fee_on_overdue_principal',
				'label' => 'Minimum Late fee on overdue principal is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_late_fee_on_overdue_principal',
				'label' => 'Maximum Late fee on overdue principal is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_late_fee_on_overdue_principal',
				'label' => 'Custom Late fee on overdue principal is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_late_fee_on_olb',
				'label' => 'Minimum Late fee on OLB is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_late_fee_on_olb',
				'label' => 'Maximum Late fee on OLB is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_late_fee_on_olb',
				'label' => 'Custom Late fee on OLB is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_late_fee_on_overdue_interest',
				'label' => 'Minimum Late fee on overdue interest is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_late_fee_on_overdue_interest',
				'label' => 'Maximum Late fee on overdue interest is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_late_fee_on_overdue_interest',
				'label' => 'Custom Late fee on overdue interest is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'atr_minimum_fees',
				'label' => 'Minimum ATR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'atr_maximum_fees',
				'label' => 'Maximum ATR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'atr_custom_fees',
				'label' => 'Custom ATR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'apr_minimum_fees',
				'label' => 'Minimum APR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'apr_maximum_fees',
				'label' => 'Maximum APR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'apr_custom_fees',
				'label' => 'Custom APR fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_line_of_credit_amount',
				'label' => 'Minimum line of credit amount fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_line_of_credit_amount',
				'label' => 'Maximum line of credit amount fees is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'minimum_number_of_tranches',
				'label' => 'Minimum number of tranches is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'maximum_number_of_tranches',
				'label' => 'Maximum number of tranches is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'custom_number_of_tranches',
				'label' => 'Custom number of tranches is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'min_gc',
				'label' => 'Minimum percentage of guarantors + collateral is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'min_guarantors',
				'label' => 'Minimum percentage guarantors is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'min_collateral',
				'label' => 'Minimum percentage collateral is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'compulsory_savings_minimum',
				'label' => 'Compulsory savings minimum is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'compulsory_savings_maximum',
				'label' => 'Compulsory savings maximum is a number',
				'rules' => 'numeric'
			),
			array(
				'field' => 'min_collateral',
				'label' => 'Compulsory savings custom is a number',
				'rules' => 'numeric'
			),

	),
	'individual_payments' =>array(
		array(
			'field' => 'customer_id',
			'label' => 'Customer Name', 
			'rules' => 'required' 
		),
		// array(
		// 	'field' => 'payment_type',
		// 	'label' => 'Payment Method', 
		// 	'rules' => 'required' 
		// ),
		array(
			'field' => 'payment_amount',
			'label' => 'Payment Amount', 
			'rules' => 'required|greater_than[0]' 
		),
		array(
			'field' => 'slip_number',
			'label' => 'Slip Number', 
			'rules' => 'required' 
		),
		array(
			'field' => 'date_paid',
			'label' => 'Date Paid', 
			'rules' => 'required' 
		),
		array(
			'field' => 'payment_month',
			'label' => 'Month Payment is for:', 
			'rules' => 'required' 
		),
	),
	'group_payments' =>array(
		array(
			'field' => 'customer_id',
			'label' => 'Group Name', 
			'rules' => 'required' 
		),
		// array(
		// 	'field' => 'payment_type',
		// 	'label' => 'Payment Method', 
		// 	'rules' => 'required' 
		// ),
		array(
			'field' => 'payment_amount',
			'label' => 'Payment Amount', 
			'rules' => 'required|greater_than[0]' 
		),
		array(
			'field' => 'slip_number',
			'label' => 'Slip Number', 
			'rules' => 'required' 
		),
		array(
			'field' => 'date_paid',
			'label' => 'Date Paid', 
			'rules' => 'required' 
		),
		array(
			'field' => 'payment_month',
			'label' => 'Month Payment is for:', 
			'rules' => 'required' 
		),
	),
	'list_payments' =>array(
		array(
			'field' => 'customer_id',
			'label' => 'Group Name', 
			'rules' => 'required' 
		),
	),
);