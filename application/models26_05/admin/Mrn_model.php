<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mrn_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function loadsupplierjson($query) {
        $q = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->like('SupName', $query, 'after')->get()->result();
        return json_encode($q);
    }

    public function loadproductjson($query,$sup,$supCode) {
        if($sup!=0){
            $query1 =$this->db->select('ProductCode,Prd_Description')->where('product.Prd_Supplier', $supCode)->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')->limit(50)->get('product');
        }else{
            $query1 =$this->db->select('ProductCode,Prd_Description')->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query ,'left')->limit(50)->get('product');
        }

        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }
    
    public function loadproductSerial($product, $q, $location) {
         $query2 = $this->db->select('productserialstock.SerialNo')->from('product')
                ->where('product.ProductCode', $product)
                ->where('productserialstock.Location', $location)
                ->where('productserialstock.Quantity', 1)
                 ->like("productserialstock.SerialNo", $q ,'left')
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->get();
    
            if (($query2->num_rows()) > 0) {
                foreach ($query2->result_array() as $row) {
                    $new_row['label'] = htmlentities(stripslashes($row['SerialNo']));
                $new_row['value'] = htmlentities(stripslashes($row['SerialNo']));
                $row_set[] = $new_row;
                }
                return json_encode($row_set);
            } else {
                return NULL;
            }
 
    }
    
    public function loadpricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }
    public function loadlocations() {
        return $this->db->select()->from('location')->get()->result();
    }
    
    public function saveMrn($grnHed,$post,$grnNo) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
//      $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
//      $pro_discountArr = json_decode($post['pro_discount']);
//      $pro_discount_precentArr = json_decode($post['discount_precent']);
//      $caseCostArr = json_decode($post['case_cost']);
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
        $location = $post['location'];
        $location_to = $post['location'];
        $location_from = '';
        $grnDattime = date("Y-m-d H:i:s");
        $isReceive= json_decode($_POST['isReceive']);
        $request_dateArr = json_decode($_POST['request_date']);
        $qualityArr = json_decode($_POST['quality']);
        $brandArr = json_decode($_POST['brand']);
        $pro_nameArr = json_decode($_POST['proName']);

        // if($request_dateArr==0){
        //     $request_date=date("Y-m-d H:i:s");
        // }else{
        //     $request_date=$request_dateArr;
        // }
        
        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
//          $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
//          $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            if($request_dateArr[$i]==0){
                $request_date=date("Y-m-d H:i:s");
            }else{
                $request_date=$request_dateArr[$i];
            }
            $serialNo=isset($serial_noArr[$i]) ? $serial_noArr[$i] : '';
            $grnDtl = array(
                'MrnNo' => $grnNo,
                'Location' => $location,
                'MrnDate' => $request_date,
                'FromLocation' => $location_from,
                'ToLocation' => $location_to,
                'ProductCode' => $product_codeArr[$i],
                'UnitPerCase' => $upcArr[$i],
                'CaseOrUnit' => $unitArr[$i],
                'RequestQty' => $qtyArr[$i],
                'ProName' => $pro_nameArr[$i],
                'ProQuality' => $qualityArr[$i],
                'ProBrand' => $brandArr[$i],
                'ReceiveQty' => 0,
                'Request' => 1,
                'Receive' => $isReceive[$i],
                'CostPrice' => $cost_priceArr[$i],
                'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                'TotalAmount' => $totalAmountArr[$i],
                'MrnIsVat' => $isVatArr[$i],
                'MrnIsNbt' => $isNbtArr[$i],
                'MrnNbtRatio' => $nbtRatioArr[$i],
                'MrnVatAmount' => $proVatArr[$i],
                'MrnNbtAmount' => $proNbtArr[$i],
                'NetAmount' => $total_netArr[$i],
                'IsSerial' => $isSerialArr[$i],
                'Serial' => $serialNo);
            $this->db->insert('materialrequestnotedtl', $grnDtl);
        
            //update price and product stock
            // $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location_from','$serial_noArr[$i]',0,0,0)");
             //update serial stock
             // $this->db->query("UPDATE productserialstock AS S
             //                    INNER JOIN  stocktransferdtl AS D ON S.ProductCode=D.ProductCode
             //                    SET S.Quantity=0
             //                    WHERE S.SerialNo = D.Serial AND D.IsSerial = 1 AND D.TrnsNo = '$grnNo' AND D.Location = '$location_from'");
              
        }


        
        $this->db->insert('materialrequestnotehed', $grnHed);
        $this->update_max_code('MRN');

        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function updateMrn($grnHed,$post,$grnNo) {        
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
       $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $isVatArr = json_decode($_POST['isVat']);
        $isNbtArr = json_decode($_POST['isNbt']);
        $nbtRatioArr = json_decode($_POST['nbtRatio']);
        $proVatArr = json_decode($_POST['proVat']);
        $proNbtArr = json_decode($_POST['proNbt']);
        $location = $post['location'];
        $location_to = $post['location'];
        $location_from = '';
        $grnDattime = date("Y-m-d H:i:s");
        $isReceive= json_decode($_POST['isReceive']);
        $request_dateArr = json_decode($_POST['request_date']);
        $qualityArr = json_decode($_POST['quality']);
        $brandArr = json_decode($_POST['brand']);
        $pro_nameArr = json_decode($_POST['proName']);

        

        
        $this->db->trans_start();

        $this->db->update('materialrequestnotehed',$grnHed,array('MrnNo' => $grnNo));
        $this->db->delete('materialrequestnotedtl',array('MrnNo' =>  $grnNo));

        for ($i = 0; $i < count($product_codeArr); $i++) {
//            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
//            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            if($request_dateArr[$i]==0){
                $request_date=date("Y-m-d H:i:s");
            }else{
                $request_date=$request_dateArr[$i];
            }
             $serialNo=isset($serial_noArr[$i]) ? $serial_noArr[$i] : '';
            $grnDtl = array(
                'MrnNo' => $grnNo,
                'Location' => $location,
                'MrnDate' => $request_date,
                'FromLocation' => $location_from,
                'ToLocation' => $location_to,
                'ProductCode' => $product_codeArr[$i],
                'UnitPerCase' => $upcArr[$i],
                'CaseOrUnit' => $unitArr[$i],
                'RequestQty' => $qtyArr[$i],
                'ProName' => $pro_nameArr[$i],
                'ProQuality' => $qualityArr[$i],
                'ProBrand' => $brandArr[$i],
                'ReceiveQty' => 0,
                'Request' => 1,
                'Receive' =>  $isReceive[$i],
                'CostPrice' => $cost_priceArr[$i],
                'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                'TotalAmount' => $totalAmountArr[$i],
                'MrnIsVat' => $isVatArr[$i],
                'MrnIsNbt' => $isNbtArr[$i],
                'MrnNbtRatio' => $nbtRatioArr[$i],
                'MrnVatAmount' => $proVatArr[$i],
                'MrnNbtAmount' => $proNbtArr[$i],
                'NetAmount' => $total_netArr[$i],
                'IsSerial' => $isSerialArr[$i],
                'Serial' => $serialNo);
            $this->db->insert('materialrequestnotedtl', $grnDtl);
        
            //update price and product stock
            // $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location_from','$serial_noArr[$i]',0,0,0)");
             //update serial stock
             // $this->db->query("UPDATE productserialstock AS S
             //                    INNER JOIN  stocktransferdtl AS D ON S.ProductCode=D.ProductCode
             //                    SET S.Quantity=0
             //                    WHERE S.SerialNo = D.Serial AND D.IsSerial = 1 AND D.TrnsNo = '$grnNo' AND D.Location = '$location_from'");
              
        }
        
        
        
        // $this->db->insert('materialrequestnotehed', $grnHed);
        // $this->update_max_code('MRN');

        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function issueMrn($grnHed,$post,$grnNo) {        
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
        $qualityArr = json_decode($_POST['quality']);
        $brandArr = json_decode($_POST['brand']);
        $pro_nameArr = json_decode($_POST['proName']);
        $location = $post['location'];
        $location_to = $post['location_from'];
        $location_from = '';
        $grnDattime = date("Y-m-d H:i:s");
        
        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
            
//            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
//            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
             $serialNo=isset($serial_noArr[$i]) ? $serial_noArr[$i] : '';
            $grnDtl = array(
                'FromLocation' => $location_from,
                // 'ToLocation' => $location_to,
                // 'ProductCode' => $product_codeArr[$i],
                'UnitPerCase' => $upcArr[$i],
                'CaseOrUnit' => $unitArr[$i],
                 'ReceiveBrand' => $brandArr[$i],
                  'ReceiveQuality' => $qualityArr[$i],
                'ReceiveQty' => $qtyArr[$i],
                // 'Request' => 1,
                'Receive' => 1,
                'ReceiveDate' => $grnDattime,
                // 'CostPrice' => $cost_priceArr[$i],
                // 'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                // 'TotalAmount' => $totalAmountArr[$i],
                'IsSerial' => $isSerialArr[$i],
                'Serial' => $serialNo);
            $this->db->update('materialrequestnotedtl', $grnDtl,array('ProductCode' => $product_codeArr[$i],'ProName' => $pro_nameArr[$i],'MrnNo' => $grnNo ));
            
           //update stock
            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location','$serialNo','0','0','0')");

//            Add Additional Code By Asanka

            //update location price stock
            $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location_to')");

            //update location product stock
            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr[$i]','$qtyArr[$i]',0,'$location_to')");

            //update to location serial stock
            $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode'=> $product_codeArr[$i],'SerialNo'=>$serialNo,'Location'=>$location_to))->get();
            if($ps->num_rows()>0){
                    $this->db->update('productserialstock',array('Quantity'=>1),array('ProductCode'=> $product_codeArr[$i],'SerialNo'=>$serialNo,'Location'=> $location_to));
            }else{
                if($isSerialArr[$i]==1){
                    $this->db->insert('productserialstock', array('ProductCode'=> $product_codeArr[$i],'Location'=> $location_to,'SerialNo'=>$serialNo,'Quantity'=>1,'GrnNo'=>$grnNo));
                }
            }

//            Add Additional Code By Asanka

            //update serial stock
            if($serialNo!=''){
                $this->db->update('productserialstock',array('Quantity'=>0),array('ProductCode'=> $product_codeArr[$i],'Location'=> $location,'SerialNo'=> $serialNo));
            }

        $this->db->update('materialrequestnotehed', $grnHed,array('MrnNo' => $grnNo ));

             //update issue status
        $issue_count = $this->db->select('Receive')->from('materialrequestnotedtl')->where('MrnNo', $grnNo)->where('Receive', 1)->get()->num_rows();
        $request_count = $this->db->select('Request')->from('materialrequestnotedtl')->where('MrnNo', $grnNo)->where('Request', 1)->get()->num_rows();

        if($request_count>$issue_count){
            $this->db->update('materialrequestnotehed',array('MrnIsReceive' => 0),array('MrnNo' => $grnNo));
        }elseif($request_count==$issue_count){
            $this->db->update('materialrequestnotehed',array('MrnIsReceive' => 1),array('MrnNo' => $grnNo));
        }
            //update price and product stock
            // $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location_from','$serial_noArr[$i]',0,0,0)");
             //update serial stock
             // $this->db->query("UPDATE productserialstock AS S
             //                    INNER JOIN  stocktransferdtl AS D ON S.ProductCode=D.ProductCode
             //                    SET S.Quantity=0
             //                    WHERE S.SerialNo = D.Serial AND D.IsSerial = 1 AND D.TrnsNo = '$grnNo' AND D.Location = '$location_from'");
            
        }
        
        
        // $this->update_max_code('MRN');

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

    public function loadMrnById($inv) {
        if($inv!=''){
            $arr['mrn_hed'] = $this->db->select()->from('materialrequestnotehed')->where('MrnNo', $inv)->get()->row();
            $arr['mrn_dtl'] = $this->db->select('materialrequestnotedtl.*,product.Prd_Description')->from('materialrequestnotedtl')
                        ->where('materialrequestnotedtl.MrnNo', $inv)
                        ->join('product', 'product.ProductCode = materialrequestnotedtl.ProductCode')
                        ->get()->result();
           
        }else{
            $arr['mrn_dtl'] =null;
            $arr['mrn_hed']=null;
        }        
        
        echo json_encode($arr);
        die;
    }


    
    public function getActiveSTOut($table, $q,$location_to,$location_from) {
//        $this->db->select('TrnsNo');
//        $this->db->like('TrnsNo', $q)->where('TransIsInProcess', 1)->where('IsCancel', 0)->where('ToLocation', $location_to)->where('FromLocation', $location_from);
//        
//        $query = $this->db->get($table);
        $query = $this->db->select('stocktransferdtl.*,product.Prd_Description,stocktransferhed.CostAmount AS GRN_totalAmount,stocktransferhed.CostAmount AS totalNet, stocktransferhed.CostAmount As TotalDiscount,stocktransferhed.FromLocation,stocktransferhed.ToLocation')->from('stocktransferdtl')
                        ->like('stocktransferhed.TrnsNo', $q)
                        ->where('stocktransferhed.IsCancel', 0)
                        ->where('stocktransferhed.ToLocation', $location_to)
                        ->where('stocktransferhed.FromLocation', $location_from)
                        ->where('stocktransferhed.TransIsInProcess', 1)
                        ->join('stocktransferhed', 'stocktransferhed.TrnsNo = stocktransferdtl.TrnsNo')
                        ->join('product', 'product.ProductCode = stocktransferdtl.ProductCode')
                        ->group_by('stocktransferhed.TrnsNo')
                        ->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['TrnsNo']." ".$row['Prd_Description']));
                $new_row['value'] = htmlentities(stripslashes($row['TrnsNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadSTOutById($inv) {
        return $this->db->select('stocktransferdtl.*,product.Prd_Description,stocktransferhed.CostAmount AS GRN_totalAmount,stocktransferhed.CostAmount AS totalNet, stocktransferhed.CostAmount As TotalDiscount,stocktransferhed.FromLocation,stocktransferhed.ToLocation')->from('stocktransferdtl')
                        ->where('stocktransferdtl.TrnsNo', $inv)
                        ->join('stocktransferhed', 'stocktransferhed.TrnsNo = stocktransferdtl.TrnsNo')
                        ->join('product', 'product.ProductCode = stocktransferdtl.ProductCode')
                        ->get()->result();
    }
    
       public function saveSTIn($location_to,$location_from,$canDate,$grnNo,$remark,$user) {
        $this->db->trans_start();
        $dattime = date("Y-m-d H:i:s");
       $this->db->update('stocktransferhed',array('TransIsInProcess'=>0,'TransInDate'=>$dattime,'TransInUser'=>$user,'TransInRemark'=>$remark),array('TrnsNo'=>$grnNo,'FromLocation'=>$location_from,'ToLocation'=>$location_to));
        $query = $this->db->get_where('stocktransferdtl',array('TrnsNo'=>$grnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr=$row['ProductCode'];
                $qtyArr=$row['TransQty'];
                $price_levelArr=$row['PriceLevel'];
                $cost_priceArr=$row['CostPrice'];
                $sell_priceArr=$row['SellingPrice'];
                $serial_noArr=$row['Serial'];
                $freeQtyArr=0;
                $isSerialArr=$row['IsSerial'];
                
                //update stock trans dtl
                 $this->db->update('stocktransferdtl',array('DismissQty'=>$qtyArr),array('ProductCode'=> $product_codeArr,'TrnsNo'=>$serial_noArr,'FromLocation'=> $location_from,'ToLocation'=>$location_to));
                 
                //update to location serial stock 
                $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode'=> $product_codeArr,'SerialNo'=>$serial_noArr,'Location'=>$location_to))->get();
                if($ps->num_rows()>0){
                    $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode'=> $product_codeArr,'InvSerialNo'=>$serial_noArr,'InvLocation'=>$location_to))->get();
                    if($isPro->num_rows()==0){
                        $this->db->update('productserialstock',array('Quantity'=>1),array('ProductCode'=> $product_codeArr,'SerialNo'=>$serial_noArr,'Location'=> $location_to));
                    }
                }else{
                    if($isSerialArr==1){
                        $this->db->insert('productserialstock', array('ProductCode'=> $product_codeArr,'Location'=> $location_to,'SerialNo'=>$serial_noArr,'Quantity'=>1,'GrnNo'=>$grnNo));
                    }
                }
                

                //update price stock
               $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr','$qtyArr','$price_levelArr','$cost_priceArr','$sell_priceArr','$location_to')");

            //update product stock
            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr','$qtyArr',0,'$location_to')");
            }
        }
        
//        $this->update_max_code('CancelGRN');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }
    
     public function cancelTranser($location_to,$location_from,$canDate,$grnNo,$remark,$user,$invCanel) {
        $this->db->trans_start();
        $dattime = date("Y-m-d H:i:s");
       $this->db->update('stocktransferhed',array('TransIsInProcess'=>0,'TransInDate'=>$dattime,'TransInUser'=>$user,'TransInRemark'=>$remark,'IsCancel'=>1),array('TrnsNo'=>$grnNo,'FromLocation'=>$location_from,'ToLocation'=>$location_to));
        $query = $this->db->get_where('stocktransferdtl',array('TrnsNo'=>$grnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr=$row['ProductCode'];
                $qtyArr=$row['TransQty'];
                $price_levelArr=$row['PriceLevel'];
                $cost_priceArr=$row['CostPrice'];
                $sell_priceArr=$row['SellingPrice'];
                $serial_noArr=$row['Serial'];
                $freeQtyArr=0;
                $isSerialArr=$row['IsSerial'];
                
                //update stock trans dtl
                 $this->db->update('stocktransferdtl',array('DismissQty'=>0),array('ProductCode'=> $product_codeArr,'TrnsNo'=>$serial_noArr,'FromLocation'=> $location_from,'ToLocation'=>$location_to));
                 
                //update to location serial stock 
                $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode'=> $product_codeArr,'SerialNo'=>$serial_noArr,'Location'=>$location_from))->get();
                if($ps->num_rows()>0){
                    $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode'=> $product_codeArr,'InvSerialNo'=>$serial_noArr,'InvLocation'=>$location_from))->get();
                    if($isPro->num_rows()==0){
                        $this->db->update('productserialstock',array('Quantity'=>1),array('ProductCode'=> $product_codeArr,'SerialNo'=>$serial_noArr,'Location'=> $location_from));
                    }
                }else{
                    if($isSerialArr==1){
                        $this->db->insert('productserialstock', array('ProductCode'=> $product_codeArr,'Location'=> $location_from,'SerialNo'=>$serial_noArr,'Quantity'=>1,'GrnNo'=>$grnNo));
                    }
                }
                

                //update price stock
               $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr','$qtyArr','$price_levelArr','$cost_priceArr','$sell_priceArr','$location_from')");

            //update product stock
            $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr','$qtyArr',0,'$location_from')");
            }
        }
        $this->db->insert('canceltranser', $invCanel);
       $this->update_max_code('Transfer Cancel');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }


public function getMRNDtlbyid($invNo) {
        $this->db->select('materialrequestnotedtl.*,product.*');
        $this->db->from('materialrequestnotedtl');
        $this->db->join('product', 'product.ProductCode = materialrequestnotedtl.ProductCode', 'left');
        $this->db->where('materialrequestnotedtl.MrnNo', $invNo);
        
        // $this->db->order_by('materialrequestnotedtl.DNoteLineNo','ASC');
        // $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;

    }

}
