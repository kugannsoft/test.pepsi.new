<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_model extends CI_Model {

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

    public function get_products($table, $q) {
        $this->db->select('*');
        $this->db->like('Prd_Description', $q);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
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
    
    public function loadInvoiceData($invNo) {
        return $this->db->select('invoicedtl.*,productcondition.*')->from('product')
                        ->where('product.ProductCode', $product)
                        ->join('productcondition', 'productcondition.ProductCode = product.ProductCode')
                        ->get()->row();
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
        return $this->db->select()->from('PriceLevel')->where('IsActive', 1)->get()->result();
    }
    public function stockUpdate($proCode,$invQty,$prLevel,$unitCost,$unitPrice,$location,$serialNo,$freeQty,$returnQty,$isReturn) {
          //update price stock
            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$proCode','$invQty','$prLevel','$unitCost','$unitPrice','$location','$serialNo','$freeQty','$returnQty','$isReturn')");
          
        
    }
    
    public function saveInvoiceDtl($invHed,$invDtl,$invPay1,$post,$invPay3,$invNo){
        $product_codeArr = json_decode($_POST['product_code']);
        $unitArr = json_decode($_POST['unit']);
        $freeQtyArr = json_decode($_POST['freeQty']);
        $refArr = json_decode($_POST['ref']);
        $serial_noArr = json_decode($_POST['serial_no']);
        $qtyArr = json_decode($_POST['qty']);
        $sell_priceArr = json_decode($_POST['sell_price']);
        $cost_priceArr = json_decode($_POST['cost_price']);
        $pro_discountArr= json_decode($_POST['pro_discount']);
        $total_netArr= json_decode($_POST['total_net']);
        $price_levelArr= json_decode($_POST['price_level']);
        $totalNetWODisArr= json_decode($_POST['totalNetWODis']);
        $warrantyArr =json_decode($_POST['warranty']);
        $upcArr =json_decode($_POST['unitPC']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $location = $post['location'];
        $action = $post['action'];
        
        // var_dump($post);die;
        $this->db->trans_start();
        $cashAmount = $_POST['cash_amount'];
        $cardAmount = $_POST['card_amount'];
        $creditAmount = $_POST['credit_amount'];
        $chequeAmount= $_POST['cheque_amount'];

        $cashAmount = $_POST['final_amount']-$creditAmount-$cardAmount-$chequeAmount;

        if($action==1){
            // insert invoice hed
        $this->db->insert('invoicehed', $invHed);
        // insert invoice dtl
        for ($i = 0; $i < count($product_codeArr); $i++) {
            
            if($totalNetWODisArr[$i]!=0){
               $proDisPrent = (100*$pro_discountArr[$i])/$totalNetWODisArr[$i];
            }else{
                $proDisPrent =0;
            }
            $invDtl = array(
                'AppNo' => '1',
                'InvNo'=>$invHed['InvNo'],
                'InvLocation'=>$_POST['location'],
                'InvDate'=>$invHed['InvDate'],
                'InvLineNo'=>$i,
                'InvProductCode'=>$product_codeArr[$i],
                'InvSerialNo'=>$serial_noArr[$i],
                'InvCaseOrUnit'=>$unitArr[$i],
                'InvUnitPerCase'=>$upcArr[$i],
                'InvQty'=>$qtyArr[$i],
                'InvFreeQty'=>$freeQtyArr[$i],
                'InvReturnQty'=>0,
                'InvPriceLevel'=>$price_levelArr[$i],
                'InvUnitPrice'=>$sell_priceArr[$i],
                'InvCostPrice'=>$cost_priceArr[$i],
                'InvDisValue'=>$pro_discountArr[$i],
                'InvDisPercentage'=>$proDisPrent,
                'InvTotalAmount'=>$totalNetWODisArr[$i],
                'InvNetAmount'=>$total_netArr[$i],
                'InvVatAmount'=>$proVatArr[$i],
                'InvNbtAmount'=>$proNbtArr[$i],
                'InvIsVat'=>$isVatArr[$i],
                'InvIsNbt'=>$isNbtArr[$i],
                'InvNbtRatio'=>$nbtRatioArr[$i],
                'IsReturn'=>0,
                'SalesPerson'=>$refArr[$i],
                'WarrantyMonth'=>$warrantyArr[$i],
                'SellingPriceORG'=>$sell_priceArr[$i]
                );

                $this->db->insert('invoicedtl', $invDtl);
                
                //update stock
                $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','$serial_noArr[$i]','$freeQtyArr[$i]','0','0')");

            }
        }elseif ($action==2) {
            // update invoice hed
            $this->db->update('invoicehed', $invHed,array('InvNo' => $invHed['InvNo']));

            $this->db->where('InvNo', $invHed['InvNo']);
            $this->db->delete('invoicedtl');
            // insert invoice dtl
            for ($i = 0; $i < count($product_codeArr); $i++) {
                
                if($totalNetWODisArr[$i]!=0){
                   $proDisPrent = (100*$pro_discountArr[$i])/$totalNetWODisArr[$i];
                }else{
                    $proDisPrent =0;
                }
                $invDtl = array(
                    'AppNo' => '1',
                    'InvNo'=>$invHed['InvNo'],
                    'InvLocation'=>$_POST['location'],
                    'InvDate'=>$invHed['InvDate'],
                    'InvLineNo'=>$i,
                    'InvProductCode'=>$product_codeArr[$i],
                    'InvSerialNo'=>$serial_noArr[$i],
                    'InvCaseOrUnit'=>$unitArr[$i],
                    'InvUnitPerCase'=>$upcArr[$i],
                    'InvQty'=>$qtyArr[$i],
                    'InvFreeQty'=>$freeQtyArr[$i],
                    'InvReturnQty'=>0,
                    'InvPriceLevel'=>$price_levelArr[$i],
                    'InvUnitPrice'=>$sell_priceArr[$i],
                    'InvCostPrice'=>$cost_priceArr[$i],
                    'InvDisValue'=>$pro_discountArr[$i],
                    'InvDisPercentage'=>$proDisPrent,
                    'InvTotalAmount'=>$totalNetWODisArr[$i],
                    'InvNetAmount'=>$total_netArr[$i],
                    'InvVatAmount'=>$proVatArr[$i],
                    'InvNbtAmount'=>$proNbtArr[$i],
                    'InvIsVat'=>$isVatArr[$i],
                    'InvIsNbt'=>$isNbtArr[$i],
                    'InvNbtRatio'=>$nbtRatioArr[$i],
                    'IsReturn'=>0,
                    'SalesPerson'=>$refArr[$i],
                    'WarrantyMonth'=>$warrantyArr[$i],
                    'SellingPriceORG'=>$sell_priceArr[$i]);
                    $this->db->insert('invoicedtl', $invDtl);
                    
                    //update stock
                    $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','$serial_noArr[$i]','$freeQtyArr[$i]','0','0')");

                }
        }
        

        // insert invoice payment
        if($cashAmount>0){
             $this->db->insert('invoicepaydtl', $invPay1);
         }
         
         if($cardAmount>0){
            $cardpaymentNo = $this->Pos_model->get_max_code('Customer Payment');
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);

             for ($k = 0; $k < count($ccNameArr); $k++) {
             $invPay2 = array(
            'AppNo' => '1',
            'InvNo'=>$invNo,
            'InvDate'=>$invHed['InvDate'],
            'InvPayType'=>'Card',
            'Mode'=>$ccNameArr[$k],
            'Reference'=>$ccRefArr[$k],
            'InvPayAmount'=>$ccAmountArr[$k],
            'PayRemark'=>'Part invoice card payment',
            'ReceiptNo'=>$cardpaymentNo);
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay2);
             }
             $this->Pos_model->update_max_code('Customer Payment');
         }

         if($chequeAmount>0){
            $chequepaymentNo = $this->Pos_model->get_max_code('Customer Payment');
            $chequeNo = $_POST['chequeNo'];
            $chequeReference = $_POST['chequeReference'];
            $chequeRecivedDate = $_POST['chequeRecivedDate'];
            $chequeDate = $_POST['chequeDate'];
            $bank = $_POST['bank'];

             $invCheque = array(
            'AppNo' => '1',
            'ReceivedDate'=>$chequeRecivedDate,
            'CusCode'=>$invHed['InvCustomer'],
            'ChequeOwner'=>$chequeReference,
            'ReferenceNo'=>$invNo,
            'BankNo'=>$bank,
            'ChequeNo'=>$chequeNo,
            'ChequeDate'=>$chequeDate,
            'ChequeAmount'=>$chequeAmount,
            'Mode'=>'Pos Invoice',
            'IsCancel'=>0,
            'IsRelease'=>0);

             
             //add cheque data
            $r8= $this->db->insert('chequedetails',$invCheque);

             $invPay4= array(
            'AppNo' => '1',
            'InvNo'=>$invNo,
            'InvDate'=>$invHed['InvDate'],
            'InvPayType'=>'Cheque',
            'Mode'=>'',
            'Reference'=>'',
            'InvPayAmount'=>$chequeAmount,
            'InvCusCode'=>$_POST['cusCode'],
            'PayRemark'=>'Part invoice cheque payment',
            'ReceiptNo'=>$chequepaymentNo);
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay4);
             $this->Pos_model->update_max_code('Customer Payment');
             
         }
         
         if($creditAmount>0){
             $invPay3 = array(
            'AppNo' => '1',
            'InvNo'=>$invNo,
            'InvDate'=>$invHed['InvDate'],
            'InvPayType'=>'Credit',
            'InvPayAmount'=>$creditAmount,
            'InvCusCode'=>$_POST['cusCode']);
             
             $invCredit = array(
            'AppNo' => '1',
            'InvoiceNo'=>$invNo,
            'InvoiceDate'=>$invHed['InvDate'],
            'Location'=>$invHed['InvLocation'],
            'CusCode'=>$invHed['InvCustomer'],
            'NetAmount'=>$invHed['InvNetAmount'],
            'CreditAmount'=>$creditAmount,
            'SettledAmount'=>0,
            'IsCloseInvoice'=>0,
            'IsCancel'=>0);
             
             $cusCode = $invHed['InvCustomer'];
             $invnetAmount = $invHed['InvNetAmount'];
             
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay3);
             //add credit invoice data
             $this->Pos_model->insert_data('creditinvoicedetails',$invCredit);
             //update customer outsatnding
             $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$cusCode','$invnetAmount','$creditAmount')");

         }
        //update code gen
         $this->update_max_code('Point Of Sales'.$location);
       $this->db->trans_complete();
       return $this->db->trans_status();
        
    }

}
