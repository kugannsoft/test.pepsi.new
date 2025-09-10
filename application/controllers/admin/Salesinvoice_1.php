<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesinvoice extends Admin_Controller {
	public function __construct() {
        parent::__construct();
        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Job_model');
        date_default_timezone_set("Asia/Colombo");
         $this->load->library('Datatables');

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $title='';
        $titleno='';
    }

    public function index() {

            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Job Invoice';
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/job/view_job');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/Job/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            
            $this->template->admin_render('admin/sales/sales-invoice', $this->data);
    }

    public function view_invoice($inv=null) {

            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Job Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/sales/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('JobLocation')->from('jobinvoicehed')->where('JobInvNo', $invNo)->get()->row()->JobLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $isPay = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobInvNo', $invNo)->where('IsPayment',1)->get()->num_rows();
         
            $this->data['title'] = 'Job Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            if($isPay>0){
                $balance=$this->db->select('JobCreditAmount')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobCreditAmount;
            }else{
                $balance=$this->db->select('JobNetAmount')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobNetAmount;
            }
            
            $this->data['balance'] = "Rs. ".number_format($balance,2);

            $this->data['inv_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->get()->result();


            $this->data['invHed']=  $this->db->select('JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobVatAmount,JobNbtAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany,JobInvNo,IsCancel,InvoiceType,users.first_name,users.last_name,TempNo,VComName,InvRemark')
                ->from('jobinvoicehed')->join('users','jobinvoicehed.JobInvUser=users.id','left')->join('vehicle_company','jobinvoicehed.JInsCompany=vehicle_company.VComId','left')->where('JobInvNo',$invNo)->get()->row();


            $this->data['jobtype'] = $this->db->select('jobcardhed.JPayType')->from('jobcardhed')->join('jobinvoicehed','jobinvoicehed.JobCardNo=jobcardhed.JobCardNo')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();

                $cusCode =  $this->db->select('JCustomer')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer;
                $regNo =  $this->db->select('JRegNo')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;
                $isJob =$this->db->select('jobcardhed.JobCardNo')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->where('JobInvNo', $invNo)->get()->num_rows();
                //check job card
                if($isJob>0){
                    $appoimnetDate =$this->db->select('jobcardhed.appoimnetDate')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->where('JobInvNo', $invNo)->get()->row()->appoimnetDate;
                    $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn,jobcardhed.OdoOut,jobcardhed.OdoOutUnit,jobcardhed.OdoInUnit,jobcardhed.NextService')
                    ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo','left')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();
                    $this->data['job_count'] = $this->db->select('count(jobcardhed.JobCardNo)  AS noofjobs')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo','left')->where('jobinvoicehed.JobInvNo', $invNo)->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row();
                     $this->data['last_job'] = $this->db->select('max(date(jobcardhed.appoimnetDate))  AS lastjob')->from('jobcardhed')->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row()->lastjob;
                }else{
                    $this->data['invjob']=null;
                    $this->data['job_count'] =null;
                }
                $this->data['job']=$this->db->select('jobinvoicehed.*')->from('jobinvoicehed')->where('jobinvoicehed.JCustomer',$cusCode)->where('jobinvoicehed.IsCancel',0)->get()->result();
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
                $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();

             

        $isCard = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->num_rows();
            if($isCard>0){
            $this->data['card_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->row();
        }else{
             $this->data['card_pay'] ='';
        }

        $isCheque = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->num_rows();
            if($isCheque>0){
            $this->data['cheque_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,chequedetails.*,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->join('chequedetails', 'chequedetails.ReferenceNo = jobinvoicepaydtl.JobInvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->row();   
        }else{
            $this->data['cheque_pay'] ='';
        }

        //invoice cancel
             $this->data['invCancel']=$this->db->select('canceljobinvoice.*,users.first_name,users.last_name')->from('canceljobinvoice')->join('users', 'canceljobinvoice.CancelUser = users.id', 'INNER')->where('canceljobinvoice.JobInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 2)->order_by('UpdateDate','DESC')->get()->result();

            $result=$this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS SubDescription , jobtypeheader.jobhead_name AS Description')->from('jobinvoicedtl')->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER')->join('jobtypeheader', 'jobtypeheader.jobhead_id = jobtype.jobhead', 'INNER')->where('jobinvoicedtl.JobInvNo', $invNo)->order_by('jobtypeheader.jobhead_order', 'ASC')->order_by('jobtype.jobtype_order', 'ASC')->order_by('jobinvoicedtl.JobinvoiceTimestamp','ASC')->order_by('jobinvoicedtl.EstLineNo', 'ASC')->get();

             $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 2)->get()->result();
            $list = array();
            foreach ($result->result() as $row) {
                $list[$row->Description][] = $row;
            }
        
            $this->data['invDtl']=$list;         
            $this->template->admin_render('admin/sales/view-invoice', $this->data);
    }

     public function view_temp_invoice($inv=null) {

            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Temparary Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/sales/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('JobLocation')->from('tempjobinvoicehed')->where('JobInvNo', $invNo)->get()->row()->JobLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;
            $isPay = 0;
         
            $this->data['title'] = 'Job Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            if($isPay>0){
                $balance=$this->db->select('JobCreditAmount')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobCreditAmount;
            }else{
                $balance=$this->db->select('JobNetAmount')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobNetAmount;
            }
            
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            $this->data['inv_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->get()->result();
            $this->data['invHed']=  $this->db->select('JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobVatAmount,JobNbtAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany,JobInvNo,IsCancel,IsInvoice,InvoiceType,users.first_name,users.last_name,VComName,InvRemark')
                ->from('tempjobinvoicehed')->join('users','tempjobinvoicehed.JobInvUser=users.id','left')->join('vehicle_company','tempjobinvoicehed.JInsCompany=vehicle_company.VComId','left')->where('JobInvNo',$invNo)->get()->row();
                $cusCode =  $this->db->select('JCustomer')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer;
                $regNo =  $this->db->select('JRegNo')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
                $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();
                $isjob = $this->db->select('JobCardNo')->from('tempjobinvoicehed')->where('JobInvNo', $invNo)->get()->row()->JobCardNo;

                if($isjob!=''){
                     $appoimnetDate =$this->db->select('jobcardhed.appoimnetDate')->from('tempjobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=tempjobinvoicehed.JobCardNo')->where('JobInvNo', $invNo)->get()->row()->appoimnetDate;

             $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn,jobcardhed.OdoOut,jobcardhed.OdoOutUnit,jobcardhed.OdoInUnit,jobcardhed.NextService')
                ->from('tempjobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=tempjobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','tempjobinvoicehed.JobInvUser=users.id')->where('tempjobinvoicehed.JobInvNo',$invNo)->get()->row();

            $this->data['job_count'] = $this->db->select('count(jobcardhed.JobCardNo)  AS noofjobs')->from('tempjobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=tempjobinvoicehed.JobCardNo','left')->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row();
            $this->data['last_job'] = $this->db->select('max(date(jobcardhed.appoimnetDate))  AS lastjob')->from('jobcardhed')->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row()->lastjob;
                }else{
                     $this->data['invjob']=null;
                      $this->data['job_count'] =0;
                       $this->data['last_job'] ='';
                }
               

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 3)->order_by('UpdateDate','DESC')->get()->result();
             $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 2)->get()->result();
            $result=$this->db->select('tempjobinvoicedtl.*,jobtype.jobtype_name AS SubDescription , jobtypeheader.jobhead_name AS Description')->from('tempjobinvoicedtl')->join('jobtype', 'tempjobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER')->join('jobtypeheader', 'jobtypeheader.jobhead_id = jobtype.jobhead', 'INNER')->where('tempjobinvoicedtl.JobInvNo', $invNo)->order_by('jobtypeheader.jobhead_order', 'ASC')->order_by('jobtype.jobtype_order', 'ASC')->order_by('tempjobinvoicedtl.JobinvoiceTimestamp','ASC')->order_by('tempjobinvoicedtl.EstLineNo', 'ASC')->get();
            $list = array();
            foreach ($result->result() as $row) {
                $list[$row->Description][] = $row;
            }
        
            $this->data['invDtl']=$list;         
            $this->template->admin_render('admin/sales/view-temp-invoice', $this->data);
    }

    public function view_invoice_1($inv=null) {

            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Job Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/sales/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('JobLocation')->from('jobinvoicehed')->where('JobInvNo', $invNo)->get()->row()->JobLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;
            $this->data['inv_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->get()->result();
            $this->data['invHed']=  $this->db->select('JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobVatAmount,JobNbtAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany,JobInvNo,IsCancel,InvoiceType')
                ->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row();
                $cusCode =  $this->db->select('JCustomer')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer;
                $regNo =  $this->db->select('JRegNo')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
                $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make')->join('model','model.model_id=vehicledetail.Model')->where('vehicledetail.RegNo',$regNo)->get()->row();

             $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn,jobcardhed.OdoOut')
                ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();

            $isCard = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->num_rows();
            if($isCard>0){
            $this->data['card_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->row();
        }else{
             $this->data['card_pay'] ='';
        }

        $isCheque = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->num_rows();
            if($isCheque>0){
            $this->data['cheque_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,chequedetails.*,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->join('chequedetails', 'chequedetails.ReferenceNo = jobinvoicepaydtl.JobInvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->row();   
        }else{
            $this->data['cheque_pay'] ='';
        }

            $result=$this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS Description')->from('jobinvoicedtl')->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER')->where('jobinvoicedtl.JobInvNo', $invNo)->order_by('jobinvoicedtl.JobinvoiceTimestamp','ASC')->order_by('jobtype.jobtype_order', 'ASC')->get();
            $list = array();
            foreach ($result->result() as $row) {
                $list[$row->Description][] = $row;
            }
        
            $this->data['invDtl']=$list;         
            $this->template->admin_render('admin/sales/view-invoice_1', $this->data);
    }

    public function print_invoice_pdf($inv=null){

            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Job Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/sales/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('JobLocation')->from('jobinvoicehed')->where('JobInvNo', $invNo)->get()->row()->JobLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $isPay = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobInvNo', $invNo)->where('IsPayment',1)->get()->num_rows();
         
            $this->data['title'] = 'Job Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            if($isPay>0){
                $balance=$this->db->select('JobCreditAmount')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobCreditAmount;
            }else{
                $balance=$this->db->select('JobNetAmount')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JobNetAmount;
            }
            
            $this->data['balance'] = "Rs. ".number_format($balance,2);

            $this->data['inv_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->get()->result();


            $this->data['invHed']=  $this->db->select('JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobVatAmount,JobNbtAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany,JobInvNo,IsCancel,InvoiceType,users.first_name,users.last_name,TempNo,VComName,InvRemark')
                ->from('jobinvoicehed')->join('users','jobinvoicehed.JobInvUser=users.id','left')->join('vehicle_company','jobinvoicehed.JInsCompany=vehicle_company.VComId','left')->where('JobInvNo',$invNo)->get()->row();
                $cusCode =  $this->db->select('JCustomer')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer;
                $regNo =  $this->db->select('JRegNo')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;
                $isJob =$this->db->select('jobcardhed.JobCardNo')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->where('JobInvNo', $invNo)->get()->num_rows();
                //check job card
                if($isJob>0){
                    $appoimnetDate =$this->db->select('jobcardhed.appoimnetDate')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->where('JobInvNo', $invNo)->get()->row()->appoimnetDate;
                    $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn,jobcardhed.OdoOut,jobcardhed.OdoOutUnit,jobcardhed.OdoInUnit,jobcardhed.NextService')
                    ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo','left')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();
                    $this->data['job_count'] = $this->db->select('count(jobcardhed.JobCardNo)  AS noofjobs')->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo','left')->where('jobinvoicehed.JobInvNo', $invNo)->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row();
                     $this->data['last_job'] = $this->db->select('max(date(jobcardhed.appoimnetDate))  AS lastjob')->from('jobcardhed')->where('jobcardhed.JRegNo', $regNo)->where('jobcardhed.JCustomer', $cusCode)->where('jobcardhed.IsCancel', 0)->where('jobcardhed.appoimnetDate<', $appoimnetDate)->get()->row()->lastjob;
                }else{
                    $this->data['invjob']=null;
                    $this->data['job_count'] =null;
                }
                
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
                $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();

             

        $isCard = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->num_rows();
            if($isCard>0){
            $this->data['card_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->where('JobInvNo', $invNo)->where('JobInvPayType','Card')->get()->row();
        }else{
             $this->data['card_pay'] ='';
        }

        $isCheque = $this->db->select('JobInvNo')->from('jobinvoicepaydtl')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->num_rows();
            if($isCheque>0){
            $this->data['cheque_pay'] = $this->db->select('jobinvoicepaydtl.*,customer.CusName,chequedetails.*,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate')->from('jobinvoicepaydtl')->join('customer', 'customer.CusCode = jobinvoicepaydtl.InsCompany')->join('chequedetails', 'chequedetails.ReferenceNo = jobinvoicepaydtl.JobInvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('JobInvNo', $invNo)->where('JobInvPayType','Cheque')->get()->row();   
        }else{
            $this->data['cheque_pay'] ='';
        }

        //invoice cancel
             $this->data['invCancel']=$this->db->select('canceljobinvoice.*,users.first_name,users.last_name')->from('canceljobinvoice')->join('users', 'canceljobinvoice.CancelUser = users.id', 'INNER')->where('canceljobinvoice.JobInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 2)->order_by('UpdateDate','DESC')->get()->result();

            $result=$this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS SubDescription , jobtypeheader.jobhead_name AS Description')->from('jobinvoicedtl')->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER')->join('jobtypeheader', 'jobtypeheader.jobhead_id = jobtype.jobhead', 'INNER')->where('jobinvoicedtl.JobInvNo', $invNo)->order_by('jobtypeheader.jobhead_order', 'ASC')->order_by('jobtype.jobtype_order', 'ASC')->order_by('jobinvoicedtl.JobinvoiceTimestamp','ASC')->order_by('jobinvoicedtl.EstLineNo', 'ASC')->get();

             $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 2)->get()->result();
            $list = array();
            foreach ($result->result() as $row) {
                $list[$row->Description][] = $row;
            }
        
            $this->data['invDtl']=$list;       
            $this->load->helper('file');
            $this->load->helper(array('dompdf'));

            // $this->load->view('admin/sales/sales-invoice-pdf', $this->data);
            $html = $this->load->view('admin/sales/sales-invoice-pdf2', $this->data, true);
            // echo $html;
            pdf_create($html, $invNo, TRUE,'a4');die;
    }

    public function all_sales_invoice() {
            $q = isset($_GET['q'])?$_GET['q']:NULL;
            /* Title Page */
            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'All Sales Invoices';

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/view_job');
            $this->breadcrumbs->unshift(1, 'All Sales Invoices', 'admin/sales/all_sales_order');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->data['q'] = $q;

            $this->template->admin_render('admin/sales/all-sales-invoices', $this->data);
    }

    public function loadallsalesinvoices() {

         $location = $_SESSION['location'];
        $this->datatables->select('salesinvoicehed.*,customer.CusName,customer.MobileNo');
        $this->datatables->from('salesinvoicehed')->join('customer','customer.CusCode=salesinvoicehed.SalesCustomer');

        echo $this->datatables->generate();
        die();
    }

    public function view_sales_invoice($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoice');
            $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_sales_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo', $invNo)->get()->row()->SalesLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['title'] = 'Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            $balance=$this->db->select('SalesCreditAmount')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCreditAmount;
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            

            $this->data['invType']= $this->db->select('SalesInvType')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row();

            $this->data['invHed']= $this->db->select('salesinvoicehed.*,users.first_name,users.last_name,users.last_name ,vehicle_company.VComName')
                ->from('salesinvoicehed')->join('users','salesinvoicehed.SalesInvUser=users.id','left')->join('vehicle_company','vehicle_company.VComId=salesinvoicehed.SalesInsCompany','left')
                ->where('SalesInvNo',$invNo)->get()->row();
            $IsPayment =  $this->db->select('InvNo')->from('invoicesettlementdetails')->where('InvNo',$invNo)->get()->num_rows();
            if($IsPayment>0){
                 $this->data['ispayment']=$IsPayment;
            }else{
                $this->data['ispayment']=0;
            }
            $cusCode =  $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCustomer;
            $regNo =  $this->db->select('SalesVehicle')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesVehicle;
                
            $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('CusCode',$cusCode)->where('vehicledetail.RegNo',$regNo)->get()->row();

            $this->data['invSales']= $this->db->select('salespersons.RepName')
                ->from('salesinvoicedtl')->join('salespersons', 'salesinvoicedtl.SalesPerson = salespersons.RepID', 'left')->where('salesinvoicedtl.SalesInvNo',$invNo)->get()->row();   

             $this->data['invDtl']=$this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')->join('product', 'salesinvoicedtl.SalesProductCode = product.ProductCode', 'INNER')->where('salesinvoicedtl.SalesInvNo', $invNo)->order_by('salesinvoicedtl.SalesInvLineNo','ASC')->get()->result();
             //invoice cancel
             $this->data['invCancel']=$this->db->select('cancelsalesinvoice.*,users.first_name,users.last_name')->from('cancelsalesinvoice')->join('users', 'cancelsalesinvoice.CancelUser = users.id', 'INNER')->where('cancelsalesinvoice.SalesInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 1)->order_by('UpdateDate','DESC')->get()->result();

            $this->data['invDtlArr']=$this->Salesinvoice_model->getSalesInvoiceDtlbyid($invNo);

            //20-01-06
            $this->data['sale']=$this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*')->from('salesinvoicehed')->join('salesinvoicepaydtl','salesinvoicepaydtl.SalesInvNo=salesinvoicehed.SalesInvNo')->where('salesinvoicehed.SalesCustomer',$cusCode)->where('salesinvoicehed.InvIsCancel',0)->get()->result();
            //20-01-06


           // $this->data['invType']= $this->db->select('SalesInvType')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->result();
            
            $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 1)->get()->result();      
            $this->template->admin_render('admin/sales/view-sales-invoice_1', $this->data);

    }


            public function view_sales_invoice_new($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoice');
            $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_sales_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo', $invNo)->get()->row()->SalesLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['title'] = 'Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            $balance=$this->db->select('SalesCreditAmount')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCreditAmount;
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            

            $this->data['invType']= $this->db->select('SalesInvType')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row();

            $this->data['invHed']= $this->db->select('salesinvoicehed.*,users.first_name,users.last_name,users.last_name ,vehicle_company.VComName')
                ->from('salesinvoicehed')->join('users','salesinvoicehed.SalesInvUser=users.id','left')->join('vehicle_company','vehicle_company.VComId=salesinvoicehed.SalesInsCompany','left')
                ->where('SalesInvNo',$invNo)->get()->row();
            $IsPayment =  $this->db->select('InvNo')->from('invoicesettlementdetails')->where('InvNo',$invNo)->get()->num_rows();
            if($IsPayment>0){
                 $this->data['ispayment']=$IsPayment;
            }else{
                $this->data['ispayment']=0;
            }
            $cusCode =  $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCustomer;
            $regNo =  $this->db->select('SalesVehicle')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesVehicle;
                
            $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('CusCode',$cusCode)->where('vehicledetail.RegNo',$regNo)->get()->row();

            $this->data['invSales']= $this->db->select('salespersons.RepName')
                ->from('salesinvoicedtl')->join('salespersons', 'salesinvoicedtl.SalesPerson = salespersons.RepID', 'left')->where('salesinvoicedtl.SalesInvNo',$invNo)->get()->row();   

             $this->data['invDtl']=$this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')->join('product', 'salesinvoicedtl.SalesProductCode = product.ProductCode', 'INNER')->where('salesinvoicedtl.SalesInvNo', $invNo)->order_by('salesinvoicedtl.SalesInvLineNo','ASC')->get()->result();
             //invoice cancel
             $this->data['invCancel']=$this->db->select('cancelsalesinvoice.*,users.first_name,users.last_name')->from('cancelsalesinvoice')->join('users', 'cancelsalesinvoice.CancelUser = users.id', 'INNER')->where('cancelsalesinvoice.SalesInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 1)->order_by('UpdateDate','DESC')->get()->result();

            $this->data['invDtlArr']=$this->Salesinvoice_model->getSalesInvoiceDtlbyid($invNo);

           // $this->data['invType']= $this->db->select('SalesInvType')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->result();
            
            $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 1)->get()->result();      
            $this->template->admin_render('admin/sales/view-sales-invoice_1', $this->data);
        
    }




            public function view_sales_invoice_1($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoice');
            $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_sales_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo', $invNo)->get()->row()->SalesLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['title'] = 'Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            $balance=$this->db->select('SalesCreditAmount')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCreditAmount;
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            

            $this->data['invHed']= $this->db->select('salesinvoicehed.*,users.first_name,users.last_name,users.last_name ,vehicle_company.VComName')
                ->from('salesinvoicehed')->join('users','salesinvoicehed.SalesInvUser=users.id','left')->join('vehicle_company','vehicle_company.VComId=salesinvoicehed.SalesInsCompany','left')
                ->where('SalesInvNo',$invNo)->get()->row();

            $cusCode =  $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCustomer;
            $regNo =  $this->db->select('SalesVehicle')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesVehicle;
                
            $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('CusCode',$cusCode)->where('vehicledetail.RegNo',$regNo)->get()->row();

            $this->data['invSales']= $this->db->select('salespersons.RepName')
                ->from('salesinvoicedtl')->join('salespersons', 'salesinvoicedtl.SalesPerson = salespersons.RepID', 'left')->where('salesinvoicedtl.SalesInvNo',$invNo)->get()->row();   

             $this->data['invDtl']=$this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')->join('product', 'salesinvoicedtl.SalesProductCode = product.ProductCode', 'INNER')->where('salesinvoicedtl.SalesInvNo', $invNo)->order_by('salesinvoicedtl.SalesInvLineNo','ASC')->get()->result();
             //invoice cancel
             $this->data['invCancel']=$this->db->select('cancelsalesinvoice.*,users.first_name,users.last_name')->from('cancelsalesinvoice')->join('users', 'cancelsalesinvoice.CancelUser = users.id', 'INNER')->where('cancelsalesinvoice.SalesInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 1)->order_by('UpdateDate','DESC')->get()->result();

             $this->data['invDtlArr']=$this->Salesinvoice_model->getSalesInvoiceDtlbyid($invNo);
              $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 1)->get()->result(); 
                   
            $this->template->admin_render('admin/sales/view-sales-invoice_1', $this->data);
    }

    public function email_invoice($inv=null){
        $inv=base64_decode($inv);
        $this->load->helper('file');
        $this->load->library('email');

        $this->email->from('noreply@nsoft.lk', 'Nsoft Notification');
        $this->email->to('esanka@nsoft.lk');
        // $this->email->cc('info@nsoft.lk');
        $this->email->bcc('esankas@gmail.com');

        $this->email->subject('Daily Cash Balance - ');
        // $this->email->message($html);
        $this->email->message('Hi '.$inv.' Here is the info you requested.');
       
        $res = $this->email->send();
        return $res;
        die;
    }

    public function email_sales_invoice_pdf($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoice');
            $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_sales_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo', $invNo)->get()->row()->SalesLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;
            
             $this->data['title'] = 'Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            $balance=$this->db->select('SalesCreditAmount')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCreditAmount;
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            
            

            $this->data['invHed']= $this->db->select('salesinvoicehed.*,users.first_name')
                ->from('salesinvoicehed')->join('users','salesinvoicehed.SalesInvUser=users.id','left')
                ->where('SalesInvNo',$invNo)->get()->row();

            $cusCode =  $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCustomer;
                
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->where('customer.CusCode',$cusCode)->get()->row();

            $this->data['invSales']= $this->db->select('salespersons.RepName')
                ->from('salesinvoicedtl')->join('salespersons', 'salesinvoicedtl.SalesPerson = salespersons.RepID', 'INNER')->where('salesinvoicedtl.SalesInvNo',$invNo)->get()->row();   

             $this->data['invDtl']=$this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')->join('product', 'salesinvoicedtl.SalesProductCode = product.ProductCode', 'INNER')->where('salesinvoicedtl.SalesInvNo', $invNo)->order_by('salesinvoicedtl.SalesInvLineNo','ASC')->get()->result();

             $this->data['invDtlArr']=$this->Salesinvoice_model->getSalesInvoiceDtlbyid($invNo);
                   
            // $this->template->admin_render('admin/sales/view-sales-invoice', $this->data);
            $this->load->helper('file');
            $this->load->helper(array('dompdf'));

            // $this->load->view('admin/sales/view-sales-invoice-pdf', $this->data);
            $html = $this->load->view('admin/sales/view-sales-invoice-pdf', $this->data, true);
            // echo $html;
            $this->load->library('email');

            $this->email->from('noreply@nsoft.lk', 'Nsoft Notification');
            $this->email->to('info@nsoft.lk');
            // $this->email->cc('info@nsoft.lk');
            $this->email->bcc('esankas@gmail.com');

            $this->email->subject('Daily Cash Balance - ');
            // $this->email->message($html);
            $this->email->message('Hi '.$inv.' Here is the info you requested.');
            $bf = pdf_create($html, 'filename', TRUE,'A4');
            $this->email->attach($bf, 'attachment', 'report.pdf', 'application/pdf');
            $res = $this->email->send();
            return $res;
    }

    public function view_sales_invoice_pdf($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoice');
            $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_sales_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo', $invNo)->get()->row()->SalesLocation;
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['title'] = 'Invoice';
            $this->data['titleno'] = $invNo;
            $this->data['balancetxt'] = 'TOTAL PAYABLE';
            $balance=$this->db->select('SalesCreditAmount')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCreditAmount;
            $this->data['balance'] = "Rs. ".number_format($balance,2);
            

            $this->data['invHed']= $this->db->select('salesinvoicehed.*,users.first_name,users.last_name,users.last_name ,vehicle_company.VComName')
                ->from('salesinvoicehed')->join('users','salesinvoicehed.SalesInvUser=users.id','left')->join('vehicle_company','vehicle_company.VComId=salesinvoicehed.SalesInsCompany','left')
                ->where('SalesInvNo',$invNo)->get()->row();
            $IsPayment =  $this->db->select('InvNo')->from('invoicesettlementdetails')->where('InvNo',$invNo)->get()->num_rows();
            if($IsPayment>0){
                 $this->data['ispayment']=$IsPayment;
            }else{
                $this->data['ispayment']=0;
            }
            $cusCode =  $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesCustomer;
            $regNo =  $this->db->select('SalesVehicle')->from('salesinvoicehed')->where('SalesInvNo',$invNo)->get()->row()->SalesVehicle;
                
            $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
            $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('CusCode',$cusCode)->where('vehicledetail.RegNo',$regNo)->get()->row();

            $this->data['invSales']= $this->db->select('salespersons.RepName')
                ->from('salesinvoicedtl')->join('salespersons', 'salesinvoicedtl.SalesPerson = salespersons.RepID', 'left')->where('salesinvoicedtl.SalesInvNo',$invNo)->get()->row();   

             $this->data['invDtl']=$this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')->join('product', 'salesinvoicedtl.SalesProductCode = product.ProductCode', 'INNER')->where('salesinvoicedtl.SalesInvNo', $invNo)->order_by('salesinvoicedtl.SalesInvLineNo','ASC')->get()->result();
             //invoice cancel
             $this->data['invCancel']=$this->db->select('cancelsalesinvoice.*,users.first_name,users.last_name')->from('cancelsalesinvoice')->join('users', 'cancelsalesinvoice.CancelUser = users.id', 'INNER')->where('cancelsalesinvoice.SalesInvoiceNo', $invNo)->order_by('CancelDate','DESC')->get()->row();

             //invoice updates
             $this->data['invUpdate']=$this->db->select('editinvoices.*,users.first_name,users.last_name')->from('editinvoices')->join('users', 'editinvoices.UpdateUser = users.id', 'INNER')->where('editinvoices.InvoiceNo', $invNo)->where('editinvoices.EditType', 1)->order_by('UpdateDate','DESC')->get()->result();

             $this->data['invDtlArr']=$this->Salesinvoice_model->getSalesInvoiceDtlbyid($invNo);
              $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 1)->get()->result();  
                   
            // $this->template->admin_render('admin/sales/view-sales-invoice', $this->data);
            $this->load->helper('file');
            $this->load->helper(array('dompdf'));

            // $this->load->view('admin/sales/view-sales-invoice-pdf', $this->data);
            $html = $this->load->view('admin/sales/view-sales-invoice-pdf2', $this->data, true);
            // echo $html;
            pdf_create($html, 'filename', TRUE,'A4');die;
    }


    public function job_invoice() {
        
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $sup = isset($_GET['sup'])?$_GET['sup']:0;

        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Job Invoice');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job', 'admin/sales/job_invoice');
            $this->breadcrumbs->unshift(1, 'Job Invoice', 'admin/sales/job_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $this->load->model('admin/Salesinvoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

            $this->data['worktype'] = $this->db->select()->from('jobtype')->get()->result();
            $this->data['jobdesc'] = $this->db->select()->from('jobdescription')->get()->result();
            $this->data['jobtype'] = $this->db->select()->from('estimate_jobtype')->get()->result();
            $this->data['estimate_type'] = $this->db->select()->from('estimate_type')->get()->result();
            $this->data['insCompany'] = $this->db->select()->from('insu_company')->get()->result();
            $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();

            $this->data['Odoout'] = $this->Salesinvoice_model->selectOdoout($id);

            // $this->db->insert('insu_company', array('InsuranceName' => 'Union Insurance', ));
            if($type=='inv'){
                $this->data['JobInvoiceNo'] = base64_decode($id);
            }elseif($type=='job'){
                $this->data['JobNo'] = base64_decode($id);
            }elseif($type=='est'){
                $this->data['EstimateNo'] = base64_decode($id);
            }elseif($type=='tempinv'){
                $this->data['TempNo'] = base64_decode($id);
            }
                $this->data['supNo'] = $sup;

            /* Load Template */
            $this->template->admin_render('admin/sales/job-invoice', $this->data);
        }
    }

    public function loadjob($jobid = NULL) {
        if(isset($jobid)){
            $result = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobid)->get()->row();
            echo json_encode($result);
        }
        die;
    }

    public function loadjobonload($jobid = NULL) {
        if(isset($jobid)){
            $jobid = base64_decode($jobid);
            $result = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobid)->get()->row();
            echo json_encode($result);
        }
        die;
    }

    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= 0;$supCode= '';
         $this->load->model('admin/Grn_model');
        echo $this->Grn_model->loadproductjson($query,$sup,$supCode);
        die;
    }

    public function loadjobjson() {
        $query = $_GET['q'];
        $q = $this->db->select('JobCardNo AS id,JobCardNo AS text')->from('jobcardHed')->like('JobCardNo', $query)->get()->result();
        echo json_encode($q);die;
    }

    public function loadinvoicejson() {
        $query = $_GET['q'];
        $q = $this->db->select('JobInvNo AS id,JobInvNo AS text')->from('jobinvoicehed')->like('JobInvNo',$query)->where('IsPayment',0)->where('IsCancel',0)->where('IsCompelte',0)->get()->result();
        echo json_encode($q);die;
    }

    public function loadinvoicejsonbyjob() {
        $query = $_GET['q'];
        $jobNo = $_GET['jobNo'];
        if($jobNo!=''){
            $q = $this->db->select('JobInvNo AS id,JobInvNo AS text')->from('jobinvoicehed')->like('JobInvNo',$query)->where('IsPayment',0)->where('JobCardNo',$jobNo)->where('IsCancel',0)->where('IsCompelte',0)->get()->result();
        }else{
            $q = $this->db->select('JobInvNo AS id,JobInvNo AS text')->from('jobinvoicehed')->like('JobInvNo',$query)->where('IsPayment',0)->where('IsCancel',0)->where('IsCompelte',0)->get()->result();
        }
        echo json_encode($q);die;
    }

    public function loadtempinvoicejson() {
        $query = $_GET['q'];
        $jobNo = $_GET['jobNo'];
        if($jobNo!=''){
            $q = $this->db->select('JobInvNo AS id,JobInvNo AS text')->from('tempjobinvoicehed')->like('JobInvNo',$query)->where('IsPayment',0)->where('JobCardNo',$jobNo)->where('IsCancel',0)->where('IsCompelte',0)->where('IsInvoice',0)->get()->result();
        }else{
            $q = $this->db->select('JobInvNo AS id,JobInvNo AS text')->from('tempjobinvoicehed')->like('JobInvNo',$query)->where('IsPayment',0)->where('IsCancel',0)->where('IsCompelte',0)->where('IsInvoice',0)->get()->result();
        }
        echo json_encode($q);die;
    }

    public function loadinvoicedetail($invid = NULL) {
        if(isset($invid)):
            $data = $this->db->select('JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany,JobNbtAmount,JobVatAmount')
                ->from('jobinvoicehed')->where('JobInvNo',$invid)->get()->row();
            $detail = $this->db->select('JobType AS jobtype,JobDescription AS description,JobQty AS qty,JobPrice AS price,JobTotalAmount AS total,JobDiscount AS discountval, JobNetAmount AS netamount,JobDiscountType AS discountmethod,JobinvoiceTimestamp AS timestamp, JobCode AS jobCode')
                ->from('jobinvoicedtl')->where('JobInvNo',$invid)->get()->result();

                $cus = $this->db->select('customer.payMethod,customer.CusType,customer.CusCompany')
                ->from('jobinvoicehed')->join('customer','customer.CusCode=jobinvoicehed.JCustomer')->where('jobinvoicehed.JobInvNo',$invid)->get()->row();


                  $advance = $this->db->select('jobcardhed.Advance')
                ->from('jobinvoicehed')->join('customer','customer.CusCode=jobinvoicehed.JCustomer')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->where('jobinvoicehed.JobInvNo',$invid)->get()->row();

            $data->date = date("Y-m-d", strtotime($data->date));
            $data->detail = $detail;
            $data->cus = $cus;
            $data->advance=$advance;
            echo json_encode($data);
        endif;
        die;
    }

    public function loadinvoicedetail2($invid = NULL) {
        if(isset($invid)):
            $invid = base64_decode($invid);
            $data = $this->db->select('JobInvNo, JobCardNo AS jobcardNo,JCustomer AS customerCode,JRegNo AS regNo,JobInvoiceDate AS date,JobAdvance,JobTotalDiscount,JobNetAmount,JobTotalAmount,EstType,JJobType,IsPayment,JobEstimateNo,JobSupplimentry,JInsCompany')
                ->from('jobinvoicehed')->where('JobInvNo',$invid)->get()->row();
            $detail = $this->db->select('JobType AS jobtype,JobDescription AS description,JobQty AS qty,JobPrice AS price,JobTotalAmount AS total,JobDiscount AS discountval, JobNetAmount AS netamount,JobDiscountType AS discountmethod,JobinvoiceTimestamp AS timestamp,JobCode AS jobCode')
                ->from('jobinvoicedtl')->where('JobInvNo',$invid)->get()->result();
            $data->date = date("Y-m-d", strtotime($data->date));
            $data->detail = $detail;
            echo json_encode($data);
        endif;
        die;
    }

    public function getInvoiceDataByInvoiceNo(){
        $invoiceNo = $_POST['invoiceNo'];

        if($invoiceNo!='' && isset($invoiceNo)){
            $cusCode = $this->db->select('JCustomer')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JCustomer;
            $regNo =$this->db->select('JRegNo')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JRegNo;
            $isInvoice = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->num_rows();
            if($isInvoice>0){
                $jobNo =$this->db->select('JobCardNo')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JobCardNo;
                $arr['inv_hed'] = $this->db->select()->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row();
                $arr['inv_dtl'] = $this->db->select('jobinvoicedtl.*,jobtype.jobtype_name')->from('jobinvoicedtl')->join('jobtype', 'jobtype.jobtype_id = jobinvoicedtl.JobType')->where('jobinvoicedtl.JobInvNo', $invoiceNo)->order_by('jobinvoicedtlid')->get()->result();
                $arr['job_inv'] = $this->Job_model->getInvoiceDtlbyid($invoiceNo);
            }else{
                $arr['inv_dtl'] =null;
                $arr['inv_hed']=null;
                $arr['job_inv'] =null;
            }
            
            $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
            $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
            if($jobNo!=''){
                $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
            }else{
                $arr['job_data'] =null;
                $arr['job_desc'] =null;
            }
        }
        echo json_encode($arr);
        die;
    }

    public function getInvoiceDataByJobNo(){
        $jobNo = $_POST['jobNo'];

        if($jobNo!='' && isset($jobNo)){
            $cusCode = $this->db->select('JCustomer')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JCustomer;
        $regNo =$this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JRegNo;
            $isInvoice = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobCardNo', $jobNo)->get()->num_rows();
            if($isInvoice>0){
                $invNo =$this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobCardNo', $jobNo)->get()->row()->JobInvNo;
                $arr['inv_hed'] = $this->db->select()->from('jobinvoicehed')->where('JobInvNo', $invNo)->get()->row();
                $arr['inv_dtl'] = $this->db->select('jobinvoicedtl.*,jobtype.jobtype_name')->from('jobinvoicedtl')->join('jobtype', 'jobtype.jobtype_id = jobinvoicedtl.JobType')->where('jobinvoicedtl.JobInvNo', $invNo)->order_by('jobinvoicedtlid')->get()->result();
                $arr['job_inv'] = $this->Job_model->getInvoiceDtlbyid($invNo);
            }else{
                $arr['inv_dtl'] =null;
                $arr['inv_hed']=null;
                $arr['job_inv'] =null;
            }
            
            $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
            $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
            if($jobNo!=''){
                $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
            }else{
                $arr['job_data'] =null;
                $arr['job_desc'] =null;
            }
        }
        echo json_encode($arr);
        die;
    }

    public function getTempInvoiceDataByInvoiceNo(){
        $invoiceNo = $_POST['invoiceNo'];
$arr[] =null;
        if($invoiceNo!='' && isset($invoiceNo)){
            $cusCode = $this->db->select('JCustomer')->from('tempjobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JCustomer;
            $regNo =$this->db->select('JRegNo')->from('tempjobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JRegNo;
            $isInvoice = $this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->num_rows();
            if($isInvoice>0){
                $jobNo =$this->db->select('JobCardNo')->from('tempjobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JobCardNo;
                $arr['inv_hed'] = $this->db->select()->from('tempjobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row();
                $arr['inv_dtl'] = $this->db->select('tempjobinvoicedtl.*,jobtype.jobtype_name')->from('tempjobinvoicedtl')->join('jobtype', 'jobtype.jobtype_id = tempjobinvoicedtl.JobType')->where('tempjobinvoicedtl.JobInvNo', $invoiceNo)->order_by('jobinvoicedtlid')->get()->result();
                $arr['job_inv'] = $this->Job_model->getInvoiceDtlbyid($invoiceNo);
            }else{
                $arr['inv_dtl'] =null;
                $arr['inv_hed']=null;
                $arr['job_inv'] =null;
            }
            
            $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
            $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
            if($jobNo!=''){
                $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
            }else{
                $arr['job_data'] =null;
                $arr['job_desc'] =null;
            }
        }
        echo json_encode($arr);
        die;
    }

    public function getTempInvoiceDataByJobNo(){
        $jobNo = $_POST['jobNo'];

        if($jobNo!='' && isset($jobNo)){
            $cusCode = $this->db->select('JCustomer')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JCustomer;
        $regNo =$this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JRegNo;
            $isInvoice = $this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobCardNo', $jobNo)->get()->num_rows();
            if($isInvoice>0){
                $invNo =$this->db->select('JobInvNo')->from('tempjobinvoicehed')->where('JobCardNo', $jobNo)->get()->row()->JobInvNo;
                $arr['inv_hed'] = $this->db->select()->from('tempjobinvoicehed')->where('JobInvNo', $invNo)->get()->row();
                $arr['inv_dtl'] = $this->db->select('tempjobinvoicedtl.*,jobtype.jobtype_name')->from('tempjobinvoicedtl')->join('jobtype', 'jobtype.jobtype_id = tempjobinvoicedtl.JobType')->where('tempjobinvoicedtl.JobInvNo', $invNo)->order_by('jobinvoicedtlid')->get()->result();
                $arr['job_inv'] = $this->Job_model->getInvoiceDtlbyid($invNo);
            }else{
                $arr['inv_dtl'] =null;
                $arr['inv_hed']=null;
                $arr['job_inv'] =null;
            }
            
            $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
            $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
            if($jobNo!=''){
                $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
            }else{
                $arr['job_data'] =null;
                $arr['job_desc'] =null;
            }
        }
        echo json_encode($arr);
        die;
    }

    public function loaddescription() {
        $jobdes = $_GET['q'];
        $jtype = $_GET['jtype'];
        if($jtype == 2) {
            $q = $this->db->select('product.ProductCode AS id ,product.Prd_Description AS text,productprice.ProductPrice AS price,productcondition.IsTax,productcondition.IsNbt,productcondition.NbtRatio')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->join('productcondition', 'productcondition.ProductCode = product.ProductCode', 'INNER')
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $jobdes ,'left')
                    ->limit(50)->get()->result();
            echo json_encode($q);die;
        } else {
             if(isset($jtype) && $jtype != '') {
            $q = $this->db->select('JobDescNo AS id, JobDescription AS text, JobCost AS price,isVat As IsTax,isNbt As IsNbt, nbtRatio As NbtRatio')
                ->from('inv_jobdescription')
                ->like('JobDescription' , $jobdes)
                ->where('jobtype', $jtype )
                ->get()->result();
            echo json_encode($q);die;
        }
       }
        die;
    }

    public function loadestimate() {
        $estimateno = $_GET['q'];
        $q = $this->db->select('EstimateNo AS id, EstimateNo AS text')->from('estimatehed')->like('EstimateNo',$estimateno)->get()->result();
        echo json_encode($q);
        die;
    }

    public function loadestimatedetail() {
        $estimate = $_GET['estno'];
        $suppliment = $_GET['supplimentNo'];
        if(isset($estimate)) {
            $data = $this->db->select()->from('estimatehed')->where('EstimateNo',$estimate)->where('Supplimentry',$suppliment)->get()->row();
            $detail = $this->db->select('EstJobType AS jobtype,EstJobId as jobCode,EstJobDescription AS description,EstQty AS qty,EstPrice AS price,EstTotalAmount AS total,EstDiscount AS discountval, EstNetAmount AS netamount,EstDiscountType AS discountmethod,EstinvoiceTimestamp AS timestamp')
                    ->from('estimatedtl')->where('EstimateNo',$estimate)->where('SupplimentryNo',$suppliment)->get()->result();
            $data->EstDate = date("Y-m-d", strtotime($data->EstDate));
            $data->detail = $detail;
            echo json_encode($data);
        }
        die;
    }

    public function loadestimatedetail2() {
        $estimate = base64_decode($_GET['estno']);
        $suppliment = $_GET['suppno'];
        if(isset($estimate)) {
            $data = $this->db->select()->from('estimatehed')->where('EstimateNo',$estimate)->where('Supplimentry',$suppliment)->get()->row();
            $detail = $this->db->select('EstJobType AS jobtype,EstJobId as jobCode,EstJobDescription AS description,EstQty AS qty,EstPrice AS price,EstTotalAmount AS total,EstDiscount AS discountval, EstNetAmount AS netamount,EstDiscountType AS discountmethod,EstinvoiceTimestamp AS timestamp')
                    ->from('estimatedtl')->where('EstimateNo',$estimate)->where('SupplimentryNo',$suppliment)->get()->result();
            $data->EstDate = date("Y-m-d", strtotime($data->EstDate));
            $data->detail = $detail;
            echo json_encode($data);
        }
        die;
    }

    public function loadsupplimentno() {
        $estimate = $_GET['estimate'];
        if(isset($estimate)) {
            $result = $this->db->select('Supplimentry AS id, Supplimentry AS text')->from('estimatehed')->where('EstimateNo',$estimate)->get()->result();
            echo json_encode($result);
        }
        die;
    }

    public function getInvoiceDataById(){
        $invNo = $_POST['invNo'];
        $cusCode = $this->db->select('JCustomer')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer; 
        $regNo =$this->db->select('JRegNo')->from('jobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;    
        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
        
        $arr['inv_hed'] = $this->db->select()->from('jobinvoicehed')->where('JobInvNo', $invNo)->get()->row();
        $arr['inv_dtl'] = $this->Job_model->getInvoiceDtlbyid($invNo);
        $arr['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn')
                ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();  
        echo json_encode($arr);
        die;
    }

     public function getTempInvoiceDataById(){
        $invNo = $_POST['invNo'];
        $cusCode = $this->db->select('JCustomer')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JCustomer; 
        $regNo =$this->db->select('JRegNo')->from('tempjobinvoicehed')->where('JobInvNo',$invNo)->get()->row()->JRegNo;    
        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
        
        $arr['inv_hed'] = $this->db->select()->from('tempjobinvoicehed')->where('JobInvNo', $invNo)->get()->row();
        $arr['inv_dtl'] = $this->Job_model->getTempInvoiceDtlbyid($invNo);
        $arr['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn')
                ->from('tempjobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=tempjobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','tempjobinvoicehed.JobInvUser=users.id')->where('tempjobinvoicehed.JobInvNo',$invNo)->get()->row();  
        echo json_encode($arr);
        die;
    }

    public function saveTempInvoices() {
        // print_r($_POST);die;
        $totalCost=0;
        $location=$_SESSION['location'];
        $action = $_POST['action'];
        $data['JCompanyCode'] = '';
        if($_POST['sup_no']=='' || $_POST['sup_no']==0){$supplimentNo=0;}else{$supplimentNo=$_POST['sup_no'];}
        $data['JCustomer'] = $_POST['cusCode'];
        $data['JRegNo'] = $_POST['regNo'];
        $data['EstType'] = isset($_POST['estimate_type']) ? $_POST['estimate_type'] : 0;
        $data['JInsCompany'] = isset($_POST['insCompany']) ? $_POST['insCompany'] : 0;
        $data['JobEstimateNo'] = $_POST['estimateNo'];
        $data['JobSupplimentry'] = $supplimentNo;
        $data['JobCardNo'] = $_POST['jobNo'];
        $data['JobInvoiceDate'] = $_POST['date'];
        $data['JobLocation'] = $location;
        $data['JobTotalAmount'] = $_POST['estimateAmount'];
        $data['JJobType'] = isset($_POST['job_type']) ? $_POST['job_type'] : 0;
        $data['IsPayment'] = 0;
        $data['IsCompelte'] = 0;
        $data['IsCancel'] = 0;
        $data['IsEdit'] = 0;
        $data['InvRemark'] =$_POST['remark'];
        $data['JobTotalDiscount'] =$_POST['total_discount'];
        $data['JobNetAmount'] =$_POST['totalNet'];
        $data['JobVatAmount'] =$_POST['totalVat'];
        $data['JobNbtAmount'] =$_POST['totalNbt'];
        $data['JobIsVatTotal'] =$_POST['isTotalVat'];
        $data['JobIsNbtTotal'] =$_POST['isTotalNbt'];
        $data['JobNbtRatioTotal']=$_POST['nbtRatioRate'];
        $data['JobInvUser']=$_SESSION['user_id'];
        $data['InvoiceType']=$_POST['InvoiceType'];
        $data['mileageout'] = $_POST['mileageout'];
        $data['mileageoutUnit'] = $_POST['mileageoutUnit'];


            //////////////////////////////////////////////
            $data1['OdoOut']=$_POST['mileageout'];
            $data1['OdoOutUnit']=$_POST['mileageoutUnit'];
             //////////////////////////////////////////////
        $net_priceArr = json_decode($_POST['net_price']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['sell_price']);
        $is_insArr = json_decode($_POST['is_ins']);
        $insuranceArr = json_decode($_POST['insurance']);
        $descArr = json_decode($_POST['desc']);
        $job_idArr = json_decode($_POST['job_id']);
        $job_orderArr = json_decode($_POST['job_order']);
        $work_idArr = json_decode($_POST['work_id']);
        $timestampArr = json_decode($_POST['timestamp']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $totalPriceArr = json_decode($_POST['totalPrice']);
        $proDiscountArr = json_decode($_POST['proDiscount']);
        $disPrecentArr = json_decode($_POST['disPercent']);
        $discountTypeArr = json_decode($_POST['discountType']);
        $estPriceArr = json_decode($_POST['estPrice']);
        $costPriceArr = json_decode($_POST['costPrice']);
        $estLineNoArr = json_decode($_POST['estLineNo']);

        $EstJobType=0;
        if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){
            $EstJobType = $this->db->select('EstJobType')->from('estimatehed')->where('EstCustomer', $_POST['cusCode'])->where('EstRegNo', $_POST['regNo'])->where('EstimateNo', $_POST['estimateNo'])->get()->row()->EstJobType;
        }

        if($action==1){
            if($EstJobType!=''){
                //Insurance
                $data['JobInvNo'] = $this->Job_model->get_max_code('TempJobInvoice'.$location);
            }else{
                //genaral
                 $data['JobInvNo'] = $this->Job_model->get_max_code('TempJobInvoice'.$location);
            }
            // if($supplimentNo==0 || $supplimentNo==''){
                // $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice');
            // }else{
            //     $data['JobInvNo'] = $_POST['invoiceNo'];
            //     $data['IsEdit'] = 1;
            // }
            $this->db->trans_start();
            $this->db->insert('tempjobinvoicehed',$data);
            $estTimestmp = '';
            for ($i = 0; $i < count($work_idArr); $i++) {
                $totalCost+=($qtyArr[$i]*$costPriceArr[$i]);
                 
                if($timestampArr[$i]!=''){
                    $estTimestmp = $timestampArr[$i];
                }else{
                    $estTimestmp = date("Y-m-d H:i:s");
                }
                
                 $jobDtl = array(
                    'JobInvNo' => $data['JobInvNo'],
                    'JobCardNo' => $data['JobCardNo'],
                    'JobOrder' => $job_orderArr[$i],
                    'JobType' => $job_idArr[$i],
                    'JobCode' => $work_idArr[$i],
                    'EstLineNo'=> $estLineNoArr[$i],
                    'JobLocation'=> $location,
                    'JobDescription' => $descArr[$i],
                    'JobQty' => $qtyArr[$i],
                    'JobPrice' => $sell_priceArr[$i],
                    'JobCost' => $costPriceArr[$i],
                    'JobIsVat' => $isVatArr[$i],
                    'JobIsNbt' => $isNbtArr[$i],
                    'JobNbtRatio' => $nbtRatioArr[$i],
                    'JobVatAmount' => $proVatArr[$i],
                    'JobNbtAmount' => $proNbtArr[$i],
                    'JobTotalAmount' => $totalPriceArr[$i],
                    'JobTotalAmount' => $totalPriceArr[$i],
                    'JobTotalAmount' => $totalPriceArr[$i],
                    'JobDiscount' => $proDiscountArr[$i],
                    'JobDisValue' => $proDiscountArr[$i],
                    'JobDisPercentage' =>$disPrecentArr[$i],
                    'JobDiscountType' => $discountTypeArr[$i],
                    'JobNetAmount' => $net_priceArr[$i],
                    'JobinvoiceTimestamp' => $estTimestmp
                    );
                 $this->db->insert('tempjobinvoicedtl',$jobDtl);
            }

            //odoout update
            $this->db->update('jobcardhed',$data1,array('JobCardNo' => $data['JobCardNo']));

            $this->Job_model->bincard($data['JobInvNo'],3,'Created');//update bincard
            $this->Job_model->update_max_code('TempJobInvoice'.$location);
            $this->db->trans_complete();
            $res2= $this->db->trans_status();

    }elseif ($action==2) {
        // update goes here
        $data['JobInvNo'] = $_POST['invoiceNo'];
        $this->db->trans_start();
            $this->db->update('tempjobinvoicehed',$data,array('JobInvNo' => $data['JobInvNo']));
            $estTimestmp = '';
            $estLineNo =0;
            $this->db->delete('tempjobinvoicedtl',array('JobInvNo' => $data['JobInvNo']));
            for ($i = 0; $i < count($work_idArr); $i++) {
                $totalCost+=($qtyArr[$i]*$costPriceArr[$i]);

                if($timestampArr[$i]!=''){
                    $estTimestmp = $timestampArr[$i];
                }else{
                    $estTimestmp = date("Y-m-d H:i:s");
                }

                if($estLineNoArr[$i]!='0'){
                    $estLineNo=$estLineNoArr[$i];
                }else{
                    $estLineNo=$this->db->select('MAX(EstLineNo) AS EstLineNo')->from('tempjobinvoicedtl')->where('JobInvNo',$data['JobInvNo'])->get()->row()->EstLineNo;
                    $estLineNo++;
                }
                 $jobDtl = array(
                    'JobInvNo' => $data['JobInvNo'],
                    'JobCardNo' => $data['JobCardNo'],
                    'JobOrder' => $job_orderArr[$i],
                    'JobType' => $job_idArr[$i],
                    'JobCode' => $work_idArr[$i],
                    'EstLineNo'=> $estLineNo,
                    'JobLocation'=> $location,
                    'JobDescription' => $descArr[$i],
                    'JobQty' => $qtyArr[$i],
                    'JobPrice' => $sell_priceArr[$i],
                    'JobCost' => $costPriceArr[$i],
                    'JobQty' => $qtyArr[$i],
                    'JobIsVat' => $isVatArr[$i],
                    'JobIsNbt' => $isNbtArr[$i],
                    'JobNbtRatio' => $nbtRatioArr[$i],
                    'JobVatAmount' => $proVatArr[$i],
                    'JobNbtAmount' => $proNbtArr[$i],
                    'JobTotalAmount' => $totalPriceArr[$i],
                    'JobDiscount' => $proDiscountArr[$i],
                    'JobDisValue' => $proDiscountArr[$i],
                    'JobDisPercentage' =>$disPrecentArr[$i],
                    'JobDiscountType' => $discountTypeArr[$i],
                    'JobNetAmount' => $net_priceArr[$i],
                    'JobinvoiceTimestamp' => $estTimestmp
                    );
                 $this->db->insert('tempjobinvoicedtl',$jobDtl);
            }
            $this->db->update('jobcardhed',$data1,array('JobCardNo' => $data['JobCardNo']));
            $this->Job_model->bincard($data['JobInvNo'],3,'Updated');//update bincard
            $this->db->trans_complete();
            $res2= $this->db->trans_status();
    }

        $return = array('JobInvNo' => $data['JobInvNo'],'SupplimentryNo'=>$supplimentNo);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

   //estimate types
    public function saveInvoices() {
        // print_r($_POST);die;
        $totalCost = 0;
        $partInvType = $_POST['partInvType'];
        $action = $_POST['action'];
        $partData['InvNo']='';

        if($partInvType==1){
            $location=$_SESSION['location'];
            $action = $_POST['action'];
            $data['JCompanyCode'] = '';
            if($_POST['sup_no']=='' || $_POST['sup_no']==0){$supplimentNo=0;}else{$supplimentNo=$_POST['sup_no'];}
            $data['JCustomer'] = $_POST['cusCode'];
            $data['JRegNo'] = $_POST['regNo'];
            $data['EstType'] = isset($_POST['estimate_type']) ? $_POST['estimate_type'] : 0;
            $data['JInsCompany'] = isset($_POST['insCompany']) ? $_POST['insCompany'] : 0;
            $data['JobEstimateNo'] = $_POST['estimateNo'];
            $data['JobSupplimentry'] = $supplimentNo;
            $data['JobCardNo'] = $_POST['jobNo'];
            if( $action==1){
                $data['JobInvoiceDate'] = $_POST['date'];
            }
            
            // $data['JobInvoiceDate'] = $_POST['date'];
            $data['JobLocation'] = $location;
            $data['JobTotalAmount'] = $_POST['estimateAmount'];
            $data['JJobType'] = isset($_POST['job_type']) ? $_POST['job_type'] : 0;
            $data['IsPayment'] = 0;
            $data['IsCompelte'] = 0;
            $data['IsCancel'] = 0;
            $data['IsEdit'] = 0;
            $data['InvRemark'] =$_POST['remark'];
            $data['JobTotalDiscount'] =$_POST['total_discount'];
            $data['JobNetAmount'] =$_POST['totalNet'];
            $data['JobVatAmount'] =$_POST['totalVat'];
            $data['JobNbtAmount'] =$_POST['totalNbt'];
            $data['JobIsVatTotal'] =$_POST['isTotalVat'];
            $data['JobIsNbtTotal'] =$_POST['isTotalNbt'];
            $data['JobNbtRatioTotal']=$_POST['nbtRatioRate'];
            $data['JobInvUser']=$_SESSION['user_id'];
            $data['InvoiceType']=$_POST['InvoiceType'];
            $data['TempNo']=$_POST['tempInvoiceNo'];
            $data['PartInvType']=$partInvType;
            $data['mileageout']=$_POST['mileageout'];
            $data['mileageoutUnit']=$_POST['mileageoutUnit'];


            //////////////////////////////////////////////
            $data1['OdoOut']=$_POST['mileageout'];
            $data1['OdoOutUnit']=$_POST['mileageoutUnit'];
             //////////////////////////////////////////////

            $tempInvoiceNo = $_POST['tempInvoiceNo'];

            $net_priceArr = json_decode($_POST['net_price']);
            $qtyArr = json_decode($_POST['qty']);
            $sell_priceArr = json_decode($_POST['sell_price']);
            $is_insArr = json_decode($_POST['is_ins']);
            $insuranceArr = json_decode($_POST['insurance']);
            $descArr = json_decode($_POST['desc']);
            $job_idArr = json_decode($_POST['job_id']);
            $job_orderArr = json_decode($_POST['job_order']);
            $work_idArr = json_decode($_POST['work_id']);
            $timestampArr = json_decode($_POST['timestamp']);
            $isVatArr = json_decode($_POST['isVat']);
            $isNbtArr = json_decode($_POST['isNbt']);
            $nbtRatioArr = json_decode($_POST['nbtRatio']);
            $proVatArr = json_decode($_POST['proVat']);
            $proNbtArr = json_decode($_POST['proNbt']);
            $totalPriceArr = json_decode($_POST['totalPrice']);
            $proDiscountArr = json_decode($_POST['proDiscount']);
            $disPrecentArr = json_decode($_POST['disPercent']);
            $discountTypeArr = json_decode($_POST['discountType']);
            $estPriceArr = json_decode($_POST['estPrice']);
            $costPriceArr = json_decode($_POST['costPrice']);
            $estLineNoArr = json_decode($_POST['estLineNo']);

            $EstJobType=0;
            if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){
                $EstJobType = $this->db->select('EstJobType')->from('estimatehed')->where('EstCustomer', $_POST['cusCode'])->where('EstRegNo', $_POST['regNo'])->where('EstimateNo', $_POST['estimateNo'])->get()->row()->EstJobType;
            }

            if($action==1){
                if($EstJobType!=''){
                    //Insurance
                    $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice'.$location);
                }else{
                    //genaral
                    $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice'.$location);
                }

                // if($supplimentNo==0 || $supplimentNo==''){
                    // $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice');
                // }else{
                //     $data['JobInvNo'] = $_POST['invoiceNo'];
                //     $data['IsEdit'] = 1;
                // }
                $this->db->trans_start();
                $this->db->insert('jobinvoicehed',$data);
                $estTimestmp = '';
                for ($i = 0; $i < count($work_idArr); $i++) {
                    $totalCost+=($qtyArr[$i]*$costPriceArr[$i]);
                    
                    if($timestampArr[$i]!=''){
                        $estTimestmp = $timestampArr[$i];
                    }else{
                        $estTimestmp = date("Y-m-d H:i:s");
                    }
                     $jobDtl = array(
                        'JobInvNo' => $data['JobInvNo'],
                        'JobCardNo' => $data['JobCardNo'],
                        'JobOrder' => $job_orderArr[$i],
                        'JobType' => $job_idArr[$i],
                        'JobCode' => $work_idArr[$i],
                        'EstLineNo'=> $estLineNoArr[$i],
                        'JobLocation'=> $location,
                        'JobDescription' => $descArr[$i],
                        'JobQty' => $qtyArr[$i],
                        'JobPrice' => $sell_priceArr[$i],
                        'JobCost' => $costPriceArr[$i],
                        'JobQty' => $qtyArr[$i],
                        'JobIsVat' => $isVatArr[$i],
                        'JobIsNbt' => $isNbtArr[$i],
                        'JobNbtRatio' => $nbtRatioArr[$i],
                        'JobVatAmount' => $proVatArr[$i],
                        'JobNbtAmount' => $proNbtArr[$i],
                        'JobTotalAmount' => $totalPriceArr[$i],
                        'JobDiscount' => $proDiscountArr[$i],
                        'JobDisValue' => $proDiscountArr[$i],
                        'JobDisPercentage' =>$disPrecentArr[$i],
                        'JobDiscountType' => $discountTypeArr[$i],
                        'JobNetAmount' => $net_priceArr[$i],
                        'JobinvoiceTimestamp' => $estTimestmp
                        );
                     $this->db->insert('jobinvoicedtl',$jobDtl);
                      if($job_idArr[$i]==2){
                        $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$work_idArr[$i]','$qtyArr[$i]','1','0','$sell_priceArr[$i]','$location','','0','0','0')");
                    }
                }
                //odoout update
                $this->db->update('jobcardhed',$data1,array('JobCardNo' => $data['JobCardNo']));
                // update job cost
                $this->db->update('jobinvoicehed',array('JobCostAmount' => $totalCost),array('JobInvNo' => $data['JobInvNo']));
                // update temparary invoice
                $this->db->update('tempjobinvoicehed',array('IsInvoice' =>1),array('JobInvNo' => $tempInvoiceNo));
                //job end
                $endDate = date("Y-m-d H:i:s");
                $this->db->update('jobcardhed',array('endDate' =>$endDate,'IsCompelte' =>2),array('JobCardNo' => $data['JobCardNo']));
                $this->Job_model->bincard($data['JobInvNo'],3,'Updated');//update bincard

                
                $this->Job_model->update_max_code('JobInvoice'.$location);
                $this->db->trans_complete();
                $res2= $this->db->trans_status();
            }elseif ($action==2) {
                // update goes here
                $data['JobInvNo'] = $_POST['invoiceNo'];
                $this->db->trans_start();
                $this->db->update('jobinvoicehed',$data,array('JobInvNo' => $data['JobInvNo']));
                $estTimestmp = '';
                $estLineNo=0;
                $this->db->delete('jobinvoicedtl',array('JobInvNo' => $data['JobInvNo']));
                for ($i = 0; $i < count($work_idArr); $i++) {
                    if($timestampArr[$i]!=''){
                        $estTimestmp = $timestampArr[$i];
                    }else{
                        $estTimestmp = date("Y-m-d H:i:s");
                    }

                    if($estLineNoArr[$i]!='0'){
                        $estLineNo=$estLineNoArr[$i];
                    }else{
                        $estLineNo=$this->db->select('MAX(EstLineNo) AS EstLineNo')->from('tempjobinvoicedtl')->where('JobInvNo',$data['JobInvNo'])->get()->row()->EstLineNo;
                        $estLineNo++;
                    }

                    $totalCost+=($qtyArr[$i]*$costPriceArr[$i]);
                    $jobDtl = array(
                        'JobInvNo' => $data['JobInvNo'],
                        'JobCardNo' => $data['JobCardNo'],
                        'JobOrder' => $job_orderArr[$i],
                        'JobType' => $job_idArr[$i],
                        'JobCode' => $work_idArr[$i],
                        'EstLineNo'=> $estLineNo,
                        'JobLocation'=> $location,
                        'JobDescription' => $descArr[$i],
                        'JobQty' => $qtyArr[$i],
                        'JobPrice' => $sell_priceArr[$i],
                        'JobCost' => $costPriceArr[$i],
                        'JobQty' => $qtyArr[$i],
                        'JobIsVat' => $isVatArr[$i],
                        'JobIsNbt' => $isNbtArr[$i],
                        'JobNbtRatio' => $nbtRatioArr[$i],
                        'JobVatAmount' => $proVatArr[$i],
                        'JobNbtAmount' => $proNbtArr[$i],
                        'JobTotalAmount' => $totalPriceArr[$i],
                        'JobDiscount' => $proDiscountArr[$i],
                        'JobDisValue' => $proDiscountArr[$i],
                        'JobDisPercentage' =>$disPrecentArr[$i],
                        'JobDiscountType' => $discountTypeArr[$i],
                        'JobNetAmount' => $net_priceArr[$i],
                        'JobinvoiceTimestamp' => $estTimestmp
                        );
                     $this->db->insert('jobinvoicedtl',$jobDtl);
                }
            $this->db->update('jobcardhed',$data1,array('JobCardNo' => $data['JobCardNo']));
            $this->Job_model->bincard($data['JobInvNo'],3,'Updated');//update bincard
                $updateTimestmp = date("Y-m-d H:i:s");

                $this->db->trans_complete();
                $res2= $this->db->trans_status();
            }
        }elseif ($partInvType==2) {
            $location=$_SESSION['location'];
            $action = $_POST['action'];
            $data['JCompanyCode'] = '';
            if($_POST['sup_no']=='' || $_POST['sup_no']==0){$supplimentNo=0;}else{$supplimentNo=$_POST['sup_no'];}
            $data['JCustomer'] = $_POST['cusCode'];
            $data['JRegNo'] = $_POST['regNo'];
            $data['EstType'] = isset($_POST['estimate_type']) ? $_POST['estimate_type'] : 0;
            $data['JInsCompany'] = isset($_POST['insCompany']) ? $_POST['insCompany'] : 0;
            $data['JobEstimateNo'] = $_POST['estimateNo'];
            $data['JobSupplimentry'] = $supplimentNo;
            $data['JobCardNo'] = $_POST['jobNo'];
            $data['JobInvoiceDate'] = $_POST['date'];
            $data['JobLocation'] = $location;
            // $data['JobTotalAmount'] = $_POST['estimateAmount'];
            $data['JJobType'] = isset($_POST['job_type']) ? $_POST['job_type'] : 0;
            $data['IsPayment'] = 0;
            $data['IsCompelte'] = 0;
            $data['IsCancel'] = 0;
            $data['IsEdit'] = 0;
            $job_total_amount = 0;
            $job_total_discount = 0;
            $job_net_amount = 0;
            $job_vat_amount = 0;
            $job_nbt_amount = 0;

            $part_total_amount = 0;
            $part_total_discount = 0;
            $part_net_amount = 0;
            $part_vat_amount = 0;
            $part_nbt_amount = 0;

            $partData['AppNo']=1;
            $partData['InvNo']=$this->Job_model->get_max_code('Point Of Sales');
            $partData['InvLocation']=$location;
            $partData['InvDate'] = $_POST['date'];
            $partData['InvCounterNo'] = 1;
            $partData['InvRootNo'] = 1;
            $partData['InvCustomer'] = $_POST['cusCode'];
            $partData['InvJobCardNo'] = $_POST['jobNo'];
            // $partData['InvDisPercentage'] = $_POST['date'];
            // $partData['InvCashAmount'] = 0;
            $partData['InvCCardAmount'] = 0;
            $partData['InvCreditAmount'] = 0;
            $partData['InvReturnPayment'] = 0;
            $partData['InvGiftVAmount'] = 0;
            $partData['InvLoyaltyAmount'] = 0;
            $partData['InvStarPoints'] = 0;
            $partData['InvChequeAmount'] = 0;
            // $partData['InvAmount'] = 0;
            $partData['InvIsVat'] =$_POST['isTotalVat'];
            $partData['InvIsNbt'] =$_POST['isTotalNbt'];
            $partData['InvNbtRatioTotal'] =$_POST['isTotalNbt'];
            // $partData['InvNbtAmount'] = 0;
            // $partData['InvVatAmount'] = 0;
            // $partData['InvNetAmount'] = 0;
            $partData['InvCustomerPayment'] = 0;
            // $partData['InvCostAmount'] = 0;
            $partData['InvRefundAmount'] = 0;
            $partData['InvUser'] = 0;
            $partData['InvHold'] = 1;
            $partData['InvIsCancel'] = 0;
            $partData['IsComplete'] = 0;
            $partData['Flag'] = 0;

            // $data['JobTotalDiscount'] =$_POST['total_discount'];
            // $data['JobNetAmount'] =$_POST['totalNet'];
            // $data['JobVatAmount'] =$_POST['totalVat'];
            // $data['JobNbtAmount'] =$_POST['totalNbt'];
            //$data['JobTotalAmount'] = $_POST['estimateAmount'];
            $data['JobIsVatTotal'] = $_POST['isTotalVat'];
            $data['JobIsNbtTotal'] = $_POST['isTotalNbt'];
            $data['JobNbtRatioTotal'] = $_POST['nbtRatioRate'];
            $data['JobInvUser'] = $_SESSION['user_id'];
            $data['InvoiceType'] = $_POST['InvoiceType'];
            $data['TempNo'] = $_POST['tempInvoiceNo'];
            $data['PartInvType'] = $partInvType;

            $tempInvoiceNo = $_POST['tempInvoiceNo'];

            $net_priceArr = json_decode($_POST['net_price']);
            $qtyArr = json_decode($_POST['qty']);
            $sell_priceArr = json_decode($_POST['sell_price']);
            $is_insArr = json_decode($_POST['is_ins']);
            $insuranceArr = json_decode($_POST['insurance']);
            $descArr = json_decode($_POST['desc']);
            $job_idArr = json_decode($_POST['job_id']);
            $job_orderArr = json_decode($_POST['job_order']);
            $work_idArr = json_decode($_POST['work_id']);
            $timestampArr = json_decode($_POST['timestamp']);
            $isVatArr = json_decode($_POST['isVat']);
            $isNbtArr = json_decode($_POST['isNbt']);
            $nbtRatioArr = json_decode($_POST['nbtRatio']);
            $proVatArr = json_decode($_POST['proVat']);
            $proNbtArr = json_decode($_POST['proNbt']);
            $totalPriceArr = json_decode($_POST['totalPrice']);
            $proDiscountArr = json_decode($_POST['proDiscount']);
            $disPrecentArr = json_decode($_POST['disPercent']);
            $discountTypeArr = json_decode($_POST['discountType']);
            $estPriceArr = json_decode($_POST['estPrice']);
            $costPriceArr = json_decode($_POST['costPrice']);

            $EstJobType=0;
            if($_POST['estimateNo']!='' || $_POST['estimateNo']!=0){
                $EstJobType = $this->db->select('EstJobType')->from('estimatehed')->where('EstCustomer', $_POST['cusCode'])->where('EstRegNo', $_POST['regNo'])->where('EstimateNo', $_POST['estimateNo'])->get()->row()->EstJobType;
            }

            if($action==1){
                if($EstJobType!=''){
                    //Insurance
                    $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice'.$location);
                }else{
                    //genaral
                    $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice'.$location);
                }

                // if($supplimentNo==0 || $supplimentNo==''){
                    // $data['JobInvNo'] = $this->Job_model->get_max_code('JobInvoice');
                // }else{
                //     $data['JobInvNo'] = $_POST['invoiceNo'];
                //     $data['IsEdit'] = 1;
                // }
                $totaljobCost=0;
                $totalpartCost=0;
                $this->db->trans_start();

                $WarrantyMonth =0;
                $upc=0;
                
               $estTimestmp = '';
            
                
                for ($i = 0; $i < count($work_idArr); $i++) {

                    //if part seperaate
                    if($job_idArr[$i]==2){
                        $totalpartCost+=($qtyArr[$i]*$costPriceArr[$i]);
                        $part_total_amount +=$totalPriceArr[$i];
                        $part_total_discount +=$proDiscountArr[$i];
                        $part_net_amount += $net_priceArr[$i];
                        $part_vat_amount += $proVatArr[$i];
                        $part_nbt_amount += $proNbtArr[$i];

                        $WarrantyMonth = $this->db->select('WarrantyPeriod')->from('productcondition')->where('ProductCode',$work_idArr[$i])->get()->row()->WarrantyPeriod;
                        $upc = $this->db->select('Prd_UPC')->from('product')->where('ProductCode',$work_idArr[$i])->get()->row()->Prd_UPC;
                        
                         $partDtl = array(
                            'AppNo' => 1,
                            'InvNo' => $partData['InvNo'],
                            'InvLocation' => $location,
                            'InvDate' =>  $partData['InvDate'],
                            'InvLineNo' => ($i+1),
                            'InvCaseOrUnit' => 'Unit',
                            'InvProductCode' => $work_idArr[$i],
                            'InvSerialNo' =>'',
                            'InvQty' => $qtyArr[$i],
                            'InvFreeQty' => 0,
                            'InvReturnQty' => 0,
                            'InvPriceLevel' => 1,
                            'InvUnitPrice' => $sell_priceArr[$i],
                            'InvCostPrice' => $costPriceArr[$i],
                            'InvUnitPerCase' => $upc,
                            'InvIsVat' => $isVatArr[$i],
                            'InvIsNbt' => $isNbtArr[$i],
                            'InvNbtRatio' => $nbtRatioArr[$i],
                            'InvVatAmount' => $proVatArr[$i],
                            'InvNbtAmount' => $proNbtArr[$i],
                            'InvTotalAmount' => $totalPriceArr[$i],
                            'InvDisValue' => $proDiscountArr[$i],
                            'InvDisPercentage' =>$disPrecentArr[$i],
                            'SalesPerson' => '0',
                            'WarrantyMonth' => $WarrantyMonth,
                            'InvNetAmount' => $net_priceArr[$i]
                            );
                         $this->db->insert('invoicedtl',$partDtl);
                    }else{
                        $totaljobCost+=($qtyArr[$i]*$costPriceArr[$i]);
                        $job_total_amount +=$totalPriceArr[$i];
                        $job_total_discount +=$proDiscountArr[$i];
                        $job_net_amount += $net_priceArr[$i];
                        $job_vat_amount += $proVatArr[$i];
                        $job_nbt_amount += $proNbtArr[$i];

                        if($timestampArr[$i]!=''){
                            $estTimestmp = $timestampArr[$i];
                        }else{
                            $estTimestmp = date("Y-m-d H:i:s");
                        }

                        $jobDtl = array(
                            'JobInvNo' => $data['JobInvNo'],
                            'JobCardNo' => $data['JobCardNo'],
                            'JobOrder' => $job_orderArr[$i],
                            'JobType' => $job_idArr[$i],
                            'JobCode' => $work_idArr[$i],
                            'EstLineNo'=> $estLineNoArr[$i],
                            'JobLocation'=> $location,
                            'JobDescription' => $descArr[$i],
                            'JobQty' => $qtyArr[$i],
                            'JobPrice' => $sell_priceArr[$i],
                            'JobCost' => $costPriceArr[$i],
                            'JobQty' => $qtyArr[$i],
                            'JobIsVat' => $isVatArr[$i],
                            'JobIsNbt' => $isNbtArr[$i],
                            'JobNbtRatio' => $nbtRatioArr[$i],
                            'JobVatAmount' => $proVatArr[$i],
                            'JobNbtAmount' => $proNbtArr[$i],
                            'JobTotalAmount' => $totalPriceArr[$i],
                            'JobDiscount' => $proDiscountArr[$i],
                            'JobDisValue' => $proDiscountArr[$i],
                            'JobDisPercentage' =>$disPrecentArr[$i],
                            'JobDiscountType' => $discountTypeArr[$i],
                            'JobNetAmount' => $net_priceArr[$i],
                            'JobinvoiceTimestamp' => $estTimestmp
                        );
                        $this->db->insert('jobinvoicedtl',$jobDtl);
                        $this->db->update('jobcardhed',$data1,array('JobCardNo' => $data['JobCardNo']));
                    }

                    $WarrantyMonth =0;
                    $upc=0;
                }

                if($part_total_amount!=0){
                    $partDisPrent =(100*$part_total_discount)/$part_total_amount;
                }else{
                    $partDisPrent =0;
                }

                $partData['InvNbtAmount'] = $part_nbt_amount;
                $partData['InvVatAmount'] = $part_vat_amount;
                $partData['InvNetAmount'] = $part_net_amount;
                $partData['InvAmount'] = $part_total_amount;
                $partData['InvDisAmount'] = $part_total_discount;
                $partData['InvDisPercentage'] = $partDisPrent;
                $partData['InvCostAmount'] = $totalpartCost;

                // insert pos invoice
                $this->db->insert('invoicehed',$partData);

                $data['JobTotalDiscount'] =$job_total_discount;
                $data['JobNetAmount'] =$job_net_amount;
                $data['JobVatAmount'] =$job_vat_amount;
                $data['JobNbtAmount'] =$job_nbt_amount;
                $data['JobTotalAmount'] = $job_total_amount;
                $data['JobCostAmount'] = $totaljobCost;

                // insert job invoice
                $this->db->insert('jobinvoicehed',$data);

                // update temparary invoice
                $this->db->update('tempjobinvoicehed',array('IsInvoice' =>1),array('JobInvNo' => $tempInvoiceNo));
                
                $this->Job_model->update_max_code('JobInvoice'.$location);
                $this->Job_model->update_max_code('Point Of Sales'.$location);
                $this->db->trans_complete();
                $res2= $this->db->trans_status();
            }
        }

        $return = array('PosInvNo' => $partData['InvNo'],'JobInvNo' => $data['JobInvNo'],'SupplimentryNo'=>$supplimentNo);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function updateinvoice() {
        $total = 0;
        $nettotal = 0;
        $netdiscount = 0;
        $jqty=0;
        $insCompany=0;
        $supNo=0;
        $location=$_SESSION['location'];
        // echo json_encode($this->input->post());die;
        $invoice = $this->input->post('invoiceNo');
        $estno=$this->input->post('estimateNo');
        $supNo=$this->input->post('supplimentNo');
        if(isset($estno)){
            $insCompany =$this->db->select('EstInsCompany')->from('estimatehed')->where('EstimateNo', $estno)->where('Supplimentry', $supNo)->get()->row()->EstInsCompany;
        }

        $this->db->trans_start();
        $this->db->set('JobEstimateNo',$this->input->post('estimateNo'));
        $this->db->set('JobSupplimentry',$this->input->post('supplimentNo'));
        $this->db->set('JobCardNo', $this->input->post('jobcardno'));
        $this->db->set('JInsCompany', $insCompany);
        $this->db->set('JCustomer', $this->input->post('customerCode'));
        $this->db->set('JRegNo', $this->input->post('regNo'));
        $this->db->set('JobInvoiceDate',$this->input->post('date'));
        $this->db->where('JobInvNo', $invoice);
        $this->db->update('jobinvoicehed');

        $this->db->where('JobInvNo', $invoice);
        $this->db->delete('jobinvoicedtl');
        $timestamp='';
        foreach ($this->input->post('data') as $key => $value) {
            if(!isset($value['timestamp']) || $value['timestamp']=='' || $value['timestamp']=="0000-00-00 00:00:00"){
                $timestamp=date("Y-m-d H:i:s");
            }else{
                $timestamp=$value['timestamp'];
            }
                    $this->db->set('JobInvNo',$invoice);
                    $this->db->set('JobCardNo','');
                    $this->db->set('JobType',$value['jobtype']);
                    $this->db->set('JobDescription',$value['description']);
                    $this->db->set('JobQty',$value['qty']);
                    $this->db->set('JobPrice',$value['price']);
                    $this->db->set('JobTotalAmount',$value['total']);
                    $this->db->set('JobDiscount',$value['discountval']);
                    $this->db->set('JobNetAmount',$value['netamount']);
                    $this->db->set('JobDiscountType',$value['discountmethod']);
                    $this->db->set('JobinvoiceTimestamp', $timestamp);
                    $this->db->set('JobCode', $value['jobCode']);
                    $this->db->insert('jobinvoicedtl');
                    $total+=$value['total'];
                    $nettotal+=$value['netamount'];
                    $netdiscount+=$value['discountval'];
                    $proCode = $value['jobCode'];
                    $qty = $value['qty'];
                    $sellPrice =$value['price'];

                    //stock update
                    if($value['jobtype']==2){
                        $jobQty =$this->db->select('JobQty')->from('jobinvoicedtl')->where('JobCode', $proCode)->where('JobInvNo', $invoice)->get()->row()->JobQty;
                        if($qty>$jobQty){
                            $jqty=$qty-$jobQty;
                            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$proCode','$jqty','1','0','$sellPrice','$location','','0','0','0')");
                        }else if($qty<$jobQty){
                            $jqty=$jobQty-$qty;
                            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$proCode','(-$jqty)','1','0','$sellPrice','$location','','0','0','0')");
                        }
                    }
        }
        $this->db->set('JobTotalAmount',$total);
        $this->db->set('JobNetAmount',$nettotal);
        $this->db->set('JobTotalDiscount',$netdiscount);
        $this->db->where('JobInvNo', $invoice);
        $this->db->update('jobinvoicehed');

        $this->db->trans_complete();
        echo $this->db->trans_status();die;
    }

    public function printinvoicecreate() {
        $invno = $_POST['invno'];

        $this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS Description');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER');
        $this->db->where('jobinvoicedtl.JobInvNo', $invno);
        
        $this->db->order_by('jobinvoicedtl.JobinvoiceTimestamp','ASC');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        $result=$this->db->get();
        $data = array();
        $data['head'] = $this->db->select('jobinvoicehed.JobInvNo,jobinvoicehed.JCustomer,jobinvoicehed.JobAdvance,jobinvoicehed.IsPayment,jobinvoicehed.JobEstimateNo,jobinvoicehed.JobInvoiceDate AS Date,jobinvoicehed.JobNetAmount,jobinvoicehed.JobTotalDiscount,jobinvoicehed.JobTotalAmount,customer.CusName,customer.Address01,customer.MobileNo,make.make as Make,model.model AS Model,vehicledetail.contactName,vehicledetail.RegNo,vehicledetail.ChassisNo')->from('jobinvoicehed')->where('JobInvNo',$invno)->join('customer','customer.CusCode=jobinvoicehed.JCustomer')->join('vehicledetail','vehicledetail.CusCode=jobinvoicehed.JCustomer')->join('make','vehicledetail.Make=make.make_id')->join('model','vehicledetail.Model=model.model_id')->get()->row();
        foreach ($result->result() as $row) {
            $data['list'][$row->Description][] = $row;
        }
        echo json_encode($data); die;
    }


    public function get_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $code= $row['CodeLimit'];
           $input = $row['AutoNumber'];
           $string= $row['FormCode'];
           $code_len = $row['FCLength'];
           $item_ref = $string . str_pad(($input+1), $code_len, $code, STR_PAD_LEFT);
        } 
        return $item_ref;
    }
    
    public function update_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $input = $row['AutoNumber'];
        } 
        $this->db->update('codegenerate',array('AutoNumber'=>($input+1)),array('FormName'=>($form)));
    }

    public function loadadvancepaymentjson() {
        $query = $_GET['q'];
        $customer = $_GET['cusCode'];
        $location = $_GET['loc'];
        $q = $this->db->select('customerpaymenthed.CusPayNo AS id, CONCAT(customerpaymenthed.CusPayNo," ",TotalPayment," ",Remark) AS text')->from('customerpaymenthed')->join('customerpaymentdtl','customerpaymentdtl.CusPayNo=customerpaymenthed.CusPayNo')->where('customerpaymenthed.Location',$location)->where('customerpaymenthed.CusCode',$customer)->where('customerpaymenthed.PaymentType',2)->where('customerpaymenthed.IsCancel',0)->where('customerpaymentdtl.IsRelease',0)->like('customerpaymenthed.CusPayNo', $query)->order_by('customerpaymenthed.CusPayNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function getadvancepaymentbyid() {
        $id = $_POST['payid'];
         $arr['advance'] = $this->db->select('TotalPayment,CusPayNo')->from('customerpaymenthed')->Where('CusPayNo', $id)->get()->row();
       echo json_encode($arr);die;
    }

    public function loadreturnpaymentjson() {
        $query = $_GET['q'];
        $customer = $_GET['cusCode'];
        $location = $_SESSION['location'];
        $q = $this->db->select('returninvoicehed.ReturnNo AS id, CONCAT(returninvoicehed.ReturnNo," ",ReturnAmount," ",Remark) AS text')->from('returninvoicehed')->where('returninvoicehed.ReturnLocation',$location)->where('returninvoicehed.CustomerNo',$customer)->where('returninvoicehed.IsCancel',0)->where('returninvoicehed.IsComplete',0)->like('returninvoicehed.ReturnNo', $query)->order_by('returninvoicehed.ReturnNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function getreturnpaymentbyid() {
        $id = $_POST['payid'];
         $arr['return'] = $this->db->select('ReturnAmount,ReturnNo')->from('returninvoicehed')->Where('ReturnNo', $id)->get()->row();
       echo json_encode($arr);die;
    }

    public function cancelInvoice() {
        
        $jobInvNo=$this->input->post('jobinvno');

        $this->db->trans_start();
        $cancelNo = $this->get_max_code('CancelJobInvoice');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_SESSION['location'],
            'CancelDate' => date("Y-m-d H:i:s"),
            'JobInvoiceNo' => $jobInvNo,
            'Remark' => $_POST['remark'],
            'CancelUser' => $_SESSION['user_id']);
        $this->db->insert('canceljobinvoice', $invCanel);

        //check is made any previous payment
        $isPay = $this->db->select('count(invoicesettlementdetails.InvNo) AS inv')->from('invoicesettlementdetails')->join('customerpaymenthed', 'invoicesettlementdetails.CusPayNo = customerpaymenthed.CusPayNo', 'INNER')->where('invoicesettlementdetails.InvNo',$jobInvNo)->where('customerpaymenthed.IsCancel',0)->get()->row()->inv;

         if ($isPay > 0) {
            echo 2;
         }else{
            //check invoice already cancel or not
            $query0 = $this->db->get_where('jobinvoicehed', array('JobInvNo' => $invCanel['JobInvoiceNo'],'IsCancel'=>0));
            
            if ($query0->num_rows() > 0) {
                $query = $this->db->get_where('jobinvoicedtl', array('JobInvNo' => $invCanel['JobInvoiceNo']));

                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {  
                        //update serial stock
                        $jobtype=  $row['JobType'];
                        if($jobtype==2){
                                //    $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['JobCode'], 'SerialNo' => $row['InvSerialNo'], 'Location' => $row['InvLocation']))->get();
                                // if ($ps->num_rows() > 0) {
                                //     $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode' => $row['InvProductCode'], 'InvSerialNo' => $row['InvSerialNo'], 'InvLocation' => $row['InvLocation']))->get();
                                //     if ($isPro->num_rows() == 0) {
                                //         $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['InvProductCode'], 'SerialNo' => $row['InvSerialNo']));
                                //     }
                                // } else {
                                    
                                // }
                                $proCode = $row['JobCode'];
                                $totalGrnQty = $row['JobQty'];
                                $loc = $_SESSION['location'];
                                $pl = 1;
                                $costp = $row['JobCost'];
                                $selp = $row['JobPrice'];

                            //update price stock
                            $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

                            //update product stock
                            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')"); 
                        }   
                    }
        }

            //update/ cancel credit invoice
            $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['JobInvoiceNo'], 'Location' => $loc));
            if ($query2->num_rows() > 0) {
                $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['JobInvoiceNo'], 'Location' => $invCanel['Location']));
                foreach ($query2->result_array() as $row) {
                    //update customer outstanding
                    $creditAmount=$row['CreditAmount'];
                    $cuscode =$row['CusCode'];
                $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                }
            }
            //cancel cheques
            $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $invCanel['JobInvoiceNo'], 'IsCancel' => 0,'IsRelease' => 0,));
            if ($query3->num_rows() > 0) {
                $this->db->update('chequedetails', array('IsCancel' => 1), array('ReferenceNo' => $invCanel['JobInvoiceNo']));
            }

            $this->db->update('jobinvoicehed', array('IsCancel' => 1), array('JobInvNo' => $invCanel['JobInvoiceNo'], 'JobLocation' => $invCanel['Location']));
            $this->Job_model->bincard($invCanel['JobInvoiceNo'],2,'cancelled');//update bincard

            $this->update_max_code('CancelJobInvoice');
            $this->db->trans_complete();
            echo $this->db->trans_status();
            }else{echo 3;}

        }
        die;
    }

      public function addSalesInvoice() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;
        $sup = isset($_GET['sup'])?$_GET['sup']:0;
        $cus = isset($_GET['cus'])?$_GET['cus']:NULL;
        $regno = isset($_GET['regno'])?$_GET['regno']:NULL;
        $action = isset($_GET['action'])?$_GET['action']:1;
        $this->load->helper('url'); 
        $this->page_title->push(('Add Sales Invoice'));
        $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/addSalesInvoice');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['inv'] =base64_decode($id);
        $this->data['customer'] = $cus;
        $this->data['regno']    = $regno;
        $this->data['action']   = $action;
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
        $this->data['plv'] = $this->Job_model->loadpricelevel();
        $this->data['location'] = $this->db->select()->from('location')->get()->result();
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
        $this->data['bank_acc']=$this->db->select('bank_account.*,bank.BankName')->from('bank_account')->join('bank','BankCode=acc_bank')->get()->result();
        $this->data['bank'] = $this->db->select()->from('bank')->get()->result();
        $this->data['sup'] = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->get()->result();
        $this->data['vehicle_company'] = $this->db->select()->from('vehicle_company')->where('VComCategory', 3)->get()->result();
        
        $this->template->admin_render('admin/sales/add-sales-invoice', $this->data);

    }

    public function saveNewSalesInvoice() {
        $location=$_SESSION['location'];
        $this->load->model('admin/Salesinvoice_model');

        $creditAmount = $_POST['creditAmount'];
        if($creditAmount>0){
            $SalesInvType=3;
        }else{
            $SalesInvType=$_POST['invType'];
        }
        

        if($_POST['action']==1 && $SalesInvType==1){
            $grnNo = $this->Salesinvoice_model->get_max_code('SalesInvoiceNo'.$location);
        }elseif($_POST['action']==1 && $SalesInvType==2){
            $grnNo = $this->Salesinvoice_model->get_max_code('TaxInvoiceNo'.$location);
        }elseif($_POST['action']==1 && $SalesInvType==3){
            $grnNo = $this->Salesinvoice_model->get_max_code('CreditInvoiceNo'.$location);
        }elseif ($_POST['action']==2) {
           $grnNo = $_POST['grn_no'];
        }

        $vehicleno = isset($_POST['regNo'])?$_POST['regNo']:'';
        $salesorder = $_POST['salesorder'];
        $invDate = date("Y-m-d H:i:s");
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $cashAmount = $_POST['cashAmount'];
        $creditAmount = $_POST['creditAmount'];
        $chequeAmount = $_POST['chequeAmount'];
        $advanceAmount = $_POST['advance_amount'];
        $advancePayNo = $_POST['advance_pay_no'];
        $returnAmount = $_POST['return_amount'];
        $returnPayNo = $_POST['return_payment_no'];
        $cardAmount = $_POST['cardAmount'];
        $bankAmount = $_POST['bank_amount'];
        $bank_account = $_POST['bankacc'];
        $shipping = $_POST['shipping'];
        $shipping_label = $_POST['shippingLabel'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $customer = $_POST['cusCode'];
        $isComplete = 0;
        $totalGrnDiscount = $_POST['totalGrnDiscount'];
        $totalProDiscount = $_POST['totalProDiscount'];
        $totalVat = $_POST['totalVat'];
        $totalNbt = $_POST['totalNbt'];
        $isTotalVat = $_POST['isTotalVat'];
        $isTotalNbt = $_POST['isTotalNbt'];
        $nbtRatioRate = $_POST['nbtRatioRate'];
        $price_level = $_POST['price_level'];
        $po_number = $_POST['po_number'];
        $newsalesperson = $_POST['newsalesperson'];
        $route = $_POST['route'];
        $SalesInsCompany = $_POST['insCompany'];
        $com_amount = $_POST['com_amount'];
        $compayto = $_POST['compayto'];
        $receiver_name = $_POST['receiver_name'];
        $receiver_nic = $_POST['receiver_nic'];
        $remark = $_POST['remark'];
        $customerPayment =  $cashAmount+ $chequeAmount+ $cardAmount+$advanceAmount+$bankAmount;
        $cashAmount=$total_net_amount-$creditAmount-$cardAmount-$chequeAmount-$advanceAmount-$bankAmount;
        $totalDisPerent = ($totalGrnDiscount*100)/($total_amount-$totalProDiscount);
        //add to here
        $grnHed = array(
            'AppNo' => '1','SalesInvNo' => $grnNo,'SalesOrderNo'=>'','SalesVehicle'=>$vehicleno,'SalesInsCompany'=>$SalesInsCompany,'SalesLocation' => $location,'SalesOrgDate' => $grnDattime,'SalesDate' => $invDate,'SalesCustomer' => $customer,'SalesInvType' => $SalesInvType,'SalesInvAmount' => $total_amount,'SalesNetAmount' => $total_net_amount,'SalesCashAmount'=>$cashAmount,'SalesShippingLabel'=>$shipping_label,'SalesShipping'=>$shipping,'SalesBankAcc'=>$bank_account,'SalesBankAmount'=>$bankAmount,'SalesCCardAmount'=>$cardAmount,'SalesCreditAmount'=>$creditAmount,'SalesChequeAmount'=>$chequeAmount,'SalesCustomerPayment'=>$customerPayment,'SalesAdvancePayment'=>$advanceAmount,'AdvancePayNo'=>$advancePayNo,'SalesReturnPayment'=>$returnAmount,'SalesDisAmount' => $total_discount,'SalesDisPercentage' => $totalDisPerent,'SalesInvUser' => $invUser,'IsComplete' => $isComplete,'InvIsCancel'=>0,'SalesIsNbt'=>$isTotalNbt,'SalesIsVat'=>$isTotalVat,'SalesNbtRatio'=>$nbtRatioRate,'SalesNbtAmount'=>$totalNbt,'SalesVatAmount'=>$totalVat,'SalesPONumber'=>$po_number,'SalesPerson'=>$newsalesperson,'RouteId'=>$route,'SalesReceiver'=>$receiver_name,'SalesRecNic'=>$receiver_nic,'SalesCommsion'=>$com_amount,'SalesComCus'=>$compayto,'salesInvRemark'=>$remark
        );

        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Salesinvoice_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];

        if($_POST['action']==1){
            $res2= $this->Salesinvoice_model->saveSalesInvoice($grnHed,$_POST,$grnNo,$totalDisPerent);
        }elseif ($_POST['action']==2) {
            $grnHed = array(
            'AppNo' => '1','SalesInvNo' => $grnNo,'SalesOrderNo'=>'','SalesVehicle'=>$vehicleno,'SalesInsCompany'=>$SalesInsCompany,'SalesLocation' => $location,'SalesOrgDate' => $grnDattime,'SalesCustomer' => $customer,'SalesInvType' => $SalesInvType,'SalesInvAmount' => $total_amount,'SalesNetAmount' => $total_net_amount,'SalesCashAmount'=>$cashAmount,'SalesShippingLabel'=>$shipping_label,'SalesShipping'=>$shipping,'SalesBankAcc'=>$bank_account,'SalesBankAmount'=>$bankAmount,'SalesCCardAmount'=>$cardAmount,'SalesCreditAmount'=>$creditAmount,'SalesChequeAmount'=>$chequeAmount,'SalesCustomerPayment'=>$customerPayment,'SalesAdvancePayment'=>$advanceAmount,'AdvancePayNo'=>$advancePayNo,'SalesReturnPayment'=>$returnAmount,'SalesDisAmount' => $total_discount,'SalesDisPercentage' => $totalDisPerent,'SalesInvUser' => $invUser,'IsComplete' => $isComplete,'InvIsCancel'=>0,'SalesIsNbt'=>$isTotalNbt,'SalesIsVat'=>$isTotalVat,'SalesNbtRatio'=>$nbtRatioRate,'SalesNbtAmount'=>$totalNbt,'SalesVatAmount'=>$totalVat,'SalesPONumber'=>$po_number,'SalesPerson'=>$newsalesperson,'RouteId'=>$route,'SalesReceiver'=>$receiver_name,'SalesRecNic'=>$receiver_nic,'SalesCommsion'=>$com_amount,'SalesComCus'=>$compayto,'salesInvRemark'=>$remark
        );
           $res2= $this->Salesinvoice_model->updateSalesInvoice($grnHed,$_POST,$grnNo,$totalDisPerent);
        }
        
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function loadsalesinvoicejson() {
        $query = $_GET['q'];
        $location = $_SESSION['location'];
        $q = $this->db->select('SalesInvNo AS id,SalesInvNo AS text')->from('salesinvoicehed')->where('SalesLocation',$location)->where('InvIsCancel',0)->like('SalesInvNo', $query)->order_by('SalesInvNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadinvoicejsonbytype() {
        $query = $_GET['q'];
        $invoiceType = $_GET['invoiceType'];
        $location = $_SESSION['location'];
        $cusCode =  $_GET['cusCode'];
        // echo $cusCode;
        if($cusCode!='0'){
            if($invoiceType==1){
                $q = $this->db->query("SELECT `SalesInvNo` AS `id`, `SalesInvNo` AS `text` FROM `salesinvoicehed` WHERE `salesinvoicehed`.`SalesCustomer` ='$cusCode' AND `SalesLocation` = $location AND `InvIsCancel` =0 AND  `SalesInvNo` LIKE '%".$query."%' ESCAPE '!' AND `SalesInvNo` NOT IN(select InvoiceNo from deliverynotehed) ORDER BY `SalesInvNo` DESC")->result();
            }elseif($invoiceType==2){
                $q = $this->db->query("SELECT `JobCardNo` AS `id`, `JobCardNo` AS `text` FROM `jobcardhed` WHERE `IsCancel` =0 AND `JCustomer` ='$cusCode' AND  `JobCardNo` LIKE '%".$query."%' ESCAPE '!' AND `JobCardNo` NOT IN(select InvoiceNo from deliverynotehed) ORDER BY `JobCardNo` DESC")->result();
            }
        }else{
            if($invoiceType==1){
                $q = $this->db->query("SELECT `SalesInvNo` AS `id`, `SalesInvNo` AS `text` FROM `salesinvoicehed` WHERE `SalesLocation` = $location AND `InvIsCancel` =0  AND `SalesInvNo` LIKE '%".$query."%' ESCAPE '!' AND `SalesInvNo` NOT IN(select InvoiceNo from deliverynotehed) ORDER BY `SalesInvNo` DESC")->result();
            }elseif($invoiceType==2){
                $q = $this->db->query("SELECT `JobCardNo` AS `id`, `JobCardNo` AS `text` FROM `jobcardhed` WHERE `IsCancel` =0 AND  `JobCardNo` LIKE '%".$query."%' ESCAPE '!' AND `JobCardNo` NOT IN(select InvoiceNo from deliverynotehed) ORDER BY `JobCardNo` DESC")->result();
            }
        }
        
        
        echo json_encode($q);die;
    }


    public function getSalesInvoiceById(){
        $this->load->model('admin/Salesinvoice_model');
        $soNo = $_POST['saleInvoiceNo'];
        $cusCode = $this->db->select('SalesCustomer')->from('salesinvoicehed')->where('SalesInvNo',$soNo)->get()->row()->SalesCustomer;

        $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        $arr['si_hed'] = $this->db->select('salesinvoicehed.*')
        ->from('salesinvoicehed')
        // ->join('product','product.ProductCode=salesorderhed.SalesPerson','left')
        // ->join('paytype','paytype.payTypeId=salesorderhed.PayType','left')
        ->where('SalesInvNo', $soNo)->get()->row();

        $arr['si_dtl'] = $this->db->select('salesinvoicedtl.*,product.*')->from('salesinvoicedtl')
        ->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode','left')->where('salesinvoicedtl.SalesInvNo', $soNo)->order_by('salesinvoicedtl.SalesInvLineNo')->get()->result();
        $arr['si_dtl_arr'] = $this->Salesinvoice_model->getSalesInvoiceDtlbyid($soNo);

        echo json_encode($arr);
        die;
    }

    public function getSalesInvoiceProductById(){
        $this->load->model('admin/Salesinvoice_model');
        $soNo = $_POST['proCode'];
         $invNo = $_POST['invNo'];
          $name = $_POST['name'];

        $arr['product'] = $this->db->select('salesinvoicedtl.*,product.*,productcondition.*')->from('salesinvoicedtl')
        ->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode')->join('productcondition', 'product.ProductCode = productcondition.ProductCode')->where('salesinvoicedtl.SalesProductCode', $soNo)->where('salesinvoicedtl.SalesProductName', $name)->where('salesinvoicedtl.SalesInvNo', $invNo)->get()->row();

        echo json_encode($arr);
        die;
    }

    public function getJobInvoiceProductById(){
        $this->load->model('admin/Salesinvoice_model');
        $soNo = $_POST['proCode'];
        $invNo = $_POST['invNo'];

        $arr['product'] = $this->db->select('jobinvoicedtl.*,product.*,productcondition.*')->from('jobinvoicedtl')
        ->join('product', 'product.ProductCode = jobinvoicedtl.JobCode')->join('productcondition', 'product.ProductCode = productcondition.ProductCode')->where('jobinvoicedtl.JobCode', $soNo)->where('jobinvoicedtl.JobInvNo', $invNo)->get()->row();

        echo json_encode($arr);
        die;
    }

    public function cancelSalesInvoice() {
        $salesInvNo=$this->input->post('salesinvno');

        $this->db->trans_start();

        $cancelNo = $this->get_max_code('CancelSalesInvoice');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_SESSION['location'],
            'CancelDate' => date("Y-m-d H:i:s"),
            'SalesInvoiceNo' => $salesInvNo,
            'Remark' => $_POST['remark'],
            'CancelUser' => $_SESSION['user_id']);
        $this->db->insert('cancelsalesinvoice', $invCanel);

        //check is made any previous paymen
        $isPay = $this->db->select('count(invoicesettlementdetails.InvNo) AS inv')->from('invoicesettlementdetails')->join('customerpaymenthed', 'invoicesettlementdetails.CusPayNo = customerpaymenthed.CusPayNo', 'INNER')->where('invoicesettlementdetails.InvNo',$salesInvNo)->where('customerpaymenthed.IsCancel',0)->get()->row()->inv;

        if ($isPay > 0) {
            echo 2;
        }else{
            //check invoice already cancel or not
            $query0 = $this->db->get_where('salesinvoicehed', array('SalesInvNo' => $invCanel['SalesInvoiceNo'],'InvIsCancel'=>0));
            if ($query0->num_rows() > 0) {
                $query = $this->db->get_where('salesinvoicedtl', array('SalesInvNo' => $invCanel['SalesInvoiceNo']));
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {  
                        //update serial stock
                        $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo'], 'Location' => $row['SalesInvLocation']))->get();
                                if ($ps->num_rows() > 0) {
                                    $isPro = $this->db->select('SalesProductCode')->from('salesinvoicedtl')->where(array('SalesProductCode' => $row['SalesProductCode'], 'SalesSerialNo' => $row['SalesSerialNo'], 'SalesInvLocation' => $row['SalesInvLocation'],'SalesInvNo' => $invCanel['SalesInvoiceNo']))->get();
                                    // echo $isPro->num_rows();die;
                                    if ($isPro->num_rows() > 0) {
                                        // $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo']));
                                    }
                                } else {
                                    
                                }

                                $proCode = $row['SalesProductCode'];
                                $totalGrnQty = $row['SalesQty'];
                                $loc = $row['SalesInvLocation'];
                                $pl = $row['SalesPriceLevel'];
                                $costp = $row['SalesCostPrice'];
                                $selp = $row['SalesUnitPrice'];

                            //update price stock
                           //$this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

                            //update product stock
                           //$this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')"); 
                        // }   
                    }
                }

            //update/ cancel credit invoice
            $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['SalesInvoiceNo'], 'Location' => $invCanel['Location']));
            if ($query2->num_rows() > 0) {
                $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['SalesInvoiceNo'], 'Location' => $invCanel['Location']));
                foreach ($query2->result_array() as $row) {
                    //update customer outstanding
                    $creditAmount=$row['CreditAmount'];
                    $cuscode =$row['CusCode'];
                $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                }
            }

            //cancel cheques
            $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $invCanel['SalesInvoiceNo'], 'IsCancel' => 0,'IsRelease' => 0,));
            if ($query3->num_rows() > 0) {
                $this->db->update('chequedetails', array('IsCancel' => 1), array('ReferenceNo' => $invCanel['SalesInvoiceNo']));
            }

            $this->db->update('salesinvoicehed', array('InvIsCancel' => 1), array('SalesInvNo' => $invCanel['SalesInvoiceNo'], 'SalesLocation' => $invCanel['Location']));
            $this->update_max_code('CancelSalesInvoice');
            $this->db->trans_complete();
            echo $this->db->trans_status();
            }else{echo 3;}
        }
        die;
    }

    public function saveDeliveryNote() {
        // print_r($_POST);die;
        $location=$_SESSION['location'];
        $action = $_POST['action'];

        $data['DNCustomer'] = $_POST['cusCode'];
        $data['DNLocation'] = $location;
        $data['DNType'] = isset($_POST['invType']) ? $_POST['invType'] : 0;
        // $data['JInsCompany'] = isset($_POST['insCompany']) ? $_POST['insCompany'] : 0;
        // $data['DeliveryNotevNo'] = $_POST['quotationNo'];
        $data['InvoiceNo'] = $_POST['grn_no'];
        $data['DNReceiver'] = $_POST['receiverName'];
        $data['DNRemark'] = $_POST['remark'];
        $data['DeliveryDate'] = $_POST['grnDate'];
        $data['ReceiverMobile'] = $_POST['mobNo'];

        
        $data['ShipTo'] = $_POST['cusAddress'];
        $data['DNIsComplete'] = 0;
        $data['DNIsCancel'] = 0;
        $data['DNInvAmount'] =$_POST['total_amount'];
        $data['DNNetAmount'] =$_POST['total_net_amount'];
        $data['DNUser']=$_SESSION['user_id'];

        $product_codeArr = json_decode($_POST['product_code']);
        $product_nameArr = json_decode($_POST['proName']);
        $unitArr = json_decode($_POST['unit_type']);
        $freeQtyArr = json_decode($_POST['freeQty']);
        $serial_noArr = json_decode($_POST['serial_no']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['unit_price']);
        $orgSell_priceArr = json_decode($_POST['org_unit_price']);
        $cost_priceArr = json_decode($_POST['cost_price']);
        $pro_discountArr = json_decode($_POST['pro_discount']);
        $pro_discount_precentArr = json_decode($_POST['discount_precent']);
        $caseCostArr = json_decode($_POST['case_cost']);
        $upcArr = json_decode($_POST['upc']);
        $total_netArr = json_decode($_POST['total_net']);
        $price_levelArr = json_decode($_POST['price_level']);
        $totalAmountArr = json_decode($_POST['pro_total']);
        $isSerialArr = json_decode($_POST['isSerial']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $salesPersonArr = json_decode($_POST['salePerson']);
        // $location = $_POST['location'];
     

        if($action==1){
            // if($supplimentNo==0 || $supplimentNo==''){
                $data['DeliveryNoteNo'] = $this->Job_model->get_max_code('DeliveryNote');
            // }else{
            //     $data['JobInvNo'] = $_POST['invoiceNo'];
            //     $data['IsEdit'] = 1;
            // }
            $this->db->trans_start();
            $this->db->insert('deliverynotehed',$data);
            $proName='';
            for ($i = 0; $i < count($product_codeArr); $i++) {

                 $jobDtl = array(
                    'InvoiceNo' => $data['InvoiceNo'],
                    'DNoteNo' => $data['DeliveryNoteNo'],
                    'DNoteLineNo' => ($i+1),
                    'DNoteProductCode' => $product_codeArr[$i],
                    'DNoteProName'=>$product_nameArr[$i],
                    'DNoteLocation' => $location,
                    'DNoteQty' => $qtyArr[$i],
                    'DNoteFreeQty' => $freeQtyArr[$i],
                    'DNoteUnitPrice' => $sell_priceArr[$i],
                    'DNoteCostPrice' => $cost_priceArr[$i],
                    'DNoteSerialNo' => $serial_noArr[$i],
                    'DNoteCaseOrUnit' => $unitArr[$i],
                    'DNoteUnitPerCase' => $upcArr[$i],
                    'DNoteNetAmount' => $total_netArr[$i],
                    'SalesPerson' => $salesPersonArr[$i],
                    'DNoteDate' => date("Y-m-d H:i:s")
                );

                $this->db->insert('deliverynotedtl',$jobDtl);

            if($_POST['invType']==1){
                $price_levelArr[$i]=1;
                // update stock
                $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','$serial_noArr[$i]','$freeQtyArr[$i]','0','0')");

                //update serial stock
                if($serial_noArr[$i]!=''){
                    $this->db->update('productserialstock',array('Quantity'=>0),array('ProductCode'=> $product_codeArr[$i],'Location'=> $location,'SerialNo'=> $serial_noArr[$i]));
                }
            }
                
            }

            $this->Job_model->update_max_code('DeliveryNote');
            $this->db->trans_complete();
            $res2= $this->db->trans_status();
    }elseif ($action==2) {
die;
        // update goes here
        $data['DeliveryNoteNo'] = $_POST['deliveryNo'];

        $this->db->trans_start();
        $this->db->update('deliverynotehed',$data,array('DeliveryNoteNo' => $data['DeliveryNoteNo']));

        $estTimestmp = 0;

        $this->db->delete('deliverynotedtl',array('DNoteNo' => $data['DeliveryNoteNo']));

        for ($i = 0; $i < count($product_codeArr); $i++) {
            // if($timestampArr[$i]!=''){
            //     $estTimestmp = $timestampArr[$i];
            // }else{
            //     $estTimestmp = date("Y-m-d H:i:s");
            // }

             $jobDtl = array(
                'InvoiceNo' => $data['InvoiceNo'],
                    'DNoteNo' => $data['DeliveryNoteNo'],
                    'DNoteLineNo' => ($i+1),
                    'DNoteProductCode' => $product_codeArr[$i],
                    'DNoteProName'=>$product_nameArr[$i],
                    'DNoteLocation' => $location,
                    'DNoteQty' => $qtyArr[$i],
                    'DNoteFreeQty' => $freeQtyArr[$i],
                    'DNoteUnitPrice' => $sell_priceArr[$i],
                    'DNoteCostPrice' => $cost_priceArr[$i],
                    'DNoteSerialNo' => $serial_noArr[$i],
                    'DNoteCaseOrUnit' => $unitArr[$i],
                    'DNoteUnitPerCase' => $upcArr[$i],
                    'DNoteNetAmount' => $total_netArr[$i],
                    'SalesPerson' => $salesPersonArr[$i],
                    'DNoteDate' => date("Y-m-d H:i:s")
                );
             $this->db->insert('deliverynotedtl',$jobDtl);
        }
        $this->db->trans_complete();
        $res2= $this->db->trans_status();
    }

    $return = array('JobInvNo' => $data['DeliveryNoteNo']);
    $return['fb'] = $res2;
    echo json_encode($return);
    die;
}

public function all_delivery_note() {

            /* Title Page */
            $this->page_title->push('Sales');
            $this->data['pagetitle'] = 'All Delivery Notes';

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/view_job');
            $this->breadcrumbs->unshift(1, 'All Delivery Notes', 'admin/sales/all_delivery_note');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->template->admin_render('admin/sales/all-delivery-notes', $this->data);
    }

    public function loadalldeliverynote() {

        $this->datatables->select('deliverynotehed.*,customer.CusName,customer.MobileNo');
        $this->datatables->from('deliverynotehed')->join('customer','customer.CusCode=deliverynotehed.DNCustomer');
        echo $this->datatables->generate();
        die();
    }

    public function view_delivery_note($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */

            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Delivery Note');
            $this->data['pagetitle'] = 'Delivery Note -'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/sales/view_delivery_note');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['invHed']= $this->db->select('deliverynotehed.*,users.first_name')
                ->from('deliverynotehed')->join('users','deliverynotehed.DNUser=users.id','left')
                ->where('DeliveryNoteNo',$invNo)->get()->row();

            $cusCode =  $this->db->select('DNCustomer')->from('deliverynotehed')->where('DeliveryNoteNo',$invNo)->get()->row()->DNCustomer;
                
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->where('customer.CusCode',$cusCode)->get()->row();

             $this->data['invDtl']=$this->db->select('deliverynotedtl.*,product.*')->from('deliverynotedtl')->join('product', 'deliverynotedtl.DNoteProductCode = product.ProductCode', 'INNER')->where('deliverynotedtl.DNoteNo', $invNo)->order_by('deliverynotedtl.DNoteLineNo','ASC')->get()->result();

             $this->data['invDtlArr']=$this->Salesinvoice_model->getDeliveryNoteDtlbyid($invNo);
                   
            $this->template->admin_render('admin/sales/view-delivery-note', $this->data);
    }

    public function cancelDeliveryNote() {
        $deliveryNoteNo=$this->input->post('deliverynoteno');

        $this->db->trans_start();

        $cancelNo = $this->get_max_code('CancelDeliveryNote');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_SESSION['location'],
            'CancelDate' => date("Y-m-d H:i:s"),
            'DeliveryNoteNo' => $deliveryNoteNo,
            // 'Remark' => $_POST['remark'],
            'CancelUser' => $_SESSION['user_id']);
        $this->db->insert('canceldeliverynote', $invCanel);

    
            //check invoice already cancel or not
            $query0 = $this->db->get_where('deliverynotehed', array('DeliveryNoteNo' => $invCanel['DeliveryNoteNo'],'DNIsCancel'=>0));
            if ($query0->num_rows() > 0) {
                $query = $this->db->get_where('deliverynotedtl', array('DNoteNo' => $invCanel['DeliveryNoteNo']));
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {  
                        //update serial stock
                        $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['DNoteProductCode'], 'SerialNo' => $row['DNoteSerialNo'], 'Location' => $row['DNoteLocation']))->get();
                                if ($ps->num_rows() > 0) {
                                    $isPro = $this->db->select('DNoteProductCode')->from('deliverynotedtl')->where(array('DNoteProductCode' => $row['DNoteProductCode'], 'DNoteSerialNo' => $row['DNoteSerialNo'], 'DNoteLocation' => $row['DNoteLocation'],'DNoteNo' => $invCanel['DeliveryNoteNo']))->get();
                                    // echo $isPro->num_rows();die;
                                    if ($isPro->num_rows() > 0) {
                                        $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['DNoteProductCode'], 'SerialNo' => $row['DNoteSerialNo']));
                                    }
                                } else {
                                    
                                }

                                $proCode = $row['DNoteProductCode'];
                                $totalGrnQty = $row['DNoteQty'];
                                $loc = $row['DNoteLocation'];
                                $pl = 1;
                                $costp = $row['DNoteCostPrice'];
                                $selp = $row['DNoteUnitPrice'];

                            //update price stock
                           $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

                            //update product stock
                           $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')"); 
                        // }   
                    }
                }


            $this->db->update('deliverynotehed', array('DNIsCancel' => 1), array('DeliveryNoteNo' => $invCanel['DeliveryNoteNo'], 'DNLocation' => $invCanel['Location']));
            $this->update_max_code('CancelDeliveryNote');
            $this->db->trans_complete();
            echo $this->db->trans_status();
            }else{echo 3;}
        
        die;
    }

     public function cancelJobPayment() {
        
        $jobInvNo=$this->input->post('jobinvno');

        $this->db->trans_start();
        $cancelNo = $this->get_max_code('CancelJobInvPayment');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_SESSION['location'],
            'CancelDate' => date("Y-m-d H:i:s"),
            'JobInvoiceNo' => $jobInvNo,
            'Remark' => $_POST['remark'],
            'CancelUser' => $_SESSION['user_id']);
        $this->db->insert('canceljobinvpayment', $invCanel);

        //check is made any previous payment
        $isPay = $this->db->select('count(invoicesettlementdetails.InvNo) AS inv')->from('invoicesettlementdetails')->join('customerpaymenthed', 'invoicesettlementdetails.CusPayNo = customerpaymenthed.CusPayNo', 'INNER')->where('invoicesettlementdetails.InvNo',$jobInvNo)->where('customerpaymenthed.IsCancel',0)->get()->row()->inv;

         if ($isPay > 0) {
            echo 2;
         }else{
            //check invoice already cancel or not
            $query0 = $this->db->get_where('jobinvoicehed', array('JobInvNo' => $invCanel['JobInvoiceNo'],'IsCancel'=>0));
            
            if ($query0->num_rows() > 0) {
                $query = $this->db->get_where('jobinvoicedtl', array('JobInvNo' => $invCanel['JobInvoiceNo']));

                

            //update/ cancel credit invoice
            $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['JobInvoiceNo'], 'Location' => $invCanel['Location']));
            if ($query2->num_rows() > 0) {
                $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['JobInvoiceNo'], 'Location' => $invCanel['Location']));
                foreach ($query2->result_array() as $row) {
                    //update customer outstanding
                    $creditAmount=$row['CreditAmount'];
                    $cuscode =$row['CusCode'];
                $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                }
            }
            //cancel cheques
            $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $invCanel['JobInvoiceNo'], 'IsCancel' => 0,'IsRelease' => 0,));
            if ($query3->num_rows() > 0) {
                $this->db->update('chequedetails', array('IsCancel' => 1), array('ReferenceNo' => $invCanel['JobInvoiceNo']));
            }

            $this->db->update('jobinvoicehed', array('IsPayment' => 0), array('JobInvNo' => $invCanel['JobInvoiceNo'], 'JobLocation' => $invCanel['Location']));
             $this->db->delete('jobinvoicepaydtl',array('JobInvNo' => $invCanel['JobInvoiceNo']));
            $this->Job_model->bincard($invCanel['JobInvoiceNo'],2,'Payment cancelled');//update bincard

            $this->update_max_code('CancelJobInvPayment');
            $this->db->trans_complete();
            echo $this->db->trans_status();
            }else{echo 3;}

        }
        die;
    }


    public function convert_number_to_words($number) {

                        $hyphen = ' ';
                        $conjunction = ' and ';
                        $separator = ' ';
                        $negative = 'negative ';
                        $decimal = ' point ';
                        $dictionary = array(
                            0 => 'zero',
                            1 => 'one',
                            2 => 'two',
                            3 => 'three',
                            4 => 'four',
                            5 => 'five',
                            6 => 'six',
                            7 => 'seven',
                            8 => 'eight',
                            9 => 'nine',
                            10 => 'ten',
                            11 => 'eleven',
                            12 => 'twelve',
                            13 => 'thirteen',
                            14 => 'fourteen',
                            15 => 'fifteen',
                            16 => 'sixteen',
                            17 => 'seventeen',
                            18 => 'eighteen',
                            19 => 'nineteen',
                            20 => 'twenty',
                            30 => 'thirty',
                            40 => 'fourty',
                            50 => 'fifty',
                            60 => 'sixty',
                            70 => 'seventy',
                            80 => 'eighty',
                            90 => 'ninety',
                            100 => 'hundred',
                            1000 => 'thousand',
                            1000000 => 'million',
                            1000000000 => 'billion',
                            1000000000000 => 'trillion',
                            1000000000000000 => 'quadrillion',
                            1000000000000000000 => 'quintillion'
                        );

                        if (!is_numeric($number)) {
                            return false;
                        }

                        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                            // overflow
                            trigger_error(
                                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
                            );
                            return false;
                        }

                        if ($number < 0) {
                            return $negative . convert_number_to_words(abs($number));
                        }

                        $string = $fraction = null;

                        if (strpos($number, '.') !== false) {
                            list($number, $fraction) = explode('.', $number);
                        }

                        switch (true) {
                            case $number < 21:
                                $string = $dictionary[$number];
                                break;
                            case $number < 100:
                                $tens = ((int) ($number / 10)) * 10;
                                $units = $number % 10;
                                $string = $dictionary[$tens];
                                if ($units) {
                                    $string .= $hyphen . $dictionary[$units];
                                }
                                break;
                            case $number < 1000:
                                $hundreds = $number / 100;
                                $remainder = $number % 100;
                                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                                if ($remainder) {
                                    $string .= $conjunction . convert_number_to_words($remainder);
                                }
                                break;
                            default:
                                $baseUnit = pow(1000, floor(log($number, 1000)));
                                $numBaseUnits = (int) ($number / $baseUnit);
                                $remainder = $number % $baseUnit;
                                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                                if ($remainder) {
                                    $string .= $remainder < 100 ? $conjunction : $separator;
                                    $string .= convert_number_to_words($remainder);
                                }
                                break;
                        }

                        if (null !== $fraction && is_numeric($fraction)) {
                            $string .= $decimal;
                            $words = array();
                            foreach (str_split((string) $fraction) as $number) {
                                $words[] = $dictionary[$number];
                            }
                            $string .= implode(' ', $words);
                        }

                        return $string;
                    }


           

}
