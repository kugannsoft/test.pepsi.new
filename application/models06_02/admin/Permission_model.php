<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model {

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

    public function getBlockFunctionByClassAndUser($class,$user)
    {$k ='';
        $num = $this->db->select('permission_function')->from('permission')->where('permission_class',$class)->where('per_user',$user)->get()->num_rows();

         if($num>0){
        $query = $this->db->select('permission_function')->from('permission')->where('permission_class',$class)->where('per_user',$user)->get()->row()->permission_function;
       
        $k =json_decode($query);
        return ($k);
        }else{
        return null;
        }
    }

    public function getBlockClassByUser($class,$user)
    {   
        $num = $this->db->select('permission_class')->where('permission_class',$class)->where('per_user',$user)->where('isClass',1)->get('permission')->num_rows();

        if($num>0){
            $query = $this->db->select('permission_class')->where('permission_class',$class)->where('per_user',$user)->where('isClass',1)->get('permission')->result();
            $row_set[]='';
            foreach ($query as $row)
            {
                $row_set[] = strtolower($row->permission_class);
            }
            // return json_encode($row_set);
            return $row_set;
        }else{
            return null;
        }
    }

}
