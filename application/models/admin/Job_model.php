<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function bincard($grnNo,$type,$remark)
    {
        $updateTimestmp = date("Y-m-d H:i:s");
        $location=$_SESSION['location'];

        $invupdate = array(
            'AppNo' => '1',
            'InvoiceNo'=>$grnNo,
            'EditType'=>$type,
            'Location'=>$location,
            'UpdateDate'=>$updateTimestmp,
            'Remark'=>$remark,
            'UpdateUser'=>$_SESSION['user_id']);

        $this->db->insert('editinvoices',$invupdate);
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
        $query = $this->db->get_where($table, $data)->row_array();
        return $query;
    }
    public function insert_data($table, $data) {
        $query = $this->db->insert($table, $data);
        return $query;
    }
    
    public function loadpricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }
    
    public function get_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $code= $row['CodeLimit'];
           $input = $row['AutoNumber'];
           $string= $row['FormCode'];
           $code_len = $row['FCLength'];
           $item_ref = $string . str_pad(($input+1), $code_len, $code, STR_PAD_LEFT);
        } 
        return $item_ref;
    }
    
    public function update_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $input = $row['AutoNumber'];
        } 
        $this->db->update('codegenerate',array('AutoNumber'=>($input+1)),array('FormName'=>($form)));
    }

    public function get_custom_max_code($form,$doc_type,$status)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $code= $row['CodeLimit'];
           $input = $row['AutoNumber'];
           $string= $row['FormCode'];
           $code_len = $row['FCLength'];
           $item_ref = str_pad(($input+1), $code_len, $code, STR_PAD_LEFT);
        } 

        if($doc_type=='Est'){

            if($status==1){
                //Insurance
                $string = 'EI';
            }elseif ($status==2) {
                //genaral
                $string = 'EG';
            }else{
                //genaral
                $string = 'EG';
            }
        }elseif($doc_type=='Inv'){
            if($status==1){
                //Insurance
                $string = 'II';
            }elseif ($status==2) {
                //genaral
                $string = 'IG';
            }else{
                //genaral
                $string = 'IG';
            }
        }elseif($doc_type=='Job'){
            if($status==1){
                //Insurance
                $string = 'JI';
            }elseif ($status==2) {
                //genaral
                $string = 'JG';
            }else{
                //genaral
                $string = 'JG';
            }
        }

        return $string.$item_ref;
    }

    public function update_data($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }

    public function loadcustomersjson($query) {
        $q = $this->db->select('CusCode AS id,CONCAT(CusName) AS text')->from('customer')->like('CONCAT(" ",customer.CusCode,customer.CusName," ",customer.MobileNo)', $query)->where('IsActive',1)->get()->result();
        return json_encode($q);
    }

    public function getCustomersDataById($cusCode) {
        $data= $this->db->select('customer.*,customeroutstanding.*,paytype.payType')->from('customer')
                        ->where('customer.CusCode', $cusCode)
                        ->join('customeroutstanding', 'customer.CusCode = customeroutstanding.CusCode')
                        ->join('paytype', 'paytype.payTypeId = customer.payMethod')
                        ->get()->row();
                        return $data;
    }

    public function getVehicleDataById($id) {
       $data= $this->db->select('*,vehicledetail.Color AS body_color')->from('vehicledetail')->where('vehicledetail.RegNo', $id)
       ->join('make', 'make.make_id = vehicledetail.Make','left')
       ->join('fuel_type', 'fuel_type.fuel_typeid = vehicledetail.FuelType','left')
       ->join('model', 'model.model_id = vehicledetail.Model','left')
       ->get()->row();
       return ($data);
    }

    public function loadvehiclesjson($query,$cuscode) {

        if($cuscode!='0' || $cuscode!=''){
            $q = $this->db->select('RegNo AS id,RegNo AS text')->from('vehicledetail')->where('IsActive',1)->where('CusCode',$cuscode)->like('RegNo', $query)->get()->result();
        }else{
            $q = $this->db->select('RegNo AS id,RegNo AS text')->from('vehicledetail')->where('IsActive',1)->like('RegNo', $query)->get()->result();
        }

        return json_encode($q);
    }

    public function loadvehiclesjsonwithoutcustomer($query) {

        if($query!='0' || $query!=''){
            $q = $this->db->select('RegNo AS id,RegNo AS text')->from('vehicledetail')->where('IsActive',1)->like('RegNo', $query)->get()->result();
        }
        return json_encode($q);
    }
    
    public function loadcustypes() {
        return $this->db->select()->from('customer_type')->get()->result();
    }

    public function loadInsuranceCompany() {
        return $this->db->select()->from('insu_company')->get()->result();
    }

    public function loadVehicleCompany() {
        return $this->db->select()->from('vehicle_company')->get()->result();
    }

    public function loadJobCondition() {
        return $this->db->select()->from('job_condition')->get()->result();
    }

    public function loadJobSection() {
        return $this->db->select()->from('job_section')->get()->result();
    }

    public function loadDescription() {
        return $this->db->select()->from('jobdescription')->get()->result();
    }

    public function loadproductjson($query,$sup,$supCode) {
        if($sup!=0){
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->where('product.Prd_Supplier', $supCode)
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')
                    ->limit(50)->get();
     
        }else{
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')
                    ->limit(50)->get();
        }

        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']." = Rs.".$row['ProductPrice']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
       
    }

    public function updateEstOrder($estNo,$supNo){
        $this->db->select('estimatedtl.*');
        $this->db->from('estimatedtl');
        $this->db->where('estimatedtl.EstimateNo', $estNo);
        $this->db->where('estimatedtl.SupplimentryNo', $supNo);
        
        $this->db->order_by('estimatedtl.EstinvoiceTimestamp','ASC');
        $this->db->order_by('estimatedtl.EstJobOrder', 'ASC');

        $result=$this->db->get();
        
        $list = array();
        $i=1;
        foreach ($result->result() as $row) {
            // EstOrderId
            $res = $this->db->update('estimatehed',array('EstLastNo' => $i),array('EstimateNo' => $estNo,'Supplimentry' => $supNo));
            $i++;
        }
        return $res;
    }

    public function getEstimateDtlbyid($estNo,$supNo) {
        $this->db->select('estimatedtl.*,jobtype.jobtype_name AS SubDescription, jobtypeheader.jobhead_name AS Description');
        $this->db->from('estimatedtl');
        $this->db->join('jobtype', 'estimatedtl.EstJobType = jobtype.jobtype_id', 'INNER');  
        $this->db->join('jobtypeheader', 'jobtypeheader.jobhead_id = jobtype.jobhead', 'INNER');
        $this->db->where('estimatedtl.EstimateNo', $estNo);
        if($supNo!=''){
            $this->db->where('estimatedtl.SupplimentryNo', $supNo); 
        }
        $this->db->order_by('jobtypeheader.jobhead_order', 'ASC');
        $this->db->order_by('estimatedtl.EstJobOrder', 'ASC');
        $this->db->order_by('estimatedtl.EstinvoiceTimestamp','ASC');
        $this->db->order_by('estimatedtl.estimatedtlid', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;

    }

    public function getInvoiceDtlbyid($invNo) {
        $this->db->select('jobinvoicedtl.*,jobtype.jobtype_name AS Description');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobtype', 'jobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER');
        $this->db->where('jobinvoicedtl.JobInvNo', $invNo);
        
        $this->db->order_by('jobinvoicedtl.JobinvoiceTimestamp','ASC');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        $this->db->order_by('jobinvoicedtl.jobinvoicedtlid','ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;

    }

    public function getTempInvoiceDtlbyid($invNo) {
        $this->db->select('tempjobinvoicedtl.*,jobtype.jobtype_name AS Description');
        $this->db->from('tempjobinvoicedtl');
        $this->db->join('jobtype', 'tempjobinvoicedtl.JobType = jobtype.jobtype_id', 'INNER');
        $this->db->where('tempjobinvoicedtl.JobInvNo', $invNo);
        
        $this->db->order_by('tempjobinvoicedtl.JobinvoiceTimestamp','ASC');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        $this->db->order_by('tempjobinvoicedtl.jobinvoicedtlid','ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;

    }
}
