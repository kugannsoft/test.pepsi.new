<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesinvoice_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

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

    public function loadsupplierjson($query) {
        $q = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->like('SupName', $query, 'after')->get()->result();
        return json_encode($q);
    }

    public function loadproductjson($query,$sup,$supCode) {
        if($sup!=0){
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->where('product.Prd_Supplier', $supCode)
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description,product.BarCode)", $query ,'left')
                    ->limit(50)->get();
        }else{
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description,product.BarCode)", $query ,'left')
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

    public function loadproductjsonbygrn($query,$sup,$supCode,$grn) {
        if($grn!='0'){
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('goodsreceivenotedtl')
                    ->join('product', 'product.ProductCode = goodsreceivenotedtl.GRN_Product', 'INNER')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->where('goodsreceivenotedtl.GRN_No', $grn)
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description,product.BarCode)", $query ,'left')
                    ->limit(50)->get();
        }else{
            $query1 =$this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice')
                    ->from('product')
                    ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                    ->where('product.Prd_Supplier', $supCode)
                    ->like("CONCAT(' ',product.ProductCode,product.Prd_Description,product.BarCode)", $query ,'left')
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
    
    public function loadpricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }
    public function loadlocations() {
        return $this->db->select()->from('location')->get()->result();
    }
    
    public function saveSalesInvoice($grnHed,$post,$grnNo,$totalDisPrecent) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $orgSell_priceArr = json_decode($post['org_unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
        $pro_discountArr = json_decode($post['pro_discount']);
        $pro_discount_precentArr = json_decode($post['discount_precent']);
        $caseCostArr = json_decode($post['case_cost']);
        $upcArr = json_decode($post['upc']);
        $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $proNameArr = json_decode($_POST['proName']);
        $salesPersonArr = json_decode($_POST['salePerson']);
        $location = $post['location'];
        $isRawMat =0;
        $totalCost = 0;

        $this->db->trans_start();

        //
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];

            $totalCost += ($qtyArr[$i]*$cost_priceArr[$i]);

            //get warranty period
            $WarrantyMonth = $this->db->select('WarrantyPeriod')->from('productcondition')->where('ProductCode',$product_codeArr[$i])->get()->row()->WarrantyPeriod;

            //insert sales invoice details
            $grnDtl = array(
                    'AppNo' => '1',
                    'SalesInvNo' => $grnNo,
                    'SalesInvLineNo' => $i,
                    'SalesInvLocation' => $location,
                    'SalesInvDate'=> $grnHed['SalesDate'],
                    'SalesProductCode' => $product_codeArr[$i],
                    'SalesUnitPerCase' => $upcArr[$i],
                    'SalesCaseOrUnit' => $unitArr[$i],
                    'SalesSerialNo' => $serial_noArr[$i],
                    'SalesProductName' => $proNameArr[$i],
                    'SalesQty' => $qtyArr[$i],
                    'SalesPriceLevel' => $price_levelArr[$i],
                    'SalesFreeQty' => $freeQtyArr[$i],
                    'SalesCostPrice' => $cost_priceArr[$i],
                    'SalesUnitPrice' => $sell_priceArr[$i],
                    'SalesDisValue' => $pro_discountArr[$i],
                    'SalesDisPercentage' => $pro_discount_precentArr[$i],
                    'SalesIsVat' => $isVatArr[$i],
                    'SalesIsNbt' => $isNbtArr[$i],
                    'SalesNbtRatio' => $nbtRatioArr[$i],
                    'SalesVatAmount' => $proVatArr[$i],
                    'SalesNbtAmount' => $proNbtArr[$i],
                    'SalesTotalAmount' => $totalAmountArr[$i],
                    'SalesInvNetAmount' => $total_netArr[$i],
                    'SalesPerson' => $salesPersonArr[$i],
                    'WarrantyMonth'=>$WarrantyMonth,
                    'SellingPriceORG'=>$orgSell_priceArr[$i]
                );
            $this->db->insert('salesinvoicedtl', $grnDtl);
            $sellPrice =0;

            if($sell_priceArr[$i]==0){
                $sellPrice=$orgSell_priceArr[$i];
            }else{
                $sellPrice=$sell_priceArr[$i];
            }
            //update stock
             $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sellPrice','$location','$serial_noArr[$i]','$freeQtyArr[$i]','0','0')");

            //update serial stock
            if($serial_noArr[$i]!=''){
                 $this->db->update('productserialstock',array('Quantity'=>0),array('ProductCode'=> $product_codeArr[$i],'Location'=> $location,'SerialNo'=> $serial_noArr[$i]));
            }
        }
        
        $cashAmount = $_POST['cashAmount'];
        $creditAmount = $_POST['creditAmount'];
        $cardAmount = $_POST['cardAmount'];
        $chequeAmount = $_POST['chequeAmount'];
        $advanceAmount = $_POST['advance_amount'];  
        $advancePayNo = $_POST['advance_pay_no'];   
        $total_net_amount = $_POST['total_net_amount'];
        $returnAmount = $_POST['return_amount'];
        $returnPayNo = $_POST['return_payment_no'];
        $bankAmount = $_POST['bank_amount'];
        $bank_account = $_POST['bankacc'];
        $cusCode = $grnHed['SalesCustomer'];

        $cashAmount=$total_net_amount-$creditAmount-$cardAmount-$chequeAmount-$advanceAmount-$returnAmount-$bankAmount;

        $cashPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Cash',
            'Mode'=>$grnNo,
            'Reference'=>$grnNo,
            'SalesInvPayAmount'=>$cashAmount);

        // insert invoice payment
        if($cashAmount>0){
             $this->db->insert('salesinvoicepaydtl', $cashPay);
         }
         
         $advancePay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Advance',
            'Mode'=>$grnNo,
            'Reference'=>$advancePayNo,
            'SalesInvPayAmount'=>$advanceAmount,
            'ReceiptNo'=>$advancePayNo);

        // insert invoice payment
        if($advanceAmount>0){
             $this->db->insert('salesinvoicepaydtl', $advancePay);

             //release advance payment
             $this->db->update('customerpaymentdtl',array('IsRelease'=>1),array('CusPayNo'=>$advancePayNo));

         }

          $returnPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Return',
            'Mode'=>$grnNo,
            'Reference'=>$returnPayNo,
            'SalesInvPayAmount'=>$returnAmount,
            'ReceiptNo'=>$returnPayNo);

        // insert invoice payment
        if($returnAmount>0){
             $this->db->insert('salesinvoicepaydtl', $returnPay);

             //release advance payment
             $this->db->update('returninvoicehed',array('IsComplete'=>1),array('ReturnNo'=>$returnPayNo));

              $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$cusCode','$returnAmount','$returnAmount')");

         }

         if($cardAmount>0){
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);
        $cardpaymentNo = $this->get_max_code('Customer Payment');

             for ($k = 0; $k < count($ccNameArr); $k++) {
             $cardPay = array(
                'AppNo' => '1',
                'SalesInvNo'=>$grnNo,
                'SalesInvDate'=>$grnHed['SalesOrgDate'],
                'SalesInvPayType'=>'Card',
                'Mode'=>$ccNameArr[$k],
                'Reference'=>$ccRefArr[$k],
                'SalesInvPayAmount'=>$ccAmountArr[$k],
                'ReceiptNo'=>$cardpaymentNo);
                     
             $this->db->insert('salesinvoicepaydtl',$cardPay);
             }
              $this->update_max_code('Customer Payment');
         }

         if($bankAmount>0){
            $bankpaymentNo = $this->get_max_code('Customer Payment');

             
             $bankPay = array(
                'AppNo' => '1',
                'SalesInvNo'=>$grnNo,
                'SalesInvDate'=>$grnHed['SalesOrgDate'],
                'SalesInvPayType'=>'Bank',
                'Mode'=>$bank_account,
                'Reference'=>$bankpaymentNo,
                'SalesInvPayAmount'=>$bankAmount,
                'ReceiptNo'=>$bankpaymentNo);
                     
             $this->db->insert('salesinvoicepaydtl',$bankPay);
             $this->update_max_code('Customer Payment');
         }

        

        // insert cheque data
        if($chequeAmount>0){
            $chequepaymentNo = $this->get_max_code('Customer Payment');
        $chequePay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Cheque',
            'Mode'=>$grnNo,
            'Reference'=>$_POST['chequeReference'],
            'SalesInvPayAmount'=>$chequeAmount,'ReceiptNo'=>$chequepaymentNo);

            $chequeNo = $_POST['chequeNo'];
            $chequeReference = $_POST['chequeReference'];
            $chequeRecivedDate = $_POST['chequeRecivedDate'];
            $chequeDate = $_POST['chequeDate'];
            $bank = $_POST['bank'];

             $invCheque = array(
            'AppNo' => '1',
            'ReceivedDate'=>$chequeRecivedDate,
            'CusCode'=>$grnHed['SalesCustomer'],
            'ChequeOwner'=>$chequeReference,
            'ReferenceNo'=>$grnNo,
            'BankNo'=>$bank,
            'ChequeNo'=>$chequeNo,
            'ChequeDate'=>$chequeDate,
            'ChequeAmount'=>$chequeAmount,
            'Mode'=>'Sales Invoice',
            'IsCancel'=>0,
            'IsRelease'=>0);

             $this->db->insert('salesinvoicepaydtl', $chequePay);
             //add cheque data
            $r8= $this->db->insert('chequedetails',$invCheque);
            $this->update_max_code('Customer Payment');
         }

         if($creditAmount>0){
             $creditPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Credit',
            'SalesInvPayAmount'=>$creditAmount);
             
             $invCredit = array(
            'AppNo' => '1',
            'InvoiceNo'=>$grnNo,
            'Type'=>1,
            'InvoiceDate'=>$grnHed['SalesOrgDate'],
            'Location'=>$location,
            'CusCode'=>$grnHed['SalesCustomer'],
            'NetAmount'=>$grnHed['SalesNetAmount'],
            'CreditAmount'=>$creditAmount,
            'SettledAmount'=>0,
            'IsCloseInvoice'=>0,
            'IsCancel'=>0);
             
             $cusCode = $grnHed['SalesCustomer'];
             $invnetAmount = $grnHed['SalesNetAmount'];
             
                     
             $this->db->insert('salesinvoicepaydtl',$creditPay);
             //add credit invoice data
             $this->db->insert('creditinvoicedetails',$invCredit);
             //update customer outsatnding
             $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$cusCode','$invnetAmount','$creditAmount')");

         }
        
        $grnHed['SalesCostAmount'] = $totalCost;
        $this->bincard($grnNo,1,'Created');//update bincard
        $this->db->insert('salesinvoicehed', $grnHed);
        $creditAmount = $_POST['creditAmount'];
        if($creditAmount>0){
            $SalesInvType=3;
        }else{
            $SalesInvType=$_POST['invType'];
        }

        if($SalesInvType==1){
           $this->update_max_code('SalesInvoiceNo'.$location);
        }elseif ($SalesInvType==2) {
           $this->update_max_code('TaxInvoiceNo'.$location);
        }elseif ($SalesInvType==3) {
           $this->update_max_code('CreditInvoiceNo'.$location);
        }

        
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function updateSalesInvoice($grnHed,$post,$grnNo,$totalDisPrecent) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $orgSell_priceArr = json_decode($post['org_unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
        $pro_discountArr = json_decode($post['pro_discount']);
        $pro_discount_precentArr = json_decode($post['discount_precent']);
        $caseCostArr = json_decode($post['case_cost']);
        $upcArr = json_decode($post['upc']);
        $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $proNameArr = json_decode($_POST['proName']);
        $salesPersonArr = json_decode($_POST['salePerson']);
        $location = $post['location'];
        $isRawMat =0;
        $totalCost = 0;

        $this->db->trans_start();
        //product stock rollback
        $invLocation = $this->db->select('SalesLocation')->from('salesinvoicehed')->where('SalesInvNo',$grnNo)->get()->row()->SalesLocation;
        $query = $this->db->get_where('salesinvoicedtl', array('SalesInvNo' => $grnNo));
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {  
                        //update serial stock
                        $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo'], 'Location' => $row['SalesInvLocation']))->get();
                                if ($ps->num_rows() > 0) {
                                    $isPro = $this->db->select('SalesProductCode')->from('salesinvoicedtl')->where(array('SalesProductCode' => $row['SalesProductCode'], 'SalesSerialNo' => $row['SalesSerialNo'], 'SalesInvLocation' => $row['SalesInvLocation'],'SalesInvNo' => $grnNo))->get();
                                    // echo $isPro->num_rows();die;
                                    if ($isPro->num_rows() > 0) {
                                        $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo']));
                                    }
                                } else {
                                    
                                }

                                $proCode = $row['SalesProductCode'];
                                $totalGrnQty = $row['SalesQty'];
                                $loc = $row['SalesInvLocation'];
                                $pl = $row['SalesPriceLevel'];
                                $costp = $row['SalesCostPrice'];
                                $selp = $row['SalesUnitPrice'];

                            //update price stock
                           $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

                            //update product stock
                           $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')"); 
                        // }   
                    }
                }

                //update/ cancel credit invoice
            $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $grnNo, 'Location' => $invLocation));
            if ($query2->num_rows() > 0) {
                foreach ($query2->result_array() as $row) {
                    //update customer outstanding
                    $creditAmount=$row['CreditAmount'];
                    $cuscode =$row['CusCode'];
                    $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                }
                $this->db->delete('creditinvoicedetails', array('InvoiceNo' => $grnNo, 'Location' => $invLocation));
            }

            //cancel cheques
            $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $grnNo, 'IsCancel' => 0,'IsRelease' => 0));
            if ($query3->num_rows() > 0) {
                $this->db->delete('chequedetails', array('ReferenceNo' => $grnNo));
            }
            //delete pay dtl
            $this->db->delete('salesinvoicepaydtl', array('SalesInvNo' => $grnNo));
            $this->db->delete('salesinvoicedtl', array('SalesInvNo' => $grnNo));
            $this->bincard($grnNo,1,'Updated');//update bincard
            $this->db->trans_complete();
            $del=$this->db->trans_status();

            // echo $del;die;
       
            if($del=1){
                 $this->db->trans_start();
        //
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];

            $totalCost += ($qtyArr[$i]*$cost_priceArr[$i]);

            //get warranty period
            $WarrantyMonth = $this->db->select('WarrantyPeriod')->from('productcondition')->where('ProductCode',$product_codeArr[$i])->get()->row()->WarrantyPeriod;

            //insert sales invoice details
            $grnDtl = array(
                    'AppNo' => '1',
                    'SalesInvNo' => $grnNo,
                    'SalesInvLineNo' => $i,
                    'SalesInvLocation' => $location,
                    'SalesInvDate'=> $grnHed['SalesOrgDate'],
                    'SalesProductCode' => $product_codeArr[$i],
                    'SalesUnitPerCase' => $upcArr[$i],
                    'SalesCaseOrUnit' => $unitArr[$i],
                    'SalesSerialNo' => $serial_noArr[$i],
                    'SalesProductName' => $proNameArr[$i],
                    'SalesQty' => $qtyArr[$i],
                    'SalesPriceLevel' => $price_levelArr[$i],
                    'SalesFreeQty' => $freeQtyArr[$i],
                    'SalesCostPrice' => $cost_priceArr[$i],
                    'SalesUnitPrice' => $sell_priceArr[$i],
                    'SalesDisValue' => $pro_discountArr[$i],
                    'SalesDisPercentage' => $pro_discount_precentArr[$i],
                    'SalesIsVat' => $isVatArr[$i],
                    'SalesIsNbt' => $isNbtArr[$i],
                    'SalesNbtRatio' => $nbtRatioArr[$i],
                    'SalesVatAmount' => $proVatArr[$i],
                    'SalesNbtAmount' => $proNbtArr[$i],
                    'SalesTotalAmount' => $totalAmountArr[$i],
                    'SalesInvNetAmount' => $total_netArr[$i],
                    'SalesPerson' => $salesPersonArr[$i],
                    'WarrantyMonth'=>$WarrantyMonth,
                    'SellingPriceORG'=>$orgSell_priceArr[$i]
                );
            $this->db->insert('salesinvoicedtl', $grnDtl);
            $sellPrice =0;

            if($sell_priceArr[$i]==0){
                $sellPrice=$orgSell_priceArr[$i];
            }else{
                $sellPrice=$sell_priceArr[$i];
            }
            //update stock
             $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sellPrice','$location','$serial_noArr[$i]','$freeQtyArr[$i]','0','0')");

            //update serial stock
            if($serial_noArr[$i]!=''){
                 $this->db->update('productserialstock',array('Quantity'=>0),array('ProductCode'=> $product_codeArr[$i],'Location'=> $location,'SerialNo'=> $serial_noArr[$i]));
            }
        }
        
        $cashAmount = $_POST['cashAmount'];
        $creditAmount = $_POST['creditAmount'];
        $cardAmount = $_POST['cardAmount'];
        $chequeAmount = $_POST['chequeAmount'];
        $advanceAmount = $_POST['advance_amount'];  
        $advancePayNo = $_POST['advance_pay_no'];   
        $total_net_amount = $_POST['total_net_amount'];
        $returnAmount = $_POST['return_amount'];
        $returnPayNo = $_POST['return_payment_no'];
        $bankAmount = $_POST['bank_amount'];
        $bank_account = $_POST['bankacc'];
        $cusCode = $grnHed['SalesCustomer'];

        $cashAmount=$total_net_amount-$creditAmount-$cardAmount-$chequeAmount-$advanceAmount-$returnAmount-$bankAmount;

        $cashPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Cash',
            'Mode'=>$grnNo,
            'Reference'=>$grnNo,
            'SalesInvPayAmount'=>$cashAmount);

        // insert invoice payment
        if($cashAmount>0){
             $this->db->insert('salesinvoicepaydtl', $cashPay);
         }
         
         $advancePay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Advance',
            'Mode'=>$grnNo,
            'Reference'=>$advancePayNo,
            'SalesInvPayAmount'=>$advanceAmount,
            'ReceiptNo'=>$advancePayNo);

        // insert invoice payment
        if($advanceAmount>0){
             $this->db->insert('salesinvoicepaydtl', $advancePay);

             //release advance payment
             $this->db->update('customerpaymentdtl',array('IsRelease'=>1),array('CusPayNo'=>$advancePayNo));

         }

         if($bankAmount>0){
            $bankpaymentNo = $this->get_max_code('Customer Payment');

             
             $bankPay = array(
                'AppNo' => '1',
                'SalesInvNo'=>$grnNo,
                'SalesInvDate'=>$grnHed['SalesOrgDate'],
                'SalesInvPayType'=>'Bank',
                'Mode'=>$bank_account,
                'Reference'=>$bankpaymentNo,
                'SalesInvPayAmount'=>$bankAmount,
                'ReceiptNo'=>$bankpaymentNo);
                     
             $this->db->insert('salesinvoicepaydtl',$bankPay);
             $this->update_max_code('Customer Payment');
         }

          $returnPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Return',
            'Mode'=>$grnNo,
            'Reference'=>$returnPayNo,
            'SalesInvPayAmount'=>$returnAmount,
            'ReceiptNo'=>$returnPayNo);

        // insert invoice payment
        if($returnAmount>0){
             $this->db->insert('salesinvoicepaydtl', $returnPay);

             //release advance payment
             $this->db->update('returninvoicehed',array('IsComplete'=>1),array('ReturnNo'=>$returnPayNo));

              $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$cusCode','$returnAmount','$returnAmount')");

         }

         if($cardAmount>0){
            $cardpaymentNo = $this->get_max_code('Customer Payment');
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);

             for ($k = 0; $k < count($ccNameArr); $k++) {
             $cardPay = array(
                'AppNo' => '1',
                'SalesInvNo'=>$grnNo,
                'SalesInvDate'=>$grnHed['SalesOrgDate'],
                'SalesInvPayType'=>'Card',
                'Mode'=>$ccNameArr[$k],
                'Reference'=>$ccRefArr[$k],
                'SalesInvPayAmount'=>$ccAmountArr[$k],
                'ReceiptNo'=>$cardpaymentNo);
                     
             $this->db->insert('salesinvoicepaydtl',$cardPay);
             }
             $this->update_max_code('Customer Payment');
         }

        

        // insert cheque data
        if($chequeAmount>0){
            $chequepaymentNo = $this->get_max_code('Customer Payment');
        $chequePay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Cheque',
            'Mode'=>$grnNo,
            'Reference'=>$_POST['chequeReference'],
            'SalesInvPayAmount'=>$chequeAmount,
            'ReceiptNo'=>$chequepaymentNo);

            $chequeNo = $_POST['chequeNo'];
            $chequeReference = $_POST['chequeReference'];
            $chequeRecivedDate = $_POST['chequeRecivedDate'];
            $chequeDate = $_POST['chequeDate'];
            $bank = $_POST['bank'];

             $invCheque = array(
            'AppNo' => '1',
            'ReceivedDate'=>$chequeRecivedDate,
            'CusCode'=>$grnHed['SalesCustomer'],
            'ChequeOwner'=>$chequeReference,
            'ReferenceNo'=>$grnNo,
            'BankNo'=>$bank,
            'ChequeNo'=>$chequeNo,
            'ChequeDate'=>$chequeDate,
            'ChequeAmount'=>$chequeAmount,
            'Mode'=>'Sales Invoice',
            'IsCancel'=>0,
            'IsRelease'=>0);

             $this->db->insert('salesinvoicepaydtl', $chequePay);
             //add cheque data
            $r8= $this->db->insert('chequedetails',$invCheque);
            $this->update_max_code('Customer Payment');
         }

         if($creditAmount>0){
             $creditPay = array(
            'AppNo' => '1',
            'SalesInvNo'=>$grnNo,
            'SalesInvDate'=>$grnHed['SalesOrgDate'],
            'SalesInvPayType'=>'Credit',
            'SalesInvPayAmount'=>$creditAmount);
             
             $invCredit = array(
            'AppNo' => '1',
            'InvoiceNo'=>$grnNo,
            'Type'=>1,
            'InvoiceDate'=>$grnHed['SalesOrgDate'],
            'Location'=>$location,
            'CusCode'=>$grnHed['SalesCustomer'],
            'NetAmount'=>$grnHed['SalesNetAmount'],
            'CreditAmount'=>$creditAmount,
            'SettledAmount'=>0,
            'IsCloseInvoice'=>0,
            'IsCancel'=>0);
             
             $cusCode = $grnHed['SalesCustomer'];
             $invnetAmount = $grnHed['SalesNetAmount'];
             
                     
             $this->db->insert('salesinvoicepaydtl',$creditPay);
             //add credit invoice data
             $this->db->insert('creditinvoicedetails',$invCredit);
             //update customer outsatnding
             $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND('$cusCode','$invnetAmount','$creditAmount')");

         }
        
        $grnHed['SalesCostAmount'] = $totalCost;
        $updateTimestmp = date("Y-m-d H:i:s");

        $invupdate = array(
            'AppNo' => '1',
            'InvoiceNo'=>$grnNo,
            'EditType'=>1,
            'Location'=>$location,
            'UpdateDate'=>$updateTimestmp,
            'Remark'=>'Update',
            'UpdateUser'=>$_SESSION['user_id']);

        $this->db->insert('editinvoices',$invupdate);
        $this->db->update('salesinvoicehed', $grnHed,array('SalesInvNo' => $grnNo));
        $creditAmount = $_POST['creditAmount'];
        if($creditAmount>0){
            $SalesInvType=3;
        }else{
            $SalesInvType=$_POST['invType'];
        }

        // if($SalesInvType==1){
        //    $this->update_max_code('SalesInvoiceNo'.$location);
        // }elseif ($SalesInvType==2) {
        //    $this->update_max_code('TaxInvoiceNo'.$location);
        // }elseif ($SalesInvType==3) {
        //    $this->update_max_code('CreditInvoiceNo'.$location);
        // }

        $this->db->trans_complete();
       return $this->db->trans_status();

    }
        
        
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
    
    public function get_autoNum($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $code= $row['CodeLimit'];
           $input = $row['AutoNumber'];
           $string= $row['FormCode'];
           $code_len = $row['FCLength'];
           $item_ref = $string . str_pad(($input+1), $code_len, $code, STR_PAD_LEFT);
        } 
        return $input;
    }
    
    public function update_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
           $input = $row['AutoNumber'];
        } 
        $this->db->update('codegenerate',array('AutoNumber'=>($input+1)),array('FormName'=>($form)));
    }
    
    
    public function getActiveGrns($table, $q,$location) {
        $this->db->select('GRN_No');
        $this->db->like('GRN_No', $q)->where('GRN_IsCancel', 0)->where('GRN_Location', $location)->order_by('GRN_No', 'DESC');
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['GRN_No']));
                $new_row['value'] = htmlentities(stripslashes($row['GRN_No']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadPoById($inv) {
        return $this->db->select('purchaseorderdtl.*,product.Prd_Description,purchaseorderhed.PO_Amount AS PO_totalAmount,purchaseorderhed.PO_NetAmount AS totalNet,purchaseorderhed.PO_DeleveryDate, purchaseorderhed.PO_TDisAmount As TotalDiscount,purchaseorderhed.SupCode')->from('purchaseorderdtl')
                        ->where('purchaseorderdtl.PO_No', $inv)
                        ->join('purchaseorderhed', 'purchaseorderhed.PO_No = purchaseorderdtl.PO_No')
                        ->join('product', 'product.ProductCode = purchaseorderdtl.ProductCode')
                        ->get()->result();
    }
    
    public function loadPrnById($inv) {
        return $this->db->select('purchasereturnnotedtl.*,product.Prd_Description,purchasereturnnotehed.PRN_Cost_Amount AS PRN_totalAmount,purchasereturnnotehed.PRN_Cost_Amount AS totalNet, purchasereturnnotehed.PRN_SupCode')->from('purchasereturnnotedtl')
                        ->where('purchasereturnnotedtl.PRN_No', $inv)
                        ->join('purchasereturnnotehed', 'purchasereturnnotehed.PRN_No = purchasereturnnotedtl.PRN_No')
                        ->join('product', 'product.ProductCode = purchasereturnnotedtl.PRN_Product')
                        ->get()->result();
    }

       public function cancelGrn($cancelNo,$location,$canDate,$grnNo,$remark,$user,$supplier) {
        $this->db->trans_start();
        $this->db->query("CALL SPT_CANCEL_GRN('$canDate','$grnNo','$user','$remark','$supplier','$cancelNo','$location')");
         $isRawMat =0;
        $query = $this->db->get_where('goodsreceivenotedtl',array('GRN_No'=>$grnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr=$row['GRN_Product'];
                $qtyArr=$row['GRN_Qty'];
                $price_levelArr=$row['GRN_PriceLevel'];
                $cost_priceArr=$row['GRN_UnitCost'];
                $sell_priceArr=$row['GRN_Selling'];
//                $location=$row[''];
                $serial_noArr=$row['SerialNo'];
                $freeQtyArr=$row['GRN_FreeQty'];

                $isRawMat = $this->db->select('isRawMaterial')->from('productcondition')->where(array('ProductCode'=> $product_codeArr))->get()->row()->isRawMaterial;

                if($isRawMat==1){
                    $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr','$qtyArr','$price_levelArr','$cost_priceArr','$sell_priceArr','$location','$serial_noArr','$freeQtyArr','0','0')");
                }
               $this->bincard($grnNo,7,'Cancelled');//update bincard
            //update product previous cost
                $this->db->update('product',array('Prd_CostPrice'=>$cost_priceArr),array('ProductCode'=> $product_codeArr));
            //update product stock
            //$this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr','$totalGrnQty',0,'$location')");
            }
        }
        
        $this->update_max_code('CancelGRN');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function getSalesInvoiceDtlbyid($invNo) {
        $this->db->select('salesinvoicedtl.*,product.*');
        $this->db->from('salesinvoicedtl');
        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'left');
        $this->db->where('salesinvoicedtl.SalesInvNo', $invNo);
        
        $this->db->order_by('salesinvoicedtl.SalesInvLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;
    }

    public function getSalesReturnDtlbyid($invNo) {
        $this->db->select('salesinvoicedtl.*,product.*');
        $this->db->from('salesinvoicedtl');
        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'left');
        $this->db->where('salesinvoicedtl.SalesInvNo', $invNo);
        // $this->db->where('salesinvoicedtl.SalesReturnQty>0');
        $this->db->order_by('salesinvoicedtl.SalesInvLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;
    }

    public function getJobInvoiceDtlbyid($invNo) {
        $this->db->select('jobinvoicedtl.*,product.Prd_AppearName');
        $this->db->from('jobinvoicedtl');
        $this->db->join('product', 'product.ProductCode = jobinvoicedtl.JobCode', 'Left');
        $this->db->where('jobinvoicedtl.SalesInvNo', $invNo);
        
        $this->db->order_by('jobinvoicedtl.JobInvLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->JobCode][] = $row;
        }
        return $list;

    }

    public function getDeliveryNoteDtlbyid($invNo) {
        $this->db->select('deliverynotedtl.*,product.*');
        $this->db->from('deliverynotedtl');
        $this->db->join('product', 'product.ProductCode = deliverynotedtl.DNoteProductCode', 'left');
        $this->db->where('deliverynotedtl.DNoteNo', $invNo);
        
        $this->db->order_by('deliverynotedtl.DNoteLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;

    }

    public function getDeliveryNoteDtlbyinvno($invNo) {
        $this->db->select('deliverynotedtl.*,product.*');
        $this->db->from('deliverynotedtl');
        $this->db->join('product', 'product.ProductCode = deliverynotedtl.DNoteProductCode', 'INNER');
        $this->db->where('deliverynotedtl.InvoiceNo', $invNo);
        
        $this->db->order_by('deliverynotedtl.DNoteLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;

    }

    public function selectOdoout($id) {
        return $this->db->select()->from('tempjobinvoicehed')->where('JobInvNo',$id)->get()->result();
    }
}
