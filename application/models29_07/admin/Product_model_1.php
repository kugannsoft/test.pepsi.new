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

    public function loadproductbyserial($product, $pl, $location) {
        $query2 = $this->db->select('product.*,productcondition.*,productprice.ProductPrice,productserialstock.SerialNo')->from('product')
                        ->where('productserialstock.SerialNo', $product)
                        ->where('productserialstock.Location', $location)
                        ->where('productprice.PL_No', $pl)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
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

    public function loaddepartment() {
        return $this->db->select()->from('department')->get()->result();
    }

    public function loadsubdepartment($dep) {
        return $this->db->select()->from('subdepartment')->where('DepCode', $dep)->get()->result();
    }

    public function loadcategory($subdep) {
        return $this->db->select()->from('category')->where('SubDepCode', $subdep)->get()->result();
    }

    public function loadsubcategory($cat) {
        return $this->db->select()->from('subcategory')->where('CategoryCode', $cat)->get()->result();
    }

    public function loadsuppliers() {
        return $this->db->select('SupCode,SupName')->from('supplier')->get()->result();
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

}
