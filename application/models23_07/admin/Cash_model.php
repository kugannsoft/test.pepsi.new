<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_model extends CI_Model {

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

    public function update_data($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }
    
    public function saveEndFloat($float,$BalanceDate,$datetime,$mode,$loc,$id,$invUser) {
        $this->db->trans_start();
        $this->db->query("CAll SPT_SAVE_CASIHER_BALANCE('1','$float','$BalanceDate','$datetime','$mode','$loc','$id','$invUser')");
        $this->db->trans_complete();
        return $this->db->trans_status();
        
    }
    
    public function saveCashFloat($table,$float) {
        $this->db->trans_start();
        $this->db->insert($table,$float);
        $this->db->trans_complete();
        return $this->db->trans_status();
        
    }
    
    public function getActiveInvoies($table, $q,$location) {
        $this->db->select('InvNo');
        $this->db->like('InvNo', $q)->where('InvIsCancel', 0)->where('InvLocation', $location)->order_by('InvNo', 'DESC');
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['InvNo']));
                $new_row['value'] = htmlentities(stripslashes($row['InvNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadInvoiceById($inv) {
        return $this->db->select('invoicedtl.*,product.Prd_Description,invoicehed.InvAmount ,invoicehed.InvNetAmount AS totalNet, invoicehed.InvDisAmount,invoicehed.InvCustomer,users.first_name,invoicehed.InvCashAmount,invoicehed.InvCreditAmount,')->from('invoicedtl')
                        ->where('invoicedtl.InvNo', $inv)
                        ->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo')
                        ->join('product', 'product.ProductCode = invoicedtl.InvProductCode')
                        ->join('users', 'invoicehed.InvUser = users.id')
                        ->get()->result();
    }
    
    public function loadInvoiceData($invNo) {
        return $this->db->select('invoicedtl.*,productcondition.*')->from('product')
                        ->where('product.ProductCode', $product)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->get()->row();
    }

    public function cancelInvoice($invCanel) {
        $this->db->trans_start();
        $this->db->insert('cancelinvoice', $invCanel);
        
        $query = $this->db->get_where('invoicedtl',array('InvNo'=>$invCanel['InvoiceNo']));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
            //update serial stock
            $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode'=> $row['InvProductCode'],'SerialNo'=>$row['InvSerialNo'],'Location'=>$row['InvLocation']))->get();
            if($ps->num_rows()>0){
                $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode'=> $row['InvProductCode'],'InvSerialNo'=>$row['InvSerialNo'],'InvLocation'=>$row['InvLocation']))->get();
                if($isPro->num_rows()==0){
                    $this->db->update('productserialstock',array('Quantity'=>1),array('ProductCode'=> $row['InvProductCode'],'SerialNo'=>$row['InvSerialNo']));
                }
            }else{
                
            }
            $proCode = $row['InvProductCode'];
            $totalGrnQty = $row['InvQty']+$row['InvFreeQty'];
            $loc = $row['InvLocation'];
            $pl = $row['InvPriceLevel'];
            $costp=$row['InvCostPrice'];
            $selp=$row['InvUnitPrice'];
            
            //update price stock
            $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");
            
             //update product stock
            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')");
            }
        }
        
        //update/ cancel credit invoice
        $query2 = $this->db->get_where('creditinvoicedetails',array('InvoiceNo'=>$invCanel['InvoiceNo'],'Location'=>$loc));
        if ($query2->num_rows() > 0) {
            $this->db->update('creditinvoicedetails',array('IsCancel'=>1),array('InvoiceNo'=>$invCanel['InvoiceNo'],'Location'=>$invCanel['Location']));
        }
        
        $this->db->update('invoicehed',array('InvIsCancel'=>1),array('InvNo'=>$invCanel['InvoiceNo'],'InvLocation'=>$invCanel['Location']));
        $this->update_max_code('CancelInvoice');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }
    
    public function loadcustomersjson($query) {
     
        $query1 =$this->db->select('CusCode,CusName')->like("CONCAT(' ',customer.CusCode,customer.CusName,customer.MobileNo)", $query ,'left')->limit(50)->get('customer');
       
        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['CusName']));
                $new_row['value'] = htmlentities(stripslashes($row['CusCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }
    
    public function getCustomersDataById($cusCode) {
        return $this->db->select('customer.*,customeroutstanding.*')->from('customer')
                        ->where('customer.CusCode', $cusCode)
                        ->join('customeroutstanding', 'customer.CusCode = customeroutstanding.CusCode')
                        ->get()->row();
    }
    
    public function getCustomersCreditDataById($cusCode) {
        return $this->db->select('*')->from('creditinvoicedetails')
                        ->where('creditinvoicedetails.CusCode', $cusCode)
                ->where('creditinvoicedetails.IsCloseInvoice', 0)
                         ->get()->result();
    }
    
    public function getActiveInvoiesByCustomer($table, $q,$location,$cus) {
       
                if($cus!='' || $cus!=0){
                 $this->db->select('InvNo,DATE(InvDate) ,InvNetAmount');
                    $this->db->like('InvNo', $q)->where('InvIsCancel', 0)->where('InvLocation', $location)->where('InvCustomer', $cus);
                }else{
                     $this->db->select('InvNo,DATE(InvDate) ,InvNetAmount');
                    $this->db->like('InvNo', $q)->where('InvIsCancel', 0)->where('InvLocation', $location);
                }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['InvNo']." | ".$row['DATE(InvDate)']." | ".$row['InvNetAmount']));
                $new_row['value'] = htmlentities(stripslashes($row['InvNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }
    
    
    public function loadproductjson($query,$sup,$inv,$pl) {
        if($sup==1 && ($inv=='' || $inv==0)){
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice,product.Prd_UPC AS InvQty')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')
                    ->limit(50)->get();
     
        }elseif($sup==0 && ($inv!='' || $inv!=0)){
//            
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,invoicedtl.InvQty,invoicedtl.InvUnitPrice as ProductPrice')
                    ->from('invoicedtl')
                    ->join('product', 'invoicedtl.InvProductCode = product.ProductCode', 'INNER')
                    ->where('invoicedtl.InvNo', $inv)
                    ->where('invoicedtl.InvPriceLevel', $pl)
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')
                    ->limit(50)->get();
        }
//        
        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']." = Rs.".$row['ProductPrice']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                 if($sup==1 && ($inv=='' || $inv==0)){
                $new_row['qty'] = htmlentities(stripslashes('All'));
                 }elseif($sup==0 && ($inv!='' || $inv!=0)){
                     $new_row['qty'] = htmlentities(stripslashes($row['InvQty']));
                 }
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }
    
    public function saveReturn($grnHed,$post,$grnNo,$totalDisPrecent,$grnCredit) {        
        $product_codeArr = json_decode($post['product_code']);
//        $unitArr = json_decode($post['unit_type']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
//        $pro_discountArr = json_decode($post['pro_discount']);
//        $pro_discount_precentArr = json_decode($post['discount_precent']);
//        $caseCostArr = json_decode($post['case_cost']);
//        $upcArr = json_decode($post['upc']);
        $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $location = $post['location'];
//        $this->db->trans_begin();
        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            $grnDtl = array(
                'AppNo' => '1',
                'ReturnNo' => $grnNo,
                'ReturnDate' => $post['invDate'],
                'ProductCode' => $product_codeArr[$i],
                'ReturnQty' => $qtyArr[$i],
                'CostPrice' => $cost_priceArr[$i],
                'SalesPersonID' => '0',
                'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                'ReturnAmount' => $totalAmountArr[$i],
                'SerialNo' => $serial_noArr[$i]);
            $this->db->insert('returninvoicedtl', $grnDtl);
            
            //update serial stock
            $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode'=> $product_codeArr[$i],'SerialNo'=>$serial_noArr[$i],'Location'=>$location))->get();
            if($ps->num_rows()>0){
//                $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode'=> $product_codeArr[$i],'InvSerialNo'=>$serial_noArr[$i],'InvLocation'=>$location))->get();
//                if($isPro->num_rows()==0){
                    $this->db->update('productserialstock',array('Quantity'=>$qtyArr[$i]),array('ProductCode'=> $product_codeArr[$i],'SerialNo'=>$serial_noArr[$i],'Location'=> $location));
//                }
            }else{
                if($isSerialArr[$i]==1){
                    $this->db->insert('productserialstock', array('ProductCode'=> $product_codeArr[$i],'Location'=> $location,'SerialNo'=>$serial_noArr[$i],'Quantity'=>$qtyArr[$i],'GrnNo'=>$grnNo));
                }
            }
        
            //update product price
//            $pp = $this->db->select('ProductCode')->from('productprice')->where(array('ProductCode'=> $product_codeArr[$i],'PL_No'=>$price_levelArr[$i]))->get();
//            if($pp->num_rows()>0){
//                $this->db->update('productprice',array('ProductPrice'=>$sell_priceArr[$i]),array('ProductCode'=> $product_codeArr[$i],'PL_No'=>$price_levelArr[$i]));
//            }else{
//                $this->db->insert('productprice', array('ProductCode'=> $product_codeArr[$i],'PL_No'=> $price_levelArr[$i],'ProductPrice'=>$sell_priceArr[$i]));
//            }
            
            //update product cost
//            $isUpdate=0;
//            $isCostUpdate = $this->db->select('Value')->from('systemoptions')->where('ID', 'M001')->get();// get system option
//            foreach ($isCostUpdate->result_array() as $row) {
//                $isUpdate = $row['Value'];
//            } 
//            
//            if($isUpdate==1){
//                if($totalDisPrecent>0){
//                    $cost = $qtyPrice - ($qtyPrice*$totalDisPrecent/100);// - by total grn discount precnt
//                    $this->db->update('product',array('Prd_CostPrice'=>$cost),array('ProductCode'=> $product_codeArr[$i]));
//                }else{
//                    $this->db->update('product',array('Prd_CostPrice'=>$qtyPrice),array('ProductCode'=> $product_codeArr[$i]));
//                }
//            }
            
            //update price stock
            $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$totalGrnQty','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location')");
            
             //update product stock
            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr[$i]','$totalGrnQty',0,'$location')");
        }
        
        $supCode = $post['cuscode'];
        $totalNet = $post['total_net_amount'];
        //update supplier outstanding
        if($supCode!=''){
                        $isSup = $this->db->select('CusCode')->from('customeroutstanding')->where('CusCode',$supCode)->get();
        if($isSup->num_rows()>0){
            $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$supCode','$totalNet','$totalNet')");
        }else{
            //$this->db->insert('supplieroustanding', array('SupCode'=> $supCode,'SupTotalInvAmount'=> $totalNet,'SupOustandingAmount'=>$totalNet,'SupSettlementAmount'=>0,'OpenOustanding'=>0,'OustandingDueAmount'=>0));
        }
        }
        
//        if($post['cuscode']!=''){
//        $this->db->insert('returnnoninvoicessettle', $grnCredit);
//        }
        $this->db->insert('returninvoicehed', $grnHed);
        $this->update_max_code('Invoice Return');

        $this->db->trans_complete();
       return $this->db->trans_status();
    }
}
