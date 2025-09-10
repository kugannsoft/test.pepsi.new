<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Admin_Controller {
    
    public $CI = NULL;/*shalika*/

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();/*shalika*/
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Payment_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        $this->cus_payment();
    }
    /*shalika*/
    public function loadreturninvbyid($cuscode,$invno) {
        //SELECT * FROM `creditinvoicedetails` WHERE CusCode=14483 AND InvoiceNo='AWC0080';
        $q = $this->db->select('CreditAmount,InvoiceNo')->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('InvoiceNo',$invno)->where('Type=',1)->get()->row();
        return $q;
    }
    public function loadreturnsettlbyid($cuscode,$invno) {
        //SELECT SUM(SettledAmount) FROM `creditinvoicedetails` WHERE CusCode=14483 AND InvoiceNo='AWC0080' and Type=2;
        $q = $this->db->select('SUM(SettledAmount) as SettledAmount,InvoiceNo')->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('InvoiceNo',$invno)->where('Type=',2)->get()->row();
        return $q;
    }
    public function loadreturninvbyidsales($cuscode,$invno) {
        //SELECT * FROM `creditinvoicedetails` WHERE CusCode=14483 AND InvoiceNo='AWC0080';
        $q = $this->db->select('ReturnNo,ReturnAmount,InvoiceNo')->from('returninvoicehed')->where('CustomerNo',$cuscode)->where('ReturnNo',$invno)->get()->row();
        return $q;
    }
    public function loadsalesinvbyid($cuscode,$invno) {
        //SELECT * FROM `creditinvoicedetails` WHERE CusCode=14483 AND InvoiceNo='AWC0080';
        $q = $this->db->select('SalesInvNo,SalesCashAmount,SalesCreditAmount')->from('salesinvoicehed')->where('SalesCustomer',$cuscode)->where('SalesInvNo',$invno)->get()->row();
        return $q;
    }
/*shalika*/
    /*=========Customer payment===========================================*/
    // public function cus_payment() {
    //     $cus = isset($_GET['cus'])?$_GET['cus']:NULL;

    //     $this->page_title->push(('Customer Payment'));
    //     $this->breadcrumbs->unshift(1, 'Customer Payment', 'admin/payment/customer-payment');
    //     $this->data['pagetitle'] = $this->page_title->show();
    //     $this->data['breadcrumb'] = $this->breadcrumbs->show();
    //     $this->data['location'] = $this->Payment_model->loadlocations();
    //     $this->data['bank_acc']=$this->db->select('bank_account.*,bank.BankName')->from('bank_account')->join('bank','BankCode=acc_bank')->get()->result();

    //       $this->data['total_credit']=$this->db->select('sum(CreditAmount) As CreditAmount')->from('creditinvoicedetails')->where('CusCode',$cus)->where('IsCancel',0)->get()->row()->CreditAmount;
    //     $this->data['total_payment']=$this->db->select('sum(SettledAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cus)->where('IsCancel',0)->where('Type!=',2)->get()->row()->SettledAmount;
    //      $this->data['return_payment']=$this->db->select('sum(returnAmount) As returnAmount')->from('creditinvoicedetails')->where('CusCode',$cus)->where('IsCancel',0)->get()->row()->returnAmount;

    //     $this->data['return_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cus)->where('IsComplete',0)->get()->row()->ReturnAmount;
    //     $this->data['over_return__complete_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cus)->where('PaymentType',3)->where('IsOverReturn',1)->get()->row()->ReturnAmount;
    //     $this->data['over_return__not_complete_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cus)->where('PaymentType',3)->where('IsOverReturn',1)->where('IsComplete',0)->get()->row()->ReturnAmount;
    //     $this->data['selectedSalesperson'] = $this->db->select('SalesPerson')->from('customerpaymenthed')->where('CusCode', $cus)->get()->row()->SalesPerson;
       
    //     // $this->data['total_credit']=$this->db->select('sum(CreditAmount) As CreditAmount')->from('creditinvoicedetails')->where('CusCode',$cus)->where('IsCancel',0)->get()->row()->CreditAmount;
    //     // $this->data['total_payment']=$this->db->select('sum(SettledAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cus)->where('IsCancel',0)->get()->row()->SettledAmount;
    //     // $this->data['return_payment']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('returninvoicehed')->where('CustomerNo',$cuscode)->where('IsCancel',0)->get()->row()->ReturnAmount;
       
        
    //     $this->data['cheque']=$this->db->select('chequedetails.*,bank.BankName,date(chequedetails.ChequeDate) AS ChequeDate,date(chequedetails.ReceivedDate) AS ReceivedDate')->from('chequedetails')->join('bank','bank.BankCode=chequedetails.BankNo')->where('CusCode',$cus)->where('chequedetails.IsCancel',0)->get()->result();

       

    //     $location = $_SESSION['location'];
    //     $id2 = array('IsActive' => '1', 'LocationCode' => $location);
    //     $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);
    //     $this->load->model('admin/Pos_model');
    //     $id3 = array('CompanyID' => $location);
    //     $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
    //     $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
        
    //     $this->template->admin_render('admin/payment/customer-payment', $this->data);
    // }


    public function cus_payment() {
        // Get the customer code from the URL parameter
        $cus = isset($_GET['cus']) ? $_GET['cus'] : NULL;
        $this->data['customer'] = $cus;
        $this->data['RouteId'] = $this->db->get_where('customer',['CusCode' =>$cus])->row()->RouteId;
        
        $this->data['HandelBy'] = $this->db->get_where('customer', ['CusCode' => $cus])->row()->HandelBy;
        
    
        // Set page title and breadcrumbs
        $this->page_title->push(('Customer Payment'));
        $this->breadcrumbs->unshift(1, 'Customer Payment', 'admin/payment/customer-payment');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        // Load necessary data
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['bank_acc'] = $this->db->select('bank_account.*, bank.BankName')
                                           ->from('bank_account')
                                           ->join('bank', 'BankCode = acc_bank')
                                           ->get()
                                           ->result();
    
        // Check if we are editing an existing customer
        if ($cus) {
            // Fetch customer related data for editing
            $this->data['total_credit'] = $this->db->select('SUM(CreditAmount) AS CreditAmount')
                                                    ->from('creditinvoicedetails')
                                                    ->where('CusCode', $cus)
                                                    ->where('IsCancel', 0)
                                                    ->get()
                                                    ->row()->CreditAmount;
    
            $this->data['total_payment'] = $this->db->select('SUM(SettledAmount) AS SettledAmount')
                                                      ->from('creditinvoicedetails')
                                                      ->where('CusCode', $cus)
                                                      ->where('IsCancel', 0)
                                                      ->where('Type !=', 2)
                                                      ->get()
                                                      ->row()->SettledAmount;
    
            $this->data['return_payment'] = $this->db->select('SUM(returnAmount) AS returnAmount')
                                                      ->from('creditinvoicedetails')
                                                      ->where('CusCode', $cus)
                                                      ->where('IsCancel', 0)
                                                      ->get()
                                                      ->row()->returnAmount;
    
            // Fetch additional return payments data
            $this->data['return_payments'] = $this->db->select('SUM(ReturnAmount) AS ReturnAmount')
                                                       ->from('return_payment')
                                                       ->where('CustomerNo', $cus)
                                                       ->where('IsComplete', 0)
                                                       ->get()
                                                       ->row()->ReturnAmount;
    
            $this->data['over_return_complete_payments'] = $this->db->select('SUM(ReturnAmount) AS ReturnAmount')
                                                                      ->from('return_payment')
                                                                      ->where('CustomerNo', $cus)
                                                                      ->where('PaymentType', 3)
                                                                      ->where('IsOverReturn', 1)
                                                                      ->get()
                                                                      ->row()->ReturnAmount;
    
            $this->data['over_return_not_complete_payments'] = $this->db->select('SUM(ReturnAmount) AS ReturnAmount')
                                                                          ->from('return_payment')
                                                                          ->where('CustomerNo', $cus)
                                                                          ->where('PaymentType', 3)
                                                                          ->where('IsOverReturn', 1)
                                                                          ->where('IsComplete', 0)
                                                                          ->get()
                                                                          ->row()->ReturnAmount;
    
            // $this->data['selectedSalesperson'] = $this->db->select('SalesPerson')
            //                                               ->from('customerpaymenthed')
            //                                               ->where('CusCode', $cus)
            //                                               ->get()
            //                                               ->row()->SalesPerson;
            // $this->data['allsalespersonroute'] = $this->db->select('cr.id,cr.name')->from('employeeroutes')
            //                                             ->join('customer_routes cr', 'employeeroutes.route_id = cr.id') 
            //                                             ->where('employeeroutes.emp_id', $this->data['selectedSalesperson'])
            //                                             ->get()
            //                                             ->result();
            // $this->data['allroutecustomer'] = $this->db->select('c.CusCode,c.DisplayName')->from('employeeroutes')
            //                                             ->join('customer_routes cr', 'employeeroutes.route_id = cr.id') 
            //                                             ->join('customer c', 'cr.id = c.RouteId') 
            //                                             ->where('employeeroutes.emp_id', $this->data['selectedSalesperson'])
            //                                             ->get()
            //                                             ->result();
            // $this->data['selectedRoute'] = $this->db->select('RootNo')
            //                                          ->from('customerpaymenthed')
            //                                          ->where('CusCode', $cus)
            //                                          ->get()
            //                                          ->row()->RootNo;
            // $this->data['selectedcus'] = $cus;
    
            // Set the edit flag
            $this->data['is_edit'] = true; // Flag to indicate that we are editing
        } else {
            // Initialize fields for adding a new customer
            $this->data['total_credit'] = 0;
            $this->data['total_payment'] = 0;
            $this->data['return_payment'] = 0;
            $this->data['return_payments'] = 0;
            $this->data['over_return_complete_payments'] = 0;
            $this->data['over_return_not_complete_payments'] = 0;
            $this->data['selectedSalesperson'] = '';
            $this->data['selectedRoute'] = '';
            
            // Set the edit flag
            $this->data['is_edit'] = false; // Flag to indicate new entry
        }
    
        // Load cheque details for the customer
        $this->data['cheque'] = $this->db->select('chequedetails.*, bank.BankName, DATE(chequedetails.ChequeDate) AS ChequeDate, DATE(chequedetails.ReceivedDate) AS ReceivedDate')
                                          ->from('chequedetails')
                                          ->join('bank', 'bank.BankCode = chequedetails.BankNo')
                                          ->where('CusCode', $cus)
                                          ->where('chequedetails.IsCancel', 0)
                                          ->get()
                                          ->result();
    
        // Load salespersons and company data
        $location = $_SESSION['location'];
        $id2 = array('IsActive' => '1', 'LocationCode' => $location);
        $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);
        
        $this->load->model('admin/Pos_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
        $this->data['routes'] = $this->db->select()->from('customer_routes')->get()->result();
          $this->data['allroutecustomer'] = $this->db->select('CusCode,DisplayName')->from('customer')->get()->result();
        // Load the view with the prepared data
       
        $this->template->admin_render('admin/payment/customer-payment', $this->data);
    }
    

    public function findemploeeroute() {
        $salespersonID = $this->input->post('salespersonID');
        $this->load->database();
        $this->db->select('er.route_id, cr.name');
        $this->db->from('employeeroutes er');
        $this->db->join('customer_routes cr', 'er.route_id = cr.id'); 
        $this->db->where('er.emp_id', $salespersonID);
        $query = $this->db->get();
        // $routes = $query->result_array();
        // echo json_encode($routes);
        // exit();
        $routes = [];
        if ($query->num_rows() > 0) {
         
            foreach ($query->result() as $row) {
                $routes[] = [
                    'route_id' => $row->route_id,
                    'route_name' => $row->name 
                ];
            }
    
        
            echo json_encode($routes);
        } else {
         
            echo json_encode([]);
        }
    
   
        exit();
        
    }

    public function loadcustomersroutewise() {
        $routeID = $this->input->post('routeID');
        $newsalesperson = $this->input->post('newsalesperson');
        $this->load->database();


        $customers = $this->db->select('customer.CusCode,customer.DisplayName')
            ->from('customer')
            ->where('RouteId', $routeID)
            ->where('HandelBy',$newsalesperson)
            ->get()
            ->result();

        echo json_encode($customers);
        die;
    }


    /*=========Supplier payment===========================================*/
    public function sup_payment() {
        $this->page_title->push(('Supplier Payment'));
        $this->breadcrumbs->unshift(1, 'Supplier Payment', 'admin/payment/supplier-payment');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $location = $_SESSION['location'];
        $id2 = array('IsActive' => '1', 'LocationCode' => $location);
        $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);
        $this->load->model('admin/Pos_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
        $this->template->admin_render('admin/payment/supplier-payment', $this->data);
    }

    public function job_payment($invno=null) {
        $this->page_title->push(('Job Payment'));
        $this->breadcrumbs->unshift(1, 'Job Payment', 'admin/payment/job-payment');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['invno'] = base64_decode($invno);
        $location = $_SESSION['location'];
        $id2 = array('IsActive' => '1', 'LocationCode' => $location);
        $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);
        $this->data['bank_acc']=$this->db->select('bank_account.*,bank.BankName')->from('bank_account')->join('bank','BankCode=acc_bank')->get()->result();
        $this->data['bank']=$this->db->select()->from('bank')->get()->result();
        $this->load->model('admin/Pos_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
        $this->template->admin_render('admin/payment/job-payment', $this->data);
    }

    public function view_customer($cuscode=null) {
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->page_title->push(('View Customer - '.$cuscode));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/addcustomer');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['invno'] = base64_decode($cuscode);
        $location = $_SESSION['location'];
        $id2 = array('IsActive' => '1', 'LocationCode' => $location);
        $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);

        $this->data['cus_doc'] = $this->db->select()->from('cus_document')->where('job_no',$cuscode)->get()->result();
        $this->data['cus']=$this->db->select('customer.*,salespersons.RepName,payType')->from('customer')->join('salespersons','RepID=HandelBy','left')->join('paytype','payTypeId=payMethod','left')->where('CusCode',$cuscode)->get()->row();
        
        $this->data['credit']=$this->db->select()->from('customeroutstanding')->where('CusCode',$cuscode)->get()->row();
        
        $this->data['credit_inv']=$this->db->select()->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('IsCancel',0)->get()->result();
        $this->data['total_credit']=$this->db->select('sum(CreditAmount) As CreditAmount')->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('IsCancel',0)->get()->row()->CreditAmount;
        $this->data['total_payment']=$this->db->select('sum(SettledAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('IsCancel',0)->where('Type!=',2)->get()->row()->SettledAmount;
        $this->data['return_payment']=$this->db->select('sum(returnAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cuscode)->where('IsCancel',0)->where('Type=',2)->get()->row()->SettledAmount;
        $this->data['total_add_payment']=$this->db->select('sum(TotalPayment) As TotalPayment')->from('customerpaymenthed')->where('CusCode',$cuscode)->where('IsCancel',0)->where('PaymentType!=',1)->get()->row()->TotalPayment;
        $this->data['total_advance_payment']=$this->db->select('sum(customerpaymenthed.TotalPayment) AS TotalPayment')->from('customerpaymenthed')->join('customerpaymentdtl','customerpaymentdtl.CusPayNo=customerpaymenthed.CusPayNo')->where('customerpaymenthed.Location',$location)->where('customerpaymenthed.CusCode',$cuscode)->where('customerpaymenthed.PaymentType',2)->where('customerpaymenthed.IsCancel',0)->where('customerpaymentdtl.IsRelease',0)->like('customerpaymenthed.CusPayNo', $query)->order_by('customerpaymenthed.CusPayNo','DESC')->get()->row()->TotalPayment;
        $this->data['return__complete_payments']=$this->db->select('sum(ReturnAmount) As OverReturnAmount')->from('return_payment')->where('CustomerNo',$cuscode)->where('PaymentType',3)->where('IsOverReturn',1)->get()->row()->OverReturnAmount;
        //will deduct from next bill
//        var_dump($this->data['total_credit'],$this->data['total_payment'],$this->data['return_payment']);die();
         $this->data['return_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cuscode)->where('IsComplete',0)->get()->row()->ReturnAmount;

//         $qr=$this->db->query("SELECT SUM(IFNULL(R.ReturnAmount,0)) As ReturnAmount FROM `creditinvoicedetails` C 
// LEFT JOIN 
// (
// SELECT InvoiceNo,SUM(ReturnAmount) AS ReturnAmount FROM returninvoicehed WHERE IsCancel=0 GROUP BY InvoiceNo
// ) R ON R.InvoiceNo=C.InvoiceNo
// WHERE C.`CusCode` = '$cuscode' AND C.`IsCloseInvoice` =0 AND C.`IsCancel` =0 AND C.`Type` != 2");

//         $row = $qr->row();

//         if (isset($row))
//         {
//                 $return = $row->ReturnAmount;
//         }

//          $this->data['return_payment']= $return;
         
        $this->data['cheque']=$this->db->select('chequedetails.*,bank.BankName,date(chequedetails.ChequeDate) AS ChequeDate,date(chequedetails.ReceivedDate) AS ReceivedDate')->from('chequedetails')->join('bank','bank.BankCode=chequedetails.BankNo')->where('CusCode',$cuscode)->where('chequedetails.IsCancel',0)->get()->result();

        

        $this->data['vehicle']=$this->db->select('vehicledetail.*,make.make,model.model,vehicledetail.Color AS body_color,fuel_type.fuel_type')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->join('fuel_type','fuel_type.fuel_typeid=vehicledetail.FuelType','left')->where('CusCode',$cuscode)->get()->result();
        
        $this->data['pay']=$this->db->select('customerpaymentdtl.*,customerpaymenthed.*')->from('customerpaymentdtl')->join('customerpaymenthed','customerpaymenthed.CusPayNo=customerpaymentdtl.CusPayNo','left')->where('customerpaymenthed.CusCode',$cuscode)->where('customerpaymenthed.IsCancel',0)->get()->result();

        $this->data['payadd']=$this->db->select('customerpaymentdtl.*,customerpaymenthed.*')->from('customerpaymentdtl')->join('customerpaymenthed','customerpaymenthed.CusPayNo=customerpaymentdtl.CusPayNo','left')->where('customerpaymenthed.CusCode',$cuscode)->where('customerpaymenthed.IsCancel',0)->where('customerpaymenthed.PaymentType',2)->get()->result();

        
        $this->data['sale']=$this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*')->from('salesinvoicehed')->join('salesinvoicepaydtl','salesinvoicepaydtl.SalesInvNo=salesinvoicehed.SalesInvNo')->where('salesinvoicehed.SalesCustomer',$cuscode)->where('salesinvoicehed.InvIsCancel',0)->get()->result();

        $this->data['job']=$this->db->select('jobinvoicehed.*')->from('jobinvoicehed')->where('jobinvoicehed.JCustomer',$cuscode)->where('jobinvoicehed.IsCancel',0)->get()->result();

        $this->data['job_card']=$this->db->select('jobcardhed.*')->from('jobcardhed')->where('jobcardhed.JCustomer',$cuscode)->where('jobcardhed.IsCancel',0)->get()->result();

        $this->data['temp_inv']=$this->db->select('tempjobinvoicehed.*')->from('tempjobinvoicehed')->where('JCustomer',$cuscode)->where('IsCancel',0)->where('IsInvoice',0)->get()->result();

        $this->data['job_com']=$this->db->select('jobinvoicehed.*,customer.CusName')->from('jobinvoicehed')->join('customer','JobComCus=CusCode')->where('jobinvoicehed.JobComCus',$cuscode)->where('jobinvoicehed.IsCancel',0)->get()->result();
        
        $this->data['sale_com']=$this->db->select('salesinvoicehed.*,customer.CusName')->from('salesinvoicehed')->join('customer','SalesComCus=CusCode')->where('salesinvoicehed.SalesComCus',$cuscode)->where('salesinvoicehed.InvIsCancel',0)->get()->result();

        $this->data['job_est']=$this->db->select('estimatehed.*,customer.CusName,vehicle_company.VComName')->from('estimatehed')->join('customer','estimatehed.EstCustomer=customer.CusCode')->join('vehicle_company','vehicle_company.VComId=estimatehed.EstInsCompany')->where('estimatehed.EstCustomer',$cuscode)->where('estimatehed.IsCancel',0)->get()->result();
        //customer all estimates-shalika
        $this->data['job_estall']=$this->db->select('estimatehed.*,customer.CusName')->from('estimatehed')->join('customer','estimatehed.EstCustomer=customer.CusCode')->where('estimatehed.EstCustomer',$cuscode)->where('estimatehed.IsCancel',0)->get()->result();
        
        $this->data['easyProduct']=$this->db->select('invoice_hed.*')->from('invoice_hed')->where('invoice_hed.CusCode',$cuscode)->where('invoice_hed.InvType',1)->where('invoice_hed.IsCancel',0)->get()->result();

        $this->data['easyCash']=$this->db->select('invoice_hed.*')->from('invoice_hed')->where('invoice_hed.CusCode',$cuscode)->where('invoice_hed.InvType',2)->where('invoice_hed.IsCancel',0)->get()->result();

        //customer all estimates
        $this->load->model('admin/Pos_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
        $this->template->admin_render('admin/payment/view_customer', $this->data);
    }

    public function cus_upload(){

        $cusCode = $_REQUEST['cusCode'];

        $config['upload_path']          = './upload/cus_doc';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 5000;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $invuser = $_SESSION['user_id'];
        // $filename =  $jobno."_".uniqid();
    
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()){
            $error = array('error' => $this->upload->display_errors());
            echo print_r($error);die;
                // $this->Payment_model->update_max_code('JobNumber');
        }else{
            $data = array('upload_data' => $this->upload->data());
            $invDate =date("Y-m-d H:i:s");
            $doc_name =$this->upload->data('file_name');
            $job_data = array('job_no' => $cusCode,'doc_name' => $doc_name,'upload_by' => $invuser,'upload_date' => $invDate );
            $this->db->insert('cus_document',$job_data);
            // $jobencode = base64_encode($cusCode);
            $this->Payment_model->bincard($cusCode,5,'file updated');//update bincard
        
            redirect('admin/payment/view_customer/'.$cusCode, 'refresh');
            die;
        }
    }
    

    public function customer_statement() {
        
        $cusCode = isset($_GET['CusCode'])?$_GET['CusCode']:0;
        $isall = isset($_GET['isall'])?1:0;
        $enddate = isset($_GET['enddate'])?$_GET['enddate']:0;
        $startdate = isset($_GET['startdate'])?$_GET['startdate']:0;

        $this->page_title->push(('Customer Statement'));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/addcustomer');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        $this->data['title'] = '';

        $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
        $this->data['credit']=$this->db->select()->from('customeroutstanding')->where('CusCode',$cusCode)->get()->row();
        $this->data['titleno'] = '';
        $this->data['balancetxt'] = 'Balance Due';
        $balance=0;
        $this->data['balance'] = "Rs. ".number_format($balance,2);
        $this->load->model('admin/Report_model');
        $today = date("Y-m-d");    
        if($isall==0){
            $enddate = isset($_REQUEST['enddate'])?$_REQUEST['enddate']:$today;
            $startdate = isset($_REQUEST['startdate'])?$_REQUEST['startdate']:$today;
        }else{
            $enddate = '';
            $startdate = '';
        }
        $this->data['startdate'] = $startdate;
        $this->data['enddate'] = $enddate;
        if($enddate!='' || $startdate!=''){
//            if ($enddate == $startdate){
//                $this->data['opbalance']= $this->db->select('OpenOustanding')->from('customeroutstanding')->where('CusCode',$cusCode)->get()->row()->OpenOustanding;
//            $this->data['opbalance']= $this->db->select('SUM(CreditAmount-SettledAmount) AS OpenBalance')->from('creditinvoicedetails')->where('DATE(InvoiceDate)<',$startdate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->OpenBalance;
            $this->data['opbalance']= $this->db->select('SUM(CreditAmount-SettledAmount-returnAmount) AS OpenBalance')->from('creditinvoicedetails')->where('DATE(InvoiceDate)<',$startdate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->OpenBalance;
            $this->data['InvAmount']= $this->db->select('SUM(CreditAmount) AS CreditAmount')->from('creditinvoicedetails')->where('DATE(InvoiceDate)>=',$startdate)->where('DATE(InvoiceDate)<=',$enddate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->CreditAmount;
            $this->data['InvPayment']= $this->db->select('SUM(SettledAmount) AS SettledAmount')->from('creditinvoicedetails')->where('DATE(InvoiceDate)>=',$startdate)->where('DATE(InvoiceDate)<=',$enddate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->SettledAmount;
            $this->data['return_payment']=$this->db->select('SUM(returnAmount) As returnAmount')->from('creditinvoicedetails')->where('DATE(InvoiceDate)>=',$startdate)->where('DATE(InvoiceDate)<=',$enddate)->where('IsCancel',0)->where('Type=',2)->where('CusCode',$cusCode)->get()->row()->returnAmount;
            $this->data['return__complete_payments']=$this->db->select('sum(ReturnAmount) As OverReturnAmount')->from('return_payment')->where('CustomerNo',$cusCode)->where('PaymentType',3)->where('IsOverReturn',1)->get()->row()->OverReturnAmount;
//            $this->data['InvAmount']= $this->db->select('SUM(CreditAmount) AS CreditAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->CreditAmount;
//            $this->data['InvPayment']= $this->db->select('SUM(SettledAmount) AS SettledAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->SettledAmount;
//            $this->data['return_payment']=$this->db->select('SUM(returnAmount) As returnAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('Type=',2)->where('CusCode',$cusCode)->get()->row()->returnAmount;
//            }
//            else {
//            $this->data['opbalance']=0;

////            var_dump($this->data['return_payment'],$this->data['InvPayment']);die();
//            }
        }else{
            $this->data['opbalance']= 0;
            $this->data['InvAmount']= $this->db->select('SUM(CreditAmount) AS CreditAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->CreditAmount;
            $this->data['InvPayment']= $this->db->select('SUM(SettledAmount) AS SettledAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->SettledAmount;
            $this->data['return_payment']=$this->db->select('SUM(returnAmount) As returnAmount')->from('creditinvoicedetails')->where('IsCancel',0)->where('Type=',2)->where('CusCode',$cusCode)->get()->row()->returnAmount;
            $this->data['return__complete_payments']=$this->db->select('sum(ReturnAmount) As OverReturnAmount')->from('return_payment')->where('CustomerNo',$cusCode)->where('PaymentType',3)->where('IsOverReturn',1)->get()->row()->OverReturnAmount;

        }
        $this->data['cr'] = $this->Report_model->customercreditstatement($startdate, $enddate, $location,$isall,$cusCode);
       
        $this->template->admin_render('admin/payment/customer_statement', $this->data);
    }

    public function customer_statement_pdf() {
        
        $cusCode = isset($_GET['CusCode'])?$_GET['CusCode']:0;
        $isall = isset($_GET['isall'])?1:0;
        $enddate = isset($_GET['enddate'])?$_GET['enddate']:0;
        $startdate = isset($_GET['startdate'])?$_GET['startdate']:0;

        $this->page_title->push(('Customer Statement'));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/addcustomer');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        $this->data['title'] = '';

        $this->data['invCus']= $this->db->select('customer.*')->from('customer')->where('customer.CusCode',$cusCode)->get()->row();
        $this->data['credit']=$this->db->select()->from('customeroutstanding')->where('CusCode',$cusCode)->get()->row();
        $this->data['titleno'] = '';
        $this->data['balancetxt'] = 'Balance Due';
        $balance=0;
        $this->data['balance'] = "Rs. ".number_format($balance,2);
        $this->load->model('admin/Report_model');
        $today = date("Y-m-d");    
        if($isall==0){
            $enddate = isset($_REQUEST['enddate'])?$_REQUEST['enddate']:$today;
            $startdate = isset($_REQUEST['startdate'])?$_REQUEST['startdate']:$today;
        }else{
            $enddate = '';
            $startdate = '';
        }
        $this->data['startdate'] = $startdate;
        $this->data['enddate'] = $enddate;
        $this->data['opbalance']= $this->db->select('SUM(CreditAmount-SettledAmount) AS OpenBalance')->from('creditinvoicedetails')->where('DATE(InvoiceDate)<',$startdate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->OpenBalance;
        $this->data['InvAmount']= $this->db->select('SUM(CreditAmount) AS CreditAmount')->from('creditinvoicedetails')->where('DATE(InvoiceDate)>=',$startdate)->where('DATE(InvoiceDate)<=',$enddate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->CreditAmount;
        $this->data['InvPayment']= $this->db->select('SUM(SettledAmount) AS SettledAmount')->from('creditinvoicedetails')->where('DATE(InvoiceDate)>=',$startdate)->where('DATE(InvoiceDate)<=',$enddate)->where('IsCancel',0)->where('CusCode',$cusCode)->get()->row()->SettledAmount;
        $this->data['cr'] = $this->Report_model->customercreditstatement($startdate, $enddate, $location,$isall,$cusCode);
       
         $this->load->helper('file');
            $this->load->helper(array('dompdf'));

           $html = $this->load->view('admin/payment/customer_statement_pdf', $this->data, true);
            // $html = $this->load->view('admin/sales/view-sales-invoice-pdf', $this->data, true);
           
            pdf_create($html, "Statement ".$cusCode, TRUE,'A4');die;
    }

    public function view_supplier($supcode=null) {
        $this->page_title->push(('View Supplier - '.$supcode));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/customer/view_supplier');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['invno'] = base64_decode($supcode);
        $location = $_SESSION['location'];
        $id2 = array('IsActive' => '1', 'LocationCode' => $location);
        $this->data['salePerson'] = $this->Payment_model->get_data_by_where('salespersons', $id2);
        $this->data['cus']=$this->db->select()->from('supplier')->where('SupCode',$supcode)->join('title','title.TitleId=supplier.SupTitle')->get()->row();
        $this->data['credit']=$this->db->select()->from('supplieroustanding')->where('SupCode',$supcode)->get()->row();
        $this->data['credit_inv']=$this->db->select()->from('creditgrndetails')->where('SupCode',$supcode)->get()->result();
        $this->data['cheque']=$this->db->select('chequedetails.*,bank.BankName,date(chequedetails.ChequeDate) AS ChequeDate,date(chequedetails.ReceivedDate) AS ReceivedDate')->from('chequedetails')->join('bank','bank.BankCode=chequedetails.BankNo')->where('CusCode',$supcode)->get()->result();
        
        $this->load->model('admin/Pos_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
        $this->template->admin_render('admin/payment/view_supplier', $this->data);
    }
    
    public function loadbankjson() {
        $query = $_GET['q'];
        echo $this->Payment_model->loadbankjson($query);
        die;
    }

    public function loadcustomersjson() {
        $query = $_GET['q'];
        $routeID = $_REQUEST['RouteId'];
        $salespersonID = $_REQUEST['HandelBy'];
        echo $this->Payment_model->loadcustomersjson($query,$salespersonID, $routeID);
        die;
    }

    public function getCustomersDataById() {
        $cusCode = $_POST['cusCode'];

        $arr['cus_data'] = $this->Payment_model->getCustomersDataById($cusCode);
        $arr['credit_data'] = $this->Payment_model->getCustomersCreditDataById($cusCode);
        $arr['return_data'] = $this->Payment_model->getCustomersReturnDataById($cusCode);
//        $arr['return_payment']=$this->db->select('sum(returnAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cusCode)->where('IsCancel',0)->get()->row()->SettledAmount;
        $arr['return_payment']=$this->db->select('sum(returnAmount) As returnAmount')->from('creditinvoicedetails')->where('CusCode',$cusCode)->where('IsCancel',0)->get()->row()->returnAmount;
        $arr['total_credit']=$this->db->select('sum(CreditAmount) As CreditAmount')->from('creditinvoicedetails')->where('CusCode',$cusCode)->where('IsCancel',0)->get()->row()->CreditAmount;
        $arr['total_payment']=$this->db->select('sum(SettledAmount) As SettledAmount')->from('creditinvoicedetails')->where('CusCode',$cusCode)->where('IsCancel',0)->where('Type!=',2)->get()->row()->SettledAmount;
        $arr['over_return__complete_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cusCode)->where('PaymentType',3)->where('IsOverReturn',1)->get()->row()->ReturnAmount;
        //will deduct next invoice
        $arr['return_payments']=$this->db->select('sum(ReturnAmount) As ReturnAmount')->from('return_payment')->where('CustomerNo',$cusCode)->where('IsComplete',0)->get()->row()->ReturnAmount;
//      var_dump( $arr['credit_data']);die();
        echo json_encode($arr);
        die;
    }


    public function customerPayment() {
        $paymentNo = $this->Payment_model->get_max_code('Customer Payment');
        $cash_amount = 0;
        $card_amount = 0;
        $cheque_amount = 0;
        $location = $_POST['location'];
        $payType = $_POST['payType'];
        $payDate = $_POST['payDate'];
        $payAmount = $_POST['payAmount'];
        $cusCode = $_POST['cusCode'];
        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $bank = $_POST['bank'];
        $outstanding = $_POST['outstanding'];
        $total_settle = $_POST['total_settle'];
        $advance_payment_no = isset($_POST['advance_payment_no'])?$_POST['advance_payment_no']:NULL;
        $bank_acc = isset($_POST['bank_acc'])?$_POST['bank_acc']:NULL;
        $avail_outstand = $outstanding - $total_settle;
        $receiptType = $_POST['receiptType'];
        $route = $_POST['route'];
        $newsalesperson = $_POST['newsalesperson'];

        $payMode = '';
        if ($payType == 1) {
            $chequeReference = '';
            $chequeRecivedDate = '';
            $chequeDate = '';
            $cash_amount = $total_settle;
            $payMode = 'Cash';
        } elseif ($payType == 3) {
            $cheque_amount = $total_settle;
            $payMode = 'Cheque';
        } elseif ($payType == 4) {
            $cash_amount = $total_settle;
            $payMode = 'Return';
        }elseif ($payType == 5) {
            $advance_amount = $total_settle;
            $payMode = 'Advance';
            $chequeReference = $advance_payment_no;
        } elseif ($payType == 7) {
            $bank_amount = $total_settle;
            $payMode = 'Bank';
            $bank = $this->db->select('acc_bank')->from('bank_account')->where('acc_id',$bank_acc)->get()->row()->acc_bank;
            $chequeReference = $bank_acc;
        } 

        $remark = $_POST['remark'];
        $invDate = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];

        $cpHed = array(
            'AppNo' => '1', 'CusPayNo' => $paymentNo, 'PaymentType' => $receiptType, 'CusCode' => $cusCode, 'RootNo' => 0, 'Location' => $location, 'PayDate' => $payDate, 'CashPay' => $cash_amount,
            'ChequePay' => $cheque_amount, 'Remark' => $remark, 'CardPay' => $card_amount, 'TotalPayment' => $total_settle, 'AvailableOustanding' => $avail_outstand, 'CancelUser' => 0, 'SystemUser' => $invUser, 'IsCancel' => 0,
            'RootNo' => $route,'SalesPerson' => $newsalesperson,
        );

        $cpDtl = array(
            'AppNo' => '1', 'CusPayNo' => $paymentNo, 'Mode' => $payMode, 'Location' => $location, 'PayDate' => $payDate, 'PayAmount' => $payAmount,
            'BankNo' => $bank, 'ChequeNo' => $chequeNo, 'ChequeDate' => $chequeDate, 'RecievedDate' => $chequeRecivedDate, 'Reference' => $chequeReference, 'IsReturn' => 0, 'IsRelease' => 0
        );
        
         $chqDtl = array(
            'AppNo' => '1', 'ReceivedDate' => $chequeRecivedDate, 'CusCode' => $cusCode, 'ChequeOwner' => $chequeReference, 'ReferenceNo' => $paymentNo, 'Mode' => 'Cusomer Payment',
            'BankNo' => $bank, 'ChequeNo' => $chequeNo, 'ChequeDate' => $chequeDate,  'ChequeAmount' => $payAmount, 'IsCancel' => 0, 'IsRelease' => 0
        );

        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        $company = $this->data['company']['CompanyName'];
        $res2 = $this->Payment_model->customerPayment($cpHed, $cpDtl, $_POST, $paymentNo,$chqDtl);
        $this->Payment_model->bincard($paymentNo,9,'Created');//update bincard
        
        $return = array(
            'InvNo' => $paymentNo,
            'InvDate' => $invDate
        );

        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
 /*=========Cancel Customer payment===========================================*/
    
    public function cancel_cus_payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */

            $this->page_title->push(('Cancel Customer Payment'));
            $this->breadcrumbs->unshift(1, 'Cancel Customer Payment', 'admin/payment/cancel-cus-payment');
            $this->data['pagetitle'] = $this->page_title->show();
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Grn_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/payment/cancel-cus-payment', $this->data);
        }
    }

    public function cancel_sup_payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */

            $this->page_title->push(('Cancel Supplier Payment'));
            $this->breadcrumbs->unshift(1, 'Cancel Supplier Payment', 'admin/payment/cancel-sup-payment');
            $this->data['pagetitle'] = $this->page_title->show();
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Grn_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/payment/cancel-sup-payment', $this->data);
        }
    }

    public function getActiveCusPayment() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location = $_GET['location'];
            $cus = $_GET['cusCode'];
            $this->Payment_model->getActiveCusPayment('customerpaymenthed', $q, $location, $cus);
            die;
        }
    }

    public function getCusPaymentDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Payment_model->loadCusPaymentById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

    public function cancelCusPayment() {
        

        $location = $_POST['location'];
        $canDate = $_POST['payDate'];
        $paymentNo = $_POST['invNo'];
        $remark = $_POST['remark'];
        $user = $_POST['invUser'];
        $customer = $_POST['cusCode'];
        $PaymentType = $this->db->select('PaymentType')->from('customerpaymenthed')->where('CusPayNo',$paymentNo)->get()->row()->PaymentType;
        $CancelAmount = $this->db->select('TotalPayment')->from('customerpaymenthed')->where('CusPayNo',$paymentNo)->get()->row()->TotalPayment;
        
            $cancelNo = $this->Payment_model->get_max_code('Cancel Cus Payments');
        if($PaymentType==1){
            $res2 = $this->Payment_model->cancelCusPayment($cancelNo, $location, $canDate, $paymentNo, $remark, $user, $customer);
        }else{
             $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $location,
            'CancelDate' => date("Y-m-d H:i:s"),
            'PaymentNo' => $paymentNo,
            'CusCode' => $customer,
            'CancelAmount' => $CancelAmount,
            'CancelRemark' => $remark,
            'CancelUser' => $_SESSION['user_id']);

        $this->db->insert('cancelcustomerpayment', $invCanel);

           $res2 =$this->db->update('customerpaymenthed',array('IsCancel'=>1,'CancelUser'=>$user),array('CusPayNo'=>$paymentNo));
        }

        $return = array('CancelNo' => $cancelNo, 'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

     public function saveJobPayment() {
        
        $location = $_POST['location'];
        $invDate =date("Y-m-d H:i:s");
       // if($_POST['invDate']=='invDate'){
       //     $invDate = date("Y-m-d H:i:s");
       // }elseif(isset($_POST['invDate']) && $_POST['invDate']!=''){
       //     $invDate = $_POST['invDate'].date(" H:i:s");
       // }else{
       //     $invDate =date("Y-m-d H:i:s");
       // }
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);

        $ccAmountArr2 =json_decode($_POST['ccAmount2']);
        $ccTypeArr2 =json_decode($_POST['ccType2']);
        $ccRefArr2 =json_decode($_POST['ccRef2']);
        $ccNameArr2 =json_decode($_POST['ccName2']);
        
        $isComplete =0;
        $invoiceNo=$_POST['invNo'];
        $cashAmount = $_POST['cash_amount'];
        $cardAmount = $_POST['card_amount'];
        $creditAmount = $_POST['credit_amount'];
        $companyAmount = $_POST['company_amount'];
        $chequeAmount = $_POST['cheque_amount'];
        $bankAmount = $_POST['bank_amount'];
        $advanceAmount = $_POST['advance_amount'];
        $advancePayNo = $_POST['advance_payment_no'];
        $cashAmount2 = $_POST['cash_amount2'];
        $cardAmount2 = $_POST['card_amount2'];
        $creditAmount2 = $_POST['credit_amount2'];
        $companyAmount2 = $_POST['company_amount2'];
        $chequeAmount2 = $_POST['cheque_amount2'];
        $customer = $_POST['cusCode'];
        $thirdcusCode = $_POST['thirdcusCode'];
        $payRemark = $_POST['payRemark'];
        $chequeReceiptAmount= $_POST['chequeReceiptAmount'];
        $cardReceiptAmount= $_POST['cardReceiptAmount'];
        $part_invoice_no= $_POST['part_invoice_no'];

        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $bank = $_POST['bank'];
        $bank_acc = $_POST['bank_acc'];

        $commission = $_POST['commission'];
        $com_paidto = $_POST['com_paidto'];

        $chequeNo2 = $_POST['chequeNo2'];
        $chequeReference2 = $_POST['chequeReference2'];
        $chequeRecivedDate2 = $_POST['chequeRecivedDate2'];
        $chequeDate2 = $_POST['chequeDate2'];
        $bank2 = $_POST['bank2'];
        $totalPay=$_POST['final_amount'];
        $jobNo ='';
        if(isset($invoiceNo) && $invoiceNo!=''){
            $insCompany =$this->db->select('JInsCompany')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JInsCompany;
            $jobNo =$this->db->select('JobCardNo')->from('jobinvoicehed')->where('JobInvNo', $invoiceNo)->get()->row()->JobCardNo;
        }

        $customer_payment = $cashAmount+$cardAmount+$chequeAmount+$advanceAmount;
        $customer_payment2 = $cashAmount2+$cardAmount2+$chequeAmount2;

        if($customer_payment2>0 && $cashAmount2>0){
            if(($customer_payment+$customer_payment2+$creditAmount+$creditAmount2)>$totalPay){
                $cashAmount2=$cashAmount2-($customer_payment+$customer_payment2+$creditAmount+$creditAmount2-$totalPay);
            }
        }elseif ($customer_payment>0 && $cashAmount>0) {
            if(($customer_payment+$customer_payment2+$creditAmount+$creditAmount2)>$totalPay){
                $cashAmount=$cashAmount-($customer_payment+$customer_payment2+$creditAmount+$creditAmount2-$totalPay);
            }
        }

        $this->db->trans_start();

        if($customer_payment>=$_POST['final_amount']){$isComplete=1;
            $this->db->update('jobinvoicehed',array('IsCompelte' => 1),array('JobInvNo' => $invoiceNo));
        }

        if($customer_payment>0 || $creditAmount>0){
            $this->db->update('jobinvoicehed',array('IsPayment' => 1),array('JobInvNo' => $invoiceNo));
        }


        if($_POST['total_amount']!=0){
        $disPrent =(100*$_POST['total_discount'])/$_POST['total_amount'];
        }else{
            $disPrent =0;
        }
        
             $invPay = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Cash',
            'JobInvPayAmount'=>$cashAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark);
            $res2=0;

        // insert invoice payment
        if($cashAmount>0){
            $r1= $this->db->insert('jobinvoicepaydtl', $invPay);
            // $res2=$r1;
         }
         
         if($cardAmount>0){
            $cardpaymentNo = $this->Payment_model->get_max_code('Customer Payment');
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);

             for ($k = 0; $k < count($ccNameArr); $k++) {
             $invPay2 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Card',
            'Mode'=>$ccNameArr[$k],
            'Reference'=>$ccRefArr[$k],
            'JobInvPayAmount'=>$ccAmountArr[$k],
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark,
            'ReceiptNo'=>$cardpaymentNo,
            'ReceiptAmount'=>$cardReceiptAmount,
            'PartInvoiceNo'=>$part_invoice_no);
                     
            $r2= $this->db->insert('jobinvoicepaydtl',$invPay2);
             }
             $this->Payment_model->update_max_code('Customer Payment');
         }

         $advancePay = array(
            
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Advance',
            'Mode'=>$invoiceNo,
            'Reference'=>$advancePayNo,
            'JobInvPayAmount'=>$advanceAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark,
            'ReceiptNo'=>$advancePayNo);

        // insert invoice payment
        if($advanceAmount>0){
             $this->db->insert('jobinvoicepaydtl', $advancePay);

             //release advance payment
             $this->db->update('customerpaymentdtl',array('IsRelease'=>1),array('CusPayNo'=>$advancePayNo));

         }

          

        // insert invoice payment
        if($bankAmount>0){
            $bankpaymentNo = $this->Payment_model->get_max_code('Customer Payment');
            $bankPay = array(
            
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Bank',
            'Mode'=>$invoiceNo,
            'Reference'=>$bank_acc,
            'JobInvPayAmount'=>$bankAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark,
            'ReceiptNo'=>$bankpaymentNo);

             $this->db->insert('jobinvoicepaydtl', $bankPay);

         }

         
         if($creditAmount>0){
             $invPay3 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Credit',
            'JobInvPayAmount'=>$creditAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark);
             
             $invCredit = array(
            'AppNo' => '2',
            'InvoiceNo'=>$invoiceNo,
            'InvoiceDate'=>$invDate,
            'Location'=>$location,
            'CusCode'=>$customer,
            'NetAmount'=>$_POST['final_amount'],
            'CreditAmount'=>$creditAmount,
            'SettledAmount'=>0,
            'IsCloseInvoice'=>0,
            'IsCancel'=>0);
             
             $invnetAmount = $_POST['final_amount'];
             
            $r3= $this->db->insert('jobinvoicepaydtl',$invPay3);
             //add credit invoice data
            $r4= $this->db->insert('creditinvoicedetails',$invCredit);
             //update customer outsatnding
             $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$customer','$invnetAmount','$creditAmount')");
             if($r3==1 && $r4 ==1){
                // $res2=1;
            }
         }

         if($companyAmount>0){
             $invPay4 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Company',
            'JobInvPayAmount'=>$companyAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark);
             
             $invCompany = array(
            'AppNo' => '1',
            'ComInvoiceNo'=>$invoiceNo,
            'ComInvoiceDate'=>$invDate,
            'ComLocation'=>$insCompany,
            'ComCusCode'=>$customer,
            'ComNetAmount'=>$_POST['final_amount'],
            'ComCreditAmount'=>$companyAmount,
            'ComSettledAmount'=>0,
            'ComIsCloseInvoice'=>0,
            'ComIsCancel'=>0);
             
             $invnetAmount = $_POST['final_amount'];
             
            $r5= $this->db->insert('jobinvoicepaydtl',$invPay4);
             //add credit invoice data
            $r6= $this->db->insert('jobcompanyinvoicedetails',$invCompany);
             //update customer outsatnding
             //$this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$customer','$invnetAmount','$creditAmount')");
            if($r5==1 && $r6 ==1){
                // $res2=1;
            }
         }

         if($chequeAmount>0){
             $chequepaymentNo = $this->Payment_model->get_max_code('Customer Payment');
             $invPay5 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Cheque',
            'JobInvPayAmount'=>$chequeAmount,
            'InsCompany'=>$customer,
            'PayRemark'=>$payRemark,
            'ReceiptNo'=>$chequepaymentNo,
            'ReceiptAmount'=>$chequeReceiptAmount,
            'PartInvoiceNo'=>$part_invoice_no);

             $invCheque = array(
            'AppNo' => '1',
            'ReceivedDate'=>$chequeRecivedDate,
            'CusCode'=>$customer,
            'ChequeOwner'=>$chequeReference,
            'ReferenceNo'=>$invoiceNo,
            'BankNo'=>$bank,
            'ChequeNo'=>$chequeNo,
            'ChequeDate'=>$chequeDate,
            'ChequeAmount'=>$chequeAmount,
            'Mode'=>'Job Invoice',
            'IsCancel'=>0,
            'IsRelease'=>0);
             
             $invnetAmount = $_POST['final_amount'];
             
            $r7= $this->db->insert('jobinvoicepaydtl',$invPay5);
             //add credit invoice data
            $r8= $this->db->insert('chequedetails',$invCheque);
            if($r7==1 && $r8 ==1){
                // $res2=1;
            }
            $this->Payment_model->update_max_code('Customer Payment');
         }

         //thrid party customer payments
          $invCusPay = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Cash',
            'JobInvPayAmount'=>$cashAmount2,
            'InsCompany'=>$thirdcusCode,
            'PayRemark'=>$payRemark);
        $res2=0;

        // insert invoice payment
        if($cashAmount2>0){
            $r1= $this->db->insert('jobinvoicepaydtl', $invCusPay);
            // $res2=$r1;
         }
         
         if($cardAmount2>0){
            $cardpaymentNo2 = $this->Payment_model->get_max_code('Customer Payment');
            $ccAmountArr2 =json_decode($_POST['ccAmount2']);
            $ccTypeArr2 =json_decode($_POST['ccType2']);
            $ccRefArr2 =json_decode($_POST['ccRef2']);
            $ccNameArr2 =json_decode($_POST['ccName2']);

             for ($k = 0; $k < count($ccNameArr2); $k++) {
             $invCusPay2 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Card',
            'Mode'=>$ccNameArr2[$k],
            'Reference'=>$ccRefArr2[$k],
            'JobInvPayAmount'=>$ccAmountArr2[$k],
            'InsCompany'=>$thirdcusCode,
            'ReceiptNo'=>$chequepaymentNo2);
                     
            $r2= $this->db->insert('jobinvoicepaydtl',$invCusPay2);
             }
             $this->Payment_model->update_max_code('Customer Payment');
         }
         
         if($creditAmount2>0){
             $invCusPay3 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Credit',
            'JobInvPayAmount'=>$creditAmount2,
            'InsCompany'=>$thirdcusCode,
            'PayRemark'=>$payRemark);
             
             $invCredit2 = array(
            'AppNo' => '2',
            'InvoiceNo'=>$invoiceNo,
            'InvoiceDate'=>$invDate,
            'Location'=>$location,
            'CusCode'=>$thirdcusCode,
            'NetAmount'=>$_POST['final_amount'],
            'CreditAmount'=>$creditAmount2,
            'SettledAmount'=>0,
            'IsCloseInvoice'=>0,
            'IsCancel'=>0);
             
             $invnetAmount2 = $_POST['final_amount'];
             
            $r3= $this->db->insert('jobinvoicepaydtl',$invCusPay3);
             //add credit invoice data
            $r4= $this->db->insert('creditinvoicedetails',$invCredit2);
             //update customer outsatnding
             $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$thirdcusCode','$invnetAmount2','$creditAmount2')");
             if($r3==1 && $r4 ==1){
                // $res2=1;
            }
         }

         if($companyAmount>0){
             $invCusPay4 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Company',
            'JobInvPayAmount'=>$companyAmount2,
            'InsCompany'=>$thirdcusCode,
            'PayRemark'=>$payRemark);
             
             $invCompany = array(
            'AppNo' => '1',
            'ComInvoiceNo'=>$invoiceNo,
            'ComInvoiceDate'=>$invDate,
            'ComLocation'=>$insCompany,
            'ComCusCode'=>$customer,
            'ComNetAmount'=>$_POST['final_amount'],
            'ComCreditAmount'=>$companyAmount2,
            'ComSettledAmount'=>0,
            'ComIsCloseInvoice'=>0,
            'ComIsCancel'=>0);
             
             $invnetAmount = $_POST['final_amount'];
             
            $r5= $this->db->insert('jobinvoicepaydtl',$invCusPay4);
             //add credit invoice data
            $r6= $this->db->insert('jobcompanyinvoicedetails',$invCompany);
             //update customer outsatnding
             //$this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$customer','$invnetAmount','$creditAmount')");
            if($r5==1 && $r6 ==1){
                // $res2=1;
            }
         }

         if($chequeAmount2>0){
            $chequepaymentNo2 = $this->Payment_model->get_max_code('Customer Payment');
             $invCusPay5 = array(
            'JobInvNo'=>$invoiceNo,
            'JobInvDate'=>$invDate,
            'JobInvPayType'=>'Cheque',
            'JobInvPayAmount'=>$chequeAmount2,
            'InsCompany'=>$thirdcusCode,
            'PayRemark'=>$payRemark,
            'ReceiptNo'=>$chequepaymentNo2);

             $invCusCheque = array(
            'AppNo' => '1',
            'ReceivedDate'=>$chequeRecivedDate2,
            'CusCode'=>$thirdcusCode,
            'ChequeOwner'=>$chequeReference2,
            'ReferenceNo'=>$invoiceNo,
            'BankNo'=>$bank2,
            'ChequeNo'=>$chequeNo2,
            'ChequeDate'=>$chequeDate2,
            'ChequeAmount'=>$chequeAmount2,
            'Mode'=>'Job Invoice',
            'IsCancel'=>0,
            'IsRelease'=>0);
             
             $invnetAmount2 = $_POST['final_amount'];
             
            $r7= $this->db->insert('jobinvoicepaydtl',$invCusPay5);
             //add credit invoice data
            $r8= $this->db->insert('chequedetails',$invCusCheque);
            if($r7==1 && $r8 ==1){
                // $res2=1;
            }
            $this->Payment_model->update_max_code('Customer Payment');
         }

        $this->db->set('CustomerPayment',$customer_payment);
        $this->db->set('ThirdCustomerPayment',$customer_payment2);
        $this->db->set('JobCashAmount',$cashAmount);
        $this->db->set('JobCreditAmount',$creditAmount);
        $this->db->set('JobCompanyAmount',$companyAmount);
        $this->db->set('JobChequeAmount',$chequeAmount);
        $this->db->set('JobCardAmount',$cardAmount);
        $this->db->set('JobBankAmount',$bankAmount);
        $this->db->set('JobBankAcc',$bank_acc);
        $this->db->set('JobCardAmount',$cardAmount);
        $this->db->set('JobAdvance',$advanceAmount);
        $this->db->set('AdvancePayNo',$advancePayNo);
        $this->db->set('ThirdCashAmount',$cashAmount2);
        $this->db->set('ThirdCreditAmount',$creditAmount2);
        $this->db->set('ThirdChequeAmount',$chequeAmount2);
        $this->db->set('ThirdCardAmount',$cardAmount2);
        $this->db->set('JobComCus',$com_paidto);
        $this->db->set('JobCommsion',$commission);
        $this->db->where('JobInvNo', $invoiceNo);
        $this->db->update('jobinvoicehed');
        if($jobNo!=''){
            $this->db->update('jobcardhed',array('IsCompelte'=>2),array('JobCardNo'=>($jobNo)));
        }
        $this->Payment_model->bincard($invoiceNo,10,'Created');//update bincard
        $this->db->trans_complete();
        $res2= $this->db->trans_status();
        $return = array(
           'InvNo'=>$invoiceNo,
           'InvDate'=>$invDate
        );
       $return['fb']=$res2;
         echo json_encode($return);
        die;
    }

    //supplier payment functions goes here
    public function loadsuppliersjson() {
        $query = $_GET['q'];
        echo $this->Payment_model->loadsuppliersjson($query);
        die;
    }

    public function getSuppliersDataById() {
        $supCode = $_POST['supCode'];
        $arr['sup_data'] = $this->db->select('supplier.*,supplieroustanding.*')->from('supplier')
                        ->where('supplier.SupCode', $supCode)
                        ->join('supplieroustanding', 'supplier.SupCode = supplieroustanding.SupCode')
                        ->get()->row();
        $arr['credit_data'] =$this->db->select('*')->from('creditgrndetails')
                        ->where('creditgrndetails.SupCode', $supCode)
                        ->where('creditgrndetails.IsCloseGRN', 0)
                        ->where('creditgrndetails.IsCancel', 0)
                        ->get()->result();
       
        echo json_encode($arr);
        die;
    }

    public function getActiveSupPayment() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location = $_GET['location'];
            $cus = $_GET['supCode'];
            $this->Payment_model->getActiveSupPayment('supplierpaymenthed', $q, $location, $cus);
            die;
        }
    }

    public function getSupPaymentDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Payment_model->loadSupPaymentById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

    public function supplierPayment() {

        $paymentNo = $this->Payment_model->get_max_code('Supplier Payment');
        $cash_amount = 0;
        $card_amount = 0;
        $cheque_amount = 0;
        $location = $_POST['location'];
        $payType = $_POST['payType'];
        $payDate = $_POST['payDate'];
        $payAmount = $_POST['payAmount'];
        $cusCode = $_POST['SupCode'];
        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $bank = $_POST['bank'];
        $outstanding = $_POST['outstanding'];
        $total_settle = $_POST['total_settle'];
        $avail_outstand = $outstanding - $total_settle;

        $payMode = '';
        if ($payType == 1) {
            $chequeReference = '';
            $chequeRecivedDate = '';
            $chequeDate = '';
            $cash_amount = $total_settle;
            $payMode = 'Cash';
        } elseif ($payType == 3) {
            $cheque_amount = $total_settle;
            $payMode = 'Cheque';
        } elseif ($payType == 4) {
            $cash_amount = $total_settle;
            $payMode = 'Return';
        }

        $remark = $_POST['remark'];
        $invDate = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];

        $cpHed = array(
            'AppNo' => '1', 'SupPayNo' => $paymentNo, 'SupCode' => $cusCode, 'RootNo' => 0, 'Location' => $location, 'PayDate' => $payDate, 'CashPay' => $payAmount,
            'ChequePay' => $cheque_amount, 'Remark' => $remark, 'CardPay' => $card_amount, 'TotalPayment' => $total_settle, 'AvailableOustanding' => $avail_outstand, 'CancelUser' => 0, 'SystemUser' => $invUser, 'IsCancel' => 0
        );

        $cpDtl = array(
            'AppNo' => '1', 'SupPayNo' => $paymentNo, 'Mode' => $payMode, 'Location' => $location, 'PayDate' => $payDate, 'PayAmount' => $payAmount,
            'BankNo' => $bank, 'ChequeNo' => $chequeNo, 'ChequeDate' => $chequeDate, 'RecievedDate' => $chequeRecivedDate, 'Reference' => $chequeReference, 'IsReturn' => 0, 'IsRelease' => 0
        );
        
         $chqDtl = array(
            'AppNo' => '1', 'ReceivedDate' => $chequeRecivedDate, 'CusCode' => $cusCode, 'ChequeOwner' => $chequeReference, 'ReferenceNo' => $paymentNo, 'Mode' => 'Supplier Payment',
            'BankNo' => $bank, 'ChequeNo' => $chequeNo, 'ChequeDate' => $chequeDate,  'ChequeAmount' => $payAmount, 'IsCancel' => 0, 'IsRelease' => 0
        );

        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        $company = $this->data['company']['CompanyName'];
        $res2 = $this->Payment_model->supplierPayment($cpHed, $cpDtl, $_POST, $paymentNo,$chqDtl);
        $this->Payment_model->bincard($paymentNo,12,'Created');//update bincard
        $return = array(
            'InvNo' => $paymentNo,
            'InvDate' => $invDate
        );

        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }


   


    public function cancelSupPayment() {
        $cancelNo = $this->Payment_model->get_max_code('CancelSupPayment');

        $location = $_POST['location'];
        $canDate = $_POST['payDate'];
        $paymentNo = $_POST['invNo'];
        $remark = $_POST['remark'];
        $user = $_POST['invUser'];
        $customer = $_POST['supCode'];
        $this->Payment_model->bincard($paymentNo,12,'Cancelled');//update bincard
        $res2 = $this->Payment_model->cancelSupPayment($cancelNo, $location, $canDate, $paymentNo, $remark, $user, $customer);
        $return = array('CancelNo' => $cancelNo, 'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function getReceiptPaymentById() {
        $invNo = $_POST['payNo'];
        $payType = $_POST['payType'];
        $res['pay'] = $this->db->select('customerpaymentdtl.*,customerpaymenthed.Remark,customer.CusName,customer.LastName,customer.DisplayName,customer.RespectSign,customer.Address01,chequedetails.*,FLOOR(customerpaymentdtl.PayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate,customerpaymentdtl.Mode as PayMethod,customer.CusCode')->from('customerpaymentdtl')->join('customerpaymenthed', 'customerpaymentdtl.CusPayNo = customerpaymenthed.CusPayNo')->join('customer', 'customer.CusCode = customerpaymenthed.CusCode')->join('chequedetails', 'chequedetails.ReferenceNo = customerpaymentdtl.CusPayNo','left')->join('bank', 'customerpaymentdtl.BankNo = bank.BankCode','left')->where('customerpaymenthed.CusPayNo', $invNo)->where('customerpaymentdtl.Mode',$payType)->get()->row();   

        $paymonut=$this->db->select('FLOOR(customerpaymentdtl.PayAmount)  As JobAmount')->from('customerpaymentdtl')->where('customerpaymentdtl.CusPayNo', $invNo)->where('customerpaymentdtl.Mode',$payType)->get()->row()->JobAmount;
//         $res['inv'] =$this->db->select('invoicesettlementdetails.InvNo,jobinvoicehed.JRegNo')->from('invoicesettlementdetails')->join('jobinvoicehed','jobinvoicehed.JobInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get()->row();
         $res['inv'] =$this->db->select('invoicesettlementdetails.InvNo')->from('invoicesettlementdetails')->where('invoicesettlementdetails.PayAmount!=', 0)->where('invoicesettlementdetails.CusPayNo', $invNo)->get()->result();
if($paymonut!=''){
    $res['pay_amount'] = strtoupper($this->Payment_model->convert_number_to_words($paymonut))." ONLY";
}
        
        echo json_encode($res);
        die;
    }


    public function getReceiptPaymentByInvoice() {
        $invNo = $_POST['payNo'];
        $payType = $_POST['payType'];
        $res['pay'] = $this->db->select('jobinvoicepaydtl.*,jobinvoicepaydtl.PayRemark AS Remark,customer.CusName,customer.LastName,customer.DisplayName,customer.RespectSign,customer.Address01,chequedetails.*,FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate,jobinvoicepaydtl.JobInvPayType as PayMethod,customer.CusCode,jobinvoicehed.JRegNo')->from('jobinvoicepaydtl')->join('jobinvoicehed', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo')->join('customer', 'customer.CusCode = jobinvoicehed.JCustomer')->join('chequedetails', 'chequedetails.ReferenceNo = jobinvoicepaydtl.JobInvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('jobinvoicehed.JobInvNo', $invNo)->where('jobinvoicepaydtl.JobInvPayType',$payType)->get()->row();   

        $paymonut=$this->db->select('FLOOR(jobinvoicepaydtl.JobInvPayAmount)  As JobAmount')->from('jobinvoicepaydtl')->where('jobinvoicepaydtl.JobInvNo', $invNo)->where('jobinvoicepaydtl.JobInvPayType',$payType)->get()->row()->JobAmount; 
         // $res['inv'] =$this->db->select('invoicesettlementdetails.InvNo,jobinvoicehed.JRegNo')->from('invoicesettlementdetails')->join('jobinvoicehed','jobinvoicehed.JobInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get()->row(); 
if($paymonut!=''){
    $res['pay_amount'] = strtoupper($this->Payment_model->convert_number_to_words($paymonut))." ONLY";
}
        
        echo json_encode($res);
        die;
    }

    public function view_customer_receipt() {

        $payno = isset($_GET['payNo'])?$_GET['payNo']:NULL;
        $payType = isset($_GET['payType'])?$_GET['payType']:NULL;
        $invNo = base64_decode($payno);
        $this->page_title->push(('Customer Receipt - '.$invNo));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/payment/customer-payment-receipt');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['invno'] =$invNo;

        $location = $_SESSION['location'];

        $this->data['pay'] = $this->db->select('users.first_name, users.last_name,customerpaymentdtl.*,customerpaymenthed.Remark,customer.CusName,customer.DisplayName,customer.RespectSign,customer.Address01,customer.Address02,customer.Address03,chequedetails.*,FLOOR(customerpaymentdtl.PayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate,customerpaymentdtl.Mode as PayMethod,customer.CusCode')->from('customerpaymentdtl')->join('customerpaymenthed', 'customerpaymentdtl.CusPayNo = customerpaymenthed.CusPayNo')->join('customer', 'customer.CusCode = customerpaymenthed.CusCode')->join('chequedetails', 'chequedetails.ReferenceNo = customerpaymentdtl.CusPayNo','left')->join('bank', 'customerpaymentdtl.BankNo = bank.BankCode','left')->join('users', 'customerpaymenthed.SystemUser = users.id','left')->where('customerpaymenthed.CusPayNo', $invNo)->get()->row();   

        $paymonut=$this->db->select('FLOOR(customerpaymentdtl.PayAmount)  As JobAmount')->from('customerpaymentdtl')->where('customerpaymentdtl.CusPayNo', $invNo)->get()->row()->JobAmount; 
        $jobinv = $this->db->select('invoicesettlementdetails.InvNo,jobinvoicehed.JRegNo As vehicle')->from('invoicesettlementdetails')->join('jobinvoicehed','jobinvoicehed.JobInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get(); 
        $isjobinv = $jobinv->num_rows();

        if($isjobinv>0){
            $this->data['inv'] =$jobinv->row();
        }else{
            $this->data['inv'] =null;
        }

        $salesinv = $this->db->select('invoicesettlementdetails.InvNo,salesinvoicehed.SalesVehicle As vehicle')->from('invoicesettlementdetails')->join('salesinvoicehed','salesinvoicehed.SalesInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get(); 
        $issalesinv = $salesinv->num_rows();
        if($issalesinv>0){
            $this->data['inv'] =$salesinv->row();
        }else{
            $this->data['inv'] =null;
        }
        if($paymonut!=''){
            $this->data['pay_amount'] = strtoupper($this->Payment_model->convert_number_to_words($paymonut))." ONLY";
        }

        $this->data['cancel'] = $this->db->select('cancelcustomerpayment.CancelRemark,users.first_name, users.last_name,cancelcustomerpayment.CancelDate')->from('cancelcustomerpayment')->join('users','cancelcustomerpayment.CancelUser=users.id')->where('cancelcustomerpayment.PaymentNo', $invNo)->get()->row(); 
      
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        $this->template->admin_render('admin/payment/customer-payment-receipt', $this->data);
    }

    public function view_customer_receipt_pdf() {

        $payno = isset($_GET['payNo'])?$_GET['payNo']:NULL;
        $payType = isset($_GET['payType'])?$_GET['payType']:NULL;
        $invNo = base64_decode($payno);
        $this->page_title->push(('Customer Receipt - '.$invNo));
        $this->breadcrumbs->unshift(1, 'Customer', 'admin/payment/customer-payment-receipt');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['location'] = $this->Payment_model->loadlocations();
        $this->data['invno'] =$invNo;

        $location = $this->db->select('Location')->from('customerpaymenthed')->where('customerpaymenthed.CusPayNo', $invNo)->get()->row()->Location;

        $this->data['pay'] = $this->db->select('customerpaymentdtl.*,customerpaymenthed.Remark,customer.CusName,customer.DisplayName,customer.RespectSign,customer.Address01,customer.Address02,customer.Address03,chequedetails.*,FLOOR(customerpaymentdtl.PayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate,customerpaymentdtl.Mode as PayMethod,customer.CusCode')->from('customerpaymentdtl')->join('customerpaymenthed', 'customerpaymentdtl.CusPayNo = customerpaymenthed.CusPayNo')->join('customer', 'customer.CusCode = customerpaymenthed.CusCode')->join('chequedetails', 'chequedetails.ReferenceNo = customerpaymentdtl.CusPayNo','left')->join('bank', 'customerpaymentdtl.BankNo = bank.BankCode','left')->where('customerpaymenthed.CusPayNo', $invNo)->get()->row();   

        $paymonut=$this->db->select('FLOOR(customerpaymentdtl.PayAmount)  As JobAmount')->from('customerpaymentdtl')->where('customerpaymentdtl.CusPayNo', $invNo)->get()->row()->JobAmount; 
        $jobinv = $this->db->select('invoicesettlementdetails.InvNo,jobinvoicehed.JRegNo As vehicle')->from('invoicesettlementdetails')->join('jobinvoicehed','jobinvoicehed.JobInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get(); 
        $isjobinv = $jobinv->num_rows();

        if($isjobinv>0){
            $this->data['inv'] =$jobinv->row();
        }else{
            $this->data['inv'] =null;
        }

        $salesinv = $this->db->select('invoicesettlementdetails.InvNo,salesinvoicehed.SalesVehicle As vehicle')->from('invoicesettlementdetails')->join('salesinvoicehed','salesinvoicehed.SalesInvNo=invoicesettlementdetails.InvNo')->where('invoicesettlementdetails.CusPayNo', $invNo)->get(); 
        $issalesinv = $salesinv->num_rows();
        if($issalesinv>0){
            $this->data['inv'] =$salesinv->row();
        }else{
            $this->data['inv'] =null;
        }
        if($paymonut!=''){
            $this->data['pay_amount'] = strtoupper($this->Payment_model->convert_number_to_words($paymonut))." ONLY";
        }

      
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Payment_model->get_data_by_where('company', $id3);
        // $this->template->admin_render('admin/payment/customer-payment-receipt', $this->data);
        $this->load->helper('file');
        $this->load->helper(array('dompdf'));

        // $this->load->view('admin/sales/sales-invoice-pdf', $this->data);
        $html = $this->load->view('admin/payment/customer-payment-receipt-pdf', $this->data, true);
        // echo $html;
        pdf_create($html, $invNo, TRUE,'a4');die;
    }
    
    /*public function cobinvoicedateget(){
    
     $q = $this->db->select('customer.CusCode,customer.JoinDate,customer.BalanceDate,creditinvoicedetails.InvoiceDate,creditinvoicedetails.InvoiceNo,creditinvoicedetails.CusCode AS Credtcusno')
        ->from('customer')->join('creditinvoicedetails','customer.CusCode=creditinvoicedetails.CusCode','left')->like('creditinvoicedetails.InvoiceDate','1900')->or_like('creditinvoicedetails.InvoiceDate','0000')->get()->result();
        
        $nullbalanc=$q;
        var_dump($nullbalanc);
            foreach ($nullbalanc as $valuedt) {
                $cuscd=$valuedt->CusCode;
                $invno=$valuedt->InvoiceNo;
                $invoicedt=$valuedt->InvoiceDate;
                $joindate=$valuedt->JoinDate;

                
                $this->balancedateeupdate($joindate,$cuscd);
                $this->cobinvoicedateupdate($joindate,$invno,$cuscd);

            }

    }
    public function cobinvoicedateupdate($joindate,$invno,$cuscd){
        $data = [
            'InvoiceDate' => $joindate,
        ];
        $this->db->where('InvoiceNo', $invno);
        $this->db->where('CusCode', $cuscd);
        $this->db->update('creditinvoicedetails', $data);
        echo 'successfully been updated';
    }
    public function balancedateeupdate($joindate,$cuscd){
        $data = [
            'BalanceDate' => $joindate,
        ];
        $this->db->where('CusCode', $cuscd);
        $this->db->update('customer', $data);
        echo 'successfully been updated BALANCEDATE';
    }*/

    public function fixReturnInvoice()
    {

        $q = $this->db->select('creditinvoicedetails.*')
            ->from('creditinvoicedetails')
            ->join('invoicesettlementdetails','invoicesettlementdetails.InvNo=creditinvoicedetails.InvoiceNo','inner')
            ->where('creditinvoicedetails.IsCloseInvoice', 1)
            ->where('creditinvoicedetails.SettledAmount ', 0.00)
            ->where('creditinvoicedetails.Type', 1)
            ->not_like('creditinvoicedetails.InvoiceNo','COB')
            ->get()->result();

var_dump( $q);

die();

    }

}
