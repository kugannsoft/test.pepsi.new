<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Cash_model');
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
            $this->breadcrumbs->unshift(1, lang('menu_invoice'), 'admin/cash');
            $this->breadcrumbs->unshift(1, ' Invoice Print', 'admin/cash/index');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Cash_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Cash_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/cash/index', $this->data);
        }
    }

    public function cash_float() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Expenses & Earning   ');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Cash Float', 'admin/cash');
            $this->breadcrumbs->unshift(1, 'Cash Float', 'admin/cash/cash-float');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            
            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Cash_model');
            $this->data['transType'] = $this->db->get_where('transactiontypes', array('IsExpenses' => 1))->result();

            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Cash_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/cash/cash-float', $this->data);
        }
    }
    
    public function cash_float_balance() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push('Cash Float Balance');
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Cash', 'admin/cash');
            $this->breadcrumbs->unshift(1, 'Cash Float Balance', 'admin/cash/cash-float-balance');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            
            /* Data */
            $location = $_SESSION['location'];
            $this->load->model('admin/Cash_model');
            $this->data['transType'] = $this->db->select()->from('transactiontypes')->where('IsActive',1)->where('IsExpenses',1)->get()->result();
            // $this->db->get_where('transactiontypes', array('IsExpenses' => 1,'IsActive',1))->result();
            $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsActive',1)->get()->result();
            

            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Cash_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/cash/cash-float-balance', $this->data);
        }
    }
    public function getTransactionType() {
            $q = ($_REQUEST['cash_type']);
            $data = $this->db->get_where('transactiontypes', array('IsExpenses' =>$q))->result();
            
            echo json_encode($data);
            die;
    }
    
    public function getTransactionByDate() {
            $date = ($_REQUEST['cash_date']);
            $location = ($_REQUEST['location']);
            
            $data =$this->db->select('*,DATE(FlotDate) As FlotDate')
                    ->from('cashflot')
                    ->join('transactiontypes', 'transactiontypes.TransactionCode = cashflot.TransactionCode', 'INNER')
                    ->where('Location' ,$location)
                    ->where('DATE(FlotDate)' ,$date)
                    ->get()->result_array();
            echo json_encode($data);
            die;
    }
    
    public function getCashFloatByDate() {
            $date = ($_REQUEST['cash_date']);
            $location = ($_REQUEST['location']);
            $user = $_SESSION['user_id'];
            // $last_date = date('Y-m-d', strtotime($date. ' - 1 days'));

            $isend = $this->db->select('ID')->from('cashierbalancesheet')->where('DATE(BalanceDate)' ,$date)->get()->num_rows();
            if($isend>0){
                $query = $this->db->query("CALL SPR_CASH_BALANCE_SHEET('$date','$location','$user')");
                $result =$query->result_array();
            }else{
                $result =$this->db->select('EndFlot AS START_FLOT, StartTime AS START_TIME')->from('cashierbalancesheet')->where('DATE(BalanceDate)<' ,$date)->order_by('BalanceDate','desc')->limit(1)->get()->result_array();
            }    
           
            echo json_encode($result);
            die;
    }
    
    public function getCashInOutByDate() {
            $date = ($_REQUEST['cash_date']);
            $location = ($_REQUEST['location']);
            
            $data =$this->db->select('cashinout.*,transactiontypes.TransactionName,salespersons.RepName')
                    ->from('cashinout')
                    ->join('salespersons','cashinout.Emp=salespersons.RepID','left')
                    ->join('transactiontypes','cashinout.TransCode=transactiontypes.TransactionCode','left')
                    ->where('Location' ,$location)
                    ->where('DATE(InOutDate)' ,$date)
                    ->get()->result_array();
           echo json_encode($data);
            die;
    }
    
    public function getActiveInvoice() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $this->Cash_model->getActiveInvoies('invoicehed', $q,$location);
            die;
        }
    }
    
    public function getActiveInvoiesByCustomer() {

        if (isset($_GET['name_startsWith'])) {
            $q = strtolower($_GET['name_startsWith']);
            $location  = $_GET['location'];
            $customer  = $_GET['cusCode'];
            $this->Cash_model->getActiveInvoiesByCustomer('invoicehed', $q,$location,$customer);
            die;
        }
    }

    public function getInvoiceDataById() {
        $invNo = $_POST['invNo'];
        $this->data['invoice_data'] = $this->Cash_model->loadInvoiceById($invNo);
        echo json_encode($this->data['invoice_data']);
        die;
    }
    public function saveCashFloat() {
        $cancelNo =$this->db->select_max('FlotNo')->get('cashflot')->row()->FlotNo;
        $datetime = date("Y-m-d H:i:s");
        $invCanel = array(
            'AppNo' => '1',
            'FlotNo' => ($cancelNo+1),
            'Location' => $_POST['location'],
            'FlotDate' => $_POST['payDate'],
            'DateORG' => $datetime,
            'TransactionCode' => $_POST['transCode'],
            'CounterNo' => 1,
            'Remark' => $_POST['remark'],
            'FlotAmount' => $_POST['floatAmount'],
            'SystemUser' => $_POST['invUser']);
        $res2 = $this->Cash_model->saveCashFloat('cashflot',$invCanel);
        $return = array('floatNo' => ($cancelNo+1),'dateORG' => $datetime);
        $return['fb'] = $res2;
        
        echo json_encode($return);
        die;
    }
    
     public function saveCashInOut() {
         if($_POST['id']==''){
            $cancelNo =$this->db->select_max('InOutID')->get('cashinout')->row()->InOutID;
            $cancelNo=$cancelNo+1;
        }else{
            $cancelNo = $_POST['id'];
        }
        if(isset($_POST['act'])){
            $act=1;
        }else{
            $act=0;
        }

        if(isset($_POST['emp'])){
            $emp=$_POST['emp'];
        }else{
            $emp=0;
        }

        $datetime = date("Y-m-d H:i:s");
        $invCanel = array(
            'AppNo' => '1',
            'InOutID' => ($cancelNo),
            'Location' => $_POST['location'],
            'InOutDate' => $datetime,
            'transCode' => isset($_POST['transCode']) ? $_POST['transCode'] :0,
            'Emp' => $emp,
            'Mode' => $_POST['cash'],
            'Remark' => $_POST['remark'],
            'CashAmount' => $_POST['cashAmount'],
            'SystemUser' => $_POST['invUser'],
            'IsActive' => $act);
        
        if($_POST['id']==''){
           $res2 = $this->db->insert('cashinout',$invCanel);
        }else{
            $invCanel = array(
            'AppNo' => '1',
            'InOutID' => ($cancelNo),
            'Emp' => $emp,
            'transCode' => isset($_POST['transCode']) ? $_POST['transCode'] :0,
            'Location' => $_POST['location'],
            'Mode' => $_POST['cash'],
            'Remark' => $_POST['remark'],
            'CashAmount' => $_POST['cashAmount'],
            'IsActive' => $act);
           $res2 = $this->db->update('cashinout',$invCanel,array('InOutID'=>($cancelNo)));
        }
        
        $return = array('InOutID' => ($cancelNo),'InOutDate' => $datetime);
        $return['fb'] = $res2;
        
        echo json_encode($return);
        die;
    }
    
    public function saveStartFloat() {
        $datetime = date("Y-m-d H:i:s");
        if($_POST['id']==''){
            $id = date("Y_m_d_H_i_s");
        }else{
            $id = $_POST['id'];
        }
        $mode='S';
        $loc = $_POST['location'];
        $BalanceDate= $_POST['payDate'].date(" H:i:s");
        $float =$_POST['floatAmount'];
        $invUser=$_POST['invUser'];
        
        $this->db->trans_start();
        $this->db->query("CAll SPT_SAVE_CASIHER_BALANCE('1','$float','$BalanceDate','$datetime','$mode','$loc','$id','$invUser')");
        $this->db->trans_complete();
        $res2 =  $this->db->trans_status();

        $return = array('InOutID' => ($id),'InOutDate' => $datetime);
        $return['fb'] = $res2;
        
        echo json_encode($return);
        die;
    }
    
    public function saveEndFloat() {  
        $BalanceDate= $_POST['payDate'].date(" H:i:s");
        
        $startflot = $_POST['floatAmount'];
        if($_POST['id']==''){
            $id = date("Y_m_d_H_i_s");
            echo 1;
        }else{
            $id = $_POST['id'];
            if($_POST['id']=='undefined'){
                $id = date("Y_m_d_")."07_00_0";
                $BalanceDate= $_POST['payDate'].date(" H:i:s");
                $datetime = date("Y-m-d")." 07:00:00";
                $mode='S';
                $loc = $_POST['location'];
                $invUser=$_POST['invUser'];
                $this->Cash_model->saveEndFloat($startflot,$BalanceDate,$datetime,$mode,$loc,$id,$invUser );

            }else{
                $id = $_POST['id'];
            }
        }

        $datetime = date("Y-m-d H:i:s");
        $mode='E';
        $loc = $_POST['location'];
       
        $float =$_POST['floatAmount'];
        $invUser=$_POST['invUser'];
        $this->db->trans_start();
        $this->Cash_model->saveEndFloat($float,$BalanceDate,$datetime,$mode,$loc,$id,$invUser);
        $this->db->trans_complete();
        $res2 =  $this->db->trans_status();
        $return = array('InOutID' => ($id),'InOutDate' => $datetime);
        $return['fb'] = $res2;
        $res3=$this->cashSummary($_POST['payDate']);//send email
        $return['email'] = $res3;
        echo json_encode($return);
        die;
    }

    public function cancelInvoice() {
        $cancelNo = $this->Cash_model->get_max_code('CancelInvoice');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_POST['location'],
            'CancelDate' => $_POST['payDate'],
            'InvoiceNo' => $_POST['invNo'],
            'Remark' => $_POST['remark'],
            'CancelUser' => $_POST['invUser']);
        $res2 = $this->Cash_model->cancelInvoice($invCanel);
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
            $this->breadcrumbs->unshift(1, 'Invoice', 'admin/cash');
            $this->breadcrumbs->unshift(1, 'Return invoice', 'admin/cash/return_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
             $this->data['plv'] = $this->Cash_model->loadpricelevel();
            $location = $_SESSION['location'];
            $this->load->model('admin/Cash_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Cash_model->get_data_by_where('company', $id3);

            /* Load Template */
            $this->template->admin_render('admin/cash/return-invoice', $this->data);
        }
    }
    
    public function loadcustomersjson() {
        $query = $_GET['q'];
        echo $this->Cash_model->loadcustomersjson($query);
        die;
    }

    public function getCustomersDataById() {
        $cusCode = $_POST['cusCode'];
        $arr['cus_data'] = $this->Cash_model->getCustomersDataById($cusCode);
        $arr['credit_data'] = $this->Cash_model->getCustomersCreditDataById($cusCode);
        echo json_encode($arr);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        $sup= $_REQUEST['nonRt'];$inv= $_REQUEST['invNo'];$pl=$_REQUEST['price_level'];
        echo $this->Cash_model->loadproductjson($query,$sup,$inv,$pl);
        die;
    }
    
    public function saveReturn() {
        $barcode = 1;
        
        $grnNo = $this->Cash_model->get_max_code('Invoice Return');
        $invNo = $_POST['invoicenumber'];
//        $addCharge = $_POST['additional'];
        $remark = $_POST['remark'];
        $invDate = $_POST['invDate'];
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $total_amount = $_POST['total_amount'];
        $total_discount = $_POST['total_discount'];
        $total_net_amount = $_POST['total_net_amount'];
        $total_cost = $_POST['total_cost'];
        $location = $_POST['location'];
        $supplier =$_POST['cuscode'];
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
        
        $retHed = array(
            'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
            'InvoiceNo' => $invNo,'CustomerNo' => $supplier,'Remark' => $remark,'ReturnAmount' => $total_amount,'ReturnUser' => $invUser,'IsComplete' => $isComplete,'IsCancel'=>0
        );
        
        $nonRet = array(
            'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => $grnDattime,'InvCount'=> 1,
            'InvoiceNo' => $invNo,'CustomerNo' => $supplier,'Remark' => $remark,'ReturnAmount' => $total_amount,'ReturnUser' => $invUser,'IsComplete' => $isComplete,'IsCancel'=>0
        );
        
        $grnCredit = array(
            'AppNo' => '1','GRNNo' => $grnNo,'Location' => $location,'GRNDate' => $invDate,'SupCode' => $supplier,'CreditAmount' => $total_net_amount,'NetAmount' => $total_net_amount,'IsCloseGRN' => 0,'SettledAmount' => 0,'IsCancel'=>0
        );
        
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Cash_model->get_data_by_where('company',$id3);
        $company = $this->data['company']['CompanyName'];
        $res2= $this->Cash_model->saveReturn($retHed,$_POST,$grnNo,$totalDisPerent,$nonRet);
        $return = array(
            'InvNo' => $grnNo,
            'InvDate' => $invDate
        );
      
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }

    public function sendEmail (){
        $this->load->library('email');

        $this->email->from('nsoftfb@gmail.com', 'Nsoft Solutions');
        $this->email->to('esankas@gmail.com');
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
        die;
    }

    public function cashSummary($date){
        // echo $_REQUEST['date'];die;
        $location = $_SESSION['location'];
        $this->load->model('admin/Cash_model');
        $id3 = array('CompanyID' => $location);
        $result['company'] = $this->Cash_model->get_data_by_where('company', $id3);
        $this->load->model('admin/Report_model');
        $enddate   = $date;
        $startdate = '';
        $route     = $location;
        $routeAr   = isset($_REQUEST['route_ar']) ? json_decode($_REQUEST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('JobLocation',$route)->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;
        $result['date']       =$enddate;
        $result['newcus']       =  $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate)',$enddate)->where('IsActive',1)->get()->row()->new;
        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('DATE(appoimnetDate)',$enddate)->where('JLocation',$route)->where('DATE(customer.JoinDate)!=',$enddate)->get()->row()->new;
        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->get()->row()->new;
        $result['completejobs'] =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',2)->get()->row()->new;
        $result['pendingjob']   =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',0)->get()->row()->new;
        $result['overjob']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)=',$enddate)->where('DATE(deliveryDate)<',$enddate)->where('IsCompelte',0)->get()->row()->new;
        // $result['cashier'] =  $this->db->select('users.first_name')->from('cashflot')->join('users','users.id=cashflot.SystemUser')->where('DATE(FlotDate)',date("Y-m-d"))->get()->row()->first_name;
        
        $result['pro']         = $this->Report_model->genjobdaysalesumreportbypayment($startdate, $enddate, $route,$routeAr);
        $result['cash']        = $this->Report_model->genjobdaycashsumreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevcash']    = $this->Report_model->genjobdaysumreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['expenses']    = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn']        = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        $result['inout']       = $this->Report_model->cashinoutbyroutebytype($startdate, $enddate, $route,$routeAr,12);
        $result['salary']      = $this->Report_model->cashinoutsalarybytype($startdate, $enddate, $route,$routeAr,12);
        $result['expearn']     = $this->Report_model->cashfloatbytype($startdate, $enddate, $route,$routeAr,12,'');
        $result['procash']     = $this->Report_model->gencashreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevprocash'] = $this->Report_model->gencashreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['product']     = $this->Report_model->gencashreportbyproduct($startdate, $enddate, $route,$routeAr);
        $result['part']        = $this->Report_model->gencashreportbypart($startdate, $enddate, $route,$routeAr);
        $result['suppay']      = $this->Report_model->totalsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,1);
        $isEnd = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
        if($isEnd>0){
            $result['lastbal']     = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->EndFlot;
        }else{
            $result['lastbal']     = 0;
        }

        $isStart = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
        if($isStart>0){
            $result['startbal']     = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        }else{
            $result['startbal']     = 0;
        }

        $isCash = $this->db->select('SystemUser')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
        if($isCash>0){
            $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('cashierbalancesheet.Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;
        }else{
            $result['cashier']     = '';
        }
        
        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->row();
        $this->load->helper('file');
        $html = $this->load->view('admin/cash/cash_summary', $result, true);
    // $this->template->admin_render('admin/cash/index', $result);
        $this->load->library('email');

        $this->email->from('noreply@nsoft.lk', 'Nsoft Notification');
        $this->email->to('gaminiwh@gmail.com');
        // $this->email->cc('info@nsoft.lk');
        $this->email->bcc('esankas@gmail.com');

        $this->email->subject('Daily Cash Balance - '. $date.' - '.$result['company']['CompanyName']);
        $this->email->message($html);
        $res = $this->email->send();
        return $res;
        die;

    }
}
