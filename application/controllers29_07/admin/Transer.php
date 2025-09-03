<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transer extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Transer_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function stock_out() {
        $this->page_title->push(('Stock Transer Out'));
        $this->breadcrumbs->unshift(1, 'Stock Transer Out', 'admin/traser/stock_out');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Transer_model->loadpricelevel();
        $this->data['location'] = $this->Transer_model->loadlocations();
        $this->template->admin_render('admin/transer/stock_out', $this->data);
    }

    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Transer_model->loadsupplierjson($query);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['sup'];$supCode= $_REQUEST['supcode'];
        echo $this->Transer_model->loadproductjson($query,$sup,$supCode);
        die;
    }
    
    public function loadproductSerial() {
        $q = $_GET['q'];
        $product= $_REQUEST['proCode'];$location= $_REQUEST['location'];
        echo $this->Transer_model->loadproductSerial($product, $q, $location);
        die;
    }
    
    public function saveStockOut() {
        $barcode = 1;
//        var_dump($_POST);die;
//        $this->load->model('admin/Transer_model');
        $grnNo = $this->Transer_model->get_max_code('Transfer Out');
        $remark = $_POST['grnremark'];
        $invDate = $_POST['grnDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $location_to = $_POST['location_to'];
        $location_from = $_POST['location_from'];
        $isComplete=0;
        $totalGrnDiscount = $_POST['totalGrnDiscount'];
        $totalProDiscount = $_POST['totalProDiscount'];
        
        $totalDisPerent = ($totalGrnDiscount*100)/($total_amount-$totalProDiscount);
        
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
        
        $grnHed = array(
            'AppNo' => '1','TrnsNo' => $grnNo,'FromLocation'=>$location_from,'ToLocation'=>$location_to,'Location' => $location,'TrnsDate' => $invDate,'TransDateORG' => $grnDattime,
            'TransIsInProcess' => 1,'Remark' => $remark,'TransInDate' => $grnDattime,
            'CostAmount' => $total_amount,'TransInUser' => '-','TransInRemark' => '-',
            'TransUser' => $invUser,'Flag' => 0,'IsCancel'=>0
        );
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Transer_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Transer_model->saveStockOut($grnHed,$_POST,$grnNo);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    
    
    //Stock In page route
    public function stock_in() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(('Stock Transfer In'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Transfer', 'admin/transer');
            $this->breadcrumbs->unshift(1, 'Stock Transfer In', 'admin/transer/stock_in');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Transer_model');
            $this->data['location'] = $this->Transer_model->loadlocations();
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Transer_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/transer/stock_in', $this->data);
        }
    }
    
    public function getActiveSTOut() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location_to  = $_GET['location_to'];
            $location_from  = $_GET['location_from'];
            $this->Transer_model->getActiveSTOut('stocktransferhed', $q,$location_to,$location_from);
            die;
        }
    }

    public function getSTOutDataById() {
        $invNo = $_POST['transNo'];
        $this->data['invoice_data'] = $this->Transer_model->loadSTOutById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

     public function saveSTIn() {
//        $cancelNo = $this->Transer_model->get_max_code('CancelGRN');
        $location_to = $_POST['location_to'];
        $location_from = $_POST['location_from'];
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
//        $supplier=$_POST['supCode'];
        
        $res2 = $this->Transer_model->saveSTIn($location_to,$location_from,$canDate,$grnNo,$remark,$user);
        $return = array('CancelNo' => '','InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
 
    //Stock In page route
    public function cancel_transer() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(('Cancel Stock Transfer'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Transfer', 'admin/transer');
            $this->breadcrumbs->unshift(1, 'Cancel Stock Transfer ', 'admin/transer/cancel_transer');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Transer_model');
            $this->data['location'] = $this->Transer_model->loadlocations();
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Transer_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/transer/cancel_transer', $this->data);
        }
    }
    
    public function cancelTranser() {
       $cancelNo = $this->Transer_model->get_max_code('Transfer Cancel');
        $location_to = $_POST['location_to'];
        $location_from = $_POST['location_from'];
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
        
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_POST['location'],
            'CancelDate' => $_POST['payDate'],
            'TRNNo' => $_POST['invNo'],
            'Remark' => $_POST['remark'],
            'CancelUser' => $_POST['invUser']);
        
        $res2 = $this->Transer_model->cancelTranser($location_to,$location_from,$canDate,$grnNo,$remark,$user,$invCanel);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
}
