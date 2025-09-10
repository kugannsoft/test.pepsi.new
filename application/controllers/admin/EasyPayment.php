<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EasyPayment extends Admin_Controller {

    public function __construct() {

        parent::__construct();
        $this->CI = & get_instance();/*shalika*/
        if (!$this->ion_auth->logged_in() OR !$this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Payment_model');
        $this->load->helper('number');
        $this->load->model('admin/Customer_model');
        $this->load->model('admin/Job_model');
        $this->load->model('admin/Easy_model');
        date_default_timezone_set("Asia/Colombo");

    }

    public function easyPayment() {

        $ac_no = isset($_GET['ac_no'])?$_GET['ac_no']:NULL;
        $balance = isset($_GET['balance'])?$_GET['balance']:NULL;

        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Add Easy Payment Invoice");
        $this->data['accountCode'] = $this->Customer_model->getMaxAccIdByType('AccountNo');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['getCusTypes'] = $this->Customer_model->customerType();
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->data['pricelevel'] = $this->Easy_model->pricelevel();
        $this->data['ac_no'] = $ac_no;
        $this->data['balance'] = $balance;
        
        $date = date("Y-m-d");
        $user = $_SESSION['user_id'];
        $isend = $this->db->select('ID')->from('cashierbalancesheet')->where('DATE(BalanceDate)' ,$date)->where('SystemUser' ,$user)->get()->num_rows();

        if ($isend > 0){
            $this->template->admin_render('easy/easy_payment', $this->data);
        } else {
            redirect('admin/cash/cash_float_balance');
        }

    }

    public function getActiveAccounts()
    {
        $keyword = $_REQUEST['name_startsWith'];
        $cusType = $_REQUEST['cus_type'];
        echo $this->Easy_model->getActiveAccounts($keyword,$cusType); die;
    }

    public function getExtraChargesById()
    {
        $accType = $_REQUEST['itemType'];
        $q = $this->db->select('charges_type.charge_type, item_charges.ChargeAmount')
            ->from('item_charges')
            ->join('charges_type','charges_type.charge_id = item_charges.ChargeType')
            ->where('item_charges.ItemType',$accType)
            ->get()->result();
        echo json_encode($q); die;
    }

    public function getTermInterest()
    {
        $accType = $_REQUEST['itemType'];
        $q = $this->db->select('IntTerm,Interest,IntId')->from('item_interest')->where('ItemType',$accType)->order_by('IntTerm', 'ASC')->get()->result();
        echo json_encode($q); die;

    }

    public function getTermInterestByID()
    {
        $accTypeId = $_REQUEST['id'];
        $q = $this->db->select('IntTerm,Interest,installment')->from('item_interest')->where('IntId',$accTypeId)->get()->row();
        echo json_encode($q); die;
    }

    public function getActiveProductCodes()
    {
        $keyword = $_REQUEST['name_startsWith'];
        $price_level = $_REQUEST['price_level'];
        $product_package = $_REQUEST['product_package'];
        if (isset($_REQUEST['sup']) && $_REQUEST['sup'] == 'ok' && isset($_REQUEST['supcode'])) {
            $result = $this->Easy_model->getActiveProductCodesBySup($_REQUEST['supcode'], $keyword, $price_level);
        }elseif (isset($product_package) && $product_package != 0){
            $result = $this->Easy_model->getActiveProductCodesByPackage($product_package, $keyword, $price_level);
        } else {
            $result = $this->Easy_model->getActiveProductCodes($keyword, $price_level);
        }

        echo json_encode($result); die;
    }

    public function saveInvoice()
    {
        $discount_type = $_POST['discount_type'];

        if ($discount_type == 2) {
            $totalDisPercent = $_POST['total_dis_percent'];
        } elseif ($discount_type == 1) {
            $totalDisPercent = 0;
        }
//      var_dump($_POST);die;

        $product_codeArr = json_decode($_POST['product_code']);
        $serial_noArr = json_decode($_POST['serial_no']);
        $qtyArr = json_decode($_POST['qty']);
        $unit_priceArr = json_decode($_POST['unit_price']);
        $discount_precentArr = json_decode($_POST['discount_precent']);
        $pro_discountArr = json_decode($_POST['pro_discount']);
        $total_netArr = json_decode($_POST['total_net']);
        $price_levelArr = json_decode($_POST['price_level']);

        //extra amounts
        $extra_dateArr = json_decode($_POST['extra_date']);
        $extra_descArr = json_decode($_POST['extra_desc']);
        $extra_amountArr = json_decode($_POST['extra_amount']);

        //down payment arrays
        $dwn_paymentArr = json_decode($_POST['dwn_paymentAr']);
        $dwn_pay_interestArr = json_decode($_POST['dwn_pay_interestAr']);
        $dwn_pay_int_rateArr = json_decode($_POST['dwn_pay_int_rateAr']);
        $dwn_pay_dateArr = json_decode($_POST['dwn_pay_dateAr']);
        $dwn_is_intArr = json_decode($_POST['dwn_is_intAr']);

        //payments array
        $monthArr = json_decode($_POST['monthAr']);
        $monPayArr = json_decode($_POST['monPayAr']);
        $pricArr = json_decode($_POST['pricAr']);
        $intArr = json_decode($_POST['intAr']);
        $balAr = json_decode($_POST['balAr']);
        $instalPymentTypes = json_decode($_POST['instalPymentTypes']);
        $acc_no = $_POST['acc_no'];

        $invNo = $this->Easy_model->get_max_code('LoanInvoiceNo');
        $down_payment = $_POST['dwn_payment'];
        $invDate = date("Y-m-d H:i:s");

        $qur_payment = $_POST['qur_payment'];
        $qur_pay_interest = $_POST['qur_pay_interest'];
        $qur_pay_int_rate = $_POST['qur_pay_int_rate'];
        $qur_pay_date = $_POST['qur_pay_date'];
        $qur_is_int = $_POST['qur_is_int'];

        $cusCode = $_POST['cusCode'];
        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $cash_amount = $_POST['cash_amount'];
        $cheque_amount = $_POST['cheque_amount'];
        $credit_amount = $_POST['credit_amount'];
        $total_amount = $_POST['total_amount'];
        $return_amount = $_POST['return_amount'];
        $refund_amount = 0;
        $tot_extra_chrages = $_POST['tot_extra_chrages'];
        $tot_extra_amount = $_POST['tot_extra_amount'];
        $total_discount = $_POST['total_discount'];
        $gross_amount = $_POST['gross_amount'];
        $final_amount = $_POST['final_amount'];

        $int_term = $_POST['int_term'];
        $int_term_interest = $_POST['int_term_interest'];
        $int_term_rate = $_POST['int_term_rate'];
        $is_int_term = $_POST['is_int_term'];

        $isPolishArr = '';
        $isSoldArr = '';
        $user = $_POST['invUser'];
        $accType = $_POST['accType'];
        $accCategory = $_POST['accCategory'];
        $location = $_POST['location'];
        $invUser = $_POST['invUser'];
        $mothly_payment_date = $_POST['mothly_payment_date'];

        $holidays = [];
        if ($instalPymentTypes == 3){

            $setDate = strtotime($mothly_payment_date);
            $termArray = count($monthArr);
            $startDate = date("Y-m-d", strtotime("+1 day", $setDate));
            $endDate = date("Y-m-d", strtotime("+$termArray day", strtotime($startDate)));

            $holidays = $this->Easy_model->getHolidayArray($startDate, $endDate);
        }
        $totalDwnPayment = 0;

        for ($i = 0; $i < count($dwn_paymentArr); $i++) {
            $totalDwnPayment+= $dwn_paymentArr[$i];
        }

        $result = $this->Easy_model->saveInvoice($acc_no, $accType, $accCategory, $location, $product_codeArr, $serial_noArr, $qtyArr, $unit_priceArr, $discount_precentArr, $pro_discountArr, $total_netArr, $price_levelArr, $extra_dateArr, $extra_descArr, $extra_amountArr, $dwn_paymentArr, $dwn_pay_interestArr, $dwn_pay_int_rateArr, $dwn_pay_dateArr, $dwn_is_intArr, $monthArr, $monPayArr, $pricArr, $intArr, $balAr, $instalPymentTypes, $acc_no, $down_payment, $qur_payment, $qur_pay_interest, $qur_pay_int_rate, $qur_pay_date, $qur_is_int, $tot_extra_chrages, $tot_extra_amount, $isPolishArr, $total_discount, $gross_amount, $int_term, $isSoldArr, $int_term_interest, $int_term_rate, $is_int_term, $invDate, $cusCode, $user, $invNo, $chequeNo, $chequeReference, $chequeRecivedDate, $chequeDate, $cash_amount, $cheque_amount, $credit_amount, $total_amount, $return_amount, $refund_amount, $invUser, $totalDwnPayment, $final_amount, $totalDisPercent,$mothly_payment_date, $holidays);
        $return['fb'] = $result;
        echo json_encode($return);
        die;
    }

    public function easyPaymentSettlement() {
        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Easy Payment Settlement");
        $this->data['accountCode'] = $this->Customer_model->getMaxAccIdByType('AccountNo');
        $id3 = array('CompanyID' => 1);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['getCusTypes'] = $this->Customer_model->customerType();
        $this->data['getCusAccountTypes'] = $this->Customer_model->customerAccountType();
        $this->data['paymentType'] = $this->Easy_model->paymentType();
        $this->data['PenaltySetting'] = $this->Easy_model->getPenaltySetting();
        
        $date = date("Y-m-d");
        $user = $_SESSION['user_id'];
        $isend = $this->db->select('ID')->from('cashierbalancesheet')->where('DATE(BalanceDate)' ,$date)->where('SystemUser' ,$user)->get()->num_rows();

        if ($isend > 0){
            $this->template->admin_render('easy/easy_payment_settlement', $this->data);
        } else {
            redirect('admin/cash/cash_float_balance');
        }

    }

    public function loadAccounts()
    {
        $keyword = $_REQUEST['name_startsWith'];
        $cus_type = $_REQUEST['cus_type'];

            $result = $this->Easy_model->loadAccounts($keyword);

        echo json_encode($result); die;
    }

    public function getRentalPaymentData()
    {
        $accNo = $_REQUEST['accNo'];

        $result = $this->Easy_model->getRentalPaymentData($accNo);

        echo json_encode($result); die;
    }

    public function checkIsReschedule()
    {
        $accNo = $_REQUEST['accNo'];

        $result = $this->Easy_model->checkIsReschedule($accNo);

        if (isset($result)) {
        echo json_encode($result); die;
        }
    }

    public function getDownPaymentData()
    {
        $invoiceNo = $_REQUEST['InvNo'];

        $result = $this->Easy_model->getDownPaymentData($invoiceNo);

        if (isset($result)) {
            echo json_encode($result); die;
        }

    }

    public function getRentalExtraAmount()
    {
        $invoiceNo = $_REQUEST['InvNo'];

        $result = $this->Easy_model->getRentalExtraAmount($invoiceNo);

        if (isset($result)) {
            echo json_encode($result); die;
        }
    }

    public function getPaymentDataByAccNo()
    {
        $invoiceNo = $_REQUEST['InvNo'];

        $result = $this->Easy_model->getPaymentDataByAccNo($invoiceNo);

        if (isset($result)) {
            echo json_encode($result); die;
        }
    }

    public function customerPayment()
    {
        $cash_amount=0;
        $cheque_amount=0;

        $paymentNo = $this->Easy_model->get_max_code('LoanPaymentNo');
//    echo $paymentNo;die;
        $invNo = $_POST['invNo'];
        $accNo = $_POST['acc_no'];
        $invDate = $_POST['invDate'];
        $payType = $_POST['payType'];
        $payDate = date("Y-m-d H:i:s");
        $payAmount = $_POST['payAmount'];
//    $cusCode = '';
        $cusCode = $_POST['cusCode'];
        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $settle_amount = $_POST['settleAmount'];
        $isInvoiceColse = $_POST['isInvoiceColse'];
        $month = json_decode($_POST['month']);
        $credit_invoiceArr = '';
//    $credit_invoiceArr = json_decode($_POST['credit_invoice']);
        $cus_settle_amountArr = json_decode($_POST['cus_settle_amount']);
        $cus_credit_amountArr = json_decode($_POST['cus_credit_amount']);
        $cus_inv_paymentArr = json_decode($_POST['cus_inv_payment']);
        $rental_default =json_decode($_POST['rental_default']);
        $extAmounts =json_decode($_POST['ExtAmounts']);
        $over_pay_amount = $_POST['over_pay_amount'];
        $over_pay_inv = $_POST['over_pay_inv'];
//     $over_pay_inv ='';
//    echo count($cus_inv_paymentArr);die;
        $extra_amount = $_POST['rd_extraAmount'];
        $insu_amount = $_POST['rd_InsuranceAmount'];

        $total_settle = $_POST['total_settle'];

        $totalPaidAmount = $_POST['totalPaidAmount'];
        $totalDueAmount = $_POST['totalDueAmount'];

        if ($payType == 1) {
            $chequeReference = '';
            $chequeRecivedDate = '';
            $chequeDate = '';
            $cash_amount=$total_settle;
        }elseif ($payType == 3) {
            $cheque_amount=$total_settle;
        }
        elseif ($payType == 4) {
            $cash_amount=$total_settle;
        }

        $result = $this->Easy_model->addCustomerPayment($paymentNo, $invNo,$accNo, $payType, $payDate, $payAmount, $cusCode, $chequeNo, $chequeReference, $chequeRecivedDate, $chequeDate, $settle_amount, $isInvoiceColse, $credit_invoiceArr, $cus_settle_amountArr,$cus_credit_amountArr, $total_settle,$cash_amount,$cheque_amount,$cus_inv_paymentArr,$rental_default,$over_pay_amount,$over_pay_inv,$month,$extra_amount,$insu_amount,$invDate,$extAmounts,$totalPaidAmount,$totalDueAmount);
        $return['fb'] = $result;
        echo json_encode($return);
        die;
    }

    public function downPayment()
    {
        $cash_amount=0;
        $cheque_amount=0;

        $paymentNo = $this->Easy_model->get_max_code('DwPayNo');
        $invNo = $_POST['invNo'];
        $accNo = $_POST['acc_no'];
        $invDate = $_POST['invDate'];
        $payType = $_POST['payType'];
        $payDate = $_POST['payDate'];
        $payAmount = $_POST['payAmount'];
//    $cusCode = '';
        $cusCode = $_POST['cusCode'];
        $chequeNo = $_POST['chequeNo'];
        $chequeReference = $_POST['chequeReference'];
        $chequeRecivedDate = $_POST['chequeRecivedDate'];
        $chequeDate = $_POST['chequeDate'];
        $settle_amount = $_POST['settleAmount'];
        $isInvoiceColse = $_POST['isInvoiceColse'];
        $month = json_decode($_POST['month']);
        $credit_invoiceArr = '';
//    $credit_invoiceArr = json_decode($_POST['credit_invoice']);
        $cus_settle_amountArr = json_decode($_POST['cus_settle_amount']);
        $cus_credit_amountArr = json_decode($_POST['cus_credit_amount']);
        $cus_inv_paymentArr = json_decode($_POST['cus_inv_payment']);
        $rental_default =json_decode($_POST['rental_default']);
        $extAmounts =json_decode($_POST['ExtAmounts']);
        $over_pay_amount = $_POST['over_pay_amount'];
        $over_pay_inv = $_POST['over_pay_inv'];
//  $over_pay_inv ='';
//    echo count($cus_inv_paymentArr);die;
        $extra_amount = $_POST['rd_extraAmount'];
        $insu_amount = $_POST['rd_InsuranceAmount'];

        $total_settle = $_POST['total_settle'];

        if ($payType == 1) {
            $chequeReference = '';
            $chequeRecivedDate = '';
            $chequeDate = '';
            $cash_amount=$total_settle;
        }elseif ($payType == 3) {
            $cheque_amount=$total_settle;
        }
        elseif ($payType == 4) {
            $cash_amount=$total_settle;
        }

        $result = $this->Easy_model->addDownPayment($paymentNo, $invNo,$accNo, $payType, $payDate, $payAmount, $cusCode, $chequeNo, $chequeReference, $chequeRecivedDate, $chequeDate, $settle_amount, $isInvoiceColse, $credit_invoiceArr, $cus_settle_amountArr,$cus_credit_amountArr, $total_settle,$cash_amount,$cheque_amount,$cus_inv_paymentArr,$rental_default,$over_pay_amount,$over_pay_inv,$month,$extra_amount,$insu_amount,$invDate,$extAmounts);
        $return['fb'] = $result;
        echo json_encode($return);
        die;
    }

    function reschedule() {
        $cusCode_last = $_POST['cusCode'];
        $acc_no_last = $_POST['acc_no'];
        $invDate = $_POST['invDate'];
        $id_no_last = $_POST['id_no'];
        $finale_balance = $_POST['finale_balance'];

        $accCode = "LOO-RE/";
        $cusCode = $cusCode_last;
        $cusNic = $id_no_last;
        $acc_date = $invDate;
        $remark = '';
        $acc_type = '2';
        $acc_category = '3';
        $location = '1';
        $inv_user = $_POST['invUser'];
        $guarantNicArr = [];
        $guarantCodeArr = [];

        $accInt = $this->Customer_model->getMaxAccIdByType("AccountNo");
        $accId = $this->Customer_model->getMaxAccId() + 1;

        //get last account number
        $accNo = $accCode . $accInt;

        $result = $this->Easy_model->addRescheduleAccount($accId,$accNo,$accCode, $cusCode, $cusNic, $acc_date, $remark, $acc_type, $acc_category, $location, $inv_user, $guarantNicArr, $guarantCodeArr,$invDate, $cusCode_last, $acc_no_last, $finale_balance);
        $result2 = $this->Easy_model->getLastRecord();
        $return['fb'] = $result;
        $return['lastAccount'] = $result2;
        echo json_encode($return);
        die;
    }

    public function easyPaymentSchedule()
    {
        $ac_no = isset($_GET['ac_no'])?$_GET['ac_no']:NULL;
        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Payment Schedule Report");
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['invoice_data'] = $this->Easy_model->getPaymentDataByAccountNo($ac_no);
        $this->data['ac_no'] = $ac_no;
        $this->template->admin_render('easy/print_payment_schedule', $this->data);
    }

    public function invoicePrint()
    {
        $ac_no = isset($_GET['ac_no'])?$_GET['ac_no']:NULL;
        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Easy Payment Invoice");
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $this->db->select('Location')->from('invoice_hed')->where('AccNo', $ac_no)->get()->row()->Location;
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
        $this->data['item_data'] = $this->Easy_model->invoicePrint($ac_no);
        $this->data['invoice_dtl'] = $this->Easy_model->getInvoiceDetailsByNo($ac_no);
        $this->data['invoice_hed'] = $this->Easy_model->getInvoiceByNo($ac_no);
        $this->data['invoice_gurent'] = $this->Easy_model->getGuranteeDataByNo($ac_no);
        $this->data['ac_no'] = $ac_no;
         $this->data['term'] = $this->db->select()->from('invoice_condition')->where('InvType', 7)->get()->result();
        $this->template->admin_render('easy/accountinv_print', $this->data);
    }

    public function printRSchedule()
    {
        $ac_no = isset($_GET['ac_no'])?$_GET['ac_no']:NULL;
        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Easy Payment Invoice");
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $location = $this->db->select('Location')->from('invoice_hed')->where('AccNo', $ac_no)->get()->row()->Location;
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
        $this->data['invoice_hed'] = $this->Easy_model->getInvoiceByNo($ac_no);
        $this->data['item_data'] = $this->Easy_model->getRentalPaymentData($ac_no);
        $this->data['ac_no'] = $ac_no;
        $this->template->admin_render('easy/schedule_print', $this->data);
    }

    public function getReceiptInvNo()
    {
        $invNo = $_POST['invNo'];
        $arr['receipt_hed'] = $this->Easy_model->getReceiptHed($invNo);
        $arr['pay_amount_word'] = strtoupper($this->Payment_model->convert_number_to_words( floatval($arr['receipt_hed']->TotalPayment)))." ONLY";
        echo json_encode($arr);
        die;
    }

    public function allEasySettlement()
    {
        $q = isset($_GET['q'])?$_GET['q']:NULL;
        /* Title Page */
        $this->page_title->push('Easy Settlement Receipt');
        $this->data['pagetitle'] = 'All Easy Settlement Receipt';

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Easy Payment', 'easy/easyPayment');
        $this->breadcrumbs->unshift(1, 'All Easy Settlement Receipt', 'easy/allEasySettlement');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['q'] = $q;

        $this->template->admin_render('easy/allEasySettlement', $this->data);
    }

    public function view_easy_invoice($inv=null) {

        $this->load->model('admin/Salesinvoice_model');
        $invNo=base64_decode($inv);
        $this->page_title->push('Sales Invoice');
        $this->data['pagetitle'] = 'Sales Invoice-'.$invNo;

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Easy', 'admin/sales/');
        $this->breadcrumbs->unshift(1, 'Easy Invoice', 'admin/sales/view_easy_invoice');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $location = 1;
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);

        $this->data['receipt_hed'] = $this->Easy_model->getReceiptHedByReceiptId($invNo);
        $this->data['pay_amount_word'] = strtoupper($this->Payment_model->convert_number_to_words( floatval($this->data['receipt_hed']->TotalPayment)))." ONLY";

        $this->template->admin_render('easy/easy_recipt_print2', $this->data);

    }

    public function allAccount()
    {
        $q = isset($_GET['q'])?$_GET['q']:NULL;
        /* Title Page */
        $this->page_title->push('Easy Settlement Receipt');
        $this->data['pagetitle'] = 'All Easy Settlement Receipt';

        /* Breadcrumbs */
        $this->breadcrumbs->unshift(1, 'Easy Payment', 'easy/easyPayment');
        $this->breadcrumbs->unshift(1, 'All Easy Settlement Receipt', 'easy/allEasySettlement');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['q'] = $q;

        $this->template->admin_render('easy/allAccount', $this->data);
    }
    
    public function easyPaymentCancel()
    {

        $this->breadcrumbs->unshift(1, 'Customer Account', 'admin/customer');
        $this->page_title->push("Cancel Easy Payment Invoice");
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin_render('easy/easy_payment_cancel', $this->data);
    }

    public function getActiveEasyPayment()
    {
        $keyword = $_REQUEST['name_startsWith'];
        $accNo = $_REQUEST['AccNo'];
        $result = $this->Easy_model->getActiveEasyPayment($keyword,$accNo);
        echo json_encode($result);
        die;
    }

    public function getEasyPaymentDataById()
    {
        $paymentId = $_REQUEST['paymentId'];
        $result = $this->Easy_model->getEasyPaymentDataById($paymentId);
        echo json_encode($result);
        die;
    }

    public function cancelEasyPayment()
    {
        $paymentId = $_POST['paymentNo'];
        $remark = $_POST['remark'];
        $invUser = $_POST['invUser'];
        $canDate = $_POST['payDate'];
        $cusCode = $_POST['cusCode'];
        $invno = $_POST['invNo'];
        $credit_invoiceArr = json_decode($_POST['credit_invoice']);
        $cus_settle_amountArr = json_decode($_POST['cus_settle_amount']);
        $monthArr = json_decode($_POST['month']);

        $result = $this->Easy_model->cancelEasyPayment($paymentId, $remark, $invUser, $canDate, $cusCode, $invno, $cus_settle_amountArr, $credit_invoiceArr,$monthArr);
        $return['fb'] = $result;
        echo json_encode($return);
        die;
    }
    
    public function allEasyPayment()
    {
            $q = isset($_GET['q'])?$_GET['q']:NULL;
            /* Title Page */
            $this->page_title->push('Easy Settlement Receipt');
            $this->data['pagetitle'] = 'All Easy Invoice';

            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Easy Payment', 'easy/easyPayment');
            $this->breadcrumbs->unshift(1, 'All Easy Invoice Receipt', 'easy/allEasyPayment');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->data['q'] = $q;

            $this->template->admin_render('easy/allEasyInvoice', $this->data);

    }


}