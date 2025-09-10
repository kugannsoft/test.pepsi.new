<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function createcutcode() {
        $id = $this->db->select_max('CusCode')->get('customer')->row()->CusCode;
        $num = explode('CUS', $id);
        $newnum = $num[1] + 1;
        $newcode = 'CUS' . str_pad($newnum, 4, '0', STR_PAD_LEFT);
        return $newcode;
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

    public function insert_data($table, $data, $vdata,$cdata,$cInv,$Isvehicle) {
        $ccode =$this->get_max_code("Customer");
        $data['CusCode'] =  $ccode;
        $vdata['CusCode'] =  $ccode;
        $cdata['CusCode'] =  $ccode;
        $cInv['CusCode'] =  $ccode;
        
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $this->db->insert('customeroutstanding', $cdata);
        if($Isvehicle==1){
            $this->db->insert('vehicledetail', $vdata);
        }
        
        if($_POST['balanaceAmount']>0){
            $openOutCode = $this->get_max_code('Customer Open Outstanding');
            $cInv['InvoiceNo'] = $openOutCode;
            $this->db->insert('creditinvoicedetails', $cInv);
            $this->update_max_code('Customer Open Outstanding');
        }
        $this->update_max_code('Customer');
        $this->db->trans_complete();
        return $ccode;
    }

    public function update_data($table, $data, $user) {
        return $this->db->update($table, $data, array('CusCode' => $user));
    }
    public function selectmake() {
        return $this->db->select()->from('make')->get()->result();
    }
    public function selectmodel() {
        return $this->db->select()->from('model')->get()->result();
    }
    public function selectfuel() {
        return $this->db->select()->from('fuel_type')->get()->result();
    }
    public function selectcolor() {
        return $this->db->select()->from('body_color')->get()->result();
    }
    public function selecttitles() {
        return $this->db->select()->from('title')->get()->result();
    }

    public function selectlocations() {
        return $this->db->select()->from('location')->get()->result();
    }

    public function selectCustomerdata($id) {
        return $this->db->select('customer.*,customeroutstanding.OpenOustanding')->from('customer')->join('customeroutstanding','customeroutstanding.CusCode=customer.CusCode','left')->where('customer.CusCode', $id)->get()->row();
    }
    public function selectVehicledata($id) {
        return $this->db->select()->from('vehicledetail')->where('CusCode',$id)->get()->result();
    }

    public function customerType() {
        return $this->db->select()->from('customer_types')->get()->result();
    }

    public function customerAccountType() {
        return $this->db->select()->from('account_type')->get()->result();
    }

    public function getExtraChargesTypes() {
        return $this->db->select()->from('charges_type')->get()->result();
    }

    public function loadcustomersjson($query) {
        $q = $this->db->select('CusCode AS id,CusName AS text')->from('customer')->like('CusName', $query, 'after')->where('IsActive',1)->get()->result();
        return json_encode($q);
    }

    public function loadtocustomersjson($query,$cus) {
        $q = $this->db->select('CusCode AS id,CusName AS text')->from('customer')->like('CusName', $query, 'after')->where('IsActive', 1)->where('CusCode!=', $cus)->get()->result();
        return json_encode($q);
    }
    
    public function loadmodelbymake($make) {
        $q = $this->db->select('model_id,model')->from('model')->where('makeid',$make)->get()->result();
        return json_encode($q);
    }
    public function getCustomersByRouteAndSalesperson($routeID, $salespersonID) {
        return $this->db->select('CusCode, CusName')
            ->from('customer')
            ->where('IsActive', 1)
            ->where('RouteId', $routeID)
            ->where('HandelBy', $salespersonID)
            ->get()
            ->result();
    }

    public function loadpaytype($paytypeid = NULL) {
        if(isset($paytypeid)){
            return $this->db->select()->from('paytype')->where('payTypeId',$paytypeid)->get()->row();
        } else {
            return $this->db->select()->from('paytype')->get()->result();
        }
    }

//-------------supplier data----------------------------------------------------
    public function insert_supplier($data) {
        $this->db->trans_start();
        $data['SupCode'] = $this->get_max_code('Supplier');
        $date = date("Y-m-d H:i:s");

        $this->db->insert('supplier', $data);
        $this->db->insert('supplieroustanding', array('SupCode' => $data['SupCode'],'SupOustandingAmount'=>$_POST['openbalance'],'OpenOustanding'=>$_POST['openbalance'] ));
        if($_POST['openbalance']>0){
            $openOutCode = $this->get_max_code('Supplier Open Outstanding');
            $openCredit = array('AppNo' => '1', 
                                'GRNDate' => $date, 
                                'GRNNo' => $openOutCode,
                                'Location' => $_SESSION['location'], 
                                'SupCode' => $data['SupCode'], 
                                'NetAmount' => $_POST['openbalance'], 
                                'CreditAmount' => $_POST['openbalance'],
                                'SettledAmount' => 0, 
                                'IsCloseGRN' => 0, 
                                'IsCancel' => 0);
            $this->db->insert('creditgrndetails', $openCredit);
            $this->update_max_code('Supplier Open Outstanding');
        }

        $this->update_max_code('Supplier');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_supplier($supplier) {
        return $this->db->select()->from('supplier')->where('SupCode', $supplier)->get()->row();
    }

    public function update_supplier($data, $supplier) {
        return $this->db->update('supplier', $data, array('SupCode' => $supplier));
    }
    
     //-------------sale person data----------------------------------------------------
    public function insert_saleperson($data) {
        $this->db->trans_start();
        $data['RepID'] = $this->get_max_code('salespersons');
        $this->db->insert('salespersons', $data);
        $this->update_max_code('salespersons');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_saleperson($supplier) {
        return $this->db->select()->from('salespersons')->where('RepID', $supplier)->get()->row();
    }

    public function update_saleperson($data, $supplier) {
        return $this->db->update('salespersons', $data, array('RepID' => $supplier));
    }

    public function selectSupplierdata($id) {
        return $this->db->select()->from('supplier')->where('SupCode', $id)->get()->row();
    }

    public function getActiveCustomers($keyword, $cusType, $item_type)
    {
        if ($item_type == 2){
            $sql = $this->db->query("SELECT * FROM customer C "
                . "INNER JOIN customeroutstanding CO ON C.CusCode=CO.CusCode "
                . "INNER JOIN customer_types CT ON CT.CusTypeId=C.CusType WHERE CONCAT(' ',C.CusName,C.CusNic) LIKE '%" . $keyword . "%'   AND CT.CusTypeId='$cusType' AND C.IsActive=1 AND C.cusPayType=2 ORDER BY C.CusName");

            $result = $sql->result();

            return $result;
        }elseif ($item_type == 0){
            $sql = "SELECT * FROM customer C "
                . "INNER JOIN customeroutstanding CO ON C.CusCode=CO.CusCode "
                . "INNER JOIN customer_types CT ON CT.CusTypeId=C.CusType WHERE CONCAT(' ',C.CusName,C.CusNic) LIKE '%" . $keyword . "%'   AND CT.CusTypeId='$cusType' AND C.IsActive=1 ORDER BY C.CusName";

            $result = mysqli_query($this->db, $sql);

            return $result;
        }
        else{
            $sql = $this->db->query("SELECT * FROM customer C "
                . "INNER JOIN customeroutstanding CO ON C.CusCode=CO.CusCode "
                . "INNER JOIN customer_types CT ON CT.CusTypeId=C.CusType WHERE CONCAT(' ',C.CusName,C.CusNic) LIKE '%" . $keyword . "%'   AND CT.CusTypeId='$cusType' AND C.IsActive=1 AND C.cusPayType=1 ORDER BY C.CusName");

            $result = $sql->result();

            return $result;
        }
    }

    public function loadAccountCustomersJson($query,$cusType) {
        $q = $this->db->select('CusCode AS id,CONCAT(CusName) AS text')
            ->from('customer')->like('CONCAT(" ",customer.CusCode,customer.CusName," ",customer.MobileNo)', $query)
            ->where('IsActive',1)
            ->where('CusType_easy',$cusType)
            ->where('IsEasy',1)
            ->get()->result();
        return json_encode($q);
    }

    public function getMaxAccIdByType($codeType) {

        $sql1 = $this->db->query("SELECT * FROM code_genarate WHERE RefType='$codeType'");
        $result1 = $sql1->row();

        $total_len = $result1->TotalLength;
        $string = $result1->String;
        $string_len = $result1->StringLength;
        $code = $result1->Code;
        $code_len = $total_len - $string_len;

        $sql = $this->db->query("SELECT MAX(AccId) AS AccId FROM account_details");
        $result =  $sql->row();
            $prdRef = $result->AccId;

            if (!isset($prdRef)) {
                $input = intval(substr(1, $string_len, $code_len));
            } else {
                $input = intval(substr($prdRef, $string_len, $code_len)) + 1;
            }

        $item_ref = $string . str_pad($input, $code_len, $code, STR_PAD_LEFT);
        return $item_ref;
    }

    public function getMaxAccId() {

        $sql = $this->db->query("SELECT MAX(AccId) AS AccId FROM account_details");

        $result = $sql->row()->AccId;
        return $result;
    }

    public function getRoutesByCusCode($cusCode) {
        // $this->db->select('e.route_id'); 
        // $this->db->from('customer c');
        // $this->db->join('employeeroutes e', 'e.emp_id = c.HandelBy'); 
        // $this->db->where('c.CusCode', $cusCode);
        
        $this->db->select('c.RouteID, cr.name AS route_name');
        $this->db->from('customer c');
        
        $this->db->join('customer_routes cr', 'cr.id = c.RouteID');
        $this->db->where('c.CusCode', $cusCode);
        $query = $this->db->get(); 
        return $query->result();
    }
}
