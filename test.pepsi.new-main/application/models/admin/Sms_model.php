<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_model extends CI_Model {

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
    
    public function expensesbydate($route,$startdate, $enddate, $isExp = NULL) {
        $this->db->select('SUM(FlotAmount) AS FlotAmount');
        $this->db->from('cashflot');
        $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashflot.TransactionCode', 'INNER');
        $this->db->where('DATE(cashflot.FlotDate) <=', $enddate);
        $this->db->where('DATE(cashflot.FlotDate) >=', $startdate);
        if (isset($route) && $route != '') {
            $this->db->where_in('cashflot.Location', $route);
        }
        
        $this->db->where('transactiontypes.IsExpenses', $isExp);
        $result=$this->db->get();
        
        $list=0;
        foreach ($result->result() as $row) {
            $list += $row->FlotAmount;
        }
        return $list;
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
        $this->db->where('subdepartment.DepCode', $cat);
         $this->db->join('department', 'department.DepCode = subdepartment.DepCode', 'INNER');
        $this->db->like('CONCAT(subdepartment.SubDepCode,subdepartment.Description)', $q, 'left');
        $this->db->group_by('subdepartment.Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsubcategory($q,$cat,$cat2) {
        $this->db->select('subcategory.SubCategoryCode AS id,subcategory.Description AS text');
        $this->db->from('subcategory');
        $this->db->where('subcategory.DepCode', $cat);
        $this->db->where('subcategory.SubDepCode', $cat2);
        $this->db->like('CONCAT(subcategory.SubCategoryCode,subcategory.Description)', $q);
        $this->db->group_by('subcategory.Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }

    public function searchcustomer($q) {
        $this->db->select('customer.CusCode AS id,customer.CusName AS text');
                        $this->db->from('customer');
                        $this->db->like("CONCAT(customer.CusCode,' ',customer.CusName)", $q);
                        $this->db->where("customer.IsActive", 1);
                        $this->db->group_by('customer.CusName');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }

    public function searchvehicle($q) {
        $this->db->select('vehicledetail.RegNo AS id,vehicledetail.RegNo AS text');
                        $this->db->from('vehicledetail');
                        $this->db->like("CONCAT(vehicledetail.RegNo)", $q);
                        $this->db->group_by('vehicledetail.VehicleId');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }

    public function searchmake($q) {
        $this->db->select('make.make_id AS id,make.make AS text');
                        $this->db->from('make');
                        $this->db->like("CONCAT(make.make)", $q);
                        $this->db->group_by('make.make_id');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }

    public function jobdelivery($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            creditinvoicedetails.NetAmount,
                            creditinvoicedetails.CreditAmount,
                            creditinvoicedetails.SettledAmount,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo');
                $this->db->from('jobcardhed');
                $this->db->join('customer','jobcardhed.JCustomer = customer.CusCode');
                $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('creditinvoicedetails.Location',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('creditinvoicedetails.CusCode',$customer);
                  }
                   
              return $this->db->get()->result();
    }

    public function customercredit($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            creditinvoicedetails.NetAmount,
                            creditinvoicedetails.CreditAmount,
                            creditinvoicedetails.SettledAmount,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo');
                $this->db->from('creditinvoicedetails');
                $this->db->join('jobinvoicehed','creditinvoicedetails.InvoiceNo=jobinvoicehed.JobInvNo','left');
                $this->db->join('customer','creditinvoicedetails.CusCode = customer.CusCode');
                $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('creditinvoicedetails.Location',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('creditinvoicedetails.CusCode',$customer);
                  }
                   
              return $this->db->get()->result();
    }

    public function activecustomers($startdate, $enddate, $route = NULL,$isall,$customer,$customer_ar =null) {
        
            $this->db->select('
                            customer.CusName,customer.CusCode,
                            customer.RespectSign,
                            MobileNo,DATE(JoinDate) As JoinDate
                            ');
                $this->db->from('customer');
               
                $this->db->where('LENGTH(MobileNo)=', 10);
                $this->db->where("locate(011,MobileNo)=",0 );
                $this->db->where('customer.IsActive',1);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
               $this->db->where('DATE(customer.JoinDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(customer.JoinDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('customer.RootNo',$route);
                 }
                  if (isset($customer_ar) && $customer_ar != '' ) {
                $this->db->where_in('customer.CusCode',$customer_ar );
                  }
                  $this->db->group_by('customer.MobileNo');
                  $this->db->order_by('customer.JoinDate');
                   
              return $this->db->get()->result();
    }


}
