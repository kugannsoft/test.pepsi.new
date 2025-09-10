<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Product_model');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_product'), 'admin/product/product');
            $this->page_title->push(('Products'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */

            /* TEST */
            $this->data['url_exist'] = is_url_exist('http://www.nsoft.lk');


            /* Load Template */
            $this->template->admin_render('admin/product/product', $this->data);
        }
    }

    public function addproduct() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_product'), 'admin/product/addproduct');
            $this->page_title->push(('Products'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */

            /* TEST */
            $this->data['url_exist'] = is_url_exist('http://www.nsoft.lk');


            /* Load Template */
            $this->template->admin_render('admin/product/addproduct', $this->data);
        }
    }

    public function loadmodal_addproduct() {
        $this->data['alldepartment'] = $this->Product_model->loaddepartment();
        $this->data['allsuppliers'] = $this->Product_model->loadsuppliers();
        $this->data['ploption'] = $this->Product_model->loadpricelevel();
        $this->data['measure'] = $this->Product_model->loadmeasuretype();
        $this->load->view('admin/product/addproduct_modal', $this->data);
    }

    public function loadmodal_editproduct() {
        $productid = $_REQUEST['id'];
        $this->data['product'] = $this->Product_model->loadproductbyid($productid);
        $this->data['productpl'] = $this->Product_model->loadpricelistbyid($productid);

        $this->data['alldepartment'] = $this->Product_model->loaddepartment();
        $this->data['allsubdepartment'] = $this->Product_model->loadsubdepartment($this->data['product']->DepCode);
        $this->data['allcatogery'] = $this->Product_model->loadcategory($this->data['product']->SubDepCode);
        $this->data['allsubcategory'] = $this->Product_model->loadsubcategory($this->data['product']->CategoryCode);

        $this->data['allsuppliers'] = $this->Product_model->loadsuppliers();
        $this->data['ploption'] = $this->Product_model->loadpricelevel();
        $this->data['measure'] = $this->Product_model->loadmeasuretype();
        $this->load->view('admin/product/editproduct_modal', $this->data);
    }

    /*     * ************Products*************************************************** */

    public function allProducts() {
        $this->load->library('Datatables');
        $this->datatables->select('*');
        $this->datatables->from('product');
        echo $this->datatables->generate('json', 'ISO-8859-1');
        die;
    }

    public function get_products() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->Product_model->get_products('product', $q);
            die;
        }
    }

    public function getActiveCustomers() {
        $data = array(
            'IsActive' => '1'
        );
        $this->data['customers'] = $this->Product_model->get_data_by_where('customer', $data);
        echo json_encode($this->data['customers']);
        die;
    }

    public function getProductById() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $this->data['product'] = $this->Product_model->loadproductbypcode($dep, $pl);
        echo json_encode($this->data['product']);
        die;
    }
    
    public function getProductByIdforGrn() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
       $location = $_POST['location'];
        $arr['product'] = $this->Product_model->loadproductbypcode($dep, $pl);
        $arr['serial'] = $this->Product_model->loadproductbyserialArray($dep, $pl,$location);
        echo json_encode($arr);
        die;
    }
    
    public function getProductByBarCodeforGrn() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $this->data['product'] = $this->Product_model->loadproductbyserial($dep, $pl, $location);
        $this->data['serial'] = $this->Product_model->loadproductbyserialArray($dep, $pl, $location);
        echo json_encode($this->data['product']);
        die;
    }

    public function getProductByBarCode() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $this->data['product'] = $this->Product_model->loadproductbyserial($dep, $pl, $location);
        echo json_encode($this->data['product']);
        die;
    }

    public function loadsubdepartment() {
        $dep = $_POST['dep'];
        echo json_encode($this->Product_model->loadsubdepartment($dep));
        die;
    }

    public function loadcategory() {
        $subdep = $_POST['subdep'];
        echo json_encode($this->Product_model->loadcategory($subdep));
        die;
    }

    public function loadsubcategory() {
        $cat = $_POST['cat'];
        echo json_encode($this->Product_model->loadsubcategory($cat));
        die;
    }

    public function add_product() {

        $data['ProductCode'] = $this->Product_model->get_max_code('Product');
        $data['Prd_Description'] = $_POST['productname'];
        $data['Prd_AppearName'] = $_POST['appearname'];
        $data['Cus_PrdCode'] = '';

        $data['DepCode'] = $_POST['department'];
        $data['SubDepCode'] = $_POST['sub_department'];
        $data['CategoryCode'] = $_POST['category'];
        $data['SubCategoryCode'] = $_POST['sub_category'];

        $data['BarCode'] = $_POST['barcode'];
        $data['Prd_UPC'] = $_POST['unitpercase'];
        $data['Prd_UOM'] = $_POST['unitpermeasure'];
        $data['Prd_ROL'] = $_POST['reorderlevel'];
        $data['Prd_ROQ'] = $_POST['reorderqty'];
        $data['Prd_Supplier'] = $_POST['supplier'];
        $data['Prd_Referance'] = '';
        $data['Prd_CostPrice'] = $_POST['costprice'];
        $data['Prd_SetAPrice'] = $_POST['setaprice'];
        $data['Prd_IsActive'] = isset($_POST['isactive']) ? 1 : 0;

        $productcondition['ProductCode'] = $data['ProductCode'];
        $productcondition['IsOpenPrice'] = isset($_POST['isopenprice']) ? 1 : 0;
        $productcondition['IsFraction'] = isset($_POST['isfraction']) ? 1 : 0;
        $productcondition['IsDiscount'] = isset($_POST['isdiscountlimit']) ? 1 : 0;
        $productcondition['IsMultiPrice'] = isset($_POST['ismultiprice']) ? 1 : 0;
        $productcondition['IsSerial'] = isset($_POST['isserialno']) ? 1 : 0;
        $productcondition['IsPromotions'] = isset($_POST['ispromotion']) ? 1 : 0;
        $productcondition['IsWarranty'] = isset($_POST['iswarranty']) ? 1 : 0;
        $productcondition['IsFreeIssue'] = isset($_POST['isfreeissue']) ? 1 : 0;
        $productcondition['WarrantyPeriod'] = $_POST['warranty'];
        $productcondition['DiscountLimit'] = $_POST['discountlimit'];
        $productcondition['IsRawMaterial'] = isset($_POST['israwmaterial']) ? 1 : 0;
        $productcondition['IsCostDisMargin'] = isset($_POST['isprofitmargin']) ? 1 : 0;

        $pldata = array();

        if (isset($_POST['pl'])) {
            foreach ($_POST['pl'] AS $key => $val) {
                $plrowdata = array(
                    'ProductCode' => $data['ProductCode'],
                    'PL_No' => $key,
                    'ProductPrice' => $val
                );
                if ($val != '' || $_POST['pl'][$key]) {
                    array_push($pldata, $plrowdata);
                }
            }
        }
//        print_r($pldata); die;
        $this->Product_model->insert_data('product', $data);
        $this->Product_model->insert_data('productcondition', $productcondition);
        $this->Product_model->insert_batchdata('productprice', $pldata);
        $this->Product_model->update_max_code('Product');
         echo 'success';
        die;
    }

    public function update_product() {
        $productcode = $_POST['productCode'];

        $data['Prd_Description'] = $_POST['productname'];
        $data['Prd_AppearName'] = $_POST['appearname'];
        $data['Cus_PrdCode'] = '';

        $data['DepCode'] = $_POST['department'];
        $data['SubDepCode'] = $_POST['sub_department'];
        $data['CategoryCode'] = $_POST['category'];
        $data['SubCategoryCode'] = $_POST['sub_category'];

        $data['BarCode'] = $_POST['barcode'];
        $data['Prd_UPC'] = $_POST['unitpercase'];
        $data['Prd_UOM'] = $_POST['unitpermeasure'];
        $data['Prd_ROL'] = $_POST['reorderlevel'];
        $data['Prd_ROQ'] = $_POST['reorderqty'];
        $data['Prd_Supplier'] = $_POST['supplier'];
        $data['Prd_Referance'] = '';
        $data['Prd_CostPrice'] = $_POST['costprice'];
        $data['Prd_SetAPrice'] = $_POST['setaprice'];
        $data['Prd_IsActive'] = isset($_POST['isactive']) ? 1 : 0;

        $productcondition['IsOpenPrice'] = isset($_POST['isopenprice']) ? 1 : 0;
        $productcondition['IsFraction'] = isset($_POST['isfraction']) ? 1 : 0;
        $productcondition['IsDiscount'] = isset($_POST['isdiscountlimit']) ? 1 : 0;
        $productcondition['IsMultiPrice'] = isset($_POST['ismultiprice']) ? 1 : 0;
        $productcondition['IsSerial'] = isset($_POST['isserialno']) ? 1 : 0;
        $productcondition['IsPromotions'] = isset($_POST['ispromotion']) ? 1 : 0;
        $productcondition['IsWarranty'] = isset($_POST['iswarranty']) ? 1 : 0;
        $productcondition['IsFreeIssue'] = isset($_POST['isfreeissue']) ? 1 : 0;
        $productcondition['WarrantyPeriod'] = $_POST['warranty'];
        $productcondition['DiscountLimit'] = $_POST['discountlimit'];
        $productcondition['IsRawMaterial'] = isset($_POST['israwmaterial']) ? 1 : 0;
        $productcondition['IsCostDisMargin'] = isset($_POST['isprofitmargin']) ? 1 : 0;


        $pldata = array();

        if (isset($_POST['pl'])) {
            foreach ($_POST['pl'] AS $key => $val) {
                $plrowdata = array(
                    'ProductCode' => $productcode,
                    'PL_No' => $key,
                    'ProductPrice' => $val
                );
                if ($val != '' || $_POST['pl'][$key]) {
//                    array_push($pldata, $plrowdata);
                    $this->Product_model->update_data('productprice', $plrowdata, array('ProductCode' => $productcode, 'PL_No' => $key));
                }
            }
        }
        $this->Product_model->update_data('product', $data, array('Productcode' => $productcode));
        $this->Product_model->update_data('productcondition', $productcondition, array('Productcode' => $productcode));
        echo 'success';
        die;
    }

}
