<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Report_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }

    public function salesbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/salesbydate2', $this->data);
        } else {
            $this->template->admin_render('admin/report/salesbydate2', $this->data);
        }
    }

    public function easybydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Easy payment by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/easypaymentbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/easypaymentbydate', $this->data);
        }
    }

    public function easypaymentnydate() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $invtype = isset($_POST['inv_type']) ? $_POST['inv_type'] : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : 0;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
//        $result = $this->Report_model->gensalesreportbyroute($startdate, $enddate, $route,$routeAr,$invtype,$salesperson);
        $result      = $this->Report_model->totaleasycuspaymentsummarydaterange($startdate, $enddate, $route,$routeAr,1);
//var_dump($result);die();
        echo json_encode($result);die;
    }

  public function easySummeryByDate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Easy', 'admin/report/easySummeryByDate');
        $this->page_title->push(('Easy payment Summery By Date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/easysummeryreport', $this->data);
        } else {
            $this->template->admin_render('admin/report/easysummeryreport', $this->data);
        }
    }

    public function easypaymentnsummerybydate() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $invtype = isset($_POST['inv_type']) ? $_POST['inv_type'] : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : 0;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result['invHead']     = $this->Report_model->totaleasycuspaymentsummarybydate($startdate, $enddate, $route,$routeAr,1);
        $result['paidDetails']     = $this->Report_model->totaleasycuspaymentsummarybydatepaydetails($enddate, $route,$routeAr,1);
//var_dump($result['paidDetails']);die();
        echo json_encode($result);die;
    }

    public function orderbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Order by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
//        $people = array("0", "10", "13");
//
//        if (in_array($_SESSION['user_id'], $people)) {
//            $this->template->admin_render('admin/report/salesbydate2', $this->data);
//        } else {
            $this->template->admin_render('admin/report/orderbydate', $this->data);
//        }
    }

    public function directsalesbyproduct() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Sale by product'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/possalesbyproduct', $this->data);
        } else {
            $this->template->admin_render('admin/report/possalesbyproduct', $this->data);
        }
    }

    public function salesbydatePos() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
//        $people = array("0", "10", "13");
//
//        if (in_array($_SESSION['user_id'], $people)) {
//            $this->template->admin_render('admin/report/salesbydate2', $this->data);
//        } else {
            $this->template->admin_render('admin/report/salesbydatePos', $this->data);
//        }
    }

    public function loadreportPos()
    {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genreportbyroute($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }


    public function salesbyproduct() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbyproduct');
        $this->page_title->push(('Sale by Product'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/salesbyproduct', $this->data);
        } else {
            $this->template->admin_render('admin/report/salesbyproduct2', $this->data);
        }
    }

    public function psalesbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/salesbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/salesbydate', $this->data);
        }
    }

    public function psalesbyproduct() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbyproduct');
        $this->page_title->push(('Sale by Product'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/psalesbyproduct', $this->data);
        } else {
            $this->template->admin_render('admin/report/psalesbyproduct', $this->data);
        }
    }

    public function serialstock() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/serialreport');
        $this->page_title->push(('Product Serial Stock'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/serialreport', $this->data);
    }

    public function productreport() {
         $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/productreport');
        $this->page_title->push(('Product Stock'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->template->admin_render('admin/report/productreport', $this->data);
    }

    public function pricereport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/pricereport');
        $this->page_title->push(('Product Price  Stock'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->template->admin_render('admin/report/pricereport', $this->data);
    }

    public function dailyfinalreport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/dailyfinalreport');
        $this->page_title->push(('Daily Phone Stock'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadSerialProduct();
        $this->template->admin_render('admin/report/dailyfinalreport', $this->data);
    }
    
    public function lowstockreport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/lowstockreport');
        $this->page_title->push(('Minimum Stock Summery'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/lowstockreport', $this->data);
    }
    
    public function trasferreport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Stock Tranfer Detail'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/trasferreport', $this->data);
    }

    public function grnreport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'GRN', 'admin/report/Vastage Report');
        $this->page_title->push(('Good Received Detail'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/grnreport', $this->data);
    }
    
    public function cashfloat() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Expenses/ Earninig'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/cashfloatreport', $this->data);
    }
    
    public function cashinout() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Cash Float In Out'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] =  $this->Report_model->loadproduct();
        $this->data['transType'] = $this->db->get_where('transactiontypes', array('IsActive' => 1))->result();
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsActive',1)->get()->result();
            
        $this->template->admin_render('admin/report/cashinoutreport', $this->data);
    }
    
    public function dailycashturnover() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Cash Turn Over - Direct Sale/ Customer Order/ Easy Payment'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] =  $this->Report_model->loadproduct();
        $this->data['transType'] = $this->db->get_where('transactiontypes', array('IsActive' => 1))->result();
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsActive',1)->get()->result();

        $this->template->admin_render('admin/report/cashturnover', $this->data);
    }
    
     public function monthwiseincomereport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Monthly Transaction'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] =  $this->Report_model->loadproduct();
        $this->data['transType'] = $this->db->get_where('transactiontypes', array('IsActive' => 1))->result();
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsActive',1)->get()->result();

        $this->template->admin_render('admin/report/monhwisereport', $this->data);
    }

     public function loadmonthlywisereport() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('JobLocation',$route)->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;


        $result['pro']         = $this->Report_model->genjobdaysalesumreportbypayment($startdate, $enddate, $route,$routeAr);
        $result['cash']        = $this->Report_model->genjobdaycashsumreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevcash']    = $this->Report_model->genjobdaysumreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['expenses']    = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn']        = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        $result['inout']       = $this->Report_model->cashinoutbyroutebytype($startdate, $enddate, $route,$routeAr,12);
        $result['salary']      = $this->Report_model->cashinoutsalarybytype($startdate, $enddate, $route,$routeAr,12);
        $result['procash']     = $this->Report_model->gencashreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevprocash'] = $this->Report_model->gencashreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['product']     = $this->Report_model->gencashreportbyproduct($startdate, $enddate, $route,$routeAr);
        $result['suppay']      = $this->Report_model->totalsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,1);

        $result['easy']        = $this->Report_model->monthlyreportbydateeasy($startdate, $enddate, $route,$routeAr);
        $result['easycuspay']      = $this->Report_model->monthlyreportbydateeasypay($startdate, $enddate, $route,$routeAr);
        $result['cusodercuspay']      = $this->Report_model->monthlyreportbydatecustomerorderpayment($startdate, $enddate, $route,$routeAr);
        $result['part']        = $this->Report_model->monthlyreportbydate($startdate, $enddate, $route,$routeAr);
        $result['expearn']     = $this->Report_model->monthlyreportbyexpensess($startdate, $enddate, $route,$routeAr);
        $result['coder']        = [];

        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->result();

        echo json_encode($result);
        die;
    }

    public function dailycashturnoversummary() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Cash Turn Over - Direct Sale/ Customer Order/ Easy Payment'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] =  $this->Report_model->loadproduct();
        $this->data['transType'] = $this->db->get_where('transactiontypes', array('IsActive' => 1))->result();
        $this->data['salesperson'] = $this->db->select()->from('salespersons')->where('IsActive',1)->get()->result();

        $this->template->admin_render('admin/report/dailycashturnoversummary', $this->data);
    }

    public function loadreportturnoversummery() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
//        var_dump($enddate,$startdate);die();
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('JobLocation',$route)->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;


        // echo json_encode($result);
        // die;
//        $result['newcus']       =  $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate)',$enddate)->where('IsActive',1)->get()->row()->new;
//        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('DATE(customer.JoinDate)!=',$enddate)->get()->row()->new;
//        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->get()->row()->new;
//        $result['completejobs'] =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',2)->get()->row()->new;
//        $result['pendingjob']   =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',0)->get()->row()->new;
//        $result['overjob']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)=',$enddate)->where('DATE(deliveryDate)<',$enddate)->where('IsCompelte',0)->get()->row()->new;
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
        $result['suppay']      = $this->Report_model->totalsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,1);

        $result['easy']        = $this->Report_model->gencashreportbyeasydaterangesummary($startdate, $enddate, $route,$routeAr);
        $result['easycuspay']      = $this->Report_model->totaleasycuspaymentsummarydaterangesummery($startdate, $enddate, $route,$routeAr,1);
        $result['cusodercuspay']      = $this->Report_model->totalcusodercuspaymentsummarydaterangesummery($startdate, $enddate, $route,$routeAr,1);
        $result['part']        = $this->Report_model->gencashreportbypartdaterangesummery($startdate, $enddate, $route,$routeAr);
        $result['coder']        = $this->Report_model->gencashreportbycoderdaterange($startdate, $enddate, $route,$routeAr);

//        $isEnd = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isEnd>0){
//            $result['lastbal']     = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->EndFlot;
//        }else{
//            $result['lastbal']     = 0;
//        }

//        $isStart = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isStart>0){
//            $result['startbal']     = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
//        }else{
//            $result['startbal']     = 0;
//        }

//        $isCash = $this->db->select('SystemUser')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isCash>0){
//            $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('cashierbalancesheet.Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;
//        }else{
//            $result['cashier']     = '';
//        }
        // $result['startbal']    = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        // $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;

        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->result();

        // $query2 = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        // $result['lastbal'] =$query2->result();
//                        var_dump($result['bal']);die();

        echo json_encode($result);
        die;
    }
    
    public function salebyinvoice() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/Vastage Report');
        $this->page_title->push(('Invoice Detail'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/invoicereport', $this->data);
    }

    /*job sales*/
    public function jobsalesbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Job Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbydate2', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbydate', $this->data);
        }
    }

    public function jobsalesumbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Job Sale Summery by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesumbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesumbydate', $this->data);
        }
    }

    public function jobsaledaysumbydate() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Daily Cash Balance'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsaledaysumbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsaledaysumbydate', $this->data);
        }
    }

    public function dailybalance() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Daily Cash Report'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/dailybalancereport', $this->data);
        } else {
            $this->template->admin_render('admin/report/dailybalancereport', $this->data);
        }
    }

    public function dailybalancedetail() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Daily Cash Summary Detail Report'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/dailybalancedetailreport', $this->data);
        } else {
            $this->template->admin_render('admin/report/dailybalancedetailreport', $this->data);
        }
    }

    public function monthlybalancedetail() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/salesbydate');
        $this->page_title->push(('Monthly Cash Summary Detail Report'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/monthlybalancedetailreport', $this->data);
        } else {
            $this->template->admin_render('admin/report/monthlybalancedetailreport', $this->data);
        }
    }

    public function jobsalesbyproduct() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyproduct');
        $this->page_title->push(('Job Sale by Product'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbyproduct', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbyproduct', $this->data);
        }
    }

    public function jobsalesbyservice() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyservice');
        $this->page_title->push(('Job Sale by Services'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbyservice', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbyservice', $this->data);
        }
    }

    public function jobsalesbymake() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyservice');
        $this->page_title->push(('Job Sale by Make'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $this->data['jobsection'] = $this->db->select('*')->from('job_section')->get()->result();
        $this->data['make'] = $this->db->select('*')->from('make')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbymake', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbymake', $this->data);
        }
    }

    public function jobsalesbyinvoice() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyservice');
        $this->page_title->push(('Job Sale by Invoices'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbyinvoice', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbyinvoice', $this->data);
        }
    }

    public function jobpaymentbyinvoice() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyservice');
        $this->page_title->push(('Job Payments by Invoices'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobpaymentsbyinvoice', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobpaymentsbyinvoice', $this->data);
        }
    }

    public function jobdelivery() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobdelivery');
        $this->page_title->push(('Job Delivery Date Exceed report'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobdelivery', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobdelivery', $this->data);
        }
    }

//    services------------------------------------------------------------------
    public function loadreport1() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
         $invtype = isset($_POST['inv_type']) ? $_POST['inv_type'] : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : 0;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->gensalesreportbyroute($startdate, $enddate, $route,$routeAr,$invtype,$salesperson);
        echo json_encode($result);die;
    }

    public function loadorederdataby() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $invtype = isset($_POST['inv_type']) ? $_POST['inv_type'] : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : 0;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->orderreportbydatewise($startdate, $enddate, $route,$routeAr,$invtype,$salesperson);
        echo json_encode($result);die;
    }

    public function loadreportdirectproductby() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $invtype = isset($_POST['inv_type']) ? $_POST['inv_type'] : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $salesperson = isset($_POST['salesperson']) ? $_POST['salesperson'] : 0;
        $product = isset($_POST['product']) ? $_POST['product'] : 0;
        $department = isset($_POST['department']) ? $_POST['department'] : 0;
        $subdepartment = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : 0;
        $subcategory_ar = isset($_POST['subcategory_ar']) ? $_POST['subcategory_ar'] : 0;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->gensalesreportbyrouteforproduct($startdate, $enddate, $route,$routeAr,$invtype,$salesperson,$product,$department,$subdepartment);
        echo json_encode($result);die;
    }

    public function loadreport2() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genreportbyproduct($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['dis'] = $this->Report_model->genreporttotalDiscountbyproduct($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['expenses'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        echo json_encode($result);die;
    }

    public function loadreport3() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        // $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['dep_ar']) ? json_decode($_POST['dep_ar']) : NULL;
        $subdep = isset($_POST['subdep_ar']) ? json_decode($_POST['subdep_ar']) : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
         $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->productdetail($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);die;
    }

    public function loadreport4() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? $_POST['isall'] : 'all';
        // $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['dep_ar']) ? json_decode($_POST['dep_ar']) : NULL;
        $subdep = isset($_POST['subdep_ar']) ? json_decode($_POST['subdep_ar']) : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
         $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->productdetailserial($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);die;
    }

    public function loadreport5() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $result = $this->Report_model->priceproductdetail($route, $isall, $product,$dep,$subdep,$sup);
        echo json_encode($result);die;
    }

    public function loadreport6() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : 'NULL';
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $product = 'NULL';
        if ($_POST['product'] != '' || $_POST['product'] != 0) {
            $product = $_POST['product'];
        }
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory']) ? $_POST['subcategory'] : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $result = $this->Report_model->productdailyfinalstock($startdate, $enddate, $route, $product,$dep,$subdep,$subcat);
        echo json_encode($result);die;
    }
    
    public function loadreport7() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : 'NULL';
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $product = 'NULL';
        if ($_POST['product'] != '' || $_POST['product'] != 0) {
            $product = $_POST['product'];
        }
        $result = $this->Report_model->productdailyfinalstock($startdate, $enddate, $route, $product);
        echo json_encode($result);die;
    }
    
    public function loadreport8() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? $_POST['isall'] : 'all';
        // $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['dep_ar']) ? json_decode($_POST['dep_ar']) : NULL;
        $subdep = isset($_POST['subdep_ar']) ? json_decode($_POST['subdep_ar']) : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->lowproductdetail($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);die;
    }
    
    public function loadreport9() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->cashfloatbyroute($startdate, $enddate, $route,$routeAr);
//        var_dump($result);die();
        echo json_encode($result);
        die;
    }
    
    public function loadreport10() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $emp = $_POST['emp'];
        $type = $_POST['type'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->cashinoutbyroute($startdate, $enddate, $route,$routeAr,$emp,$type);
        echo json_encode($result);
        die;
    }
    
    public function loadreportturnover() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
//        var_dump($enddate,$startdate);die();
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('JobLocation',$route)->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;


        // echo json_encode($result);
        // die;
//        $result['newcus']       =  $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate)',$enddate)->where('IsActive',1)->get()->row()->new;
//        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('DATE(customer.JoinDate)!=',$enddate)->get()->row()->new;
//        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->get()->row()->new;
//        $result['completejobs'] =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',2)->get()->row()->new;
//        $result['pendingjob']   =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',0)->get()->row()->new;
//        $result['overjob']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('DATE(appoimnetDate)=',$enddate)->where('DATE(deliveryDate)<',$enddate)->where('IsCompelte',0)->get()->row()->new;
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
        $result['suppay']      = $this->Report_model->totalsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcuspaymentsummary($startdate, $enddate, $route,$routeAr,1);

        $result['easy']        = $this->Report_model->gencashreportbyeasydaterange($startdate, $enddate, $route,$routeAr);
        $result['easycuspay']      = $this->Report_model->totaleasycuspaymentsummarydaterange($startdate, $enddate, $route,$routeAr,1);
        $result['cusodercuspay']      = $this->Report_model->totalcusodercuspaymentsummarydaterange($startdate, $enddate, $route,$routeAr,1);
        $result['part']        = $this->Report_model->gencashreportbypartdaterange($startdate, $enddate, $route,$routeAr);
        $result['coder']        = $this->Report_model->gencashreportbycoderdaterange($startdate, $enddate, $route,$routeAr);

//        $isEnd = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isEnd>0){
//            $result['lastbal']     = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->EndFlot;
//        }else{
//            $result['lastbal']     = 0;
//        }

//        $isStart = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isStart>0){
//            $result['startbal']     = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
//        }else{
//            $result['startbal']     = 0;
//        }

//        $isCash = $this->db->select('SystemUser')->from('cashierbalancesheet')->where('Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
//        if($isCash>0){
//            $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('cashierbalancesheet.Location',$route)->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;
//        }else{
//            $result['cashier']     = '';
//        }
        // $result['startbal']    = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        // $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;

        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->result();

        // $query2 = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        // $result['lastbal'] =$query2->result();
//                        var_dump($result['bal']);die();

        echo json_encode($result);
        die;
    }
    
    public function productjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchproduct($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function supplierjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchsupplier($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function departmentjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchdepartment($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function subdepartmentjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $result = $this->Report_model->searchsubdepartment($q,$cat);
            echo json_encode($result);
            die;
        }
    }
    
    public function categoryjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $result = $this->Report_model->searchcategory($q,$cat,$cat2);
            echo json_encode($result);
            die;
        }
    }
    
    public function subcategoryjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $cat2 = ($_GET['subdep']);
            $result = $this->Report_model->searchsubcategory($q,$cat,$cat2);
            echo json_encode($result);
            die;
        }
    }

    public function customerjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchcustomer($q);
            echo json_encode($result);
            die;
        }
    }

    public function vehiclejson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchvehicle($q);
            echo json_encode($result);
            die;
        }
    }

    public function makejson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Report_model->searchmake($q);
            echo json_encode($result);
            die;
        }
    }

    public function trasferreportjson() {
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $from = isset($_POST['location_from']) ? $_POST['location_from'] : NULL;
        $to = isset($_POST['location_to']) ? $_POST['location_to'] : NULL;
        $pro = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

       $this->db->select('stocktransferdtl.*,product.Prd_Description,users.first_name,stocktransferhed.TransIsInProcess,stocktransferhed.IsCancel,(stocktransferhed.TransDateORG) AS TransDate');
                $this->db->from('stocktransferdtl');
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(stocktransferdtl.TrnsDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(stocktransferdtl.TrnsDate) >=', $startdate);
                }
                 if (isset($from) && $from != '' ) {
                $this->db->where('stocktransferhed.FromLocation',$from);
                 }
                  if (isset($to) && $to != '' ) {
                $this->db->where('stocktransferhed.ToLocation',$to);
                  }
                   if (isset($isall) && $isall == 0 ) {
                $this->db->where('stocktransferhed.IsCancel',0);
                  }
                  if (isset($pro) && $pro != '' ) {
                $this->db->where('stocktransferdtl.ProductCode',$pro);
                  }
                $this->db->join('product', 'product.ProductCode=stocktransferdtl.ProductCode');
                $this->db->join('stocktransferhed', 'stocktransferhed.TrnsNo=stocktransferdtl.TrnsNo');
                $this->db->join('users','users.id=stocktransferhed.TransUser');
               $data = $this->db->get();
        
        $list = array();
        foreach ($data->result() as $row) {
            $list[$row->TrnsNo][] = $row;
        }
        echo json_encode($list);
        die;
        
    }
    
    public function invoicereportjson() {
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $pro = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

       $this->db->select('invoicedtl.*,product.Prd_Description,users.first_name,invoicehed.IsComplete,invoicehed.InvIsCancel,DATE(invoicehed.InvDate) AS InvDate,invoicehed.InvDisAmount,invoicehed.InvNetAmount AS TotalNetAmount');
                $this->db->from('invoicedtl');
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(invoicedtl.InvDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(invoicedtl.InvDate) >=', $startdate);
                }
                if (isset($route) && $route != '' ) {
                $this->db->where('invoicehed.InvLocation',$route);
                }
                 
                if (isset($isall) && $isall == 0 ) {
                $this->db->where('invoicehed.InvIsCancel',0);
                }
                if (isset($pro) && $pro != '' ) {
                $this->db->where('invoicedtl.InvProductCode',$pro);
                }
                $this->db->join('product', 'product.ProductCode=invoicedtl.InvProductCode');
                $this->db->join('invoicehed', 'invoicehed.InvNo=invoicedtl.InvNo');
                $this->db->join('users','users.id=invoicehed.InvUser');
               $data = $this->db->get();
        
        $list = array();
        foreach ($data->result() as $row) {
            $list[$row->InvNo][] = $row;
        }
        echo json_encode($list);
        die;
        
    }

    public function loadjobdatesale() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result    = $this->Report_model->genjobreportbyroute($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }

    public function loadjobdatesalesum() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result    = $this->Report_model->genjobsumreportbyroute($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }

    public function loadjobdaysalesum() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;
      
        $result['pro']         = $this->Report_model->genjobdaysumreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['cash']        = $this->Report_model->genjobdaycashsumreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevcash']    = $this->Report_model->genjobdaysumreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['expenses']    = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn']        = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
       $result['inout']       = $this->Report_model->cashinoutbyroutebytype($startdate, $enddate, $route,$routeAr,12);
        $result['salary']      = $this->Report_model->cashinoutsalarybytype($startdate, $enddate, $route,$routeAr,12);
        $result['procash']     = $this->Report_model->gencashreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevprocash'] = $this->Report_model->gencashreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['product']     = $this->Report_model->gencashreportbyproduct($startdate, $enddate, $route,$routeAr);
        
        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        $result['bal'] =$query->result();
        echo json_encode($result);
        die;
    }

    public function loaddailybalance() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;
        
        
        // echo json_encode($result);
        // die;
        $result['newcus']       =  $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate)',$enddate)->where('IsActive',1)->get()->row()->new;
        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('DATE(appoimnetDate)',$enddate)->where('DATE(customer.JoinDate)!=',$enddate)->get()->row()->new;
        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)',$enddate)->get()->row()->new;
        $result['completejobs'] =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',2)->get()->row()->new;
        $result['pendingjob']   =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)',$enddate)->where('IsCompelte',0)->get()->row()->new;
        $result['overjob']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)=',$enddate)->where('DATE(deliveryDate)<',$enddate)->where('IsCompelte',0)->get()->row()->new;
        // $result['cashier'] =  $this->db->select('users.first_name')->from('cashflot')->join('users','users.id=cashflot.SystemUser')->where('DATE(FlotDate)',date("Y-m-d"))->get()->row()->first_name;
        
        $result['pro']         = $this->Report_model->genjobdaysumreportbyroute($startdate, $enddate, $route,$routeAr);
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
        $result['suppay']      = $this->Report_model->totalsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcuspayment($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcuspayment($startdate, $enddate, $route,$routeAr,1);
        $result['lastbal']     = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)<' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->EndFlot;
        

        $query = $this->db->query("CALL SPR_DAILY_CASH_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->result();

        // $query2 = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        // $result['lastbal'] =$query2->result();
        
        echo json_encode($result);
        die;
    }

    public function loaddailybalancedetail() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('JobLocation',$route)->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;
        
        
        // echo json_encode($result);
        // die;
        $result['newcus']       =  $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate)',$enddate)->where('IsActive',1)->get()->row()->new;
        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->where('DATE(customer.JoinDate)!=',$enddate)->get()->row()->new;
        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('JLocation',$route)->where('JLocation',$route)->where('DATE(appoimnetDate)',$enddate)->get()->row()->new;
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
        $result['easy']        = $this->Report_model->gencashreportbyeasy($startdate, $enddate, $route,$routeAr);
        $result['coder']        = $this->Report_model->gencashreportbycoder($startdate, $enddate, $route,$routeAr);
        $result['easycuspay']      = $this->Report_model->totaleasycuspaymentsummary($startdate, $enddate, $route,$routeAr,1);
        $result['cusodercuspay']      = $this->Report_model->totalcusodercuspaymentsummary($startdate, $enddate, $route,$routeAr,1);

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
        // $result['startbal']    = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        // $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;

        $query = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$enddate','$route','')");
        $result['bal'] =$query->result();

        // $query2 = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        // $result['lastbal'] =$query2->result();
//                        var_dump($result['bal']);die();

        echo json_encode($result);
        die;
    }

    public function loadmonthlybalancedetail() {
        $this->output->set_content_type('application_json');
        $enddate   = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route     = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr   = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;

        $bal_date = $this->db->select('MAX(date(JobInvoiceDate)) As baldate')->from('jobinvoicehed')->where('date(JobInvoiceDate)<',$enddate)->get()->row()->baldate;
        
        
        // echo json_encode($result);
        // die;
        $result['newcus']       = $this->db->select('Count(CusCode) as new')->from('customer')->where('DATE(JoinDate) <=',$enddate)->where('DATE(JoinDate) >=',$startdate)->where('IsActive',1)->get()->row()->new;
        $result['repcus']       = $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->join('customer','customer.CusCode=jobcardhed.JCustomer')->where('DATE(appoimnetDate)<=',$enddate)->where('DATE(appoimnetDate)>=',$startdate)->where('DATE(customer.JoinDate)<',$startdate)->get()->row()->new;
        $result['newjobs']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)<=',$enddate)->where('DATE(appoimnetDate)>=',$startdate)->get()->row()->new;
        $result['completejobs'] =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)<=',$enddate)->where('DATE(appoimnetDate)>=',$startdate)->where('IsCompelte',2)->get()->row()->new;
        $result['pendingjob']   =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)<=',$enddate)->where('DATE(appoimnetDate)>=',$startdate)->where('IsCompelte',0)->get()->row()->new;
        $result['overjob']      =  $this->db->select('Count(JobCardNo) as new')->from('jobcardhed')->where('DATE(appoimnetDate)<=',$enddate)->where('DATE(appoimnetDate)>=',$startdate)->where('DATE(deliveryDate)<',$startdate)->where('IsCompelte',0)->get()->row()->new;
        // $result['cashier'] =  $this->db->select('users.first_name')->from('cashflot')->join('users','users.id=cashflot.SystemUser')->where('DATE(FlotDate)',date("Y-m-d"))->get()->row()->first_name;
        
        $result['pro']         = $this->Report_model->genjobmonthsalesumreportbypayment($startdate, $enddate, $route,$routeAr);
        $result['cash']        = $this->Report_model->genjobdaycashsumreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevcash']    = $this->Report_model->genjobdaysumreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['expenses']    = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn']        = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        $result['inout']       = $this->Report_model->cashinoutmonthbyroutebytype($startdate, $enddate, $route,$routeAr,12);
        $result['salary']      = $this->Report_model->cashinoutmonthsalarybytype($startdate, $enddate, $route,$routeAr,12);
        $result['expearn']     = $this->Report_model->cashfloatbytype($startdate, $enddate, $route,$routeAr,12,'');
        $result['procash']     = $this->Report_model->gencashreportbyroute($startdate, $enddate, $route,$routeAr);
        $result['prevprocash'] = $this->Report_model->gencashreportbyroute($startdate, $bal_date, $route,$routeAr);
        $result['product']     = $this->Report_model->gencashmonthreportbyproduct($startdate, $enddate, $route,$routeAr);
        $result['suppay']      = $this->Report_model->totalmonthsupplierpayment($startdate, $enddate, $route,$routeAr);
        $result['advance']     = $this->Report_model->totalcusmonthpaymentsummary($startdate, $enddate, $route,$routeAr,2);
        $result['cuspay']      = $this->Report_model->totalcusmonthpaymentsummary($startdate, $enddate, $route,$routeAr,1);
        $isEnd = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
        if($isEnd>0){
            $result['lastbal']     = $this->db->select('EndFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->EndFlot;
        }else{
            $result['lastbal']     = 0;
        }

        $isStart = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$startdate)->get()->num_rows();
        if($isStart>0){
            $result['startbal']     = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$startdate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        }else{
            $result['startbal']     = 0;
        }

        $isCash = $this->db->select('SystemUser')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->get()->num_rows();
        if($isCash>0){
            $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;
        }else{
            $result['cashier']     = '';
        }
        // $result['startbal']    = $this->db->select('StartFlot')->from('cashierbalancesheet')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->StartFlot;
        // $result['cashier']     = $this->db->select('first_name')->from('cashierbalancesheet')->join('users','users.id=cashierbalancesheet.SystemUser')->where('DATE(BalanceDate)=' ,$enddate)->order_by('BalanceDate','desc')->limit(1)->get()->row()->first_name;
        

        $query = $this->db->query("CALL SPR_MONTHLY_BALANCE_SHEET('$startdate','$enddate','$route','')");
        $result['bal'] =$query->result();

        // $query2 = $this->db->query("CALL SPR_DAILY_BALANCE_SHEET('$bal_date','$route','')");
        // $result['lastbal'] =$query2->result();
        
        echo json_encode($result);
        die;
    }

    public function getCashFloatByDate() {
        $date     = ($_REQUEST['cash_date']);
        $location = ($_REQUEST['location']);
        $user     = $_SESSION['user_id'];
        $query    = $this->db->query("CALL SPR_CASH_BALANCE_SHEET('$date','$location','$user')");
        $result   = $query->result_array();
//        return $result;
    
            echo json_encode($result);
            die;
    }

    public function loadjobsalebyproduct() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genjobreportbyproduct($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['dis'] = $this->Report_model->genjobreporttotalDiscountbyproduct($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        // $result['expenses'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        // $result['earn'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

    public function loadjobsalebyservice() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genjobreportbyservices($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

    public function loadjobsalebymake() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genjobreportbymake($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

    public function loadjobsalebyinvoice() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genjobreportbyinvoices($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

    public function loadjobpaymentbyinvoice() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genpaymentreportbyinvoices($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

    public function grnreportjson() {
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $from = isset($_POST['location_from']) ? $_POST['location_from'] : NULL;
        $pro = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $supplier = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        $this->db->select('goodsreceivenotedtl.*,product.Prd_Description,goodsreceivenotehed.GRN_IsComplete,goodsreceivenotehed.GRN_IsCancel,(goodsreceivenotehed.GRN_DateORG) AS TransDate,DATE(goodsreceivenotedtl.GRN_Date) As grndate,supplier.SupName');
        $this->db->from('goodsreceivenotedtl');
        if (isset($enddate) && $enddate != '' ) {
            $this->db->where('DATE(goodsreceivenotedtl.GRN_Date) <=', $enddate);
        }
        if (isset($startdate) && $startdate != '' ) {
            $this->db->where('DATE(goodsreceivenotedtl.GRN_Date) >=', $startdate);
        }
        if (isset($from) && $from != '' ) {
            $this->db->where('goodsreceivenotehed.GRN_Location',$from);
        }
          
        if (isset($isall) && $isall == 0 ) {
            $this->db->where('goodsreceivenotehed.GRN_IsCancel',0);
        }
        if (isset($pro) && $pro != '' ) {
            $this->db->where('goodsreceivenotedtl.GRN_Product',$pro);
        }
        if (isset($supplier) && $supplier != '' ) {
            $this->db->where('goodsreceivenotehed.GRN_SupCode',$supplier);
        }
        $this->db->join('product', 'product.ProductCode=goodsreceivenotedtl.GRN_Product');
        $this->db->join('goodsreceivenotehed', 'goodsreceivenotehed.GRN_No=goodsreceivenotedtl.GRN_No');
        $this->db->join('supplier', 'supplier.SupCode=goodsreceivenotehed.GRN_SupCode');
        $data = $this->db->get();
        
        $list = array();
        foreach ($data->result() as $row) {
            $list[$row->GRN_No." - ".$row->grndate." - ".$row->SupName][] = $row;
        }
        echo json_encode($list);die;
    }

    public function suppliercredit() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customercredit');
        $this->page_title->push(('Supplier Outstanding'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "14");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/suppliercredit', $this->data);
        } else {
            $this->template->admin_render('admin/report/suppliercredit', $this->data);
        }
    }

    public function loadsuppliercredit() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Report_model->suppliercredit($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

    public function customercredit() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customercredit');
        $this->page_title->push(('Customer Outstanding Detail'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
        $this->load->model('admin/Job_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/customercredit', $this->data);
        } else {
            $this->template->admin_render('admin/report/customercredit', $this->data);
        }
    } 
    
    
    
    
    public function customerallreport() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customercredit');
        $this->page_title->push(('Customer Outstanding'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
        $this->load->model('admin/Job_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/cusallreport', $this->data);
        } else {
            $this->template->admin_render('admin/report/cusallreport', $this->data);
        }
    }
    

    public function loadcustomercredit() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Report_model->customercredit($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

    public function customerpayment() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customerpayment');
        $this->page_title->push(('Customer Payment'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/customerpayment', $this->data);
        } else {
            $this->template->admin_render('admin/report/customerpayment', $this->data);
        }
    }

    public function loadcustomerpayment() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cp'] = $this->Report_model->customerpayment($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

    public function supplierpayment() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/supplierpayment');
        $this->page_title->push(('Supplier Payment'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/supplierpayment', $this->data);
        } else {
            $this->template->admin_render('admin/report/supplierpayment', $this->data);
        }
    }

    public function loadsupplierpayment() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }

       $this->db->select('supplier.SupName,
                        supplier.Address01,
                        supplier.Address02,
                        supplier.SupTitle,
                        supplierpaymenthed.SupPayNo,
                        DATE(supplierpaymenthed.PayDate) AS PayDate,
                        supplierpaymentdtl.PayAmount,
                        bank.BankCode,
                        supplierpaymentdtl.`Mode`,
                        supplierpaymentdtl.ChequeNo,
                        DATE(supplierpaymentdtl.ChequeDate) AS ChequeDate,
                        DATE(supplierpaymentdtl.RecievedDate) AS RecievedDate,
                        supplierpaymentdtl.Reference,
                        title.TitleName');
                $this->db->from('supplierpaymenthed');
                $this->db->join('supplierpaymentdtl','supplierpaymentdtl.SupPayNo=supplierpaymenthed.SupPayNo');
                $this->db->join('supplier','supplierpaymenthed.SupCode = supplier.SupCode');
                $this->db->join('title','supplier.SupTitle = title.TitleId','left');
                $this->db->join('bank','supplierpaymentdtl.BankNo = bank.BankCode','left');

                 $this->db->where('supplierpaymenthed.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(supplierpaymenthed.PayDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(supplierpaymenthed.PayDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('supplierpaymenthed.Location',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('supplierpaymenthed.SupCode',$customer);
                  }
                   
               $result = $this->db->get()->result();
    
        echo json_encode($result);
        die;
        
    }

    public function vehiclesummery() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/supplierpayment');
        $this->page_title->push(('Job summary by vehicle'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
            $this->load->model('admin/Job_model');
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/vehiclesummery', $this->data);
        } else {
            $this->template->admin_render('admin/report/vehiclesummery', $this->data);
        }
    }

    public function loadvehiclesummery() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

        $result['inv'] = $this->Report_model->invoicesbyvehicle($startdate, $enddate, $route,$isall,$customer);
        $result['cp'] = $this->Report_model->customerpaymentbyvehicle($startdate, $enddate, $route,$isall,$customer);
        $result['cr'] = $this->Report_model->customercreditbyvehicle($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

    public function loadjobdelivery() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Report_model->jobdelivery($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }


    //////////////////////2019-09-13////////////////////////////
        public function customercreditsummary() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customercreditsummary');
        $this->page_title->push(('Customer Outstanding Summary'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
        $this->load->model('admin/Job_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/customercreditsummary', $this->data);
        } else {
            $this->template->admin_render('admin/report/customercreditsummary', $this->data);
        }
    }

     public function loadcustomercreditsummary() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Report_model->customercreditsummary($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

    public function customercommission() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customercommission');
        $this->page_title->push(('Customer Commission'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $location = $_SESSION['location'];
        $this->load->model('admin/Job_model');
        $id3 = array('CompanyID' => $location);
        $this->data['company'] = $this->Job_model->get_data_by_where('company', $id3);
            
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/customercommission', $this->data);
        } else {
            $this->template->admin_render('admin/report/customercommission', $this->data);
        }
    } 

    public function loadcustomercommission() {
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $customer = isset($_POST['customer']) ? $_POST['customer'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;

        if($isall==0){
            $enddate = $_POST['enddate'];
            $startdate = $_POST['startdate'];
        }else{
            $enddate = '';
            $startdate = '';
        }

       $result['cr'] = $this->Report_model->customersalecommission($startdate, $enddate, $route,$isall,$customer);
       $result['cr2'] = $this->Report_model->customerjobcommission($startdate, $enddate, $route,$isall,$customer);
        echo json_encode($result);
        die;
        
    }

}
