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
//        $this->output->cache($n);
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
        $people = array("1", "10", "13");

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
        $people = array("1", "10", "13");

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

//    services------------------------------------------------------------------
    public function loadreport1() {
        $this->output->set_content_type('application_json');
        $enddate = $_POST['enddate'];
        $startdate = $_POST['startdate'];
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Report_model->genreportbyroute($startdate, $enddate, $route,$routeAr);
        echo json_encode($result);
        die;
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
        echo json_encode($result);
        die;
    }

    public function loadreport3() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
//        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
        $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $result = $this->Report_model->productdetail($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);
        die;
    }

    public function loadreport4() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $result = $this->Report_model->productdetailserial($route, $isall, $product);
        echo json_encode($result);
        die;
    }

    public function loadreport5() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $result = $this->Report_model->priceproductdetail($route, $isall, $product,$dep,$subdep,$sup);
        echo json_encode($result);
        die;
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
        echo json_encode($result);
        die;
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
        echo json_encode($result);
        die;
    }
    
    public function loadreport8() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['department']) ? $_POST['department'] : NULL;
        $subdep = isset($_POST['subdepartment']) ? $_POST['subdepartment'] : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
        $result = $this->Report_model->lowproductdetail($route, $isall, $product,$dep,$subdep,$sup);
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
    
}
