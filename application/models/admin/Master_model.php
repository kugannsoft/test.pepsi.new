<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    public function get_count_record($table)
    {
        $query = $this->db->count_all($table);

        return $query;
    }
    
    public function get_data($table)
    {
        $query = $this->db->get($table);
        return $query;
    }
    
    public function insert_data($table,$data)
    {
        $query = $this->db->insert($table, $data);
        return $query;
    }
    
     
    public function update_data($table,$data,$id)
    {
        $query =$this->db->update($table,$data,$id);
        return $query;
    }
    
     public function get_max_depcode($table)
    {
        $query = $this->db->select_max('DepCode')->get($table);
        return $query;
    }
    
    public function get_max_subdepcode($table)
    {
        $query = $this->db->select_max('SubDepCode')->get($table);
        return $query;
    }
    
    public function get_max_catcode($table)
    {
        $query = $this->db->select_max('CategoryCode')->get($table);
        return $query;
    }
    
    public function get_max_subcatcode($table)
    {
        $query = $this->db->select_max('SubCategoryCode')->get($table);
        return $query;
    }
     public function getSubDepByDep($table,$id)
    {
        $query = $this->db->select()->where('DepCode',$id)->get($table)->result();
        return $query;
    }
    
    public function getCatByDep($table,$id,$id2)
    {
        $query = $this->db->select()->where('DepCode',$id)->where('SubDepCode',$id2)->get($table)->result();
        return $query;
    }
    
    public function getSubCatByDep($table,$id,$id2,$id3)
    {
        $query = $this->db->select()->where('DepCode',$id)->where('SubDepCode',$id2)->where('CategoryCode',$id3)->get($table)->result();
        return $query;
    }
    
    public function deleteCategory($table,$id,$level)
    { 
        $query=0;
        if ($level == 4) {
            $isPro = $this->db->select()->where('SubCategoryCode', $id['SubCategoryCode'])->get('product');
            if ($isPro->num_rows() == 0) {
                $query = $this->db->where('SubCategoryCode', $id['SubCategoryCode'])->delete($table);
            } else {
                $query = 3;
            }
        } elseif ($level == 3) {
            $isPro = $this->db->select()->where('CategoryCode', $id['CategoryCode'])->get('product');
            if ($isPro->num_rows() == 0) {
                $isSCat = $this->db->select()->where('CategoryCode', $id['CategoryCode'])->get('subcategory');

                if ($isSCat->num_rows() == 0) {
                    $query = $this->db->where('CategoryCode', $id['CategoryCode'])->delete($table);
                } else {
                    $query = 2;
                }
            } else {
                $query = 3;
            }
        } elseif ($level == 2) {
            $isPro = $this->db->select()->where('SubDepCode', $id['SubDepCode'])->get('product');
            if ($isPro->num_rows() == 0) {
                $isSCat = $this->db->select()->where('SubDepCode', $id['SubDepCode'])->get('subcategory');
                if ($isSCat->num_rows() == 0) {
                    $isCat = $this->db->select()->where('SubDepCode', $id['SubDepCode'])->get('category');

                    if ($isCat->num_rows() == 0) {
                        $query = $this->db->where('SubDepCode', $id['SubDepCode'])->delete($table);
                    } else {
                        $query = 2;
                    }
                } else {
                    $query = 2;
                }
            } else {
                $query = 3;
            }
        } elseif ($level == 1) {
            $isPro = $this->db->select()->where('DepCode', $id['DepCode'])->get('product');
            if ($isPro->num_rows() == 0) {
                $isSCat = $this->db->select()->where('DepCode', $id['DepCode'])->get('subcategory');
                if ($isSCat->num_rows() == 0) {
                    $isCat = $this->db->select()->where('DepCode', $id['DepCode'])->get('category');
                    if ($isCat->num_rows() == 0) {
                        $isDep = $this->db->select()->where('DepCode', $id['DepCode'])->get('subdepartment');
                        if ($isDep->num_rows() == 0) {
                            $query = $this->db->where('DepCode', $id['DepCode'])->delete($table);
                        } else {
                            $query = 2;
                        }
                    } else {
                        $query = 2;
                    }
                } else {
                    $query = 2;
                }
            } else {
                $query = 3;
            }
        }
        return $query;
    }
    
    public function deleteTransType($table,$id)
    { 
        $query=0;
        $this->db->trans_start();
        $isPro = $this->db->select()->where('TransactionCode', $id)->get('cashflot');
        if ($isPro->num_rows() == 0) {
            $query = $this->db->where('TransactionCode', $id)->delete($table);
        } else {
            $query = 3;
        }
        $this->db->trans_complete();
        return $query;
    }
    
}
