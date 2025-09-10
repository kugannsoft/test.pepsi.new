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
            $this->template->admin_render('admin/report/salesbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/salesbydate2', $this->data);
        }
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
        $this->data['products'] = $this->Report_model->loadproduct();
        $this->template->admin_render('admin/report/cashinoutreport', $this->data);
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
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbydate', $this->data);
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
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesumbydate', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesumbydate', $this->data);
        }
    }

    public function jobsalesbyproduct() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyproduct');
        $this->page_title->push(('Job Profit & Lost'));
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
     public function jobsalesbyproduct1() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbyproduct1');
        $this->page_title->push(('Job Invoice Insurance Report'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbyproduct1', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobsalesbyproduct1', $this->data);
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

//    services------------------------------------------------------------------
    public function loadreport1() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genreportbyroute($startdate, $enddate, $route,$routeAr);
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
        echo json_encode($result);
        die;
    }
    
    public function loadreport10() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->cashinoutbyroute($startdate, $enddate, $route,$routeAr);
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
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genjobreportbyroute($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }

    public function loadjobdatesalesum() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genjobsumreportbyroute($startdate, $enddate, $route,$routeAr);
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
        $result['expenses'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        // $result['dis'] =null;
        // $result['expenses'] =null;
        // $result['earn'] =null;
        echo json_encode($result);
        die;
    }


 public function loadjobsalebyproduct1() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genjobreportbyproduct1($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['dis'] = $this->Report_model->genjobreporttotalDiscountbyproduct1($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
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
            $this->db->where('goodsreceivenotedtl.ProductCode',$pro);
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


    public function customercredit() {
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
            $this->template->admin_render('admin/report/customercredit', $this->data);
        } else {
            $this->template->admin_render('admin/report/customercredit', $this->data);
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

    public function customersummary() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/customersummary');
        $this->page_title->push(('Customer Summary'));
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
            $this->template->admin_render('admin/report/customersummary', $this->data);
        } else {
            $this->template->admin_render('admin/report/customersummary', $this->data);
        }
    }

    public function loadcustomersummary() {
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

       $result['cr'] = $this->Report_model->customersummary($startdate, $enddate, $route,$isall,$customer);
    
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

        //--------------------------------2018-07-03-------------------------------//
         public function testingjobcards() {
                $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
                $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/testingjobcards');
                $this->page_title->push(('Testing Job Cards'));
                $this->data['pagetitle'] = $this->page_title->show();
                $this->data['breadcrumb'] = $this->breadcrumbs->show();
                $this->data['locations'] = $this->Report_model->loadroot();
                $this->data['products'] = $this->Report_model->loadproduct();
                $this->template->admin_render('admin/report/testingjobcards', $this->data);                
        }


        public function loadtestingjobcards() {
                $this->output->set_content_type('application_json');
                $enddate = $_POST['enddate'];
                $startdate = $_POST['startdate'];
                $product = isset($_POST['product']) ? $_POST['product'] : NULL;
                $route = isset($_POST['route']) ? $_POST['route'] : NULL;
                $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
                $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
                $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
                $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
                $result['pro'] = $this->Report_model->gentestingjobcards($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
                $result['dis'] = $this->Report_model->genjobreporttestingjobcards($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
                $result['expenses'] = $this->Report_model->getTotalExpences($startdate, $enddate);
                $result['earn'] = $this->Report_model->getTotalEarning($startdate, $enddate);
                // $result['dis'] =null;
                // $result['expenses'] =null;
                // $result['earn'] =null;
                echo json_encode($result);
                die;
    }





        //All Jobs
     public function viewalljobs() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/alljobs');
        $this->page_title->push(('All Jobs'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['products'] = $this->Report_model->loadproduct();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/alljobs', $this->data);
        } else {
            $this->template->admin_render('admin/report/alljobs', $this->data);
        }
    }

      public function loadalljobs() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genalljobreport($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['dis'] = $this->Report_model->genalljobreporttotalDiscountbyproduct($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        $result['expenses'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 1);
        $result['earn'] = $this->Report_model->expensesbydate($routeAr,$startdate, $enddate, 0);
        // $result['dis'] =null;
        // $result['expenses'] =null;
        // $result['earn'] =null;
        echo json_encode($result);
        die;
    }


      public function jobsalesbydate_without_testing() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesbydate_without_testing');
        $this->page_title->push(('Job Sale by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        // $people = array("0", "10", "13");

        // if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesbydate_without_testing', $this->data);
        // } else {
        //     $this->template->admin_render('admin/report/jobsalesbydate_without_testing', $this->data);
        // }
    }

     public function loadjobdatesale_without_testing() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genjobreportbyroute_without_testing($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }


     public function jobsalesumbydate_without_testing() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobsalesumbydate_without_testing');
        $this->page_title->push(('Job Sale Summery by date'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        // $people = array("0", "10", "13");

        // if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobsalesumbydate_without_testing', $this->data);
        // } else {
        //     $this->template->admin_render('admin/report/jobsalesumbydate_without_testing', $this->data);
        // }
    }

     public function loadjobdatesalesum_without_testing() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genjobsumreportbyroute_without_testing($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
    }


     public function vehiclesummery_without_testing() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Credit', 'admin/report/vehiclesummery_without_testing');
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
            $this->template->admin_render('admin/report/vehiclesummery_without_testing', $this->data);
        } else {
            $this->template->admin_render('admin/report/vehiclesummery_without_testing', $this->data);
        }
    }

    public function loadvehiclesummery_without_testing() {
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

        $result['inv'] = $this->Report_model->invoicesbyvehicle_without_testing($startdate, $enddate, $route,$isall,$customer);
        // $result['cp'] = $this->Report_model->customerpaymentbyvehicle_without_testing($startdate, $enddate, $route,$isall,$customer);
        // $result['cr'] = $this->Report_model->customercreditbyvehicle_without_testing($startdate, $enddate, $route,$isall,$customer);
    
        echo json_encode($result);
        die;
        
    }

       public function jobpaymentbyinvoice_without_testing() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Sales', 'admin/report/jobpaymentsbyinvoice_without_testing');
        $this->page_title->push(('Job Payments by Invoices'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Report_model->loadroot();
        $this->data['jobtype'] = $this->db->select('*')->from('jobtype')->get()->result();
        $people = array("0", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/report/jobpaymentsbyinvoice_without_testing', $this->data);
        } else {
            $this->template->admin_render('admin/report/jobpaymentsbyinvoice_without_testing', $this->data);
        }
    }


     public function loadjobpaymentbyinvoice_without_testing() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $product = isset($_POST['product']) ? $_POST['product'] : NULL;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $result['pro'] = $this->Report_model->genpaymentreportbyinvoices_without_testing($startdate, $enddate, $route, $product,$routeAr,$dep,$subdep,$subcat);
        
        $result['dis'] =null;
        $result['expenses'] =null;
        $result['earn'] =null;
        echo json_encode($result);
        die;
    }

}
