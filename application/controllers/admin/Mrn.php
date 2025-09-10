<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mrn extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Mrn_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function add_mrn() {
        // $invNo=base64_decode($inv);
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        $type = isset($_GET['type'])?$_GET['type']:NULL;

        $this->data['mrnNo'] = base64_decode($id);
        if($type=='job'){
            $this->data['jobNo'] = base64_decode($id);
            $this->data['mrnNo'] ='';
            $this->data['estNo'] ='';
        }elseif($type=='mrn'){
            $this->data['jobNo'] ='';
            $this->data['mrnNo'] =base64_decode($id);
            $this->data['estNo'] ='';
        }elseif($type=='est'){
            $this->data['jobNo'] ='';
            $this->data['estNo'] =base64_decode($id);
            $this->data['mrnNo'] ='';
        }else{
            $this->data['jobNo'] ='';
            $this->data['mrnNo'] ='';
            $this->data['estNo'] ='';
        }

        $currentLocation = $_SESSION['location'];
        $this->page_title->push(('Parts Request Note'));
        $this->breadcrumbs->unshift(1, 'Parts Request Note', 'admin/mrn/add_mrn');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Mrn_model->loadpricelevel();
        $this->data['location'] = $this->db->select()->from('location')->where('location_id !=', $currentLocation)->get()->result();
         $this->data['brand'] = $this->db->select('*')->from('productbrand')->get()->result();
        $this->data['quality'] = $this->db->select('*')->from('productquality')->get()->result();
        $this->template->admin_render('admin/mrn/add-mrn', $this->data);
    }

    public function all_mrns() {
        
            /* Title Page */
            $this->page_title->push('Mrn');
            $this->data['pagetitle'] = 'All Parts Requets';

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Mrn', 'admin/mrn/all_mrns');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $this->template->admin_render('admin/mrn/all-mrns', $this->data);
    }

    public function view_mrn($inv=null) {

            $this->load->model('admin/Salesinvoice_model');
            $invNo=base64_decode($inv);
            /* Title Page */
// echo $invNo;die;
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Material Request Note');
            $this->data['pagetitle'] = 'Material Request Note -'.$invNo;

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Sales', 'admin/mrn/');
            $this->breadcrumbs->unshift(1, 'Sales Invoice', 'admin/mrn/view_mrn');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Mrn_model->get_data_by_where('company', $id3);
            
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;

            $this->data['invHed']= $this->db->select('materialrequestnotehed.*,users.first_name,location.location')
                ->from('materialrequestnotehed')
                ->join('location', 'location.location_id=materialrequestnotehed.ToLocation','INNER')
                ->join('users','materialrequestnotehed.MrnOutUser=users.id','left')
                ->where('MrnNo',$invNo)->get()->row();

            $cusCode =  $this->db->select('ToCustomer')->from('materialrequestnotehed')->where('MrnNo',$invNo)->get()->row()->ToCustomer;

            $branch_id = $_SESSION['location'];
            // $this->db->select('jobcardhed.JobLocation')->from('jobcardhed')->where('JobCardNo',$jno)->get()->row()->JobLocation;
            $this->data['branch']=$this->db->select('branch_address.*,company.CompanyName,company.CompanyName2')->from('branch_address')->join('company', 'company.CompanyID = branch_address.company_id')->where('loc_id',$branch_id)->get()->row();
            
                
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->where('customer.CusCode',$cusCode)->get()->row();

             $this->data['invDtl']=$this->db->select('materialrequestnotedtl.*,product.*')->from('materialrequestnotedtl')->join('product', 'materialrequestnotedtl.ProductCode = product.ProductCode', 'INNER')->where('materialrequestnotedtl.MrnNo', $invNo)->get()->result();

             $this->data['invDtlArr']=$this->Mrn_model->getMRNDtlbyid($invNo);
                   
            $this->template->admin_render('admin/mrn/view-mrn', $this->data);
    }

    public function loadallmrns() {
        $this->load->library('Datatables');
        $this->datatables->select('materialrequestnotehed.*,location.location');
        $this->datatables->from('materialrequestnotehed');
        $this->datatables->join('location', 'location.location_id=materialrequestnotehed.ToLocation','INNER');
        echo $this->datatables->generate();
        die();
    }

    public function loadmrnjson() {
        $query = $_GET['q'];
        $q = $this->db->select('MrnNo AS id,MrnNo AS text')->from('materialrequestnotehed')->like('MrnNo', $query)->where('IsCancel', 0)->order_by('MrnNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Mrn_model->loadsupplierjson($query);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['sup'];$supCode= $_REQUEST['supcode'];
        echo $this->Mrn_model->loadproductjson($query,$sup,$supCode);
        die;
    }
    
    public function loadproductSerial() {
        $q = $_GET['q'];
        $product= $_REQUEST['proCode'];$location= $_REQUEST['location'];
        echo $this->Mrn_model->loadproductSerial($product, $q, $location);
        die;
    }
    
    public function saveMrn() {
        $barcode = 1;
//        var_dump($_POST);die;
//        $this->load->model('admin/Mrn_model');
        $action = $_POST['action'];

        $remark = $_POST['grnremark'];
        $invDate = $_POST['grnDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $location_to = $_POST['location'];
        $location_from =  $_POST['location_from'];
        $to_customer = $_POST['cusCode'];
        $isComplete=0;
        $totalGrnDiscount = $_POST['totalGrnDiscount'];
        $totalProDiscount = $_POST['totalProDiscount'];
        $jobno = $_POST['jobNo'];
        $estno = $_POST['estNo'];

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
        $request_dateArr = json_decode($_POST['request_date']);
        $qualityArr = json_decode($_POST['quality']);
        $brandArr = json_decode($_POST['brand']);

        if($request_dateArr==0){
            $request_date=date("Y-m-d H:i:s");
        }else{
            $request_date=$request_dateArr;
        }

        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Mrn_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];

        if($action==1){
             $grnNo = $this->Mrn_model->get_max_code('MRN');
            // insert
            $grnHed = array(
                'AppNo' => '1','MrnNo' => $grnNo,'ToCustomer'=>$to_customer,'FromLocation'=>$location_from,'ToLocation'=>$location,'Location' => $location,'MrnDate' => $invDate,'MrnDateORG' => $grnDattime,'MrnJobNo' => $jobno,'MrnEstimateNo' => $estno,'MrnRemark' => $remark,'ReceivedDate' => '',
                'CostAmount' => $total_amount,'MrnOutUser' => '-','MrnInRemark' => '-','MrnIsReceive'=>0,'MrnUser' => $invUser,'Flag' => 0,'IsCancel'=>0
            );
        
            $res2= $this->Mrn_model->saveMrn($grnHed,$_POST,$grnNo);

        }elseif($action==2){
             $grnNo =$_POST['mrnNo'];
            //update 
            $grnHed = array(
                'AppNo' => '1','ToCustomer'=>$to_customer,'FromLocation'=>$location_from,'ToLocation'=>$location,'Location' => $location,'MrnJobNo' => $jobno,'MrnEstimateNo' => $estno,'MrnRemark' => $remark,
                'CostAmount' => $total_amount,'MrnOutUser' => '-','MrnInRemark' => '-','MrnIsReceive'=>0,'MrnUser' => $invUser,'Flag' => 0,'IsCancel'=>0
            );
            
            $res2= $this->Mrn_model->updateMrn($grnHed,$_POST,$grnNo);
        }

        //update issue status
        $issue_count = $this->db->select('Receive')->from('materialrequestnotedtl')->where('MrnNo', $grnNo)->where('Receive', 1)->get()->num_rows();
        $request_count = $this->db->select('Request')->from('materialrequestnotedtl')->where('MrnNo', $grnNo)->where('Request', 1)->get()->num_rows();

        if($request_count>$issue_count){
            $this->db->update('materialrequestnotehed',array('MrnIsReceive' => 0),array('MrnNo' => $grnNo));
        }elseif($request_count==$issue_count){
            $this->db->update('materialrequestnotehed',array('MrnIsReceive' => 1),array('MrnNo' => $grnNo));
        }
        
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
            $this->load->model('admin/Mrn_model');
            $this->data['location'] = $this->Mrn_model->loadlocations();
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Mrn_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/transer/stock_in', $this->data);
        }
    }
    
    public function getActiveSTOut() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location_to  = $_GET['location_to'];
            $location_from  = $_GET['location_from'];
            $this->Mrn_model->getActiveSTOut('stocktransferhed', $q,$location_to,$location_from);
            die;
        }
    }

    public function getSTOutDataById() {
        $invNo = $_POST['transNo'];
        $this->data['invoice_data'] = $this->Mrn_model->loadSTOutById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }

    public function loadMrnById() {
        $inv= $_POST['mrnNo'];
        if($inv!=''){
            $arr['mrn_hed'] = $this->db->select()->from('materialrequestnotehed')->where('MrnNo', $inv)->get()->row();
            $arr['mrn_dtl'] = $this->db->select('materialrequestnotedtl.*,product.Prd_AppearName')->from('materialrequestnotedtl')
                        ->where('materialrequestnotedtl.MrnNo', $inv)
                        ->join('product', 'product.ProductCode = materialrequestnotedtl.ProductCode')
                        ->get()->result();
        }else{
            $arr['mrn_dtl'] =null;
            $arr['mrn_hed']=null;
        }        
        echo json_encode($arr);
        die;
    }

     public function saveSTIn() {
//        $cancelNo = $this->Mrn_model->get_max_code('CancelGRN');
        $location_to = $_POST['location_to'];
        $location_from = $_POST['location_from'];
        $location=$_POST['location'];
        $canDate=$_POST['payDate'];
        $grnNo=$_POST['invNo'];
        $remark=$_POST['remark'];
        $user=$_POST['invUser'];
//        $supplier=$_POST['supCode'];
        
        $res2 = $this->Mrn_model->saveSTIn($location_to,$location_from,$canDate,$grnNo,$remark,$user);
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
            $this->load->model('admin/Mrn_model');
            $this->data['location'] = $this->Mrn_model->loadlocations();
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Mrn_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/transer/cancel_transer', $this->data);
        }
    }
    
    public function cancelTranser() {
       $cancelNo = $this->Mrn_model->get_max_code('Transfer Cancel');
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
        
        $res2 = $this->Mrn_model->cancelTranser($location_to,$location_from,$canDate,$grnNo,$remark,$user,$invCanel);
        $return = array('CancelNo' => $cancelNo,'InvNo' => $_POST['invNo']);
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function loadjobjson() {
        $query = $_GET['q'];
        $q = $this->db->select('JobCardNo AS id,JobCardNo AS text')->from('jobcardhed')->like('JobCardNo', $query)->order_by('JobCardNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadrequestmrnjson() {
        $query = $_GET['q'];
        $q = $this->db->select('MrnNo AS id,MrnNo AS text')->from('materialrequestnotehed')->like('MrnNo', $query)->where('MrnIsReceive', 0)->where('IsCancel', 0)->order_by('MrnNo','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function issue_mrn() {
        $this->page_title->push(('Issue Material Request'));
        $this->breadcrumbs->unshift(1, 'Material Request Note', 'admin/mrn/issue_mrn');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Mrn_model->loadpricelevel();
        $this->data['location'] = $this->Mrn_model->loadlocations();
        $this->data['brand'] = $this->db->select('*')->from('productbrand')->get()->result();
        $this->data['quality'] = $this->db->select('*')->from('productquality')->get()->result();
        $this->template->admin_render('admin/mrn/issue-mrn', $this->data);
    }

    public function getMrnDataById(){
        $mrnNo = $_POST['mrnNo'];
        $arr['mrn_hed'] = $this->db->select('materialrequestnotehed.*')->from('materialrequestnotehed')
        ->where('MrnNo', $mrnNo)->get()->row();

    
        $arr['mrn_dtl'] =$this->db->select('materialrequestnotedtl.*,product.*,productcondition.IsSerial')
        ->from('materialrequestnotedtl')
        ->join('product', 'materialrequestnotedtl.ProductCode = product.ProductCode', 'INNER')
        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode', 'INNER')
        ->where('materialrequestnotedtl.MrnNo', $mrnNo)->get()->result();
        
        echo json_encode($arr);
        die;
    }

    public function confirmMrn(){
        $mrnNo = $_REQUEST['mrnno'];
        $res = $this->db->update('materialrequestnotehed', array('IsConfirm' => 1 ),array('MrnNo' => $mrnNo ));
        echo $res;die;
    }

    public function issueMrn() {
        $barcode = 1;
//        var_dump($_POST);die;
//        $this->load->model('admin/Mrn_model');
        $grnNo = $_POST['mrnNo'];

        $remark = $_POST['grnremark'];
        $invDate = $_POST['grnDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $location_to = $_POST['location'];
        $location_from = $_POST['location_from'];
        $to_customer = $_POST['cusCode'];
        $isComplete=0;
        $totalGrnDiscount = $_POST['totalGrnDiscount'];
        $totalProDiscount = $_POST['totalProDiscount'];
        $jobno = $_POST['jobNo'];
        $estno = $_POST['estNo'];

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
        
        $grnHed = array(
            'FromLocation'=>$location,
            'ReceivedDate' => $grnDattime,'MrnOutUser' => $invUser,'MrnInRemark' => $remark,'MrnIsReceive'=>0
        );
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Mrn_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Mrn_model->issueMrn($grnHed,$_POST,$grnNo);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
}
