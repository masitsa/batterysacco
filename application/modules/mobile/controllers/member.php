<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
// include autoloader
require_once "./application/libraries/dompdf/autoload.inc.php";
	
// reference the Dompdf namespace
use Dompdf\Dompdf;

class Member extends MX_Controller 
{
	var $individual_path;
	var $individual_location;
	var $signature_path;
	var $signature_location;
	
	function __construct()
	{
		parent:: __construct();
		
		$this->load->model('auth/auth_model');
		$this->load->model('site/site_model');
		$this->load->model('admin/users_model');
		$this->load->model('admin/sections_model');
		$this->load->model('admin/file_model');
		$this->load->model('admin/admin_model');
		$this->load->model('microfinance/individual_model');
		$this->load->model('microfinance/savings_plan_model');
		$this->load->model('microfinance/loans_plan_model');
		$this->load->model('microfinance/payments_model');
		$this->load->model('microfinance/withdrawals_model');
		$this->load->model('hr/personnel_model');
		
		$member_login_status = $this->session->userdata('member_login_status');
		if($member_login_status != TRUE)
		{
			redirect('member-login');
		}
	}
    
	/*
	*
	*	Edit an existing individual
	*	@param int $individual_id
	*
	*/
	public function individual_account($image_location = NULL, $signature_location = NULL) 
	{
		$individual_id = $this->session->userdata('individual_id');
		//open the add new individual
		$data['title'] = 'Statement';
		$v_data['title'] = $data['title'];
		$v_data['individual'] = $this->individual_model->get_individual($individual_id);
		$row = $v_data['individual']->row();
		
		$v_data['member_account'] = TRUE;
		$v_data['individual_id'] = $individual_id;
		$v_data['payments'] = $this->individual_model->get_loan_payments($individual_id);
		$v_data['savings_payments'] = $this->individual_model->get_savings_payments($individual_id);
		$v_data['individual_savings'] = $this->individual_model->get_individual_savings_plans($individual_id);
		$v_data['savings_withdrawal_amount']= $this->individual_model->get_loan_repayment_amount($individual_id);
		$v_data['individual_loan'] = $this->individual_model->get_individual_loans($individual_id);
		$v_data['all_savings_payments'] = $this->individual_model->get_all_savings_payments($individual_id);
		$v_data['disbursments'] = $this->individual_model->get_disbursments($individual_id);
		$v_data['parent_sections'] = $this->sections_model->all_parent_sections('section_position');
		$v_data['savings_withdrawals'] = $this->individual_model->get_savings_withdrawals($individual_id);
		$v_data['withdrawal_type'] = $this->withdrawals_model->get_withdrawal_type();
		$data['content'] = $this->load->view('member/individual_account', $v_data, true);
		
		$this->load->view('templates/mobile', $data);
	}
	
	public function print_statement()
	{
		$individual_id = $this->session->userdata('individual_id');
		$v_data['all_savings_payments'] = $this->individual_model->get_all_savings_payments($individual_id);
		$v_data['individual'] = $this->individual_model->get_individual($individual_id);
		$v_data['savings_payments'] = $this->individual_model->get_savings_payments($individual_id);
		$v_data['individual_loan'] = $this->individual_model->get_individual_loans($individual_id);
		$v_data['disbursments'] = $this->individual_model->get_disbursments($individual_id);
		$v_data['contacts'] = $this->site_model->get_contacts();
		$this->load->view('individual/print_statement', $v_data);	
	}
	
	public function download_statement()
	{
		$individual_id = $this->session->userdata('individual_id');
		//$this->load->helper(array('dompdf', 'pdfFilePath'));
		$v_data['individual'] = $this->individual_model->get_individual($individual_id);
		$v_data['all_savings_payments'] = $this->individual_model->get_all_savings_payments($individual_id);
		$v_data['savings_payments'] = $this->individual_model->get_savings_payments($individual_id);
		$v_data['individual_loan'] = $this->individual_model->get_individual_loans($individual_id);
		$v_data['disbursments'] = $this->individual_model->get_disbursments($individual_id);
		$v_data['contacts'] = $this->site_model->get_contacts();
		//$this->load->view('individual/print_statement', $v_data);
		$html=$this->load->view('individual/print_statement', $v_data, true);
		
		$row = $v_data['individual']->row();

		$individual_lname = $row->individual_lname;
		$individual_mname = $row->individual_mname;
		$individual_fname = $row->individual_fname;
		$individual_number = $row->individual_number;
	
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = $individual_fname." ".$individual_mname." ".$individual_lname." ".$individual_number." statement.pdf";
		
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'potrait');
		
		// Render the HTML as PDF
		$dompdf->render();
		
		// Output the generated PDF to Browser
		$dompdf->stream();
 
        //load mPDF library
        /*$this->load->library('dompdf');
 
       //generate the PDF from the given html
        $this->dompdf->pdf->WriteHTML($html);
 
        //download it.
        $this->dompdf->pdf->Output($pdfFilePath, "D");
		
		 $html = $this->load->view('individual/print_statement', $v_data, true);
     	pdf_create($html, 'filename');*/
	}
}
?>