<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_count_record($table) {
        $query = $this->db->count_all($table);

        return $query;
    }

    public function get_data($table) {
        $query = $this->db->get($table);
        return $query;
    }

    public function get_data_by_where($table, $data) {
        $query = $this->db->get_where($table, $data)->result();
        return $query;
    }

    public function insert_data($table, $data) {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    public function insert_batchdata($table, $data) {
        return $this->db->insert_batch($table, $data);
    }

    public function update_data($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }

    public function loadproductstockbyid($product,$location)
    {
        return $this->db->select('Stock')
            ->from('productstock')->where('ProductCode', $product)->where('Location', $location)
            ->get()->row();
    }

    public function get_max_code($form) {
        $query = $this->db->select('*')->where('FormName', $form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
            $code = $row['CodeLimit'];
            $input = $row['AutoNumber'];
            $string = $row['FormCode'];
            $code_len = $row['FCLength'];
            $item_ref = $string . str_pad(($input + 1), $code_len, $code, STR_PAD_LEFT);
        }
        return $item_ref;
    }

    public function update_max_code($form) {
        $query = $this->db->select('*')->where('FormName', $form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
            $input = $row['AutoNumber'];
        }
        $this->db->update('codegenerate', array('AutoNumber' => ($input + 1)), array('FormName' => ($form)));
    }

    public function get_products($table, $q) {
        $query = $this->db->select('product.Prd_Description,product.ProductCode,productprice.ProductPrice')->from('product')
                ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $q ,'left')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->where('product.Prd_IsActive', 1)
                ->limit(50)
                ->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                $new_row['price'] = htmlentities(stripslashes($row['ProductPrice']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadproductbyid($product) {
        return $this->db->select('product.*,productcondition.*')->from('product')
                        ->where('product.ProductCode', $product)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->get()->row();
    }

    public function loadpricelistbyid($product) {
        return $this->db->select('productprice.ProductPrice,productprice.PL_No,pricelevel.PriceLevel')
                ->from('productprice')->where('ProductCode', $product)
                ->join('pricelevel','pricelevel.PL_No = productprice.PL_No')
                ->get()->result();
    }

    public function loadproductlocationbyid($product) {
        return $this->db->select('productlocation.*,rack.rack_no,store_location.bin_no,location.location,')
                ->from('productlocation')->where('ProductCode', $product)
                ->join('rack','rack.rack_id = productlocation.ProRack')
                ->join('location','location.location_id = rack.rack_loc')
                ->join('store_location','store_location.store_id = productlocation.ProBin')
                ->get()->result();
    }

    public function loadproductbypcode($product, $pl) {
        return $this->db->select('product.*,productcondition.*,productprice.ProductPrice')->from('product')
                        ->where('product.ProductCode', $product)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get()->row();
    }

    public function loadproductbybarcode($product, $pl) {
        return $this->db->select('product.*,productcondition.*,productprice.ProductPrice')->from('product')
                        ->where('product.BarCode', $product)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get()->row();
    }

    public function loadproductbypcodeandbarcode($product, $pl) {
        $query1= $this->db->select('product.*,productcondition.*,productprice.ProductPrice')->from('product')
                        ->where('product.ProductCode', $product)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get()->row();
        $query2= $this->db->select('product.*,productcondition.*,productprice.ProductPrice')->from('product')
                        ->where('product.BarCode', $product)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get()->row();
       if(($query1->num_rows())>0){
            return $query1->row();
        }else if(($query2->num_rows())>0){
            return $query2->row();
        }                 
    }

    public function loadproductbyserial($product, $pl, $location) {
        $query2 = $this->db->select('product.*,productcondition.*,productprice.ProductPrice,productserialstock.SerialNo,goodsreceivenotedtl.GRN_UnitCost AS Prd_CostPrice')->from('product')
                        ->where('productserialstock.SerialNo', $product)
                        ->where('productserialstock.Location', $location)
                        ->where('productprice.PL_No', $pl)
                        ->where('productserialstock.Quantity', 1)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                        ->join('goodsreceivenotedtl', 'goodsreceivenotedtl.SerialNo = productserialstock.SerialNo')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get();
        $query1 =$this->db->select('product.*,productcondition.*,productprice.ProductPrice')->from('product')
                        ->where('product.BarCode', $product)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get();
        if(($query1->num_rows())>0){
            return $query1->row();
        }else if(($query2->num_rows())>0){
            return $query2->row();
        }
    }
    
    public function loadproductbyserialArray($product, $pl, $location) {
        $query2 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
			->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
        $query1 = $this->db->select('productcondition.IsSerial')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productcondition.IsSerial', 1)
                ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                ->get();

        if (($query1->num_rows()) > 0) {
            if (($query2->num_rows()) > 0) {
                foreach ($query2->result_array() as $row) {
                    $row_set[] = htmlentities(stripslashes($row['SerialNo']));
                }
                return ($row_set);
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }
    
    public function loadproductbyserialArrayByCode($product, $pl, $location) {
   
        $query2 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
        ->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
        $query4 = $this->db->select('productserialstock.SerialNo')->from('product')
                //->where('productserialstock.SerialNo', $product)
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
        ->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
        $query1 = $this->db->select('productcondition.IsSerial')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productcondition.IsSerial', 1)
                ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                ->get();
        $query3 = $this->db->select('productcondition.IsSerial')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->where('productcondition.IsSerial', 1)
                ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->get();
        
        $query5 = $this->db->select('product.ProductCode')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->group_by('product.ProductCode')
                ->get();
        
        if (($query1->num_rows()) > 0) {
            if (($query2->num_rows()) > 0) {
                foreach ($query2->result_array() as $row) {
                    $row_set[] = htmlentities(stripslashes($row['SerialNo']));
                }
                return ($row_set);
            }
        }else if (($query3->num_rows()) > 0) {
            if (($query5->num_rows()) > 0) {
                //get product code by serial
                foreach ($query5->result_array() as $row) {
                    $pro = htmlentities(stripslashes($row['ProductCode']));
                }
                
                 $query4 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('product.ProductCode', $pro)
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
                ->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
                
                foreach ($query4->result_array() as $row) {
                    $row_set[] = htmlentities(stripslashes($row['SerialNo']));
                }
                return ($row_set);
            } 
        } else  {
            return NULL;
        }
    }
    
     public function loadproductbyserialArrayBySerial($product, $pl, $location) {
   
        $query2 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
                ->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
        $query4 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->where('productserialstock.Location', $location)
                ->where('productprice.PL_No', $pl)
                ->where('productserialstock.Quantity', 1)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->get();
        $query1 = $this->db->select('productcondition.IsSerial')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productcondition.IsSerial', 1)
                ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                ->get();
        $query3 = $this->db->select('productcondition.IsSerial')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->where('productcondition.IsSerial', 1)
                ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->get();
        
        if (($query1->num_rows()) > 0) {
            if (($query2->num_rows()) > 0) {
                foreach ($query2->result_array() as $row) {
                    $row_set[] = htmlentities(stripslashes($row['SerialNo']));
                }
                return ($row_set);
            }
        }else if (($query3->num_rows()) > 0) {
            if (($query4->num_rows()) > 0) {
                foreach ($query4->result_array() as $row) {
                    $row_set[] = htmlentities(stripslashes($row['SerialNo']));
                }
                return ($row_set);
            } 
        } else  {
            return NULL;
        }
    }
    
    public function loaddepartment() {
        return $this->db->select()->from('department')->get()->result();
    }

    public function loadsubdepartment($dep) {
        return $this->db->select()->from('subdepartment')->where('DepCode', $dep)->get()->result();
    }

    public function loadcategory($subdep,$dep) {
        return $this->db->select()->from('category')->where('SubDepCode', $subdep)->where('DepCode', $dep)->get()->result();
    }

    public function loadsubcategory($cat,$subdep,$dep) {
        return $this->db->select()->from('subcategory')->where('DepCode', $dep)->where('SubDepCode', $subdep)->where('CategoryCode', $cat)->get()->result();
    }

    public function loadbin($rack) {
        return $this->db->select()->from('store_location')->where('store_rack', $rack)->get()->result();
    }

    public function loadracks($location) {
        return $this->db->select()->from('rack')->where('rack_loc', $location)->get()->result();
    }

    public function loadsuppliers() {
        return $this->db->select('SupCode,SupName')->from('supplier')->where('IsActive',1)->get()->result();
    }

    public function loadpricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }

    public function loadmeasuretype() {
        return $this->db->select()->from('measure')->where('IsActive', 1)->get()->result();
    }

    public function save_product() {
        return $this->db->insert();
    }
    public function saveProduct($data,$productcondition,$pldata){

        $this->db->trans_start();
        $this->insert_data('product', $data);
        $this->insert_data('productcondition', $productcondition);
        $this->insert_batchdata('productprice', $pldata);
        $loc_array  = json_decode($_POST['loc_array']);
        $rack_array = json_decode($_POST['rack_array']);
        $bin_array  = json_decode($_POST['bin_array']);

        //product location
        for ($i=0; $i <count($loc_array) ; $i++) { 
           $proLoc['ProductCode'] = $data['ProductCode'];
           $proLoc['ProLocation'] = $loc_array[$i];
           $proLoc['ProRack']     = $rack_array[$i]; 
           $proLoc['ProBin']      = $bin_array[$i];
           $this->insert_data('productlocation', $proLoc);
        }
        $this->update_max_code('Product');
         $this->db->trans_complete();
       return $this->db->trans_status();
    }

     public function loadSystemOptionById($id){
       return $this->db->select('Value')->from('systemoptions')->where('ID', $id)->get()->row()->Value;
    }

       public function loadpricestockbyid($product,$location,$price,$pl)
    {
       
            return $this->db->select('Stock,Price,UnitCost')
            ->from('pricestock')
            ->where('PSCode', $product)
            ->where('PSLocation', $location)
            ->where('Price', $price)
            ->where('PSPriceLevel', $pl)
            ->get()->row();
        
        
    }

      public function loadproductbypcodegrn($product, $pl) {
        return $this->db->select('product.*,productcondition.*,
                        productprice.ProductPrice')
                        ->from('product')
                        ->where('product.ProductCode', $product)
                        // ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                       
                        ->get()->row();
    }

     public function loadproductbypcodegrnWhole($product, $pl) {
        return $this->db->select('productprice.ProductPrice')
                        ->from('product')
                        ->where('product.ProductCode', $product)
                         ->where('productprice.PL_No', 2)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                        ->get()->row();
    }

    
}
