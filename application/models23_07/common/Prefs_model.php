<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prefs_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function admin_prefs()
    {
        $query = $this->db->get('admin_preferences');
        foreach ($query->result_array() as $value)
        {
            $data['user_panel']         = $value['user_panel'];
            $data['sidebar_form']       = $value['sidebar_form'];
            $data['messages_menu']      = $value['messages_menu'];
            $data['notifications_menu'] = $value['notifications_menu'];
            $data['tasks_menu']         = $value['tasks_menu'];
            $data['user_menu']          = $value['user_menu'];
            $data['ctrl_sidebar']       = $value['ctrl_sidebar'];
            $data['transition_page']    = $value['transition_page'];
        }
        return $data;
    }

    public function user_info_login($id)
    {
        $user = $this->ion_auth->user($id)->row();

        $data['id']         = $user->id;
        $data['ipadress']   = $user->id;
        $data['username']   = ! empty($user->username) ? htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8') : NULL;
        $data['email']      = $user->email;
        $data['created_on'] = $user->created_on;
        $data['lastlogin']  = ! empty($user->last_login) ? $user->last_login : NULL;
        $data['active']     = $user->active;
        $data['firstname']  = ! empty($user->first_name) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : NULL;
        $data['lastname']   = ! empty($user->last_name) ? ' '.htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8') : NULL;
        $data['company']    = htmlspecialchars($user->company, ENT_QUOTES, 'UTF-8');
        $data['phone']      = ! empty($user->phone) ? $user->phone : NULL;

        return $data;
    }
    
    public function getActiveTranserOutByto(){
        $this->db->select('*');
        $this->db->from('stocktransferdtl');
        $this->db->join('stocktransferhed', 'stocktransferdtl.TrnsNo = stocktransferhed.TrnsNo', 'INNER');
        $this->db->join('product', 'stocktransferdtl.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('location', 'stocktransferhed.FromLocation = location.location_id', 'LEFT');
        $this->db->where('stocktransferhed.TransIsInProcess', 1)->where('stocktransferhed.IsCancel', 0)->where('stocktransferhed.ToLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get()->result_array();
        return $q;
    }
    
    public function getCountActiveTranserOut(){
        $this->db->select('*');
        $this->db->from('stocktransferdtl');
        $this->db->join('stocktransferhed', 'stocktransferdtl.TrnsNo = stocktransferhed.TrnsNo', 'INNER');
        $this->db->join('product', 'stocktransferdtl.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('location', 'stocktransferhed.FromLocation = location.location_id', 'LEFT');
        $this->db->where('stocktransferhed.TransIsInProcess', 1)->where('stocktransferhed.IsCancel', 0)->where('stocktransferhed.ToLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get();
        
        if($q->num_rows()>0){
            return $q->num_rows();
        }else{
             return 0;
        }
    }

    public function getActivePartRequest(){
        $this->db->select('materialrequestnotehed.*,users.first_name,users.last_name,T.location as toLoc,F.location AS fromLoc');
        $this->db->from('materialrequestnotehed');
        $this->db->join('users', 'users.id = materialrequestnotehed.MrnUser', 'INNER');
        $this->db->join('location T', 'materialrequestnotehed.ToLocation = T.location_id', 'left');
        $this->db->join('location F', 'materialrequestnotehed.FromLocation = F.location_id', 'LEFT');
        $this->db->where('materialrequestnotehed.MrnIsReceive', 0)->where('materialrequestnotehed.IsCancel', 0)->where('materialrequestnotehed.FromLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get()->result_array();
        return $q;
    }

    public function getActivePartRequestCount(){
        $this->db->select('materialrequestnotehed.*,users.first_name,users.last_name,T.location as toLoc,F.location AS fromLoc');
        $this->db->from('materialrequestnotehed');
        $this->db->join('users', 'users.id = materialrequestnotehed.MrnUser', 'INNER');
        $this->db->join('location T', 'materialrequestnotehed.ToLocation = T.location_id', 'left');
        $this->db->join('location F', 'materialrequestnotehed.FromLocation = F.location_id', 'LEFT');
        $this->db->where('materialrequestnotehed.MrnIsReceive', 0)->where('materialrequestnotehed.IsCancel', 0)->where('materialrequestnotehed.FromLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get()->num_rows();
        return $q;
    }

    public function getActivePartIssuedRequest(){
        $this->db->select('materialrequestnotehed.*,users.first_name,users.last_name,T.location as toLoc,F.location AS fromLoc');
        $this->db->from('materialrequestnotehed');
        $this->db->join('users', 'users.id = materialrequestnotehed.MrnOutUser', 'INNER');
        $this->db->join('location T', 'materialrequestnotehed.ToLocation = T.location_id', 'left');
        $this->db->join('location F', 'materialrequestnotehed.FromLocation = F.location_id', 'LEFT');
        $this->db->where('materialrequestnotehed.MrnIsReceive', 1)->where('materialrequestnotehed.IsConfirm', 0)->where('materialrequestnotehed.IsCancel', 0)->where('materialrequestnotehed.FromLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get()->result_array();
        return $q;
    }

    public function getActivePartIssuedRequestCount(){
        $this->db->select('materialrequestnotehed.*,users.first_name,users.last_name,T.location as toLoc,F.location AS fromLoc');
        $this->db->from('materialrequestnotehed');
        $this->db->join('users', 'users.id = materialrequestnotehed.MrnOutUser', 'INNER');
        $this->db->join('location T', 'materialrequestnotehed.ToLocation = T.location_id', 'left');
        $this->db->join('location F', 'materialrequestnotehed.FromLocation = F.location_id', 'LEFT');
        $this->db->where('materialrequestnotehed.MrnIsReceive', 1)->where('materialrequestnotehed.IsConfirm', 0)->where('materialrequestnotehed.IsCancel', 0)->where('materialrequestnotehed.FromLocation', $_SESSION['location']);
        // $this->db->group_by('stocktransferhed.TrnsNo');
        $q= $this->db->get()->num_rows();
        return $q;
    }

    public function getBlockFunctionByClassAndUser1($class,$user){
        $k ='';
        $num = $this->db->select('permission_function')->from('permission')->where('permission_class',$class)->where('per_user',$user)->get()->num_rows();

        if($num>0){
            $query = $this->db->select('permission_function')->from('permission')->where('permission_class',$class)->where('per_user',$user)->get()->row()->permission_function;
       
            $k =json_decode($query);
            return ($k);
        }else{
            return null;
        }
    }

    public function getRoleIdByUser($user)
    {

      $role = $this->db->select('role')->from('users')->where('id',$user)->get()->row()->role;
      return $role;

    }

    public function getBlockClassByUser1($class,$user){   
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

    public function getBlockFunctionByUser1($user){
        $k ='';
        $num = $this->db->select('permission_function')->from('permission')->where('per_user',$user)->get()->num_rows();

        if($num>0){
            $query = $this->db->select('permission_function')->from('permission')->where('per_user',$user)->get()->row()->permission_function;
       
            $k =json_decode($query);
            return ($k);
        }else{
            return null;
        }
    }

    public function getAllBlockClassByUser1($user){
        $k ='';
        $num = $this->db->select('permission_class')->from('permission')->where('per_user',$user)->get()->num_rows();

        if($num>0){
            $query = $this->db->select('permission_class')->from('permission')->where('per_user',$user)->get()->row()->permission_class;
       
            $k =json_decode($query);
            return ($k);
        }else{
            return null;
        }
    }
    
/*Start By Asanka 2020-09-08 - This functions for permission VIEW, ADD, EDIT or DELETE  */

    public function getBlockForView($role)
    {
        $row = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_view', 1)->get()->num_rows();
        if ($row > 0) {
            $query = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_view', 1)->get()->result();

            $perCodeArray = array();
            foreach ($query as $key => $value) {

                array_push($perCodeArray, $value->per_code);
            }
            return $perCodeArray;
        } else {
            return null;
        }
    }

    public function getBlockForAdd($role)
    {
        $row = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_add', 1)->get()->num_rows();
        if ($row > 0) {
            $query = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_add', 1)->get()->result();

            $perCodeArray = array();
            foreach ($query as $key => $value) {

                array_push($perCodeArray, $value->per_code);
            }
            return $perCodeArray;
        } else {
            return null;
        }
    }

    public function getBlockForEdit($role)
    {
        $row = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_edit', 1)->get()->num_rows();
        if ($row > 0) {
            $query = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_edit', 1)->get()->result();

            $perCodeArray = array();
            foreach ($query as $key => $value) {

                array_push($perCodeArray, $value->per_code);
            }
            return $perCodeArray;
        } else {
            return null;
        }
    }

    public function getBlockForDelete($role)
    {
        $row = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_delete', 1)->get()->num_rows();
        if ($row > 0) {
            $query = $this->db->select('per_code')->from('system_permission_set')->where('role_id', $role)->where('is_delete', 1)->get()->result();

            $perCodeArray = array();
            foreach ($query as $key => $value) {

                array_push($perCodeArray, $value->per_code);
            }
            return $perCodeArray;
        } else {
            return null;
        }
    }

/*End By Asanka*/    
}