<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Invoice_model');
        date_default_timezone_set("Asia/Colombo");
        $this->load->library('Datatables');
        $this->load->database();
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
            $this->data['returnTypes'] = $this->db->select()->from('return_types')->get()->result();

            // echo json_encode($this->data['salesperson']);
            // die();
            /* Load Template */
            $this->template->admin_render('admin/invoice/return-invoice', $this->data);
        }
    }

    public function reserve_invoice() {
        if (!$this->ion_auth->logged_in() ) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Received invoice');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Invoice', 'admin/invoice');
            $this->breadcrumbs->unshift(1, 'Add Received invoice', 'admin/invoice/reserve_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['plv'] = $this->Invoice_model->loadpricelevel();
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);
            $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
            $this->data['routes'] = $this->db->select()->from('customer_routes')->get()->result();

            // echo json_encode($this->data['salesperson']);
            // die();
            /* Load Template */
            $this->template->admin_render('admin/invoice/collected-product', $this->data);
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
        $sup= $_REQUEST['nonRt'];
        $inv= $_REQUEST['invNo'];
        $pl=$_REQUEST['price_level'];
        $invType=$_REQUEST['invoiceType'];
        echo $this->Invoice_model->loadproductjson($query,$sup,$inv,$pl,$invType);
        die;
    }

    public function saveReturn() {

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
        $route = 1;
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
        $returninvoice_typeArr = json_decode($_POST['reinvoiceType']);
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
        $res2= $this->Invoice_model->saveReturn($retHed,$invDate);
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

    public function received_invoice($id=null) {
        $action = isset($_GET['action'])?$_GET['action']:1;
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $decoded_id = base64_decode($id);
            $this->data['inv'] =$this->db->select('*')->from('received_invoices')->where('id', $decoded_id)->get()->row();
            $this->data['items']=$this->db->select('received_invoices_items.*')->from('received_invoices')
                                ->join('received_invoices_items','received_invoices.id = received_invoices_items.InvoiceID')
                                ->where('received_invoices.id',$decoded_id)->get()->result();
            // echo var_dump($this->data['items']);die;

            $this->load->helper('url');
            $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');

            $this->load->helper('url');
            $this->page_title->push(('Add Received Invoice'));
            $this->breadcrumbs->unshift(1, 'Received Invoice', 'admin/invoice/received_invoice');
            $this->data['pagetitle'] = $this->page_title->show();
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $location = $_SESSION['location'];
            $this->load->model('admin/Invoice_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);
            $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();

            $this->data['selectedRoute'] = null;
            $selectedRoute = $this->db->select('Route')->from('received_invoices')->where('id', $decoded_id)->get()->row();

            if ($selectedRoute) {
              $this->data['selectedRoute'] = $selectedRoute->Route;
          }

          $invoiceData = $this->db->select('SalespersonID, Route')
                           ->from('received_invoices')
                           ->where('id', $decoded_id)
                           ->get()
                           ->row();

                           if ($invoiceData) {
                               $selectedSalespersonID = $invoiceData->SalespersonID;
                            //    echo var_dump($selectedSalespersonID );die;
                              $this->data['selectedRoute'] = $invoiceData->Route;
                          } else {
                              $selectedSalespersonID = null;
                              $this->data['selectedRoute'] = null;
                          }


                          if ($selectedSalespersonID) {
                              $this->data['routes'] = $this->db->select('cr.id, cr.name')
                                  ->from('employeeroutes er')
                                  ->join('customer_routes cr', 'er.route_id = cr.id')
                                  ->where('er.emp_id', $selectedSalespersonID)
                                  ->get()
                                  ->result();
                          } else {
                              $this->data['routes'] = [];
                          }
            $this->data['customers'] = $this->db->select('c.CusCode, c.DisplayName')
                 ->from('customer c')
                ->where('c.HandelBy', $invoiceData->SalespersonID)
                ->where('c.RouteId',$invoiceData->Route)
                ->get()
                ->result();
                // echo var_dump($this->data['customers']);die;
              $action = isset($_GET['action']) ? $_GET['action'] : 1;
              $this->data['selectedSalespersonID'] =$invoiceData->SalespersonID;
              $this->data['isEditMode'] = ($action == 2);
            $this->template->admin_render('admin/invoice/collected-product', $this->data);
    }

    public function getSalesProductCodes() {
        $query = $_GET['name_startsWith'];
        $this->load->database();
        $this->db->select('SalesProductCode, SalesProductName, SUM(salesinvoicedtl.SalesQty) as TotalSalesQty');
        $this->db->from('salesinvoicedtl');
        $this->db->like('SalesProductCode',$query);
        $this->db->or_like('SalesProductName',$query);
        $this->db->group_by(['SalesProductCode', 'SalesProductName']);
        $result = $this->db->get()->result();

        echo json_encode($result);
        die;


    }


    public function saveReturnDetails() {

        $invoiceNo = $this->input->post('grnNo');
        if (!empty($invoiceNo)) {

            $invDate = $this->input->post('invDate');
            $grnRemark = $this->input->post('grnRemark');
            $location = $this->input->post('location');
            $invUser = $this->input->post('invUser');
            $salesperson = $this->input->post('salesperson');
            $route = $this->input->post('route');
            $customer = $this->input->post('customer');
            $items = $this->input->post('items');


            $this->db->trans_start();


            $invoice = $this->db->select('id')->from('received_invoices')
                ->where('InvoiceNo', $invoiceNo)
                ->get()->result();


            if (!empty($invoice)) {

                $id = (int) $invoice[0]->id;


                $data = [
                    'ReceivedDate' => $invDate,
                    'ReceivedRemark' => $grnRemark,
                    'Location' => $location,
                    'UserID' => $invUser,
                    'SalespersonID' => $salesperson,
                    'Route' => $route,
                    'CustomerID' => $customer,
                    'created_at' => $invDate,
                ];


                $this->db->where('id', $id);
                $this->db->update('received_invoices', $data);

                if (!empty($items)) {
                    foreach ($items as $item) {
                        $ProductCode = $item['productCode'];
                        $ProductName = $item['productName'];
                        $quantity = (int)$item['quantity'];

                        $productExist = $this->db->select('id')
                        ->from('received_invoices_items')
                        ->where('InvoiceID', $id)
                        ->where('ProductCode', $ProductCode)
                        ->where('ProductName', $ProductName)
                        ->get()->row();

                        $item_id = (int) $productExist->id;
                        if ($productExist) {
                            $newQuantity = $quantity;
                            $this->db->where('id',$item_id);
                            $this->db->update('received_invoices_items', ['Quantity' => $newQuantity]);
                        } else {
                            $productData = [
                                'InvoiceID' => $id,
                                'ProductCode' => $ProductCode,
                                'Quantity' => $quantity,
                                'created_at' => $invDate,
                                'ProductName'=>$ProductName,
                            ];

                            $this->db->insert('received_invoices_items', $productData);
                        }
                    }
                }

            } else {
                echo "Invoice not found!";
                die();
            }


            $this->db->trans_complete();


            $res2 = $this->db->trans_status();
            echo $res2 ? '1' : 'Failure'; die();


        }else{

            $invDate = $this->input->post('invDate');
            $grnRemark = $this->input->post('grnRemark');
            $location = $this->input->post('location');
            $invUser = $this->input->post('invUser');
            $salesperson = $this->input->post('salesperson');
            $route = $this->input->post('route');
            $customer = $this->input->post('customer');
            $items = $this->input->post('items');
            if (empty($items)) {
                echo json_encode(['success' => false, 'message' => 'No items to save']);
                return;
            }

            $this->db->trans_start();

            $this->db->select('MAX(CAST(SUBSTRING_INDEX(InvoiceNo, "DINV", -1) AS UNSIGNED)) as last_no');
            $query = $this->db->get('received_invoices');

            $result = $query->row();

            $nextNo = $result ? $result->last_no + 1 : 1;
            $invoiceNo = 'DINV' . str_pad($nextNo, 5, '0', STR_PAD_LEFT);

            $grnData = [
                'InvoiceNo' => $invoiceNo,
                'ReceivedDate' => date('Y-m-d', strtotime($invDate)),
                'ReceivedRemark' => $grnRemark,
                'Location' => $location,
                'UserID' => $invUser,
                'SalespersonID' => $salesperson,
                'Route' => $route,
                'CustomerID' => $customer,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('received_invoices', $grnData);
            $invoiceId = $this->db->insert_id();



            foreach ($items as $item) {
                $itemData = [
                    'InvoiceID' => $invoiceId,
                    'ProductCode' => $item['productCode'],
                    'ProductName' => $item['productName'],
                    'Quantity' => $item['quantity'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->insert('received_invoices_items', $itemData);
            }

            $this->db->trans_complete();

            $res2= $this->db->trans_status();
            echo $res2;die;
        }

    }

    // public function saveReturnDetails() {
    //     $invDate = $this->input->post('invDate');
    //     $grnRemark = $this->input->post('grnRemark');
    //     $location = $this->input->post('location');
    //     $invUser = $this->input->post('invUser');
    //     $salesperson = $this->input->post('salesperson');
    //     $route = $this->input->post('route');
    //     $customer = $this->input->post('customer');
    //     $items = $this->input->post('items');
    //     $invoiceNo = $this->input->post('grnNo');

    //     if (empty($items)) {
    //         echo json_encode(['success' => false, 'message' => 'No items to save']);
    //         return;
    //     }

    //     $this->db->trans_start();

    //     if ($invoiceNo !== NULL) {
    //         $this->db->where('InvoiceNo', $invoiceNo);
    //         $query = $this->db->get('received_invoices');
    //         $invoice = $query->row();

    //         if ($invoice) {
    //             $invoiceId = $invoice->id;

    //             // Update invoice
    //             $this->db->where('id', $invoiceId);
    //             $this->db->update('received_invoices', [
    //                 'ReceivedDate' => date('Y-m-d', strtotime($invDate)),
    //                 'ReceivedRemark' => $grnRemark,
    //                 'Location' => $location,
    //                 'UserID' => $invUser,
    //                 'SalespersonID' => $salesperson,
    //                 'Route' => $route,
    //                 'CustomerID' => $customer,
    //                 'updated_at' => date('Y-m-d H:i:s'),
    //             ]);

    //             foreach ($items as $item) {
    //                 $this->db->where('InvoiceID', $invoiceId);
    //                 $this->db->where('ProductCode', $item['productCode']);
    //                 $existingItem = $this->db->get('received_invoices_items')->row();

    //                 if ($existingItem) {
    //                     $this->db->where('InvoiceID', $invoiceId);
    //                     $this->db->where('ProductCode', $item['productCode']);
    //                     $this->db->update('received_invoices_items', [
    //                         'Quantity' => $item['quantity'],
    //                         'updated_at' => date('Y-m-d H:i:s'),
    //                     ]);
    //                 } else {
    //                     $itemData = [
    //                         'InvoiceID' => $invoiceId,
    //                         'ProductCode' => $item['productCode'],
    //                         'ProductName' => $item['productName'],
    //                         'Quantity' => $item['quantity'],
    //                         'created_at' => date('Y-m-d H:i:s'),
    //                     ];
    //                     $this->db->insert('received_invoices_items', $itemData);
    //                 }
    //             }
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Invoice not found']);
    //             return;
    //         }
    //     } else {
    //         // Create new invoice
    //         $this->db->select('MAX(CAST(SUBSTRING_INDEX(InvoiceNo, "DINV", -1) AS UNSIGNED)) as last_no');
    //         $query = $this->db->get('received_invoices');
    //         $result = $query->row();
    //         $nextNo = $result ? $result->last_no + 1 : 1;
    //         $invoiceNo = 'DINV' . str_pad($nextNo, 5, '0', STR_PAD_LEFT);

    //         $grnData = [
    //             'InvoiceNo' => $invoiceNo,
    //             'ReceivedDate' => date('Y-m-d', strtotime($invDate)),
    //             'ReceivedRemark' => $grnRemark,
    //             'Location' => $location,
    //             'UserID' => $invUser,
    //             'SalespersonID' => $salesperson,
    //             'Route' => $route,
    //             'CustomerID' => $customer,
    //             'created_at' => date('Y-m-d H:i:s'),
    //         ];
    //         $this->db->insert('received_invoices', $grnData);
    //         $invoiceId = $this->db->insert_id();

    //         foreach ($items as $item) {
    //             $itemData = [
    //                 'InvoiceID' => $invoiceId,
    //                 'ProductCode' => $item['productCode'],
    //                 'ProductName' => $item['productName'],
    //                 'Quantity' => $item['quantity'],
    //                 'created_at' => date('Y-m-d H:i:s'),
    //             ];
    //             $this->db->insert('received_invoices_items', $itemData);
    //         }
    //     }

    //     $this->db->trans_complete();
    //     $res2 = $this->db->trans_status();
    //     echo $res2;die;
    // }




    public function all_received_invoice() {
        /* Breadcrumbs */
        $this->load->helper('url');
        $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');

        $this->page_title->push(('All Received Invoice'));
        $this->breadcrumbs->unshift(1, 'Received Invoice', 'admin/invoice/all_received_invoice');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $this->load->model('admin/Invoice_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Invoice_model->get_data_by_where('company', $id3);
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->get()->result();
        $this->template->admin_render('admin/invoice/all-collected-product', $this->data);
    }




    public function loadallreceivedinvoices() {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        // Get date filters from POST
        $startDate = $this->input->post("startDate");
        $endDate   = $this->input->post("endDate");

        // Base query
        $this->db->select('received_invoices.*, customer.DisplayName, SUM(received_invoices_items.Quantity) AS Qty')
            ->from('received_invoices')
            ->join('received_invoices_items', 'received_invoices.id = received_invoices_items.InvoiceID', 'inner')
            ->join('customer', 'received_invoices.CustomerID = customer.CusCode', 'left');

        // Filter by ReceivedDate if dates provided
        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('received_invoices.ReceivedDate >=', $startDate);
            $this->db->where('received_invoices.ReceivedDate <=', $endDate);
        }

        // Group and paginate
        $this->db->group_by('received_invoices.InvoiceNo');
        $this->db->limit($length, $start);

        $query = $this->db->get();
        $data = $query->result();

        // Count with same filters applied
        $this->db->from('received_invoices');
        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('ReceivedDate >=', $startDate);
            $this->db->where('ReceivedDate <=', $endDate);
        }
        $total_records = $this->db->count_all_results();

        $output = [
            "draw" => $draw,
            "recordsTotal" => $total_records,
            "recordsFiltered" => $total_records,
            "data" => $data
        ];

        echo json_encode($output);
        exit;
    }



    // public function view_received_invoice($inv=null) {
    //     $this->load->helper('url');
    //     $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');
    //     $invNo=base64_decode($inv);
    //     /* Title Page */
    //     $id = isset($_GET['id'])?$_GET['id']:NULL;
    //     $this->page_title->push('Received Invoices');
    //     $this->data['pagetitle'] = 'Received Invoices-'.$invNo;
    //     /* Breadcrumbs */
    //     $this->breadcrumbs->unshift(1, 'Job Card', 'admin/invoice/');
    //     $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/invoice/');
    //     $this->data['breadcrumb'] = $this->breadcrumbs->show();
    //     $this->template->admin_render('admin/invoice/view-received-invoice');
    // }

    public function view_received_invoice($inv = null) {
        $this->load->helper('url');
        $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/invoice');
        $this->page_title->push('All Received Invoice');
        $this->breadcrumbs->unshift(2, 'Received Invoice', 'admin/invoice/view_received_invoice');
        $this->data['pagetitle'] = 'Return Invoice - ' . $inv;
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $location = $_SESSION['location'];
        $this->load->model('admin/Invoice_model');

        // Get company info
        $this->data['company'] = $this->Invoice_model->get_data_by_where('company', ['CompanyID' => $location]);

        // Optional Date Filter
        $startDate = $this->input->get('startDate') ?: '2000-01-01';
        $endDate   = $this->input->get('endDate') ?: date('Y-m-d');

        $this->data['startDate'] = $startDate;
        $this->data['endDate'] = $endDate;

        // Get received invoice data
        $this->data['receivedInv'] = $this->db->select('received_invoices.*, customer.DisplayName, SUM(received_invoices_items.Quantity) AS Qty')
            ->from('received_invoices')
            ->join('received_invoices_items', 'received_invoices.id = received_invoices_items.InvoiceID')
            ->join('customer', 'received_invoices.CustomerID = customer.CusCode', 'left')
            ->where('received_invoices.InvoiceNo', $inv)
            ->where('received_invoices.ReceivedDate >=', $startDate)
            ->where('received_invoices.ReceivedDate <=', $endDate)
            ->group_by('received_invoices.id')
            ->get()
            ->result();

        $this->data['invNo'] = $inv;

        // Get invoice header
        $this->data['invHed'] = $this->db->select('*')
            ->from('received_invoices')
            ->where('InvoiceNo', $inv)
            ->get()
            ->row();

        // Get customer
        $cusCodeResult = $this->db->select('CustomerID')
            ->from('received_invoices')
            ->where('InvoiceNo', $inv)
            ->get()
            ->row();
        $cusCode = $cusCodeResult ? $cusCodeResult->CustomerID : null;

        $this->data['invCus'] = $cusCode
            ? $this->db->select('*')->from('customer')->where('CusCode', $cusCode)->get()->row()
            : null;

        // Invoice detail items
        $this->data['invDtlArr'] = $this->Invoice_model->getReceivedDtlbyid($inv);

        $this->template->admin_render('admin/invoice/view-received-invoice', $this->data);
    }

}
