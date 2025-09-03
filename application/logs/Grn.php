<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grn extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Grn_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function barcodeprint() {
        $this->page_title->push(('Barcode print'));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Grn', 'admin/grn');
        $this->breadcrumbs->unshift(1, 'Barcode print', 'admin/grn/barcode_print');
        
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Grn_model->loadpricelevel();
        $this->data['location'] = $this->Grn_model->loadlocations();
        $this->template->admin_render('admin/grn/barcode_print', $this->data);
    }
    
    public function addgrn() {
        $this->load->helper('url'); 
        $this->page_title->push(('Add Good Received Note'));
        $this->breadcrumbs->unshift(1, 'Add GRN', 'admin/grn');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Grn_model->loadpricelevel();
        $this->data['location'] = $this->Grn_model->loadlocations();
        $people = array("1", "10", "13");
        
        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/grn/add_grn', $this->data);
        }else{
           redirect('admin/dashboard'); 
        }
    }

    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Grn_model->loadsupplierjson($query);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['sup'];$supCode= $_REQUEST['supcode'];
        echo $this->Grn_model->loadproductjson($query,$sup,$supCode);
        die;
    }
    
    public function saveGrn() {
        $barcode = 1;
//        var_dump($_POST);die;
//        $this->load->model('admin/Grn_model');
        $grnNo = $this->Grn_model->get_max_code('Goods Received Note');
        $invNo = $_POST['invoicenumber'];
        $addCharge = $_POST['additional'];
        $remark = $_POST['grnremark'];
        $invDate = $_POST['grnDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $supplier =$_POST['supcode'];
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
            'AppNo' => '1','GRN_No' => $grnNo,'GRN_PONo'=>'','GRN_Location' => $location,'GRN_Date' => $invDate,'GRN_DateORG' => $grnDattime,
            'GRN_InvoiceNo' => $invNo,'GRN_SupCode' => $supplier,'GRN_Remark' => $remark,'GRN_AdditionalCharges' => $addCharge,
            'GRN_Amount' => $total_amount,'GRN_NetAmount' => $total_net_amount,'GRN_DueAmount' => 0,'GRN_ReturnAmount' => 0,
            'GRN_DisAmount' => $total_discount,'GRN_DisPersantage' => $totalDisPerent,'GRN_User' => $invUser,'GRN_IsComplete' => $isComplete,'GRN_IsCancel'=>0
        );
        $grnCredit = array(
            'AppNo' => '1','GRNNo' => $grnNo,'Location' => $location,'GRNDate' => $invDate,'SupCode' => $supplier,'CreditAmount' => $total_net_amount,'NetAmount' => $total_net_amount,'IsCloseGRN' => 0,'SettledAmount' => 0,'IsCancel'=>0
        );
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Grn_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Grn_model->saveGrn($grnHed,$_POST,$grnNo,$totalDisPerent,$grnCredit);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        //auto generate barcode
        if($barcode==1 && $res2==1){
            $this->load->helper('file');
            $this->load->helper('download');
//            $company = 'VCOM';
            $data = "Company,ProductCode,ProductName,Price\n";
             for ($i = 0; $i < count($product_codeArr); $i++) {
                 $totlQty=$qtyArr[$i]+$freeQtyArr[$i];
                 $price = number_format($sell_priceArr[$i], 0, '.', '');
                 for ($j = 0; $j < $totlQty; $j++) {
                     $data.="\r\n"."$company,$product_codeArr[$i],$pro_nameArr[$i],$price";
                 }
             }
             $filePath = APPPATH."/views/admin/grn/barcode".$location.".txt";
            if ( ! write_file($filePath, $data))
            {
                   $return['grnFile'] = 0;
            }
            else
            {$return['grnFile'] = 1;
                
            }
        }elseif($barcode==0){
            
        }
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    public function barcodeGen(){
        $location = $_POST['location'];
        $product_codeArr = json_decode($_POST['product_code']);
        $pro_nameArr = json_decode($_POST['proName']);
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
        $this->load->helper('file');
        $this->load->helper('download');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Grn_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $data = "Company,ProductCode,ProductName,Price\n";
         for ($i = 0; $i < count($product_codeArr); $i++) {
             $totlQty=$qtyArr[$i]+$freeQtyArr[$i];
             $price = number_format($sell_priceArr[$i], 0, '.', '');
             for ($j = 0; $j < $totlQty; $j++) {
                 $data.="\r\n"."$company,$product_codeArr[$i],$pro_nameArr[$i],$price";
             }
         }
         $filePath = APPPATH."/views/admin/grn/barcode".$location.".txt";
        if ( ! write_file($filePath, $data))
        {
                echo 'Unable to write the file';
        }
        else
        {
            $return = array('fb' => 1,'fileData'=>$data );
            echo json_encode($return);
        }
        die;
    }
    
    public function downloadBarCode ()
    {
            $this->load->helper('download');
            $filePath = APPPATH."/views/admin/grn/barcode".$_SESSION['location'].".txt";
		//set the textfile's content 
		$data = file_get_contents($filePath);
		//set the textfile's name
		$name = 'barcode.txt';
		//use this function to force the session/browser to download the created file
		force_download($name, $data);   
    }
    
    public function barcodeGenerate2(){
        $location = $_POST['location'];
        $product_codeArr = json_decode($_POST['product_code']);
        $pro_nameArr = json_decode($_POST['proName']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['unit_price']);
        
        $this->load->helper('file');
        $this->load->helper('download');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Grn_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $data = "Company,ProductCode,ProductName,Price\n";
         for ($i = 0; $i < count($product_codeArr); $i++) {
             $totlQty=$qtyArr[$i];
             $price = number_format($sell_priceArr[$i], 0, '.', '');
             for ($j = 0; $j < $totlQty; $j++) {
                 $data.="\r\n"."$company,$product_codeArr[$i],$pro_nameArr[$i],$price";
             }
         }
         $filePath = APPPATH."/views/admin/grn/barcode".$location.".txt";
        if ( ! write_file($filePath, $data))
        {
                echo 'Unable to write the file';
        }
        else
        {
            $return = array('fb' => 1,'fileData'=>$data );
            echo json_encode($return);
        }
        die;
    }
    
    //cancel page route
    public function cancel_grn() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(('Cancel Grn'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Grn', 'admin/grn');
            $this->breadcrumbs->unshift(1, 'Cancel Grn', 'admin/grn/cancel_grn');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Grn_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Grn_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/grn/cancel-grn', $this->data);
        }
    }
    
    public function getActiveGRN() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $this->Grn_model->getActiveGrns('goodsreceivenotehed', $q,$location);
            die;
        }
    }

    public function getGRNDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Grn_model->loadGrnById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

     public function cancelGRN() {
        $cancelNo = $this->Grn_model->get_max_code('CancelGRN');
        
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
        $supplier=$_POST['supCode'];
        
        $res2 = $this->Grn_model->cancelGRN($cancelNo,$location,$canDate,$grnNo,$remark,$user,$supplier);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
}
