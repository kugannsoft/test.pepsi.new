<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Purchase_model');
        date_default_timezone_set("Asia/Colombo");
        $this->load->library('Datatables');
    }

    public function index() {
        
    }

    public function all_po() {
        $this->page_title->push(('All Purchase Order'));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase');
        $this->breadcrumbs->unshift(1, 'All PO', 'admin/purchase/all-po');
        
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->template->admin_render('admin/purchase/all-po', $this->data);
    }
    
    public function view_po($gno=null) {
        $grnNo=base64_decode($gno);
        $this->page_title->push(('Purchase Order of '. $grnNo));
        
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase/all_po');
        $this->breadcrumbs->unshift(1,  $grnNo, 'admin/purchase/view-po');
        
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
         $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);

        $this->data['po'] = $this->Purchase_model->loadPoById($grnNo);
         $this->data['po_hed'] = $this->db->select('purchaseorderhed.*,supplier.*,users.first_name')->from('purchaseorderhed')->join('users','purchaseorderhed.PO_User=users.id','left')->join('supplier', 'supplier.SupCode = purchaseorderhed.SupCode')->where('purchaseorderhed.PO_No', $grnNo)
       ->get()->row();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->template->admin_render('admin/purchase/view-po', $this->data);
    }

    public function all_prn() {
        $this->page_title->push(('Purchase Return Note'));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase');
        $this->breadcrumbs->unshift(1, 'All PRN', 'admin/purchase/all-prn');
        
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->template->admin_render('admin/purchase/all-prn', $this->data);
    }
    
    public function view_prn($pno=null) {
        $prnNo=base64_decode($pno);
        $this->page_title->push(('Purchase Return Note of '. $prnNo));
        
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase/all_prn');
        $this->breadcrumbs->unshift(1,  $prnNo, 'admin/purchase/view-prn');
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);
        
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['prn'] = $this->Purchase_model->loadPrnById($prnNo);
         $this->data['prn_hed'] = $this->db->select('purchasereturnnotehed.*,supplier.*,goodsreceivenotehed.GRN_InvoiceNo')->from('purchasereturnnotehed')->where('purchasereturnnotehed.PRN_No', $prnNo)
       ->join('supplier', 'supplier.SupCode = purchasereturnnotehed.PRN_SupCode')
       ->join('goodsreceivenotehed', 'goodsreceivenotehed.GRN_No = purchasereturnnotehed.GRN_No','left')->get()->row();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->template->admin_render('admin/purchase/view-prn', $this->data);
    }

    public function addpo() {
        $po = isset($_GET['po'])?$_GET['po']:NULL;
        $jobno = isset($_GET['job'])?$_GET['job']:NULL;
        $pono =base64_decode($po);
        $jobno =base64_decode($jobno);
        $this->load->helper('url'); 
        $this->page_title->push(('Add Purchase Order'));
        $this->breadcrumbs->unshift(1, 'Add Purchase Order', 'admin/purchase');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['po_no'] = $pono;
        $this->data['jobno'] = $jobno;
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->data['sup'] = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->get()->result();
        $people = array("1", "3", "13");
        
        // if (in_array($_SESSION['user_id'], $people)) {
        $this->template->admin_render('admin/purchase/add_po', $this->data);
        // }else{
        //    redirect('admin/dashboard'); 
        // }
    }

    public function addprn() {
        $this->load->helper('url'); 
        $this->page_title->push(('Add Purchase Return Note'));
        $this->breadcrumbs->unshift(1, 'Add Purchase Return Note', 'admin/purchase');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->data['sup'] = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->get()->result();
        $people = array("1", "3", "13");
        
        // if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/purchase/add_prn', $this->data);
        // }else{
        //    redirect('admin/dashboard'); 
        // }
    }

    public function loadallpos() {
        $this->datatables->select('purchaseorderhed.*,supplier.SupName');
        $this->datatables->from('purchaseorderhed');
        $this->datatables->join('supplier','supplier.SupCode=purchaseorderhed.SupCode');
        echo $this->datatables->generate();
        die();
    }

    public function loadallprn() {
        $this->datatables->select('purchasereturnnotehed.*,supplier.SupName');
        $this->datatables->from('purchasereturnnotehed');
        $this->datatables->join('supplier','supplier.SupCode=purchasereturnnotehed.PRN_SupCode');
        
        echo $this->datatables->generate();
        die();
    }

    public function loadpojson() {
        $query = $_GET['q'];
        $location = $_SESSION['location'];
        $q = $this->db->select('PO_No AS id,PO_No AS text')->from('purchaseorderhed')->where('PO_Location',$location)->where('IsCancel',0)->like('PO_No', $query)->order_by('PO_No','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadgrnjson() {
        $query = $_GET['q'];
        $supcode = $_GET['supcode'];
        $location = $_SESSION['location'];

        if($supcode!='' || $supcode!=0){
            $q = $this->db->select('GRN_No AS id,GRN_No AS text')->from('goodsreceivenotehed')->where('GRN_Location',$location)->where('GRN_IsCancel',0)->where('GRN_SupCode',$supcode)->like('GRN_No', $query)->order_by('GRN_No','DESC')->get()->result();
        }elseif($supcode==0){
            $q = $this->db->select('GRN_No AS id,GRN_No AS text')->from('goodsreceivenotehed')->where('GRN_Location',$location)->where('GRN_IsCancel',0)->like('GRN_No', $query)->order_by('GRN_No','DESC')->get()->result();
            echo $supcode;die;
        }
        
        echo json_encode($q);die;
    }

    public function loadprnjson() {
        $query = $_GET['q'];
        $location = $_SESSION['location'];
        $q = $this->db->select('PRN_No AS id,PRN_No AS text')->from('purchasereturnnotehed')->where('PRN_Location',$location)->where('PRN_IsCancel',0)->like('PRN_No', $query)->order_by('PRN_No','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Purchase_model->loadsupplierjson($query);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['sup'];
        $supCode= $_REQUEST['supcode'];
        $isGrn = $_REQUEST['isGrn'];
        
        if($isGrn==1){
            $grnNo = $_REQUEST['grn_no'];
            echo $this->Purchase_model->loadproductjsonbygrn($query,$sup,$supCode,$grnNo);
        }else{
            echo $this->Purchase_model->loadproductjson($query,$sup,$supCode);
        }
        die;
    }
    
    public function savePO() {
        if($_POST['action']==1){
            $grnNo = $this->Purchase_model->get_max_code('Purchase Order');
        }elseif ($_POST['action']==2) {
           $grnNo = $_POST['grn_no'];
        }

        $invNo = $_POST['invoicenumber'];//billno
        $addCharge = $_POST['additional'];//jobno
        $remark = $_POST['grnremark'];//
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
        $totalVat =$_POST['totalVat'];
        $totalNbt =$_POST['totalNbt'];
        $isTotalVat =$_POST['isTotalVat'];
        $isTotalNbt =$_POST['isTotalNbt'];
        $nbtRatioRate=$_POST['nbtRatioRate'];
        
        $totalDisPerent = ($totalGrnDiscount*100)/($total_amount-$totalProDiscount);
        
        // $product_codeArr = json_decode($_POST['product_code']);
        // $unitArr = json_decode($_POST['unit_type']);
        // $freeQtyArr = json_decode($_POST['freeQty']);
        // $serial_noArr = json_decode($_POST['serial_no']);
        // $qtyArr = json_decode($_POST['qty']);
        // $sell_priceArr = json_decode($_POST['unit_price']);
        // $cost_priceArr = json_decode($_POST['cost_price']);
        // $pro_discountArr = json_decode($_POST['pro_discount']);
        // $pro_discount_precentArr = json_decode($_POST['discount_precent']);
        // $caseCostArr = json_decode($_POST['case_cost']);
        // $upcArr = json_decode($_POST['upc']);
        // $total_netArr = json_decode($_POST['total_net']);
        // $price_levelArr = json_decode($_POST['price_level']);
        // $totalAmountArr = json_decode($_POST['pro_total']);
        // $pro_nameArr = json_decode($_POST['proName']);
        
        $grnHed = array(
            'AppNo' => '1','PO_No' => $grnNo,'JobNo' => $addCharge,'PO_Bil' => $invNo,'QuotationNo'=>'','PO_Location' => $location,'PO_Date' => $grnDattime,'PO_DeleveryDate' => $invDate,'SupCode' => $supplier,'Remark' => $remark,'PO_Amount' => $total_amount,'PO_NetAmount' => $total_net_amount,'PO_TDisAmount' => $total_discount,'PO_TDisPercentage' => $totalDisPerent,'PO_User' => $invUser,'IsComplate' => $isComplete,'IsCancel'=>0,'PO_IsNbtTotal'=>$isTotalNbt,'PO_IsVatTotal'=>$isTotalVat,'PO_NbtRatioTotal'=>$nbtRatioRate,'PONbtAmount'=>$totalNbt,'POVatAmount'=>$totalVat
        );
        
        

        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];

        if($_POST['action']==1){
            $res2= $this->Purchase_model->savePO($grnHed,$_POST,$grnNo,$totalDisPerent);
        }elseif ($_POST['action']==2) {
           $res2= $this->Purchase_model->updatePO($grnHed,$_POST,$grnNo,$totalDisPerent);
        }
        

        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function savePRN() {
        $barcode = 1;
        
        $prnNo = $this->Purchase_model->get_max_code('PRN');
        $remark = $_POST['grnremark'];
        $invDate = $_POST['grnDate'];
        $grnNo = $_POST['grn_no'];
        $sup_code = $_POST['sup_code'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
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
            'AppNo' => '1','PRN_No' => $prnNo,'PRN_Location' => $location,'PRN_Date' => $invDate,'PRN_DateORG' => $grnDattime,'PRN_SupCode' => $sup_code,'PRN_Remark' => $remark,'GRN_No' => $grnNo,'PRN_Cost_Amount' => $total_amount,'PRN_User' => $invUser,'PRN_IsCancel'=>0
        );
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Purchase_model->savePRN($grnHed,$_POST,$prnNo);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    //cancel page route
    public function cancel_po() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(('Cancel Purchase Order'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase');
            $this->breadcrumbs->unshift(1, 'Cancel Purchase Order', 'admin/purchase/cancel_po');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Purchase_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/purchase/cancel-po', $this->data);
        }
    }
    
    public function getActivePO() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $this->Purchase_model->getActivePOS('purchaseorderhed', $q,$location);
            die;
        }
    }

    public function getPoDataById() {
        $id = $_POST['poNo'];
        $arr['po_data'] = $this->db->select('purchaseorderhed.*,DATE(purchaseorderhed.PO_DeleveryDate) AS delivery_date,supplier.*')->from('purchaseorderhed')->join('supplier','supplier.SupCode=purchaseorderhed.SupCode')->where('PO_No', $id)->get()->row();
        $arr['po_desc'] = $this->db->select("purchaseorderdtl.*,product.Prd_Description,product.Prd_AppearName")->from('purchaseorderdtl')->join('product','product.ProductCode=purchaseorderdtl.ProductCode')->where('purchaseorderdtl.PO_No', $id)->get()->result_array();
        echo json_encode($arr);
        die;
    }

     public function cancelPO() {
        $cancelNo = $this->Purchase_model->get_max_code('CancelPO');
        
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
        $supplier=0;
        $this->bincard($grnNo,1,'Cancelled');//update bincard
        $res2 = $this->Purchase_model->cancelPO($cancelNo,$location,$canDate,$grnNo,$remark,$user,$supplier);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    public function getAutoSerialMax() {
        $grnNo = $this->Purchase_model->get_autoNum('AutoSerial');
        echo ($grnNo);
        die;
    }

    //cancel page route
    public function cancel_prn() {
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(('Cancel PRN'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Purchase', 'admin/purchase');
            $this->breadcrumbs->unshift(1, 'Cancel Prn', 'admin/purchase/cancel_prn');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Grn_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/purchase/cancel-prn', $this->data);
        }
    }

    public function getActivePRN() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $this->Purchase_model->getActivePrns('purchasereturnnotehed', $q,$location);
            die;
        }
    }

    public function getPRNDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Purchase_model->loadPrnById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

    public function getPrnDataByPrnNo(){

        $grnNo = $_POST['grnNo'];

        $arr['grn_hed'] = $this->db->select('purchasereturnnotehed.*,DATE(purchasereturnnotehed.PRN_Date) as PRN_Date,supplier.*')->from('purchasereturnnotehed')->join('supplier', 'supplier.SupCode = purchasereturnnotehed.PRN_SupCode','left')->where('PRN_No', $grnNo)->get()->row();
        $arr['grn_dtl'] = $this->db->select('purchasereturnnotedtl.*, product.Prd_AppearName')->from('purchasereturnnotedtl')->join('product','purchasereturnnotedtl.PRN_Product=product.ProductCode')->where('purchasereturnnotedtl.PRN_No', $grnNo)->get()->result();
        // $arr['job_est'] = $this->Job_model->getEstimateDtlbyid($estimateNo,$supplemetNo);
        // $arr['cus_data'] = $this->Job_model->getCustomersDataById($cusCode);
        echo json_encode($arr);
        die;
    }

     public function cancelPRN() {
        $cancelNo = $this->Purchase_model->get_max_code('CancelPRN');
        
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
        $supplier=$_POST['supCode'];
       
        
        $res2 = $this->Purchase_model->cancelPRN($cancelNo,$location,$canDate,$grnNo,$remark,$user,$supplier);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
}