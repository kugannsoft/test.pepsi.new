<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SetPermission_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_data($table, $data) {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    public function where_permssion($roleId, $per_code)
    {
        $query = $this->db->select('*')->from('system_permission_set')->where('role_id',$roleId)->where('per_code', $per_code)->get()->row();

        return $query;
    }

    public function update_data($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }

    public function delete_data($table,$id)
    {
        $query = $this->db->delete($table,$id);
        return $query;
    }
    public function CheckPermissionview($userrole,$per_code)
    {
        $query = $this->db->select('*')->from('system_permission_set')->where('role_id',$userrole)->where('per_code', $per_code)->get()->row();
        if ($query->is_view==0) {
            echo '<div class="alert" style="padding: 20px;
                  background-color: #fff;
                  color: #f44336;">
                  <div><img src="http://localhost/shalika/avinda/upload/alert.png" width="100" style="margin-right: 20px;float:left;"></div>
                  <div><strong>Access Denied!</strong> You do not have permission to acccess this resourse.</div>
                  <br> <a href="javascript:window.history.go(-1);" class="btn btn-info" style="margin-top: 15px;">Go Back</a> 
                </div>';
            die();
        }
        
        
    }
    public function CheckPermissionadd($userrole,$per_code)
    {
        $query = $this->db->select('*')->from('system_permission_set')->where('role_id',$userrole)->where('per_code', $per_code)->get()->row();
        if ($query->is_add==0) {
            echo '<div class="alert" style="padding: 20px;
                  background-color: #fff;
                  color: #f44336;">
                  <div><img src="http://localhost/shalika/avinda/upload/alert.png" width="100" style="margin-right: 20px;float:left;"></div>
                  <div><strong>Access Denied!</strong> You do not have permission to acccess this resourse.</div>
                  <br> <a href="javascript:window.history.go(-1);" class="btn btn-info" style="margin-top: 15px;">Go Back</a> 
                </div>';
            die();
        }
        
        
    }
    public function CheckPermissionedit($userrole,$per_code)
    {
        $query = $this->db->select('*')->from('system_permission_set')->where('role_id',$userrole)->where('per_code', $per_code)->get()->row();
        if ($query->is_edit==0) {
            echo '<div class="alert" style="padding: 20px;
                  background-color: #fff;
                  color: #f44336;">
                  <div><img src="http://localhost/shalika/avinda/upload/alert.png" width="100" style="margin-right: 20px;float:left;"></div>
                  <div><strong>Access Denied!</strong> You do not have permission to acccess this resourse.</div>
                  <br> <a href="javascript:window.history.go(-1);" class="btn btn-info" style="margin-top: 15px;">Go Back</a> 
                </div>';
            die();
        }
        
        
    }
    public function CheckPermissiondelete($userrole,$per_code)
    {
        $query = $this->db->select('*')->from('system_permission_set')->where('role_id',$userrole)->where('per_code', $per_code)->get()->row();
        if ($query->is_delete==0) {
            echo '<div class="alert" style="padding: 20px;
                  background-color: #fff;
                  color: #f44336;">
                  <div><img src="http://localhost/shalika/avinda/upload/alert.png" width="100" style="margin-right: 20px;float:left;"></div>
                  <div><strong>Access Denied!</strong> You do not have permission to acccess this resourse.</div>
                  <br> <a href="javascript:window.history.go(-1);" class="btn btn-info" style="margin-top: 15px;">Go Back</a> 
                </div>';
            die();
        }
        
        
    }
     public function editRoles($id)
    {
        $query = $this->db->select('*')->from('role')->where('role_id',$id)->get()->row();

        return $query;

    }
}
