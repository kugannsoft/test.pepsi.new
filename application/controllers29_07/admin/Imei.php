<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imei extends Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('admin/Imei_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function imei_check() {
        $this->page_title->push(('IMEI Checker'));
        $this->breadcrumbs->unshift(1, 'IMEI Checker', 'admin/imei/imei-check');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Imei_model->loadpricelevel();
        $this->data['location'] = $this->Imei_model->loadlocations();
        $this->template->admin_render('admin/imei/imei-check', $this->data);
    }
    
    public function clear_serial_stock() {
        $this->load->helper('url'); 
        $this->page_title->push(('Clear Serial Stock'));
        $this->breadcrumbs->unshift(1, 'Clear Serial Stock', 'admin/imei/clear-serial-stock');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['plv'] = $this->Imei_model->loadpricelevel();
        $this->data['location'] = $this->Imei_model->loadlocations();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/imei/clear-serial-stock', $this->data);
        } else {
            $this->template->admin_render('admin/dashboard/500', $this->data);
        }
    }
    
    public function clear_product_stock() {
        $this->load->helper('url'); 
        $this->page_title->push(('Clear Product Stock By Department'));
        $this->breadcrumbs->unshift(1, 'Clear Product Stock', 'admin/imei/clear-product-stock');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['department'] = $this->Imei_model->loaddepartment();
        $this->data['location'] = $this->Imei_model->loadlocations();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/imei/clear-product-stock', $this->data);
        } else {
            $this->template->admin_render('admin/dashboard/500', $this->data);
        }
    }
    
    public function clear_bulk_stock() {
        $this->load->helper('url'); 
        $this->page_title->push(('Clear Product Stock By Multiple Department'));
        $this->breadcrumbs->unshift(1, 'Clear Bulk Stock', 'admin/imei/clear-bulk-stock');
        $this->data['pagetitle'] = $this->page_title->show();
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->data['department'] = $this->Imei_model->loaddepartment();
        $this->data['location'] = $this->Imei_model->loadlocations();
        $people = array("1", "10", "13");

        if (in_array($_SESSION['user_id'], $people)) {
            $this->template->admin_render('admin/imei/clear-bulk-stock', $this->data);
        } else {
            $this->template->admin_render('admin/dashboard/500', $this->data);
        }
    }

    public function loadsupplierjson() {
        $query = $_GET['q'];
        echo $this->Imei_model->loadsupplierjson($query);
        die;
    }
    
    public function loadproductjson() {
        $query = $_GET['q'];
        echo $this->Imei_model->loadproductjson($query);
        die;
    }
    
    public function loadproductSerial() {     
        $product= $_REQUEST['proCode'];$location= $_REQUEST['location'];
        $serial =  $this->Imei_model->loadproductSerial($product, $location);
        echo json_encode($serial);
        die;
    }
    
    public function loadproductbyDepandSubdep() {     
        $dep= $_REQUEST['dep'];$subdep= $_REQUEST['subdep'];$loc= $_REQUEST['location'];
        $serial =  $this->Imei_model->loadproductbyDepandSubdep($dep,$subdep,$loc);
        echo json_encode($serial);
        die;
    }
    
    public function loadproductbyDeps() {     
        $dep= json_decode($_REQUEST['dep']);$loc= $_REQUEST['location'];
        $serial =  $this->Imei_model->loadproductbyDeps($dep,$loc);
        echo json_encode($serial);
        die;
    }
    
    //clear peoduct and serial stock
    public function clearSerialStock() {
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $totalqty = $_POST['totalStock'];
        $proCode = $_POST['productCode'];
        $location = $_POST['location'];
        
        $res2= $this->Imei_model->clearSerialStock($proCode,$location,$totalqty,$invUser,$grnDattime);
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    //clear peoduct and serial stock
    public function clearProductStock() {
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $totalqty = $_POST['totalStock'];
        $dep = $_POST['dep'];
        $subdep = $_POST['subdep'];
        $location = $_POST['location'];
        
        $res2= $this->Imei_model->clearProductStock($dep,$subdep,$location,$totalqty,$invUser,$grnDattime);
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    //clear peoduct and serial stock
    public function clearBulkProductStock() {
        $grnDattime = date("Y-m-d H:i:s");
        $invUser = $_POST['invUser'];
        $totalqty = $_POST['totalStock'];
        $dep = ($_POST['dep']);
//        $subdep = $_POST['subdep'];
        $location = $_POST['location'];
        
        $res2= $this->Imei_model->clearBulkProductStock($dep,$location,$totalqty,$invUser,$grnDattime);
        
        $return['fb'] = $res2;
        echo json_encode($return);
        die;
    }
    
    public function getProductByBarCode() {
        $dep = $_POST['proCode'];
        $location = $_POST['location'];
       $arr['stock']  = $this->Imei_model->loadproductlocbyserial($dep, $location);
       $arr['product']  = $this->Imei_model->loadproductbyserial($dep, $location);
       $arr['sale']  = $this->Imei_model->loadsalebyserial($dep, $location);
       $arr['trans']  = $this->Imei_model->loadtranserbyserial($dep, $location);
//       $arr['loc'] =$this->Imei_model->loadlocations();
        echo json_encode($arr);
        die;
    }
    
    
   
}
