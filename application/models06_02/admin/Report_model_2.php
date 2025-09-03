<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function loadroot() {
        $this->db->select();
        $this->db->from('location');
        return $this->db->get()->result();
    }

    public function loadproduct() {
        $this->db->select('ProductCode,Prd_Description');
        $this->db->from('product');
        return $this->db->get()->result();
    }

    public function loadSerialProduct() {
        $this->db->select('product.ProductCode,product.Prd_Description');
        $this->db->from('product');
        $this->db->join('productcondition', 'productcondition.ProductCode = product.ProductCode', 'INNER');
        $this->db->where('productcondition.IsSerial', 1);
        return $this->db->get()->result();
    }

    public function genreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) <=', $enddate);
            $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where_in('InvLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) <=', $enddate);
            $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genreportbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('InvProductCode,
                           invoicehed.InvNo,
                           invoicehed.InvDate,
                           Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                           SUM(InvQty) AS Qty,
                           SUM(InvFreeQty) AS FreeQty,
                           SUM(InvCostPrice * InvQty) AS CostValue,
                           SUM(invoicedtl.InvTotalAmount) AS TotalAmount,
                           SUM(invoicedtl.InvDisValue) AS DisAmount,
                           SUM(invoicedtl.InvNetAmount) AS NetAmount,
                           SUM(InvReturnQty) AS ReturnQty,
                           SUM(invoicehed.InvDisAmount) AS TotalDiscount,
                           department.Description,
                           product.DepCode,
                           product.SubCategoryCode');
        $this->db->from('invoicedtl');
        $this->db->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'INNER');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'INNER');
        $this->db->where('DATE(invoicehed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('InvProductCode', $product);
        }
        
         if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        $this->db->group_by('ProductCode');
        $this->db->order_by('invoicehed.InvDate');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }
    
    public function genreporttotalDiscountbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('SUM(invoicehed.InvDisAmount) AS TotalDiscount');
        $this->db->from('invoicedtl');
        $this->db->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'left');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'left');
        $this->db->where('DATE(invoicehed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('InvProductCode', $product);
        }
        
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        $this->db->group_by('invoicedtl.InvNo');
        // $this->db->limit(50);
        $result=$this->db->get()->row()->TotalDiscount;
//        $list=0;
//        foreach ($result->result() as $row) {
//            $list = $row->TotalDiscount;
//        }
        return $result;
    }

    public function searchproduct($q) {
        $this->db->select('ProductCode AS id,Prd_Description AS text');
        $this->db->from('product');
        $this->db->where('product.Prd_IsActive', 1);
        $this->db->like('CONCAT(ProductCode,Prd_Description)', $q, 'left');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsupplier($q) {
        $this->db->select('SupCode AS id,SupName AS text');
        $this->db->from('supplier');
        $this->db->like('CONCAT(SupCode,SupName)', $q, 'left');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchdepartment($q) {
        $this->db->select('DepCode AS id,Description AS text');
        $this->db->from('department');
        $this->db->like('CONCAT(DepCode,Description)', $q, 'left');
        $this->db->group_by('Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsubdepartment($q,$cat) {
        $this->db->select('subdepartment.SubDepCode AS id,subdepartment.Description AS text');
        $this->db->from('subdepartment');
//        $this->db->where('subdepartment.DepCode', $cat);
//         $this->db->join('department', 'department.DepCode = subdepartment.DepCode', 'INNER');
        $this->db->like('CONCAT(subdepartment.SubDepCode,subdepartment.Description)', $q, 'left');
        $this->db->group_by('subdepartment.Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsubcategory($q,$cat,$cat2) {
        $this->db->select('subcategory.SubCategoryCode AS id,subcategory.Description AS text');
        $this->db->from('subcategory');
//        $this->db->where('subcategory.DepCode', $cat);
//        $this->db->where('subcategory.SubDepCode', $cat2);
        $this->db->like('CONCAT(subcategory.SubCategoryCode,subcategory.Description)', $q, 'left');
        $this->db->group_by('subcategory.Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    public function productdetail($route, $isall, $product = NULL,$dep,$subdep,$sup,$subcat) {
        $this->db->select('product.ProductCode,
                           product.Prd_Description,
                           product.Prd_CostPrice,
                           product.SubDepCode,
                           product.Prd_ROL,
                           product.Prd_ROQ,
                           subdepartment.Description,
                           location.location,
                           productstock.Stock,
                           productprice.ProductPrice,
                           supplier.SupName');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->join('productstock', 'productstock.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
        $this->db->join('productprice', 'productprice.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'left');
        $this->db->join('location', 'location.location_id = productstock.Location', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        
        if (isset($route) && $route != '') {
            $this->db->where_in('productstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
//        $this->db->order_by('product.SubCategoryCode', 'ASC');
        $this->db->order_by('subcategory.Description', 'ASC');
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }
    
    public function lowproductdetail($route, $isall, $product = NULL,$dep,$subdep,$sup) {
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.Prd_CostPrice,
                            product.SubDepCode,
                             product.Prd_ROL,
                              product.Prd_ROQ,
                            subdepartment.Description,
                            location.location,
                            productstock.Stock,
                            supplier.SupName');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->join('productstock', 'productstock.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
//        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'INNER');
        $this->db->join('location', 'location.location_id = productstock.Location', 'INNER');
        $this->db->where('productstock.Stock < product.Prd_ROL');
        $this->db->where('product.Prd_IsActive', 1);
        
        if (isset($route) && $route != '') {
            $this->db->where('productstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($dep) && $dep != '' && isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function priceproductdetail($route, $isall, $product = NULL,$dep,$subdep,$sup) {
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.SubDepCode,
                            subdepartment.Description,
                            product.Prd_CostPrice,
                            location.location,
                            pricestock.Stock,
                            pricestock.Price,
                            supplier.SupName');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->join('pricestock', 'pricestock.PSCode = product.ProductCode', 'LEFT');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
//        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'INNER');
        $this->db->join('location', 'location.location_id = pricestock.PSLocation', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        if (isset($route) && $route != '') {
            $this->db->where('pricestock.PSLocation', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($dep) && $dep != '' && isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        $result= $this->db->get();
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function productdetailserial($route, $isall, $product = NULL) {
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.Prd_CostPrice,
                            location.location,
                            productserialstock.Quantity,
                            productserialstock.SerialNo,
                            supplier.SupName,
                            goodsreceivenotehed.GRN_DateORG');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('location', 'location.location_id = productserialstock.Location', 'INNER');
        $this->db->join('goodsreceivenotehed', 'goodsreceivenotehed.GRN_No = productserialstock.GrnNo', 'Left');
        $this->db->where('product.Prd_IsActive', 1);
        if (isset($route) && $route != '') {
            $this->db->where('productserialstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
        return $this->db->get()->result();
    }

    public function productdailyfinalstock($startdate, $enddate, $route, $product = NULL,$dep,$subdep,$subcat) {
        $query = $this->db->query("CALL SPR_STOCK_FINAL_V2('$startdate','$enddate','$route','$product','$dep','$subdep','$subcat')");
        $result = array();
        foreach ($query->result() as $rows) {
        $result[$rows->CategoryName][] = $rows;
        }
        return $result;
    }
    
     public function productdailyfinalstock2($startdate, $enddate, $route, $product = NULL) {
         $query = $this->db->query("CALL SPR_STOCK_FINAL('$startdate','$enddate','$route','$product')");
        $data = array();
        while ($row = $query->result()) {
            $data[$row['country']][$row['city']] = $row['venue'];
        }
        foreach ($row as $country => $cities) {
            echo "<h1>$country</h1>\n";
            foreach ($cities as $city => $venues) {
                echo "<h2>$city</h2>\n";
            }
        }
    }

    public function laststockreportdate() {
        if (isset($this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate) &&
                $this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate != '') {
            return $this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate;
        } else {
            return date("Y-m-d");
        }
    }

    public function dailyreportupdate($date, $user) {
        $now = date("Y-m-d H:i:s");
        if ($this->db->query("CALL SPT_UPDATE_DAILY_STOCK('$date','$user','$now')")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function dailyreportupdateuserdata() {
        $maxid = $this->db->select_max('id')->from('stockdateuser')->get()->row()->id;
        return $this->db->select()->from('stockdateuser')->where('id', $maxid)->get()->row();
    }

}
