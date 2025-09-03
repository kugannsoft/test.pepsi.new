<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transer_model extends CI_Model {

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
                 ->where('productserialstock.Quantity >', 0)
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
    
    public function saveStockOut($grnHed,$post,$grnNo) {        
        $product_codeArr = json_decode($post['product_code']);
        $unitArr = json_decode($post['unit_type']);
        $proReturn = json_decode($post['proReturn']);
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
        $location_to = $post['location_to'];
        $location_from = $post['location_from'];
        $grnDattime = date("Y-m-d H:i:s");
        
        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
//            $totalGrnQty = ($qtyArr[$i]+$freeQtyArr[$i]);
//            $qtyPrice = $total_netArr[$i]/$qtyArr[$i];
            $grnDtl = array(
                'TrnsNo' => $grnNo,
                'Location' => $location,
                'TrnsDate' => $grnDattime,
                'FromLocation' => $location_from,
                'ToLocation' => $location_to,
                'ProductCode' => $product_codeArr[$i],
                'UnitPerCase' => $upcArr[$i],
                'CaseOrUnit' => $unitArr[$i],
                'TransQty' => $qtyArr[$i],
                'DismissQty' => 0,
                'CostPrice' => $cost_priceArr[$i],
                'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                'TransAmount' => $totalAmountArr[$i],
                'IsSerial' => $isSerialArr[$i],
                'Serial' => $serial_noArr[$i],
            'ReturnStatus' => $proReturn[$i]);
            $this->db->insert('stocktransferdtl', $grnDtl);
            $returnQty=0;
            if($proReturn[$i]==1){
                $returnQty=1;           
            }
        
            //update price and product stock
            $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$i]','$qtyArr[$i]','$price_levelArr[$i]','$cost_priceArr[$i]','$sell_priceArr[$i]','$location_from','$serial_noArr[$i]',0,$returnQty,$proReturn[$i])");
             //update serial stock
             $this->db->query("UPDATE productserialstock AS S
                                INNER JOIN  stocktransferdtl AS D ON S.ProductCode=D.ProductCode
                                SET S.Quantity=0
                                WHERE S.SerialNo = D.Serial AND D.IsSerial = 1 AND D.TrnsNo = '$grnNo' AND D.Location = '$location_from'");
            
        }
        
        
        
        $this->db->insert('stocktransferhed', $grnHed);
        $this->update_max_code('Transfer Out');

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
    
    public function getActiveSTOut($table, $q,$location_to,$location_from) {
        $this->db->select('TrnsNo');
        $this->db->like('TrnsNo', $q)->where('TransIsInProcess', 1)->where('IsCancel', 0)->where('ToLocation', $location_to)->where('FromLocation', $location_from);
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['TrnsNo']));
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
    
    public function getActiveTranserOutByto($location){
        $this->db->select('TrnsNo');
        $this->db->where('TransIsInProcess', 1)->where('IsCancel', 0)->where('ToLocation', $location);
        $query = $this->db->get('stocktransferhed');
        if ($query->num_rows() > 0) {
            return ($query->result_array());
         
        }
    }
}
