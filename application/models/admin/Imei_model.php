<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Imei_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function loadsupplierjson($query) {
        $q = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->like('SupName', $query, 'after')->get()->result();
        return json_encode($q);
    }

    public function loadproductjson($query) {
        $query1 = $this->db->select('ProductCode,Prd_Description')->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query, 'left')->limit(50)->get('product');

        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description']));
                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadproductSerial($product, $location) {
        $ps = $this->db->select('ProductCode')->from('productcondition')->where(array('ProductCode' => $product, 'IsSerial' => 1))->get();
        if ($ps->num_rows() > 0) {
            $query2 = $this->db->select('productserialstock.*,product.Prd_Description')->from('productserialstock')
                            ->where('product.ProductCode', $product)
                            ->where('productserialstock.Location', $location)
                            ->join('product', 'productserialstock.ProductCode = product.ProductCode')
                            ->get()->result();
        } else {
            $query2 = $this->db->select('productstock.*,product.Prd_Description,productstock.Stock As Quantity')->from('productstock')
                            ->where('product.ProductCode', $product)
                            ->where('productstock.Location', $location)
                            ->join('product', 'productstock.ProductCode = product.ProductCode')
                            ->get()->result();
        }
        return $query2;
    }

    public function loadproductbyDepandSubdep($dep, $subdep, $loc) {
        if (isset($dep) && $dep != '' && $dep != '0' && $subdep != '' && $subdep != '0') {
            $query2 = $this->db->select('productstock.*,product.Prd_Description,productstock.Stock As Quantity')->from('productstock')
                            ->where('product.DepCode', $dep)
                            ->where('product.SubDepCode', $subdep)
                            ->where('productstock.Location', $loc)
                            ->join('product', 'productstock.ProductCode = product.ProductCode')
                            ->get()->result();
        } else {
            $query2 = $this->db->select('productstock.*,product.Prd_Description,productstock.Stock As Quantity')->from('productstock')
                            ->where('product.DepCode', $dep)
                            ->where('productstock.Location', $loc)
                            ->join('product', 'productstock.ProductCode = product.ProductCode')
                            ->get()->result();
        }
        return $query2;
    }
    public function loadproductbyDeps($dep,  $loc) {
        if (isset($dep) && $dep != '' && $dep != '0') {
            $query2 = $this->db->select('productstock.*,product.Prd_Description,productstock.Stock As Quantity')->from('productstock')
                            ->where_in('product.DepCode', $dep)
                            ->where('productstock.Location', $loc)
                            ->where('productstock.Stock<>', 0)
                            ->join('product', 'productstock.ProductCode = product.ProductCode')
                            ->get()->result();
        } else {
            $query2 = $this->db->select('productstock.*,product.Prd_Description,productstock.Stock As Quantity')->from('productstock')
                            ->where_in('product.DepCode', $dep)
                            ->where('productstock.Location', $loc)
                            ->where('productstock.Stock<>', 0)
                            ->join('product', 'productstock.ProductCode = product.ProductCode')
                            ->get()->result();
        }
        return $query2;
    }

    public function loadpricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }

    public function loaddepartment() {
        return $this->db->select()->from('department')->get()->result();
    }

    public function loadlocations() {
        return $this->db->select()->from('location')->get()->result();
    }

    public function clearSerialStock($proCode, $location, $totalqty, $invUser, $grnDattime) {

        $this->db->trans_start();
        $grnDtl = array(
            'Location' => $location,
            'ProductCode' => $proCode,
            'SerialNo' => '',
            'Stock' => $totalqty,
            'UpdateUser' => $invUser,
            'SysDate' => $grnDattime);
        $this->db->insert('clearseriallog', $grnDtl);
        $this->db->update('productstock', array('Stock' => 0), array('ProductCode' => $proCode, 'Location' => $location));
        $this->db->update('pricestock', array('Stock' => 0), array('PSCode' => $proCode, 'PSLocation' => $location));
        $this->db->update('productserialstock', array('Quantity' => 0), array('ProductCode' => $proCode, 'Location' => $location));

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function clearProductStock($dep,$subdep,$location,$totalqty,$invUser,$grnDattime) {

        $this->db->trans_start();
        $grnDtl = array(
            'Location' => $location,
            'ProductCode' => $dep,
            'SerialNo' => $subdep,
            'Stock' => $totalqty,
            'UpdateUser' => $invUser,
            'SysDate' => $grnDattime);
         if (isset($dep) && $dep != '' && $dep != '0' && $subdep != '' && $subdep != '0') {
            $q1= $this->db->query("UPDATE productstock AS C,(
                            SELECT P.ProductCode
                            FROM   product AS P 
                            INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                            WHERE  P.DepCode=$dep AND P.SubDepCode=$subdep 
                            ) T2 SET Stock = 0
                            WHERE C.Location=$location AND C.ProductCode=T2.ProductCode;");
         }else{
          $q1= $this->db->query("UPDATE productstock AS C,(
                            SELECT P.ProductCode
                            FROM   product AS P 
                            INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                            WHERE  P.DepCode=$dep 
                            ) T2 SET Stock = 0
                            WHERE C.Location=$location AND C.ProductCode=T2.ProductCode;");
         }
         
         if (isset($dep) && $dep != '' && $dep != '0' && $subdep != '' && $subdep != '0') {
            $q1= $this->db->query("UPDATE pricestock AS C,
                                    (
                                    SELECT P.ProductCode
                                    FROM   product AS P 
                                    INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                                     WHERE  P.DepCode=$dep AND P.SubDepCode=$subdep 
                                    ) T2
                                    SET Stock = 0
                                    WHERE C.PSLocation=$location AND C.PSCode=T2.ProductCode;");
         }else{
          $q1= $this->db->query("UPDATE pricestock AS C,
                                    (
                                    SELECT P.ProductCode
                                    FROM   product AS P 
                                    INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                                     WHERE  P.DepCode=$dep 
                                    ) T2
                                    SET Stock = 0
                                    WHERE C.PSLocation=$location AND C.PSCode=T2.ProductCode;");
         }
        $this->db->insert('clearproductlog', $grnDtl);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function clearBulkProductStock($dep2,$location,$totalqty,$invUser,$grnDattime) {
        $dep=json_decode($dep2);
        $this->db->trans_start();
        $grnDtl = array(
            'Location' => $location,
            'ProductCode' => $dep2,
            'SerialNo' => $dep2,
            'Stock' => $totalqty,
            'UpdateUser' => $invUser,
            'SysDate' => $grnDattime);
         if (isset($dep) && $dep != '' && $dep != '0') {
             for($i=0;$i<count($dep);$i++){
            $q1= $this->db->query("UPDATE productstock AS C,(
                            SELECT P.ProductCode
                            FROM   product AS P 
                            INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                            WHERE P.DepCode=$dep[$i] 
                            ) T2 SET Stock = 0
                            WHERE C.Location=$location AND C.ProductCode=T2.ProductCode;");
             }
         }else{
          
         }
         
         if (isset($dep) && $dep != '' && $dep != '0') {
              for($j=0;$j<count($dep);$j++){
            $q1= $this->db->query("UPDATE pricestock AS C,
                                    (
                                    SELECT P.ProductCode
                                    FROM   product AS P 
                                    INNER JOIN productcondition AS PC ON PC.ProductCode=P.ProductCode
                                     WHERE P.DepCode=$dep[$j] 
                                    ) T2
                                    SET Stock = 0
                                    WHERE C.PSLocation=$location AND C.PSCode=T2.ProductCode;");
              }
         }else{
          
         }
        $this->db->insert('clearproductlog', $grnDtl);
        $this->db->trans_complete();
        return $this->db->trans_status();
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

    public function get_data_by_where($table, $data) {
        $query = $this->db->get_where($table, $data)->row_array();
        return $query;
    }

    public function getActiveSTOut($table, $q, $location_to, $location_from) {
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
                $new_row['label'] = htmlentities(stripslashes($row['TrnsNo'] . " " . $row['Prd_Description']));
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

    public function saveSTIn($location_to, $location_from, $canDate, $grnNo, $remark, $user) {
        $this->db->trans_start();
        $dattime = date("Y-m-d H:i:s");
        $this->db->update('stocktransferhed', array('TransIsInProcess' => 0, 'TransInDate' => $dattime, 'TransInUser' => $user, 'TransInRemark' => $remark), array('TrnsNo' => $grnNo, 'FromLocation' => $location_from, 'ToLocation' => $location_to));
        $query = $this->db->get_where('stocktransferdtl', array('TrnsNo' => $grnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr = $row['ProductCode'];
                $qtyArr = $row['TransQty'];
                $price_levelArr = $row['PriceLevel'];
                $cost_priceArr = $row['CostPrice'];
                $sell_priceArr = $row['SellingPrice'];
                $serial_noArr = $row['Serial'];
                $freeQtyArr = 0;
                $isSerialArr = $row['IsSerial'];

                //update stock trans dtl
                $this->db->update('stocktransferdtl', array('DismissQty' => $qtyArr), array('ProductCode' => $product_codeArr, 'TrnsNo' => $serial_noArr, 'FromLocation' => $location_from, 'ToLocation' => $location_to));

                //update to location serial stock 
                $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $product_codeArr, 'SerialNo' => $serial_noArr, 'Location' => $location_to))->get();
                if ($ps->num_rows() > 0) {
                    $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode' => $product_codeArr, 'InvSerialNo' => $serial_noArr, 'InvLocation' => $location_to))->get();
                    if ($isPro->num_rows() == 0) {
                        $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $product_codeArr, 'SerialNo' => $serial_noArr, 'Location' => $location_to));
                    }
                } else {
                    if ($isSerialArr == 1) {
                        $this->db->insert('productserialstock', array('ProductCode' => $product_codeArr, 'Location' => $location_to, 'SerialNo' => $serial_noArr, 'Quantity' => 1, 'GrnNo' => $grnNo));
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

    public function cancelTranser($location_to, $location_from, $canDate, $grnNo, $remark, $user, $invCanel) {
        $this->db->trans_start();
        $dattime = date("Y-m-d H:i:s");
        $this->db->update('stocktransferhed', array('TransIsInProcess' => 0, 'TransInDate' => $dattime, 'TransInUser' => $user, 'TransInRemark' => $remark, 'IsCancel' => 1), array('TrnsNo' => $grnNo, 'FromLocation' => $location_from, 'ToLocation' => $location_to));
        $query = $this->db->get_where('stocktransferdtl', array('TrnsNo' => $grnNo));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $product_codeArr = $row['ProductCode'];
                $qtyArr = $row['TransQty'];
                $price_levelArr = $row['PriceLevel'];
                $cost_priceArr = $row['CostPrice'];
                $sell_priceArr = $row['SellingPrice'];
                $serial_noArr = $row['Serial'];
                $freeQtyArr = 0;
                $isSerialArr = $row['IsSerial'];

                //update stock trans dtl
                $this->db->update('stocktransferdtl', array('DismissQty' => 0), array('ProductCode' => $product_codeArr, 'TrnsNo' => $serial_noArr, 'FromLocation' => $location_from, 'ToLocation' => $location_to));

                //update to location serial stock 
                $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $product_codeArr, 'SerialNo' => $serial_noArr, 'Location' => $location_from))->get();
                if ($ps->num_rows() > 0) {
                    $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode' => $product_codeArr, 'InvSerialNo' => $serial_noArr, 'InvLocation' => $location_from))->get();
                    if ($isPro->num_rows() == 0) {
                        $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $product_codeArr, 'SerialNo' => $serial_noArr, 'Location' => $location_from));
                    }
                } else {
                    if ($isSerialArr == 1) {
                        $this->db->insert('productserialstock', array('ProductCode' => $product_codeArr, 'Location' => $location_from, 'SerialNo' => $serial_noArr, 'Quantity' => 1, 'GrnNo' => $grnNo));
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
    
    public function loadproductlocbyserial($product, $location) {
        $query2 = $this->db->select('productserialstock.SerialNo,productserialstock.Quantity,location.location')->from('productserialstock')
                ->where('productserialstock.SerialNo', $product)
                ->join('location', 'location.location_id = productserialstock.Location')
                ->get();
        $query1 = $this->db->select('productserialstock.SerialNo,productserialstock.Quantity,location.location')->from('productserialstock')
                ->where('productserialstock.SerialNo', $product)
                ->where('productserialstock.Quantity>', 0)
                ->join('location', 'location.location_id = productserialstock.Location')
                ->get();
        if (($query1->num_rows()) > 0) {
            return $query1->row();
        } else if (($query2->num_rows()) > 0) {
            return $query2->row();
        }
    }
    
    public function loadproductbyserial($product, $location) {
        $query2 = $this->db->select('product.*,productprice.ProductPrice,productserialstock.SerialNo,productserialstock.Quantity,goodsreceivenotedtl.GRN_UnitCost,supplier.SupName,goodsreceivenotehed.GRN_No,goodsreceivenotehed.GRN_DateORG,location.location')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('goodsreceivenotedtl', 'goodsreceivenotedtl.SerialNo = productserialstock.SerialNo')
                ->join('goodsreceivenotehed', 'goodsreceivenotedtl.GRN_No = goodsreceivenotehed.GRN_No')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->join('supplier', 'supplier.SupCode = goodsreceivenotehed.GRN_SupCode')
                ->join('location', 'location.location_id = productserialstock.Location')
                ->get();
        $query1 = $this->db->select('product.*,productprice.ProductPrice,productserialstock.SerialNo,productserialstock.Quantity,goodsreceivenotedtl.GRN_UnitCost,supplier.SupName,goodsreceivenotehed.GRN_No,goodsreceivenotehed.GRN_DateORG,location.location')->from('product')
                ->where('productserialstock.SerialNo', $product)
                ->where('productserialstock.Location', $location)
                ->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode')
                ->join('goodsreceivenotedtl', 'goodsreceivenotedtl.SerialNo = productserialstock.SerialNo')
                ->join('goodsreceivenotehed', 'goodsreceivenotedtl.GRN_No = goodsreceivenotehed.GRN_No')
                ->join('productprice', 'productprice.ProductCode = product.ProductCode')
                ->join('supplier', 'supplier.SupCode = goodsreceivenotehed.GRN_SupCode')
                ->join('location', 'location.location_id = productserialstock.Location')
                ->get();
        if (($query1->num_rows()) > 0) {
            return $query1->row();
        } else if (($query2->num_rows()) > 0) {
            return $query2->row();
        }
    }

    public function loadsalebyserial($product, $location) {
        $query2 = $this->db->select('invoicedtl.*,invoicehed.*,location.location')->from('invoicedtl')
                ->where('invoicedtl.InvSerialNo', $product)
                ->where('invoicehed.InvIsCancel', 0)
                ->join('invoicehed', 'invoicedtl.InvNo = invoicehed.InvNo')
                ->join('location', 'location.location_id = invoicehed.InvLocation')
                ->get();
        $query1 = $this->db->select('invoicedtl.*,invoicehed.*,location.location')->from('invoicedtl')
                ->where('invoicedtl.InvSerialNo', $product)
                ->where('invoicehed.InvLocation', $location)
                ->where('invoicehed.InvIsCancel', 0)
                ->join('invoicehed', 'invoicedtl.InvNo = invoicehed.InvNo')
                ->join('location', 'location.location_id = invoicehed.InvLocation')
                ->get();
        if (($query1->num_rows()) > 0) {
            return $query1->row();
        } else if (($query2->num_rows()) > 0) {
            return $query2->row();
        }
    }
    
     public function loadtranserbyserial($product, $location) {
        $query2 = $this->db->select('stocktransferdtl.*,stocktransferhed.*,location.location')->from('stocktransferdtl')
                ->where('stocktransferdtl.Serial', $product)
                ->where('stocktransferhed.IsCancel', 0)
                ->join('stocktransferhed', 'stocktransferdtl.TrnsNo = stocktransferhed.TrnsNo')
                ->join('location', 'location.location_id = stocktransferhed.Location')
                ->get();
        $query1 = $this->db->select('stocktransferdtl.*,stocktransferhed.*,location.location')->from('stocktransferdtl')
                ->where('stocktransferdtl.Serial', $product)
                ->where('stocktransferhed.Location', $location)
                ->where('stocktransferhed.IsCancel', 0)
                ->join('stocktransferhed', 'stocktransferdtl.TrnsNo = stocktransferhed.TrnsNo')
                ->join('location', 'location.location_id = stocktransferhed.Location')
                ->get();
        if (($query1->num_rows()) > 0) {
            return $query1->row();
        } else if (($query2->num_rows()) > 0) {
            return $query2->row();
        }
    }

}
