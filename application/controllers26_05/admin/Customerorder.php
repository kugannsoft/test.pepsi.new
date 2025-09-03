<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customerorder extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Purchase_model');
        $this->load->model('admin/Payment_model');
        $this->load->model('admin/Customerorder_model');
        date_default_timezone_set("Asia/Colombo");
        $this->load->library('Datatables');
    }

    public function index() {

    }

    public function allCustomerOrder() {
        $this->page_title->push(('All Customer Order'));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/Customerorder');
        $this->breadcrumbs->unshift(1, 'All PO', 'admin/Customerorder/allCustomerOrder');

        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();

        $date = date("Y-m-d");
        $user = $_SESSION['user_id'];
        $isend = $this->db->select('ID')->from('cashierbalancesheet')->where('DATE(BalanceDate)' ,$date)->where('SystemUser' ,$user)->get()->num_rows();

        if ($isend > 0){
            $this->template->admin_render('admin/customerorder/allCustomerOrder', $this->data);
        } else {
            redirect('admin/cash/cash_float_balance');
        }

    }

    public function view_po($gno=null) {
        $grnNo=base64_decode($gno);
        $this->page_title->push(('Customer Order of '. $grnNo));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Customer Order', 'admin/purchase/all_po');
        $this->breadcrumbs->unshift(1,  $grnNo, 'admin/customerorder/view_po');

        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);

        $this->data['po'] = $this->Customerorder_model->loadCoById($grnNo);
        $this->data['po_hed'] = $this->db->select('customerorderhed.*,customer.*,users.first_name')->from('customerorderhed')->join('users','customerorderhed.PO_User=users.id','left')->join('customer', 'customer.CusCode = customerorderhed.SupCode')->where('customerorderhed.PO_No', $grnNo)
            ->get()->row();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 1)->get()->result();
        $this->template->admin_render('admin/customerorder/viewCustomerOrder', $this->data);
    }


    public function addCustomerOrder() {
        $po = isset($_GET['po'])?$_GET['po']:NULL;
        $jobno = isset($_GET['job'])?$_GET['job']:NULL;
        $action = isset($_GET['action'])?$_GET['action']:1;
        $pono =base64_decode($po);
        $jobno =base64_decode($jobno);
        $this->load->helper('url');
        $this->page_title->push(('Add Customer Order'));
        $this->breadcrumbs->unshift(1, 'Add Customer Order', 'admin/customerorder');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['po_no'] = $pono;
        $this->data['jobno'] = $jobno;
        $this->data['action']   = $action;
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->data['sup'] = $this->db->select('CusCode AS id,DisplayName AS text')->from('customer')->get()->result();
        $people = array("1", "3", "13");

        $date = date("Y-m-d");
        $user = $_SESSION['user_id'];
        $isend = $this->db->select('ID')->from('cashierbalancesheet')->where('DATE(BalanceDate)' ,$date)->where('SystemUser' ,$user)->get()->num_rows();

        if ($isend > 0){
            $this->template->admin_render('admin/customerorder/addCustomerOrder', $this->data);
        } else {
            redirect('admin/cash/cash_float_balance');
        }



//        var_dump($isend,$date);die();
        // if (in_array($_SESSION['user_id'], $people)) {
//        $this->template->admin_render('admin/customerorder/addCustomerOrder', $this->data);
        // }else{
        //    redirect('admin/dashboard');
        // }
    }


    public function loadallpos() {
        $this->datatables->select('customerorderhed.*,customer.CusName');
        $this->datatables->from('customerorderhed');
        $this->datatables->join('customer','customer.CusCode=customerorderhed.SupCode');
        echo $this->datatables->generate();
        die();
    }



    public function loadpojson() {
        $query = $_GET['q'];
        $location = $_SESSION['location'];
        $q = $this->db->select('PO_No AS id,PO_No AS text')->from('customerorderhed')->where('PO_Location',$location)->where('IsCancel',0)->where('IsComplate',0)->like('PO_No', $query)->order_by('PO_No','DESC')->get()->result();
        echo json_encode($q);die;
    }

    public function loadpojsonCancel() {
        $query = $_GET['q'];
        $supcode = $_GET['supcode'];
        $location = $_SESSION['location'];
        $q = $this->db->select('PO_No AS id,PO_No AS text')->from('customerorderhed')->where('SupCode',$supcode)->where('IsUse',0)->where('PO_Location',$location)->where('IsCancel',1)->where('IsComplate',0)->like('PO_No', $query)->order_by('PO_No','DESC')->get()->result();
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


    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Purchase_model->loadsupplierjson($query);
        die;
    }

    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['sup'];$supCode= $_REQUEST['supcode'];
        $isGrn = $_REQUEST['isGrn'];

        if($isGrn==1){
            $grnNo = $_REQUEST['grn_no'];
            echo $this->Purchase_model->loadproductjsonbygrn($query,$sup,$supCode,$grnNo);
        }else{
            echo $this->Purchase_model->loadproductjson($query,$sup,$supCode);
        }
        die;
    }

    public function saveCustomerOrder() {
        if($_POST['action']==1){
            $grnNo = $this->Purchase_model->get_max_code('Customer Order');
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
        $cancelOrder=$_POST['grn_no_cancel'];

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
            $res2= $this->Customerorder_model->saveCustomerOrder($grnHed,$_POST,$grnNo,$totalDisPerent);

            if ($cancelOrder != '' || $cancelOrder != null){

                $query = $this->db->select('*')->from('customerorderpayment')->where('OrderNo',$cancelOrder)->get()->result();

                foreach ($query as $querys){

                    $cinvDtl = array(
                        'Rcp_No' => $querys->Rcp_No,
                        'OrderNo' => $querys->OrderNo,
                        'PayType' => $querys->PayType,
                        'PayAmount' => $querys->PayAmount,
                        'payDate' => $querys->payDate);

                    $this->db->insert('customerorderpayment_temp', $cinvDtl);
                }

                $data = array('OrderNo' => $grnNo);
                $this->db->update('customerorderpayment', $data, array('OrderNo' => $cancelOrder));

                $data = array('IsUse' => 1, 'UseOderNo' => $grnNo);
                $this->db->update('customerorderhed', $data, array('PO_No' => $cancelOrder));

            }
        } elseif ($_POST['action']==2) {
            $res2= $this->Customerorder_model->updateCustomerOrder($grnHed,$_POST,$grnNo,$totalDisPerent);

            if ($cancelOrder != '' || $cancelOrder != null){

                $query = $this->db->select('*')->from('customerorderpayment')->where('OrderNo',$cancelOrder)->get()->result();

                foreach ($query as $querys){

                    $cinvDtl = array(
                        'Rcp_No' => $querys->Rcp_No,
                        'OrderNo' => $querys->OrderNo,
                        'PayType' => $querys->PayType,
                        'PayAmount' => $querys->PayAmount,
                        'payDate' => $querys->payDate);

                    $this->db->insert('customerorderpayment_temp', $cinvDtl);
                }

                $data = array('OrderNo' => $grnNo);
                $this->db->update('customerorderpayment', $data, array('OrderNo' => $cancelOrder));

                $data = array('IsUse' => 1, 'UseOderNo' => $grnNo);
                $this->db->update('customerorderhed', $data, array('PO_No' => $cancelOrder));
            }
        }


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

    public function getCoDataById() {
        $id = $_POST['poNo'];
        $arr['po_data'] = $this->db->select('customerorderhed.*,DATE(customerorderhed.PO_DeleveryDate) AS delivery_date,customer.*')->from('customerorderhed')->join('customer','customer.CusCode=customerorderhed.SupCode')->where('PO_No', $id)->get()->row();
        $arr['po_desc'] = $this->db->select("customerorderdtl.*,product.Prd_Description,product.Prd_AppearName")->from('customerorderdtl')->join('product','product.ProductCode=customerorderdtl.ProductCode')->where('customerorderdtl.PO_No', $id)->get()->result_array();
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

    public function addPayment($gno=null)
    {
        $grnNo=base64_decode($gno);
        $this->page_title->push(('Customer Order Payment of '. $grnNo));

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Customer Order', 'admin/purchase/all_po');
        $this->breadcrumbs->unshift(1,  $grnNo, 'admin/customerorder/view_po');

        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $_SESSION['location'];
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Purchase_model->get_data_by_where('company', $id3);

        $this->data['po'] = $this->Customerorder_model->loadCoById($grnNo);
        $this->data['po_hed'] = $this->db->select('customerorderhed.*,customer.*,users.first_name')->from('customerorderhed')->join('users','customerorderhed.PO_User=users.id','left')->join('customer', 'customer.CusCode = customerorderhed.SupCode')->where('customerorderhed.PO_No', $grnNo)->get()->row();
        $this->data['pay_dtl'] = $this->db->select('customerorderpayment.*,paytype.*')->from('customerorderpayment')->join('paytype', 'paytype.payTypeId = customerorderpayment.PayType')->where('customerorderpayment.OrderNo', $grnNo)->order_by('payDate', 'DESC')->get()->result();

        $this->data['location'] = $this->Purchase_model->loadlocations();
        $this->template->admin_render('admin/customerorder/customerOrderPayment', $this->data);
    }

    public function saveCustomerOrderPayment()
    {
        $rcpNo = $this->Payment_model->get_max_code('Customer Order Receipt');
        $coNo = $_POST['coNo'];
        $payType = $_POST['payType'];
        $payAmount = $_POST['payAmount'];
        $payDate = date("Y-m-d H:i:s");



        $coPayment = array(
           'Rcp_No' => $rcpNo,'OrderNo' => $coNo,'PayType' => $payType,'PayAmount' => $payAmount,'payDate'=> $payDate
        );

        $res2 = $this->db->insert('customerorderpayment', $coPayment);

        $this->Payment_model->update_max_code('Customer Order Receipt');
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function deleteRecode()
    {
//        var_dump($_POST);die();
        $id =  $_POST['id'];

        $this->db->trans_start();
        $this->db->delete('customerorderpayment',array('id' => $id));
        $this->db->trans_complete();
        $res2= $this->db->trans_status();

        $return = array('JobCardNo' => ($id));
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function getCustomerOrderReceiptDtl()
    {
        $orderNo = $_POST['orderNo'];
        $arr['receipt_hed'] = $this->db->select('customerorderpayment.*,customer.*,paytype.PayType')
            ->from('customerorderpayment')
            ->join('paytype', 'paytype.payTypeId = customerorderpayment.PayType')
            ->join('customerorderhed', 'customerorderhed.PO_No = customerorderpayment.OrderNo', 'INNER')
            ->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER')
            ->where('customerorderpayment.OrderNo', $orderNo)
            ->order_by('customerorderpayment.Id', 'DESC')
            ->limit(1)
            ->get()->row();

        $arr['pay_amount_word'] = strtoupper($this->Payment_model->convert_number_to_words( floatval($arr['receipt_hed']->PayAmount)))." ONLY";
        echo json_encode($arr);
        die;
    }


    public function getCustomerOrderReceiptDtlById()
    {
        $id = $_POST['id'];
        $arr['receipt_hed'] = $this->db->select('customerorderpayment.*,customer.*,paytype.PayType')
            ->from('customerorderpayment')
            ->join('paytype', 'paytype.payTypeId = customerorderpayment.PayType')
            ->join('customerorderhed', 'customerorderhed.PO_No = customerorderpayment.OrderNo', 'INNER')
            ->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER')
            ->where('customerorderpayment.Id', $id)
            ->get()->row();

        $arr['pay_amount_word'] = strtoupper($this->Payment_model->convert_number_to_words( floatval($arr['receipt_hed']->PayAmount)))." ONLY";
        echo json_encode($arr);
        die;
    }

    public function cancel_customer_order()
    {
        $invNo=$_POST['id'];

        $this->page_title->push(('All Customer Order'));
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Purchase', 'admin/Customerorder');
        $this->breadcrumbs->unshift(1, 'All PO', 'admin/Customerorder/allCustomerOrder');

        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Purchase_model->loadpricelevel();
        $this->data['location'] = $this->Purchase_model->loadlocations();

        $data = array('IsCancel' => 1);
        $this->db->update('customerorderhed', $data, array('PO_No' => $invNo));
        redirect('admin/Customerorder/allCustomerOrder');
    }

}