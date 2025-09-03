<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

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

    public function update_data($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }

    public function getActiveInvoies($table, $q, $location) {
        $this->db->select('invoicedtl.InvNo,product.Prd_Description,invoicehed.InvNetAmount')->from('invoicehed');
        $this->db->like('invoicehed.InvNo', $q)->where('invoicehed.InvIsCancel', 0)->where('invoicehed.InvLocation', $location)
                ->join('invoicedtl', 'invoicehed.InvNo = invoicedtl.InvNo')
                ->join('product', 'product.ProductCode = invoicedtl.InvProductCode')->group_by('invoicedtl.InvNo')->order_by('invoicedtl.InvNo', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['InvNo'] . " - " . $row['Prd_Description']. " - Rs." . number_format($row['InvNetAmount'])));
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

        $query = $this->db->get_where('invoicedtl', array('InvNo' => $invCanel['InvoiceNo']));
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                //update serial stock
                $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['InvProductCode'], 'SerialNo' => $row['InvSerialNo'], 'Location' => $row['InvLocation']))->get();
                if ($ps->num_rows() > 0) {
                    $isPro = $this->db->select('InvProductCode')->from('invoicedtl')->where(array('InvProductCode' => $row['InvProductCode'], 'InvSerialNo' => $row['InvSerialNo'], 'InvLocation' => $row['InvLocation']))->get();
                    if ($isPro->num_rows() == 0) {
                        $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['InvProductCode'], 'SerialNo' => $row['InvSerialNo']));
                    }
                } else {
                    
                }
                $proCode = $row['InvProductCode'];
                $totalGrnQty = $row['InvQty'] + $row['InvFreeQty'];
                $loc = $row['InvLocation'];
                $pl = $row['InvPriceLevel'];
                $costp = $row['InvCostPrice'];
                $selp = $row['InvUnitPrice'];

                //update price stock
                $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

                //update product stock
                $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')");
            }
        }

        //update cancel credit invoice
        $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['InvoiceNo'], 'Location' => $loc));
        if($query2->num_rows() > 0) {
            $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['InvoiceNo'], 'Location' => $invCanel['Location']));
        }

        $this->db->update('invoicehed', array('InvIsCancel' => 1), array('InvNo' => $invCanel['InvoiceNo'], 'InvLocation' => $invCanel['Location']));
        $this->update_max_code('CancelInvoice');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function loadcustomersjson($query) {

        // $query1 = $this->db->select('CusCode,CusName')
        // ->like("CONCAT(' ',customer.CusCode,customer.CusName,customer.MobileNo)", $query, 'left')
        // ->limit(50)->get('customer');
        $query1 =$this->db->select('customer.CusCode,customer.CusName,customer.LastName,CONCAT(CusName) AS text')->from('customer')
        ->join('customer_routes', 'customer_routes.id = customer.RouteId')
        ->like("CONCAT(' ',customer.CusCode,customer.CusName,' ',customer.MobileNo)", $query ,'left')
        ->where('IsActive',1)->limit(50)->get();

        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['text']));
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

    public function getActiveInvoiesByCustomer($table, $q, $location, $cus) {

        if ($cus != '' || $cus != 0) {
            $this->db->select('InvNo,DATE(InvDate) ,InvNetAmount');
            $this->db->like('InvNo', $q)->where('InvIsCancel', 0)->where('InvLocation', $location)->where('InvCustomer', $cus);
        } else {
            $this->db->select('InvNo,DATE(InvDate) ,InvNetAmount');
            $this->db->like('InvNo', $q)->where('InvIsCancel', 0)->where('InvLocation', $location);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['InvNo'] . " | " . $row['DATE(InvDate)'] . " | " . $row['InvNetAmount']));
                $new_row['value'] = htmlentities(stripslashes($row['InvNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadproductjson($query, $sup, $inv, $pl,$invType) {
       
            $query1 = $this->db->select('product.ProductCode,product.Prd_Description,productprice.ProductPrice,product.Prd_UPC AS InvQty')
                            ->from('product')
                            ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
                            ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $query, 'left')
                            ->limit(50)->get();
        
        
//        
        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                if ($row['IsSerial'] == 1) {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description'] . " = Rs." . $row['ProductPrice'] . " , Serial - " . $row['SalesSerialNo']));
                $new_row['serial'] = htmlentities(stripslashes($row['SalesSerialNo']));
                } else {
                $new_row['label'] = htmlentities(stripslashes($row['Prd_Description'] . " = Rs." . $row['ProductPrice']));
                }

                $new_row['value'] = htmlentities(stripslashes($row['ProductCode']));
                if ($sup == 1 && ($inv == '' || $inv == 0)) {
                    $new_row['qty'] = htmlentities(stripslashes('All'));
                } elseif ($sup == 0 && ($inv != '' || $inv != 0)) {
                    $new_row['qty'] = htmlentities(stripslashes($row['InvQty']));
                }
                $new_row['price'] = htmlentities(stripslashes($row['ProductPrice']));
                $new_row['name'] = htmlentities(stripslashes($row['Prd_Description']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function saveReturn($grnHed, $retPay, $post, $grnNo, $totalDisPrecent, $grnCredit,$invDate) {
         $invType = $_POST['invType'];
         $supCode = $post['cuscode'];
         $totalNet = $post['total_amount'];
         $invNo = $post['invoicenumber'];
         $invoiceUser = $post['invUser'];
         $invRemark = $post['remark'];
        $total_Ret_amount = $post['total_amount'];
        $product_codeArr = json_decode($post['product_code']);
        $freeQtyArr = json_decode($post['freeQty']);
        $serial_noArr = json_decode($post['serial_no']);
        $qtyArr = json_decode($post['qty']);
        $sell_priceArr = json_decode($post['unit_price']);
        $cost_priceArr = json_decode($post['cost_price']);
        $total_netArr = json_decode($post['total_net']);
        $price_levelArr = json_decode($post['price_level']);
        $totalAmountArr = json_decode($post['pro_total']);
        $isSerialArr = json_decode($post['isSerial']);
        $pro_nameArr = json_decode($post['proName']);
        $returninvoice_typeArr = json_decode($_POST['reinvoiceType']);
        $location = $post['location'];

        $this->db->trans_start();
        for ($i = 0; $i < count($product_codeArr); $i++) {
            $totalGrnQty = ($qtyArr[$i] + $freeQtyArr[$i]);
            $qtyPrice = $total_netArr[$i] / $qtyArr[$i];
            $grnDtl = array(
                'AppNo' => '1',
                'ReturnNo' => $grnNo,
                'ReturnDate' => $invDate,
                'ProductCode' => $product_codeArr[$i],
                'ProductName' => $pro_nameArr[$i],
                'ReturnQty' => $qtyArr[$i],
                'CostPrice' => $cost_priceArr[$i],
                'SalesPersonID' => '0',
                'PriceLevel' => $price_levelArr[$i],
                'SellingPrice' => $sell_priceArr[$i],
                'ReturnAmount' => $totalAmountArr[$i],
                'SerialNo' => $serial_noArr[$i],
                'ReturnType' => $returninvoice_typeArr[$i]);
            $this->db->insert('returninvoicedtl', $grnDtl);

            //update sales  invoice
            if($invType==1){
                $this->db->update('salesinvoicedtl', array('IsReturn' => 1,'SalesReturnQty' => $qtyArr[$i]), array('SalesProductCode' => $product_codeArr[$i], 'SalesProductName' => $pro_nameArr[$i], 'SalesSerialNo' => $serial_noArr[$i], 'SalesInvNo' => $invNo));
                $this->db->update('salesinvoicehed', array('SalesReturnAmount' => $totalNet), array( 'SalesInvNo' => $invNo));


            }elseif ($invType==2) {
                 //update job  invoice
               $this->db->update('jobinvoicedtl', array('IsReturn' => 1,'JobReturnQty' => $qtyArr[$i]), array('JobCode' => $product_codeArr[$i], 'JobDescription'=>$pro_nameArr[$i] , 'JobInvNo' => $invNo));
                $this->db->update('jobinvoicehed', array('JobReturnAmount' => $totalNet), array( 'JobInvNo' => $invNo));
            }

            //update serial stock
            $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $product_codeArr[$i], 'SerialNo' => $serial_noArr[$i], 'Location' => $location))->get();
            if ($ps->num_rows() > 0) {
                $this->db->update('productserialstock', array('Quantity' => $qtyArr[$i]), array('ProductCode' => $product_codeArr[$i], 'SerialNo' => $serial_noArr[$i], 'Location' => $location));
            } else {
                if ($isSerialArr[$i] == 1) {
                    $this->db->insert('productserialstock', array('ProductCode' => $product_codeArr[$i], 'Location' => $location, 'SerialNo' => $serial_noArr[$i], 'Quantity' => $qtyArr[$i], 'GrnNo' => $grnNo));
                }
            }

            if ($returninvoice_typeArr[$i] == 1) {
               
                // Update price stock
                $this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$product_codeArr[$i]', '$totalGrnQty', '$price_levelArr[$i]', '$cost_priceArr[$i]', '$sell_priceArr[$i]', '$location')");
        
                // Update product stock
                $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr[$i]', '$totalGrnQty', 0, '$location')");

                $this->db->set('NormalReturn', 'COALESCE(NormalReturn, 0) + ' . (int)$qtyArr[$i], FALSE)
                ->where('ProductCode', $product_codeArr[$i])
                ->where('Location', $location)
                ->update('productstock');
       
//                echo $this->db->last_query();
            }

            if ($returninvoice_typeArr[$i] == 2) {
                $this->db
                ->set('Damage', 'COALESCE(Damage, 0) + ' . (int)$qtyArr[$i], FALSE)
                ->where('ProductCode', $product_codeArr[$i])
                ->where('Location', $location)
                ->update('productstock');

                
   
            }

            if ($returninvoice_typeArr[$i] == 3) {
                $this->db->set('Expired', 'COALESCE(Expired ,0) + ' . (int)$qtyArr[$i], FALSE)
                ->where('ProductCode', $product_codeArr[$i])
                ->where('Location', $location)
                ->update('productstock');
   
            }

        }




        //update supplier outstanding
        if ($supCode != '') {
            $isCredit = $this->db->select('CusCode')->from('creditinvoicedetails')->where('CusCode', $supCode)->where('InvoiceNo', $invNo)->where('IsCancel', 0)->where('Type!=', 2)->get();

            if ($isCredit->num_rows() > 0) {
                 $invCredit = array('AppNo' => '1',
                                    'InvoiceNo'=>$invNo,
                                    'Type'=>2,
                                    'InvoiceDate'=>$invDate,
                                    'Location'=>$location,
                                    'CusCode'=>$supCode,
                                    'NetAmount'=>0,
                                    'CreditAmount'=>(0),
                                    'SettledAmount'=>0,
                                    'returnAmount'=>$totalNet,
                                    'IsCloseInvoice'=>0,
                                    'IsCancel'=>0);

                //add credit invoice data
                $this->db->insert('creditinvoicedetails',$invCredit);
            } else {
                $isCredit2 = $this->db->select('CusCode')->from('creditinvoicedetails')->where('CusCode', $supCode)->get();


                if ($isCredit2->num_rows() > 0) {
                     $invCredit = array(
                            'AppNo' => '1',
                            'InvoiceNo'=>$invNo,
                            'Type'=>2,
                            'InvoiceDate'=>$invDate,
                            'Location'=>$location,
                            'CusCode'=>$supCode,
                            'NetAmount'=>0,
                            'CreditAmount'=>(0),
                            'SettledAmount'=>0,
                            'returnAmount'=>$totalNet,
                            'IsCloseInvoice'=>0,
                            'IsCancel'=>0);

                    //add credit invoice data
                    //$this->db->insert('creditinvoicedetails',$invCredit);
                } else {
                     $invCredit = array(
                            'AppNo' => '1',
                            'InvoiceNo'=>$invNo,
                            'Type'=>2,
                            'InvoiceDate'=>$invDate,
                            'Location'=>$location,
                            'CusCode'=>$supCode,
                            'NetAmount'=>0,
                            'CreditAmount'=>(0),
                            'SettledAmount'=>0,
                            'returnAmount'=>$totalNet,
                            'IsCloseInvoice'=>0,
                            'IsCancel'=>0);

                    // $this->db->insert('creditinvoicedetails',$invCredit);

                    //$this->db->insert('supplieroustanding', array('SupCode'=> $supCode,'SupTotalInvAmount'=> $totalNet,'SupOustandingAmount'=>$totalNet,'SupSettlementAmount'=>0,'OpenOustanding'=>0,'OustandingDueAmount'=>0));
                }
            }

            $outstand = $this->db->select('CusOustandingAmount')->from('customeroutstanding')->where('CusCode', $supCode)->get()->row()->CusOustandingAmount;
            if ($outstand > 0 && $isCredit->num_rows() > 0) {

                $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$supCode','$totalNet','$totalNet','0')");
                // echo "CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$supCode','$totalNet','$totalNet','0')";
                 // echo  $totalNet." ".$supCode;die;
            } else {
                //$this->db->insert('supplieroustanding', array('SupCode'=> $supCode,'SupTotalInvAmount'=> $totalNet,'SupOustandingAmount'=>$totalNet,'SupSettlementAmount'=>0,'OpenOustanding'=>0,'OustandingDueAmount'=>0));
            }
        }

//Return Payment
        // sales  invoice

      
        if($invType==1){
         

                $checkComplete = $this->db->select('IsComplete')->from('salesinvoicehed')->where(array('SalesInvNo' => $invNo))->get()->row()->IsComplete;
                $checkPaymentType = $this->db->select('SalesInvType')->from('salesinvoicehed')->where(array('SalesInvNo' => $invNo))->get()->row()->SalesInvType;
                // echo var_dump($checkPaymentType);die;
                $retPay2 = array(
                    'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                    'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_Ret_amount,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 0
                );
                
                $retPayIsCredit = array(
                    'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                    'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_Ret_amount,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 1
                );
                
                if ($checkComplete == 1){
                    
                    if ($checkPaymentType == 3){
                        
                        $this->db->insert('return_payment', $retPayIsCredit);
                        
                    } else {
                        
                        $this->db->insert('return_payment', $retPay2);
                        
                    }
                } else {
    
                    $isSettleMorethanReturn = $this->db->select('*,SUM(creditinvoicedetails.returnAmount) AS ReturnAmount')->from('creditinvoicedetails')->where('creditinvoicedetails.CusCode', $supCode)->where('creditinvoicedetails.InvoiceNo', $invNo)->where('creditinvoicedetails.IsCancel', 0)->group_by('creditinvoicedetails.InvoiceNo')->get()->row();
    
                    $retunrAmount  = $isSettleMorethanReturn->ReturnAmount;
                    $creditAmount  = $isSettleMorethanReturn->CreditAmount;
                    $settledAmount = $isSettleMorethanReturn->SettledAmount;
    
                    $balanceDue = $creditAmount-$settledAmount;
                    $total_amount_return_pay = $retunrAmount - $balanceDue;
                   
                    $retPay1 = array(
                        'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                        'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_amount_return_pay,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 1
                    );
                    
    
                    if ($retunrAmount > $balanceDue) {
                        $this->db->insert('return_payment', $retPay1);
                        $this->db->update('salesinvoicehed', array('IsComplete' => 1), array( 'SalesInvNo' => $invNo));
                        $this->db->update('creditinvoicedetails', array('IsCloseInvoice' => 1), array( 'InvoiceNo' => $invNo,'Type!='=>2));
    
                    } elseif ($retunrAmount == $balanceDue) {
    //                    $this->db->insert('return_payment', $retPay2);
                        $this->db->update('salesinvoicehed', array('IsComplete' => 1), array( 'SalesInvNo' => $invNo));
                        $this->db->update('creditinvoicedetails', array('IsCloseInvoice' => 1), array( 'InvoiceNo' => $invNo,'Type!='=>2));
                    }
    
                }
        } elseif ($invType==2) {
            // job  invoice
            $checkCredit = $this->db->select('JobCreditAmount')->from('jobinvoicehed')->where(array('JobInvNo' => $invNo))->get()->row()->JobCreditAmount;
            if ($checkCredit == 0 || $checkCredit == null){
                $checkPaymentType = 1;
            } else {
                $checkPaymentType = 3;
            }

            $checkComplete = $this->db->select('IsCompelte')->from('jobinvoicehed')->where(array('JobInvNo' => $invNo))->get()->row()->IsCompelte;
            $retPay3 = array(
                    'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                    'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_Ret_amount,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 0
                );

            $retPayIsCreditJob = array(
                'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_Ret_amount,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 1
            );

            if ($checkComplete == 1){

                if ($checkPaymentType == 3) {

                    $this->db->insert('return_payment', $retPayIsCreditJob);

                } else {

                    $this->db->insert('return_payment', $retPay3);
                }
            } else {

                $isSettleMorethanReturn = $this->db->select('*,SUM(creditinvoicedetails.returnAmount) AS ReturnAmount')->from('creditinvoicedetails')->where('creditinvoicedetails.CusCode', $supCode)->where('creditinvoicedetails.InvoiceNo', $invNo)->where('creditinvoicedetails.IsCancel', 0)->group_by('creditinvoicedetails.InvoiceNo')->get()->row();

                $retunrAmount  = $isSettleMorethanReturn->ReturnAmount;
                $creditAmount  = $isSettleMorethanReturn->CreditAmount;
                $settledAmount = $isSettleMorethanReturn->SettledAmount;

                $balanceDue = $creditAmount-$settledAmount;
                $total_amount_return_pay = $retunrAmount - $balanceDue;
                $retPay1 = array(
                    'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                    'InvoiceNo' => $invNo,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_amount_return_pay,'ReturnUser' => $invoiceUser, 'PaymentType' => $checkPaymentType, 'IsOverReturn' => 1
                );

                if ($retunrAmount > $balanceDue) {
                    $this->db->insert('return_payment', $retPay1);
                    $this->db->update('jobinvoicehed', array('IsComplete' => 1), array( 'JobInvNo' => $invNo));
                    $this->db->update('creditinvoicedetails', array('IsCloseInvoice' => 1), array( 'InvoiceNo' => $invNo,'Type!='=>2));
                } elseif ($retunrAmount == $balanceDue) {
//                    $this->db->insert('return_payment', $retPay3);
                    $this->db->update('jobinvoicehed', array('IsComplete' => 1), array( 'JobInvNo' => $invNo));
                    $this->db->update('creditinvoicedetails', array('IsCloseInvoice' => 1), array( 'InvoiceNo' => $invNo,'Type!='=>2));
                }
            }
        }

        $this->db->insert('returninvoicehed', $grnHed);
        $this->update_max_code('Invoice Return');
        if($invNo == 0){
            $retPayIsCredit = array(
                'AppNo' => '1','ReturnNo' => $grnNo,'ReturnLocation' => $location,'ReturnDate' => $invDate,'RootNo' => 0,
                'InvoiceNo' => 0,'InvoiceType' => $invType,'CustomerNo' => $supCode,'Remark' => $invRemark,'ReturnAmount' => $total_Ret_amount,'ReturnUser' => $invoiceUser, 'PaymentType' => 3, 'IsOverReturn' => 0
            );
            //  echo var_dump($retPayIsCredit);die;
            $this->db->insert('return_payment', $retPayIsCredit);
        }

        return  $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getReturnDtlbyid($invNo) {
        $this->db->select('returninvoicedtl.*,product.*');
        $this->db->from('returninvoicedtl');
        $this->db->join('product', 'product.ProductCode = returninvoicedtl.ProductCode', 'left');
        $this->db->where('returninvoicedtl.ReturnNo', $invNo);
        
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

    public function getReceivedDtlbyid($inv) {
        $this->db->select('received_invoices.*,received_invoices_items.*,product.*');
        $this->db->from('received_invoices');
        $this->db->join('received_invoices_items', 'received_invoices_items.InvoiceID = received_invoices.id', 'inner');
        $this->db->join('product', 'product.ProductCode = received_invoices_items.ProductCode', 'left');
        $this->db->where('received_invoices.id', $inv);
        
     
        
        
        $result=$this->db->get();
        // echo var_dump($result);die;
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->ProductCode][] = $row;
        }
        return $list;

    }

}
