<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_model extends CI_Model {

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
    
    public function getActivePOS($table, $q,$location) {
        $this->db->select('PO_No');
        $this->db->like('PO_No', $q)->where('IsCancel', 0)->where('PO_Location', $location)->order_by('PO_No', 'DESC');
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['PO_No']));
                $new_row['value'] = htmlentities(stripslashes($row['PO_No']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function savePO($grnHed,$post,$grnNo,$totalDisPrecent) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
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
        $pro_nameArr = json_decode($_POST['proName']);
        $location = $post['location'];
        $isRawMat =0;

        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            $grnDtl = array(
                'AppNo' => '1',
                'PO_No' => $grnNo,
                'PO_LineNo' => $i,
                'ProductCode' => $product_codeArr[$i],
                'PO_ProName' => $pro_nameArr[$i],
                'PO_UPC' => $upcArr[$i],
                'PO_Type' => $unitArr[$i],
                'PO_Qty' => $qtyArr[$i],
                'PO_TotalQty' => $totalGrnQty,
                'GRN_Qty' => 0,
                'PO_CaseCost' => $caseCostArr[$i],
                'PO_UnitCost' => $cost_priceArr[$i],
                'PO_UnitPrice' => $sell_priceArr[$i],
                'PO_DisAmount' => $pro_discountArr[$i],
                'PO_DisPercentage' => $pro_discount_precentArr[$i],
                'PO_IsVat' => $isVatArr[$i],
                'PO_IsNbt' => $isNbtArr[$i],
                'PO_NbtRatio' => $nbtRatioArr[$i],
                'PO_VatAmount' => $proVatArr[$i],
                'PO_NbtAmount' => $proNbtArr[$i],
                'PO_TotalAmount' => $totalAmountArr[$i],
                'PO_NetAmount' => $total_netArr[$i],
                'PO_IsComplete' => 0);
            $this->db->insert('purchaseorderdtl', $grnDtl);
        }
        $this->bincard($grnNo,6,'Created');//update bincard
        $this->db->insert('purchaseorderhed', $grnHed);
        $this->update_max_code('Purchase Order');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function updatePO($grnHed,$post,$grnNo,$totalDisPrecent) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
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
        $pro_nameArr = json_decode($_POST['proName']);
        $location = $post['location'];
        $isRawMat =0;

        $this->db->trans_start();
        $this->db->delete('purchaseorderdtl',array('PO_No' => $grnNo));
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            $grnDtl = array(
                'AppNo' => '1',
                'PO_No' => $grnNo,
                'PO_LineNo' => $i,
                'ProductCode' => $product_codeArr[$i],
                'PO_ProName' => $pro_nameArr[$i],
                'PO_UPC' => $upcArr[$i],
                'PO_Type' => $unitArr[$i],
                'PO_Qty' => $qtyArr[$i],
                'PO_TotalQty' => $totalGrnQty,
                'GRN_Qty' => 0,
                'PO_CaseCost' => $caseCostArr[$i],
                'PO_UnitCost' => $cost_priceArr[$i],
                'PO_UnitPrice' => $sell_priceArr[$i],
                'PO_DisAmount' => $pro_discountArr[$i],
                'PO_DisPercentage' => $pro_discount_precentArr[$i],
                'PO_IsVat' => $isVatArr[$i],
                'PO_IsNbt' => $isNbtArr[$i],
                'PO_NbtRatio' => $nbtRatioArr[$i],
                'PO_VatAmount' => $proVatArr[$i],
                'PO_NbtAmount' => $proNbtArr[$i],
                'PO_TotalAmount' => $totalAmountArr[$i],
                'PO_NetAmount' => $total_netArr[$i],
                'PO_IsComplete' => 0);
            $this->db->insert('purchaseorderdtl', $grnDtl);
        }
        $this->bincard($grnNo,1,'Updated');//update bincard
        $this->db->update('purchaseorderhed', $grnHed,array('PO_No'=>($grnNo)));
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function savePRN($grnHed,$post,$prnNo) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
//        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
//        $pro_discountArr = json_decode($post['pro_discount']);
//        $pro_discount_precentArr = json_decode($post['discount_precent']);
//        $caseCostArr = json_decode($post['case_cost']);
        $upcArr = json_decode($post['upc']);
//        $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $location = $post['location'];
        $grnDattime = date("Y-m-d H:i:s");
        $grnno=$_POST['grn_no'];
        $sup_code = $_POST['sup_code'];
        $total_amount = $_POST['total_amount'];

        
        
        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {

            $grnDtl = array(
                'AppNo' => 1,
                'PRN_No' => $prnNo,
                'PRN_Product' => $product_codeArr[$i],
                'PRN_UPC' => $upcArr[$i],
                'PRN_UPCType' => $unitArr[$i],
                'PRN_Qty' => $qtyArr[$i],
                'PRN_UnitCost' => $cost_priceArr[$i],
                'PRN_PriceLevel' => $price_levelArr[$i],
                'PRN_Selling' => $sell_priceArr[$i],
                'PRN_Amount' => $totalAmountArr[$i],
                'IsSerial' => $isSerialArr[$i],
                'Serial' => $serial_noArr[$i]);
            $this->db->insert('purchasereturnnotedtl', $grnDtl);
        
            //update price stock
            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','0','0','0','0')");
            // $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location')");

            //update product stock
            // $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr[$i]','$qtyArr',0,'$location')");

            //update price and product stock
//            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','$serial_noArr[$i]',0,0,0)");
             //update serial stock
             $this->db->query("UPDATE productserialstock AS S
                                INNER JOIN  purchasereturnnotedtl AS D ON S.ProductCode=D.PRN_Product
                                SET S.Quantity=0
                                WHERE S.SerialNo = D.Serial AND D.IsSerial = 1 AND D.PRN_No = '$prnNo'");

             //update grn details
//            if($grnno!='' || $grnno!=0){
//                $this->db->update('goodsreceivenotedtl', array('GRN_ReturnQty'=>$qtyArr[$i]),array('GRN_No'=>$grnno,'GRN_Product'=>$product_codeArr[$i],'SerialNo'=>$serial_noArr[$i]));
//            }
        }

//        if($grnno!='' || $grnno!=0){
//            $grnCredit=0;
//            //update supplier outstanding
//            $this->db->query("CALL SPT_UPDATE_SUPOUTSTAND_RBACK('$sup_code','$total_amount','$total_amount')");
//
//            $this->db->update('goodsreceivenotehed', array('GRN_ReturnAmount'=>($total_amount)),array('GRN_No'=>($grnno)));
//
//            $grnCredit = $this->db->select('CreditAmount')->from('creditgrndetails')->where('GRNNO',$grnno)->get()->row()->CreditAmount;
//
//            if($grnCredit>0){
//                $creditAmount = $grnCredit-$total_amount;
//                //update credit invoices
//                $this->db->update('creditgrndetails', array('CreditAmount'=>($creditAmount)),array('GRNNO'=>($grnno)));
//            }
//         }
        $this->bincard($grnno,11,'Created');//update bincard
        $this->db->insert('purchasereturnnotehed', $grnHed);
        $this->update_max_code('PRN');

        $this->db->trans_complete();
       return $this->db->trans_status();
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
    
    public function get_data_by_where($table, $data) {
        $query = $this->db->get_where($table, $data)->row_array();
        return $query;
    }
    

    public function loadPoById($inv) {
        return $this->db->select('purchaseorderdtl.*,product.Prd_Description,product.Prd_AppearName,purchaseorderhed.PO_Amount AS PO_totalAmount,purchaseorderhed.PO_NetAmount AS totalNet,purchaseorderhed.PO_DeleveryDate, purchaseorderhed.PO_TDisAmount As TotalDiscount,purchaseorderhed.SupCode')->from('purchaseorderdtl')
                        ->where('purchaseorderdtl.PO_No', $inv)
                        ->join('purchaseorderhed', 'purchaseorderhed.PO_No = purchaseorderdtl.PO_No')
                        ->join('product', 'product.ProductCode = purchaseorderdtl.ProductCode')
                        ->get()->result();
    }
    
    public function loadPrnById($inv) {
        return $this->db->select('purchasereturnnotedtl.*,product.Prd_Description,product.Prd_AppearName,purchasereturnnotehed.PRN_Cost_Amount AS PRN_totalAmount,purchasereturnnotehed.PRN_Cost_Amount AS totalNet, purchasereturnnotehed.PRN_SupCode')->from('purchasereturnnotedtl')
                        ->where('purchasereturnnotedtl.PRN_No', $inv)
                        ->join('purchasereturnnotehed', 'purchasereturnnotehed.PRN_No = purchasereturnnotedtl.PRN_No')
                        ->join('product', 'product.ProductCode = purchasereturnnotedtl.PRN_Product')
                        ->get()->result();
    }

       public function getActivePrns($table, $q,$location) {
        $this->db->select('PRN_No');
        $this->db->like('PRN_No', $q)->where('PRN_IsCancel', 0)->where('PRN_Location', $location)->order_by('PRN_No', 'DESC');
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['PRN_No']));
                $new_row['value'] = htmlentities(stripslashes($row['PRN_No']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    // public function loadPrnById($inv) {
    //     return $this->db->select('purchasereturnnotedtl.*,product.Prd_Description,purchasereturnnotehed.PRN_Amount AS PRN_totalAmount,purchasereturnnotehed.PRN_NetAmount AS totalNet, purchasereturnnotehed.PRN_DisAmount As TotalDiscount,purchasereturnnotehed.PRN_SupCode')->from('purchasereturnnotedtl')
    //                     ->where('purchasereturnnotedtl.PRN_No', $inv)
    //                     ->join('purchasereturnnotehed', 'purchasereturnnotehed.PRN_No = purchasereturnnotedtl.PRN_No')
    //                     ->join('product', 'product.ProductCode = purchasereturnnotedtl.PRN_Product')
    //                     ->get()->result();
    // }
    
       public function cancelPrn($cancelNo,$location,$canDate,$prnNo,$remark,$user,$supplier) {
        $this->db->trans_start();

        $prnCan = array(
                'AppNo' => 1,
                'CancelNo' => $cancelNo,
                'Location' => $location,
                'CancelDate' => $canDate,
                'PRNNo' => $prnNo,
                'Remark' => $remark,
                'CancelUser' => $user);

        $isRawMat =0;
        $grnno = $this->db->select('GRN_No')->from('purchasereturnnotehed')->where('PRN_No',$prnNo)->get()->row()->GRN_No;
        $total_amount = $this->db->select('PRN_Cost_Amount')->from('purchasereturnnotehed')->where('PRN_No',$prnNo)->get()->row()->PRN_Cost_Amount;
        $query = $this->db->get_where('purchasereturnnotedtl',array('PRN_No'=>$prnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr=$row['PRN_Product'];
                $qtyArr=$row['PRN_Qty'];
                $price_levelArr=$row['PRN_PriceLevel'];
                $cost_priceArr=$row['PRN_UnitCost'];
                $sell_priceArr=$row['PRN_Selling'];
//                $location=$row[''];
                $serial_noArr=$row['Serial'];
                // $freeQtyArr=$row['PRN_FreeQty'];
                

                // if($isRawMat==0){
                    $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr','$qtyArr','$price_levelArr','$cost_priceArr','$sell_priceArr','$location','$serial_noArr','0','0','0')");
                     //update price stock
                    $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr','$qtyArr','$price_levelArr','$cost_priceArr','$sell_priceArr','$location')");
                   
                    //update product stock
                    $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr','$qtyArr',0,'$location')");

                // }
               if($serial_noArr!=''){
                $this->db->update('productserialstock',array('Quantity'=>1),array('ProductCode'=> $product_codeArr,'Location'=> $location,'SerialNo'=> $serial_noArr));
               }
               
            }

            if($grnno!='' || $grnno!=0){
            $grnCredit=0;
            $grnReturn=0;
            //update supplier outstanding
            $this->db->query("CALL SPT_UPDATE_SUPOUTSTAND('$supplier','$total_amount','0')");
            $grnReturn = $this->db->select('GRN_ReturnAmount')->from('goodsreceivenotehed')->where('GRN_No',$grnno)->get()->row()->GRN_ReturnAmount;

            $this->db->update('goodsreceivenotehed', array('GRN_ReturnAmount'=>($grnReturn-$total_amount)),array('GRN_No'=>($grnno)));

            $grnCredit = $this->db->select('CreditAmount')->from('creditgrndetails')->where('GRNNO',$grnno)->get()->row()->CreditAmount;

            if($grnCredit>0){
                $creditAmount = $grnCredit+$total_amount;
                //update credit invoices
                $this->db->update('creditgrndetails', array('CreditAmount'=>($creditAmount)),array('GRNNO'=>($grnno)));
            }

            $this->db->update('purchasereturnnotehed', array('PRN_IsCancel'=>1),array('PRN_No'=>($prnNo)));
         }

        }
        $this->bincard($grnNo,11,'PRN Cancelled');//update bincard
        $this->db->insert('cancelprn', $prnCan);
        $this->update_max_code('CancelPRN');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function cancelPO($cancelNo,$location,$canDate,$poNo,$remark,$user,$supplier) {
        $this->db->trans_start();

        $poCan = array(
                'AppNo' => 1,
                'CancelNo' => $cancelNo,
                'Location' => $location,
                'CancelDate' => $canDate,
                'PONo' => $poNo,
                'Remark' => $remark,
                'CancelUser' => $user);

        $this->bincard($poNo,6,'Cancelled');//update bincard
        $this->db->update('purchaseorderhed', array('IsCancel'=>1),array('PO_No'=>($poNo)));
        $this->db->insert('cancelpo', $poCan);
        $this->update_max_code('CancelPO');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }
}
