<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Product_model');
        date_default_timezone_set("Asia/Colombo");
    }

    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_product'), 'admin/product/product');
            $this->page_title->push(('Products'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Load Template */
            $this->template->admin_render('admin/product/product', $this->data);
        }
    }

    public function addproduct() {
        if (!$this->ion_auth->logged_in() ) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->breadcrumbs->unshift(1, lang('menu_product'), 'admin/product/addproduct');
            $this->page_title->push(('Products'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Load Template */
            $this->template->admin_render('admin/product/addproduct', $this->data);
        }
    }

    public function loadmodal_addproduct() {
        $this->data['alldepartment'] = $this->Product_model->loaddepartment();
        $this->data['allsuppliers'] = $this->Product_model->loadsuppliers();
        $this->data['ploption'] = $this->Product_model->loadpricelevel();
        $this->data['measure'] = $this->Product_model->loadmeasuretype();
        $this->data['brand'] = $this->db->select('*')->from('productbrand')->get()->result();
        $this->data['quality'] = $this->db->select('*')->from('productquality')->get()->result();
        $this->data['location'] = $this->Product_model->get_data('location')->result();
        $this->data['auto_pro_code'] = $this->Product_model->loadSystemOptionById('M002');
        // $this->data['racks'] = $this->Product_model->get_data('rack')->result();
        $this->load->view('admin/product/addproduct_modal', $this->data);
    }

    public function loadmodal_editproduct() {
        $productid = $_REQUEST['id'];
        $this->data['product']    = $this->Product_model->loadproductbyid($productid);
        $this->data['productpl']  = $this->Product_model->loadpricelistbyid($productid);
        $this->data['productloc'] = $this->Product_model->loadproductlocationbyid($productid);
        
        $this->data['brand'] = $this->db->select('*')->from('productbrand')->get()->result();
        $this->data['quality'] = $this->db->select('*')->from('productquality')->get()->result();
        $this->data['alldepartment']    = $this->Product_model->loaddepartment();
        $this->data['allsubdepartment'] = $this->Product_model->loadsubdepartment($this->data['product']->DepCode);
        $this->data['allcatogery']      = $this->Product_model->loadcategory($this->data['product']->SubDepCode,$this->data['product']->DepCode);
        $this->data['allsubcategory']   = $this->Product_model->loadsubcategory($this->data['product']->CategoryCode,$this->data['product']->SubDepCode,$this->data['product']->DepCode);

        $this->data['allsuppliers'] = $this->Product_model->loadsuppliers();
        $this->data['ploption']     = $this->Product_model->loadpricelevel();
        $this->data['measure']      = $this->Product_model->loadmeasuretype();
        $this->data['location']     = $this->Product_model->get_data('location')->result();
        // $this->data['racks'] = $this->Product_model->get_data('rack')->result();
        $this->load->view('admin/product/editproduct_modal', $this->data);
    }

    /*     * ************Products*************************************************** */
    public function check_product() {
        if (isset($_REQUEST['pname'])) {
            $q = ($_REQUEST['pname']);
            $isPro = $this->db->select('Prd_Description')->from('product')->where('Prd_Description', $q)->get()->num_rows();
            if($isPro>0){
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
    }

    public function check_product_code() {
        if (isset($_REQUEST['pcode'])) {
            $q = ($_REQUEST['pcode']);
            $isPro = $this->db->select('ProductCode')->from('product')->where('ProductCode', $q)->get()->num_rows();
            if($isPro>0){
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
    }

    public function allProducts() {
        $this->load->library('Datatables');
        $this->datatables->select('product.*, productprice.ProductPrice');
        $this->datatables->from('product');
        $this->datatables->join('productprice','productprice.ProductCode=product.ProductCode', 'inner');
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
    
    public function getallproducts() {
            $this->Product_model->getallproducts('product', '');
            die;
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

    public function getProductByBarCode() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $this->data['product'] = $this->Product_model->loadproductbyserial($dep, $pl, $location);
        echo json_encode($this->data['product']);
        die;
    }
    
    public function getProductByIdAndBarcode() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $arr['product'] = $this->Product_model->loadproductbypcodeandbarcode($dep, $pl);
        $arr['serial'] = $this->Product_model->loadproductbyserialArray($dep, $pl,$location);
        echo json_encode($arr);
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
        $arr['product'] = $this->Product_model->loadproductbyserial($dep, $pl, $location);
        $arr['serial'] = $this->Product_model->loadproductbyserialArray($dep, $pl, $location);
        echo json_encode($arr);
        die;
    }
    
    public function getProductByIdforSTO() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $arr['product'] = $this->Product_model->loadproductbypcode($dep, $pl);
        $arr['serial'] = $this->Product_model->loadproductbyserialArrayByCode($dep, $pl,$location);
        echo json_encode($arr);
        die;
    }
    
    public function getProductByBarCodeforSTO() {
        $dep = $_POST['proCode'];
        $pl = $_POST['prlevel'];
        $location = $_POST['location'];
        $arr['product'] = $this->Product_model->loadproductbyserial($dep, $pl, $location);
        $arr['serial'] = $this->Product_model->loadproductbyserialArrayByCode($dep, $pl, $location);
        echo json_encode($arr);
        die;
    }

    public function loadsubdepartment() {
        $dep = $_POST['dep'];
        echo json_encode($this->Product_model->loadsubdepartment($dep));
        die;
    }

    public function loadcategory() {
        $subdep = $_POST['subdep'];
        $dep = $_POST['dep'];
        echo json_encode($this->Product_model->loadcategory($subdep,$dep));
        die;
    }

    public function loadsubcategory() {
        $cat = $_POST['cat'];
        $subdep = $_POST['subdep'];
        $dep = $_POST['dep'];
        echo json_encode($this->Product_model->loadsubcategory($cat,$subdep,$dep));
        die;
    }

    public function loadbins() {
        $dep = $_POST['dep'];
        echo json_encode($this->Product_model->loadbin($dep));
        die;
    }

    public function loadracks() {
        $loc = $_POST['loc'];
        echo json_encode($this->Product_model->loadracks($loc));
        die;
    }

    public function add_product() {
        $autoProCode = $this->Product_model->loadSystemOptionById('M002');

        if($autoProCode==1){
            $data['ProductCode'] = $this->Product_model->get_max_code('Product');
        }else{
            $data['ProductCode'] = $_POST['productCode'];
        }
        
        if($_POST['barcode']==''){
            $barcode = $data['ProductCode'];
        }else{
            $barcode = $_POST['barcode'];
        }
        
         if($_POST['appearname']==''){
            $appearname = strtoupper($_POST['productname']);
        }else{
            $appearname = strtoupper($_POST['appearname']);
        }

         if($_POST['proDate']==''){
            $proDate = date("Y-m-d");
        }else{
            $proDate = ($_POST['proDate']);
        }

        $isPro = $this->db->select('Prd_Description')->from('product')->where('Prd_Description', $_POST['productname'])->get()->num_rows();
        //check duplicate pro code
        $isProCode =$this->db->select('ProductCode')->from('product')->where('ProductCode', $data['ProductCode'])->get()->num_rows();

        $data['Prd_Description'] = strtoupper($_POST['productname']);
        $data['Prd_AppearName'] = $appearname;
        $data['Cus_PrdCode'] = $_POST['part_no'];
        $data['OrgPartNo'] = $_POST['orgpart_no'];
        $data['Prd_Brand'] = $_POST['brand'];
        $data['Prd_Quality'] = $_POST['quality'];
        $data['Prd_Date'] = $proDate;

        $data['DepCode'] = $_POST['department'];
        $data['SubDepCode'] = $_POST['sub_department'];
        $data['CategoryCode'] = isset($_POST['category']) ? $_POST['category'] : 0;
        $data['SubCategoryCode'] = isset($_POST['sub_category']) ? $_POST['sub_category'] : 0;

        $data['BarCode'] = $barcode;

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
        $productcondition['IsTax'] = isset($_POST['isvat']) ? 1 : 0;
        $productcondition['IsNbt'] = isset($_POST['isnbt']) ? 1 : 0;
        $productcondition['NbtRatio'] = isset($_POST['nbtratio']) ? $_POST['nbtratio'] : 1;

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
        }else{
            $plrowdata = array(
                    'ProductCode' => $data['ProductCode'],
                    'PL_No' => 1,
                    'ProductPrice' => 1
                );
            if ($data['ProductCode'] != '') {
                array_push($pldata, $plrowdata);
            }
        }
         if($isPro>0){
            $dpro=$this->db->select('ProductCode')->from('product')->where('Prd_Description', $_POST['productname'])->get()->row()->ProductCode;
                $return = array(
                   'ProductCode'=>$dpro,
                   'fb'=>2
                );
        }elseif($isProCode>0){
            $dprocode=$this->db->select('ProductCode')->from('product')->where('ProductCode', $date['ProductCode'])->get()->row()->ProductCode;
                $return = array(
                   'ProductCode'=>$dprocode,
                   'fb'=>3
                );
        }else{
            $res=$this->Product_model->saveProduct($data,$productcondition,$pldata);
            $return = array(
               'ProductCode'=>$data['ProductCode'],
               'fb'=>$res
            );
        }
       echo json_encode($return);
        die;
    }

    public function update_product() {
        $productcode = $_POST['productCode'];

        $data['Prd_Description'] = $_POST['productname'];
        $data['Prd_AppearName'] = $_POST['appearname'];
        $data['Cus_PrdCode'] = $_POST['part_no'];
        $data['Prd_Date'] = $_POST['proDate'];
        $data['OrgPartNo'] = $_POST['orgpart_no'];
        $data['Prd_Brand'] = $_POST['brand'];
        $data['Prd_Quality'] = $_POST['quality'];

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
        $productcondition['IsTax'] = isset($_POST['isvat']) ? 1 : 0;
        $productcondition['IsNbt'] = isset($_POST['isnbt']) ? 1 : 0;
        $productcondition['NbtRatio'] = isset($_POST['nbtratio']) ? $_POST['nbtratio'] : 1;

        $pldata = array();

        $loc_array  = json_decode($_POST['loc_array']);
        $rack_array = json_decode($_POST['rack_array']);
        $bin_array  = json_decode($_POST['bin_array']);
        $this->db->delete('productlocation',array('ProductCode' => $productcode));
        //product location
        for ($i=0; $i <count($loc_array) ; $i++) { 
           $proLoc['ProductCode'] = $productcode;
           $proLoc['ProLocation'] = $loc_array[$i];
           $proLoc['ProRack']     = $rack_array[$i]; 
           $proLoc['ProBin']      = $bin_array[$i];
           $this->db->insert('productlocation', $proLoc);
        }

        if (isset($_POST['pl'])) {
            foreach ($_POST['pl'] AS $key => $val) {
                $plrowdata = array(
                    'ProductCode' => $productcode,
                    'PL_No' => $key,
                    'ProductPrice' => $val
                );
                if ($val != '' || $_POST['pl'][$key]) {
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
