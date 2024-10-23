<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Invoice_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(' Invoice Print');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');
            $this->breadcrumbs->unshift(1, ' Invoice Print', 'admin/invoice/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/invoice/index', $this->data);
        }
    }

    public function cancel_invoice() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_invoice_cancel'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');
            $this->breadcrumbs->unshift(1, 'Cancel invoice', 'admin/invoice/cancel_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/invoice/cancel-invoice', $this->data);
        }
    }
    
    public function print_invoice() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_invoice_cancel'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');
            $this->breadcrumbs->unshift(1, 'Cancel invoice', 'admin/invoice/print_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/invoice/print_invoice', $this->data);
        }
    }

    public function getActiveInvoice() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $this->Invoice_model->getActiveInvoies('invoicehed', $q,$location);
            die;
        }
    }
    
    public function getActiveInvoiesByCustomer() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $customer  = $_GET['cusCode'];
            $this->Invoice_model->getActiveInvoiesByCustomer('invoicehed', $q,$location,$customer);
            die;
        }
    }

    public function getInvoiceDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Invoice_model->loadInvoiceById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

    public function cancelInvoice() {
        $cancelNo = $this->Invoice_model->get_max_code('CancelInvoice');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_POST['location'],
            'CancelDate' => $_POST['payDate'],
            'InvoiceNo' => $_POST['invNo'],
            'Remark' => $_POST['remark'],
            'CancelUser' => $_POST['invUser']);
        $res2 = $this->Invoice_model->cancelInvoice($invCanel);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    /*=============return invoice=========================================================================*/
    public function return_invoice() {
        if (!$this->ion_auth->logged_in() ) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Return invoice');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Invoice', 'admin/invoice');
            $this->breadcrumbs->unshift(1, 'Return invoice', 'admin/invoice/return_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
             $this->data['plv'] = $this->Invoice_model->loadpricelevel();
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);
            $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
            // echo json_encode($this->data['salesperson']);
            // die();
            /* Load Template */
            $this->template->admin_render('admin/invoice/return-invoice', $this->data);
        }
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
    
    public function loadcustomersjson() {
        $query = $_GET['q'];
        echo $this->Invoice_model->loadcustomersjson($query);
        die;
    }

    public function getCustomersDataById() {
        $cusCode = $_POST['cusCode'];
        $arr['cus_data'] = $this->Invoice_model->getCustomersDataById($cusCode);
        $arr['credit_data'] = $this->Invoice_model->getCustomersCreditDataById($cusCode);
        echo json_encode($arr);
        die;
    }
    
   public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['nonRt'];$inv= $_REQUEST['invNo'];$pl=$_REQUEST['price_level'];$invType=$_REQUEST['invoiceType'];
        echo $this->Invoice_model->loadproductjson($query,$sup,$inv,$pl,$invType);
        die;
    }
    
    public function saveReturn() {
        $barcode = 1;
        
        $grnNo = $this->Invoice_model->get_max_code('Invoice Return');
        $invNo = $_POST['invoicenumber'];
        $invType = $_POST['invType'];
        $remark = $_POST['remark'];
        $invDate = $_POST['invDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $route = $_POST['route'];
        $newsalesperson = $_POST['newsalesperson'];
        $location = $_POST['location'];
        $supplier =$_POST['cuscode'];
        $isComplete=0;
        $totalGrnDiscount = $_POST['totalGrnDiscount'];
        $totalProDiscount = $_POST['totalProDiscount'];
        if($total_amount>0){
            $totalDisPerent = ($totalGrnDiscount*100)/($total_amount-$totalProDiscount);
        }else{
            $totalDisPerent = 0;
        }
        
        
        $product_codeArr = json_decode($_POST['product_code']);
        $unitArr = json_decode($_POST['unit_type']);
        $freeQtyArr = json_decode($_POST['freeQty']);
        $serial_noArr = json_decode($_POST['serial_no']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['unit_price']);
        $cost_priceArr = json_decode($_POST['cost_price']);
        $pro_discountArr = json_decode($_POST['pro_discount']);
        $pro_discount_precentArr = json_decode($_POST['discount_precent']);
        $caseCostArr = json_decode($_POST['case_cost']);
        $upcArr = json_decode($_POST['upc']);
        $total_netArr = json_decode($_POST['total_net']);
        $price_levelArr = json_decode($_POST['price_level']);
        $totalAmountArr = json_decode($_POST['pro_total']);
        $pro_nameArr = json_decode($_POST['proName']);
        $invDate = date("Y-m-d H:i:s");
        
        $retHed = array(
            'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' =>$route,'SalesPerson'=>$newsalesperson,
            'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supplier,'Remark' => $remark,'ReturnAmount' => $total_amount,'ReturnUser' => $invUser,'IsComplete' => $isComplete,'IsCancel'=>0
        );

        $retPay = array(
            'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' =>$route,
            'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supplier,'Remark' => $remark,'ReturnAmount' => $total_amount,'ReturnUser' => $invUser
        );
        
        $nonRet = array(
            'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => $grnDattime,'InvCount'=> 1,
            'InvoiceNo' => $invNo,'CustomerNo' => $supplier,'Remark' => $remark,'ReturnAmount' => $total_amount,'ReturnUser' => $invUser,'IsComplete' => $isComplete,'IsCancel'=>0
        );
    
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Invoice_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Invoice_model->saveReturn($retHed,$retPay,$_POST,$grnNo,$totalDisPerent,$nonRet,$invDate);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );

//        var_dump($res2);die();
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

     public function loadinvoicejsonbytype() {
        $query = $_GET['q'];
        $invoiceType = $_GET['invoiceType'];
        $location = $_SESSION['location'];
        $cusCode =  $_GET['cusCode'];
        // echo $cusCode;
        if($cusCode!='0'){
            if($invoiceType==1){
                $q = $this->db->query("SELECT `SalesInvNo` AS `id`, `SalesInvNo` AS `text` FROM `salesinvoicehed` WHERE `salesinvoicehed`.`SalesCustomer` ='$cusCode' AND `SalesLocation` = $location AND `InvIsCancel` =0 AND  `SalesInvNo` LIKE '%".$query."%' ORDER BY `SalesInvNo` DESC")->result();
            }elseif($invoiceType==2){
                $q = $this->db->query("SELECT `JobInvNo` AS `id`, `JobInvNo` AS `text` FROM `jobinvoicehed` WHERE `IsCancel` =0 AND `JCustomer` ='$cusCode' AND  `JobInvNo` LIKE '%".$query."%'  ORDER BY `JobInvNo` DESC")->result();
            }
        }else{
            if($invoiceType==1){
                $q = $this->db->query("SELECT `SalesInvNo` AS `id`, `SalesInvNo` AS `text` FROM `salesinvoicehed` WHERE `SalesLocation` = $location AND `InvIsCancel` =0  AND `SalesInvNo` LIKE '%".$query."%'  ORDER BY `SalesInvNo` DESC")->result();
            }elseif($invoiceType==2){
               $q = $this->db->query("SELECT `JobInvNo` AS `id`, `JobInvNo` AS `text` FROM `jobinvoicehed` WHERE `IsCancel` =0 AND  `JobInvNo` LIKE '%".$query."%'  ORDER BY `JobInvNo` DESC")->result();
            }
        }
        
        
        echo json_encode($q);die;
    }

    public function all_returns() {
        
            /* Title Page */
            $this->page_title->push('Returns');
            $this->data['pagetitle'] = 'All Returns';

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Returns', 'admin/invoice/all_returns');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->template->admin_render('admin/invoice/all-return', $this->data);
    }

    public function view_return($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */
// echo $invNo;die;
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Return Invoice');
            $this->data['pagetitle'] = 'Return Invoice -'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Invoice', 'admin/invoice/');
            $this->breadcrumbs->unshift(1, 'Return Invoice', 'admin/invoice/view_return');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);
            
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['invHed']= $this->db->select('returninvoicehed.*')
                ->from('returninvoicehed')
                ->where('ReturnNo',$invNo)->get()->row();

            $cusCode =  $this->db->select('CustomerNo')->from('returninvoicehed')->where('ReturnNo',$invNo)->get()->row()->CustomerNo;
                
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->where('customer.CusCode',$cusCode)->get()->row();

             $this->data['invDtl']=$this->db->select('returninvoicedtl.*,product.*')->from('returninvoicedtl')->join('product', 'returninvoicedtl.ProductCode = product.ProductCode', 'INNER')->where('returninvoicedtl.ReturnNo', $invNo)->get()->result();

             $this->data['invDtlArr']=$this->Invoice_model->getReturnDtlbyid($invNo);
                   
            $this->template->admin_render('admin/invoice/view-return', $this->data);
    }

    public function loadallreturns() {
$this->load->library('Datatables');
        $this->datatables->select('returninvoicehed.*');
        $this->datatables->from('returninvoicehed');
        echo $this->datatables->generate();
        die();
    }

    public function loadholdinvoicejson() {
        $query = $_REQUEST['q'];
        $q = $this->db->select('InvNo AS id,InvNo AS text,InvJobCardNo AS jobno')->from('invoicehed')->like('InvNo', $query)->where('InvHold',1)->order_by('InvNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function getPosInvoiceDataByInvNo(){
        $invoiceNo = $_REQUEST['invNo'];
        $this->load->model('admin/Job_model');

        if($invoiceNo!='' && isset($invoiceNo)){
            $cusCode = $this->db->select('InvCustomer')->from('invoicehed')->where('InvNo', $invoiceNo)->get()->row()->InvCustomer;

            $isInvoice = $this->db->select('InvNo')->from('invoicehed')->where('InvNo', $invoiceNo)->get()->num_rows();
            if($isInvoice>0){
                $jobNo =$this->db->select('InvJobCardNo')->from('invoicehed')->where('InvNo', $invoiceNo)->get()->row()->InvJobCardNo;
                $arr['inv_hed'] = $this->db->select('invoicehed.*')->from('invoicehed')->where('InvNo', $invoiceNo)->get()->row();
                $arr['inv_dtl'] = $this->db->select('invoicedtl.*,product.*')->from('invoicedtl')->join('product', 'product.ProductCode = invoicedtl.InvProductCode')->where('invoicedtl.InvNo', $invoiceNo)->order_by('InvLineNo')->get()->result();
            }else{
                $arr['inv_dtl'] =null;
                $arr['inv_hed']=null;
            }
            
            $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
           
            if($jobNo!=''){
                $regNo =$this->db->select('JRegNo')->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row()->JRegNo;
                $arr['job_data'] = $this->db->select()->from('jobcardhed')->where('JobCardNo', $jobNo)->get()->row();
                $arr['job_desc'] = $this->db->select()->from('jobcarddtl')->where('JobCardNo', $jobNo)->get()->result();
                $arr['vehicle_data'] = $this->Job_model->getVehicleDataById($regNo);
            }else{
                $arr['job_data'] =null;
                $arr['job_desc'] =null;
                $arr['vehicle_data'] =null;
            }
        }
        echo json_encode($arr);
        die;
    }
}
