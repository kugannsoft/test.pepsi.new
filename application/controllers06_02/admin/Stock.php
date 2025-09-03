<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Stock_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        
    }


    public function serialstock() {
        $this->breadcrumbs->unshift(1, 'Reports', 'admin/report');
        $this->breadcrumbs->unshift(1, 'Stock', 'admin/report/serialreport');
        $this->page_title->push(('Product Serial Stock'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Stock_model->loadroot();
        $this->data['products'] = $this->Stock_model->loadproduct();
        $this->template->admin_render('admin/report/serialreport', $this->data);
    }

    public function stockclear() {
         $this->breadcrumbs->unshift(1, 'Stock', 'admin/stock');
        $this->breadcrumbs->unshift(1, 'Stock Clear', 'admin/stock/stockclear');
        $this->page_title->push(('Stock Clear'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['locations'] = $this->Stock_model->loadroot();
        $this->template->admin_render('admin/stock/stockclear', $this->data);
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
        $result = $this->Stock_model->productdetail($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);
        die;
    }

    public function loadreport4() {
        $product = isset($_POST['productsearch']) ? $_POST['productsearch'] : NULL;
        $isall = isset($_POST['isall']) ? 1 : 0;
        // $route = isset($_POST['route']) ? $_POST['route'] : NULL;
        $dep = isset($_POST['dep_ar']) ? json_decode($_POST['dep_ar']) : NULL;
        $subdep = isset($_POST['subdep_ar']) ? json_decode($_POST['subdep_ar']) : NULL;
        $subcat = isset($_POST['subcategory_ar']) ? json_decode($_POST['subcategory_ar']) : NULL;
         $sup = isset($_POST['supplier']) ? $_POST['supplier'] : NULL;
         $routeAr = isset($_POST['route_ar']) ? json_decode($_POST['route_ar']) : NULL;
        $result = $this->Stock_model->productdetailserial($routeAr, $isall, $product,$dep,$subdep,$sup,$subcat);
        echo json_encode($result);
        die;
    }

    
    
    public function productjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Stock_model->searchproduct($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function supplierjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Stock_model->searchsupplier($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function departmentjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $result = $this->Stock_model->searchdepartment($q);
            echo json_encode($result);
            die;
        }
    }
    
    public function subdepartmentjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $result = $this->Stock_model->searchsubdepartment($q,$cat);
            echo json_encode($result);
            die;
        }
    }
    
    public function categoryjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $result = $this->Stock_model->searchcategory($q,$cat,$cat2);
            echo json_encode($result);
            die;
        }
    }
    
    public function subcategoryjson() {
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            $cat = ($_GET['dep']);
            $cat2 = ($_GET['subdep']);
            $result = $this->Stock_model->searchsubcategory($q,$cat,$cat2);
            echo json_encode($result);
            die;
        }
    }
}
