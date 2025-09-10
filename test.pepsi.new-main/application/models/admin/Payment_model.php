<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

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
    
    public function loadcustomersjson2($query) {
        $q = $this->db->select('CusCode AS id,CusName AS text')->from('customer')->like('CusName', $query, 'after')->where('IsActive',1)->get()->result();
        return json_encode($q);
    }
    
    public function loadsupplierjson($query) {
        $q = $this->db->select('SupCode AS id,SupName AS text')->from('supplier')->like('SupName', $query, 'after')->get()->result();
        return json_encode($q);
    }
    
    public function loadbankjson($query) {
        $q = $this->db->select('BankCode AS id,BankName AS text')->from('bank')->like('BankName', $query, 'after')->get()->result();
        return json_encode($q);
    }

    public function loadcustomersjson($query) {

        // $query1 =$this->db->select('CusCode,CusName')->like("CONCAT(' ',customer.CusCode,customer.CusName,customer.MobileNo)", $query ,'left')->limit(50)->get('customer');

        $query1 =$this->db->select('customer.CusCode,customer.CusName,customer.LastName')->from('customer')
            ->like("CONCAT(' ',customer.CusCode,customer.CusName,' ',customer.MobileNo)", $query ,'left')
            ->where('IsActive',1)
            ->limit(50)->get();

        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                // $new_row['label'] = htmlentities(stripslashes($row['CusName']));
                $name = $row['CusName'];
                $new_row['label'] = htmlentities(stripslashes($name));
                $new_row['value'] = htmlentities(stripslashes($row['CusCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }


    public function getCustomersDataById($cusCode) {
        return $this->db->select('customer.*,customeroutstanding.*,customer_routes.name,salespersons.RepName')
        ->from('customer')
        ->join('customeroutstanding', 'customer.CusCode = customeroutstanding.CusCode')
        ->join('salespersons', 'customer.HandelBy = salespersons.RepId')
        ->join('customer_routes', 'customer.RouteId = customer_routes.id')
        ->where('customer.CusCode', $cusCode)
        ->get()->row();
    }



    public function getCustomersCreditDataById($cusCode) {
//        $q= $this->db->query("SELECT C.AppNo,C.Type,C.InvoiceDate,C.InvoiceNo,C.Location,C.CusCode,C.NetAmount,C.CreditAmount,C.SettledAmount,C.IsCloseInvoice,C.IsCancel,IFNULL(R.ReturnAmount,0) As ReturnAmount FROM `creditinvoicedetails` C 
// LEFT JOIN 
// (
// SELECT InvoiceNo,SUM(ReturnAmount) AS ReturnAmount FROM returninvoicehed WHERE IsCancel=0 GROUP BY InvoiceNo
// ) R ON R.InvoiceNo=C.InvoiceNo
// WHERE C.`CusCode` = '$cusCode' AND C.`IsCloseInvoice` =0 AND C.`IsCancel` =0 AND C.`Type` != 2  ");
        return $this->db->select('*,SUM(creditinvoicedetails.returnAmount) AS ReturnAmount')->from('creditinvoicedetails')
                        ->where('creditinvoicedetails.CusCode', $cusCode)
                        ->where('creditinvoicedetails.IsCloseInvoice', 0)
                        ->where('creditinvoicedetails.IsCancel', 0)
                        ->group_by('creditinvoicedetails.InvoiceNo')
                        ->get()->result();
       // return $q->result();
    }

    public function getCustomersReturnDataById($cusCode) {
//        $q= $this->db->query("SELECT C.AppNo,C.Type,C.InvoiceDate,C.InvoiceNo,C.Location,C.CusCode,C.NetAmount,C.CreditAmount,C.SettledAmount,C.IsCloseInvoice,C.IsCancel,IFNULL(R.ReturnAmount,0) As ReturnAmount FROM `creditinvoicedetails` C 
// LEFT JOIN 
// (
// SELECT InvoiceNo,SUM(ReturnAmount) AS ReturnAmount FROM returninvoicehed WHERE IsCancel=0 GROUP BY InvoiceNo
// ) R ON R.InvoiceNo=C.InvoiceNo
// WHERE C.`CusCode` = '$cusCode' AND C.`IsCloseInvoice` =0 AND C.`IsCancel` =0 AND C.`Type` != 2  ");
        return $this->db->select('*')->from('creditinvoicedetails')
                        ->where('creditinvoicedetails.CusCode', $cusCode)
                        // ->where('creditinvoicedetails.IsCloseInvoice', 0)
                        ->where('creditinvoicedetails.IsCancel', 0)
                        ->where('creditinvoicedetails.Type=', 2)
                        ->get()->result();
       // return $q->result();
    }
    
   
    public function loadlocations(){
        return $this->db->select()->from('location')->get()->result();
    }
    
    public function customerPayment($cpHed,$cpDtl,$post,$paymentNo,$chqDtl) {
        $credit_invoiceArr = json_decode($post['credit_invoice']);
        $cus_settle_amountArr = json_decode($post['cus_settle_amount']);
        $cus_credit_amountArr = json_decode($post['cus_credit_amount']);
        $cus_inv_paymentArr = json_decode($post['cus_inv_payment']);
        $cusCode = $cpHed['CusCode'];
        $payAmount =$_POST['payAmount'];
        
        $this->db->trans_start();         
        //update customer payment
        $this->db->insert('customerpaymenthed', $cpHed);
        //update customer payment
        $this->db->insert('customerpaymentdtl', $cpDtl);
        if ($post['receiptType'] == 1){
            //update customer outstanding
            $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cusCode','0','$payAmount',1)");
        }
        //cheque details
        if ($post['payType'] == 3){
            $this->db->insert('chequedetails', $chqDtl);
        }
        //advance release
        if ($post['payType'] == 5){
            $this->db->update('customerpaymentdtl',array('IsRelease'=>1),array('CusPayNo'=>$_POST['advance_payment_no']));
        }
        //return release
        if ($post['payType'] == 4){
           
            $completeDate = date("Y-m-d H:i:s");
            $this->db->update('returninvoicehed',array('IsComplete'=>1, 'Compete_date'=>$completeDate),array('ReturnNo'=>$_POST['return_payment_no']));
        }
        
        for ($i = 0; $i < count($credit_invoiceArr); $i++) {
            $cinvDtl = array(
                'CusPayNo' => $paymentNo,
                'InvNo' => $credit_invoiceArr[$i],
                'CreditAmount' => $cus_credit_amountArr[$i],
                'SettledAmount' => $cus_settle_amountArr[$i],
                'PayAmount' => $cus_inv_paymentArr[$i]);
            if ($cus_inv_paymentArr[$i] >0) {
            $this->db->insert('invoicesettlementdetails', $cinvDtl);
            }
            
            if ($cus_settle_amountArr[$i] >= $cus_credit_amountArr[$i]) {
                $isClose = 1;
            } else {
                $isClose = 0;
            }
            // update credit invoice
            $this->db->update('creditinvoicedetails',array('SettledAmount'=>$cus_settle_amountArr[$i],'IsCloseInvoice'=>$isClose),array('InvoiceNo'=>($credit_invoiceArr[$i]),'Type!='=>2));
            
            $isSalesInv = $this->db->select('SalesInvNo')->from('salesinvoicehed')->where('SalesInvNo', $credit_invoiceArr[$i])->get()->num_rows();
            $isJobInv = $this->db->select('JobInvNo')->from('jobinvoicehed')->where('JobInvNo', $credit_invoiceArr[$i])->get()->num_rows();
            
             //close salesinvoice
            if($isSalesInv>0){
                $this->db->update('salesinvoicehed',array('IsComplete'=>$isClose),array('SalesInvNo'=>($credit_invoiceArr[$i])));
            }

            //close jobinvoice
            if($isJobInv>0){
                $this->db->update('jobinvoicehed',array('IsCompelte'=>$isClose),array('JobInvNo'=>($credit_invoiceArr[$i])));
            }
            
        }
        
        $this->update_max_code('Customer Payment');

        $this->db->trans_complete();
       return $this->db->trans_status();
    }
    
    public function cancelCusPayment($cancelNo,$location,$canDate,$paymentNo,$remark,$user,$customer) {
        $this->db->trans_start();
        $this->db->query("CALL SPT_CANCEL_CUSTOMER_PAYMENT('$canDate','$paymentNo','$user','$remark','$customer','$cancelNo','$location')");
        
        $this->update_max_code('Cancel Cus Payments');
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



    public function getActiveCusPayment($table, $q,$location,$cusCode) {
        
        $this->db->select('CusPayNo');
        $this->db->like('CusPayNo', $q)
        ->where('IsCancel', 0)
        ->where('CusCode', $cusCode)
        ->where('Location', $location)
        ->order_by('CusPayNo', 'DESC');

        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['CusPayNo']));
                $new_row['value'] = htmlentities(stripslashes($row['CusPayNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function getActiveSupPayment($table, $q,$location,$cusCode) {
        $this->db->select('SupPayNo');
        $this->db->like('SupPayNo', $q)->where('IsCancel', 0)->where('SupCode', $cusCode)->where('Location', $location)->order_by('SupPayNo', 'DESC');
        
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['SupPayNo']));
                $new_row['value'] = htmlentities(stripslashes($row['SupPayNo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    
    public function loadCusPaymentById($inv) {
        return $this->db->select('customerpaymentdtl.*,bank.BankName,customerpaymenthed.AvailableOustanding,customerpaymenthed.TotalPayment AS totalAmount')->from('customerpaymentdtl')
                        ->where('customerpaymentdtl.CusPayNo', $inv)
                        ->join('customerpaymenthed', 'customerpaymenthed.CusPayNo = customerpaymentdtl.CusPayNo')
                        ->join('bank', 'bank.BankCode = customerpaymentdtl.BankNo','left')
                        ->get()->result();
    }

    public function loadsuppliersjson($query) {
     
        $query1 =$this->db->select('SupCode,SupName')->like("CONCAT(' ',supplier.SupCode,supplier.SupName,supplier.MobileNo)", $query ,'left')->where('IsActive',1)->get('supplier');
       
        if ($query1->num_rows() > 0) {
            foreach ($query1->result_array() as $row) {
                $new_row['label'] = htmlentities(stripslashes($row['SupName']));
                $new_row['value'] = htmlentities(stripslashes($row['SupCode']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set); //format the array into json data
        }
    }

    public function loadSupPaymentById($inv) {
        return $this->db->select('supplierpaymentdtl.*,bank.BankName,supplierpaymenthed.AvailableOustanding,supplierpaymenthed.TotalPayment AS totalAmount')->from('supplierpaymentdtl')
            ->where('supplierpaymentdtl.SupPayNo', $inv)
            ->join('supplierpaymenthed', 'supplierpaymenthed.SupPayNo = supplierpaymentdtl.SupPayNo')
            ->join('bank', 'bank.BankCode = supplierpaymentdtl.BankNo','left')
            ->get()->result();
    }

    public function supplierPayment($cpHed,$cpDtl,$post,$paymentNo,$chqDtl) {
        
        $credit_invoiceArr = json_decode($post['credit_invoice']);
        $cus_settle_amountArr = json_decode($post['cus_settle_amount']);
        $cus_credit_amountArr = json_decode($post['cus_credit_amount']);
        $cus_inv_paymentArr = json_decode($post['cus_inv_payment']);
        $cusCode = $cpHed['SupCode'];
        $payAmount =$_POST['payAmount'];
        
        $this->db->trans_start();
         
         //update customer payment
        $this->db->insert('supplierpaymenthed', $cpHed);
        //update customer payment
        $this->db->insert('supplierpaymentdtl', $cpDtl);
        //update customer outstanding
        $this->db->query("CALL SPT_UPDATE_SUPOUTSTAND_RBACK('$cusCode','0','$payAmount')");
        //cheque details
        if ($post['payType'] == 3){
            $this->db->insert('chequedetails', $chqDtl);
        }
        
        for ($i = 0; $i < count($credit_invoiceArr); $i++) {
            $cinvDtl = array(
                'SupPayNo' => $paymentNo,
                'GRNNo' => $credit_invoiceArr[$i],
                'CreditAmount' => $cus_credit_amountArr[$i],
                'SettledAmount' => $cus_settle_amountArr[$i],
                'PayAmount' => $cus_inv_paymentArr[$i]);
            if ($cus_settle_amountArr[$i] >0) {
            $this->db->insert('grnsettlementdetails', $cinvDtl);
            }
            
            if ($cus_settle_amountArr[$i] >= $cus_credit_amountArr[$i]) {
                $isClose = 1;
            } else {
                $isClose = 0;
            }
            // update credit invoice
            $this->db->update('creditgrndetails',array('SettledAmount'=>$cus_settle_amountArr[$i],'IsCloseGRN'=>$isClose),array('GRNNo'=>($credit_invoiceArr[$i])));
            
        }
        
        $this->update_max_code('Supplier Payment');

        $this->db->trans_complete();
       return $this->db->trans_status();
    }


    
    

    public function cancelSupPayment($cancelNo,$location,$canDate,$paymentNo,$remark,$user,$customer) {
        $this->db->trans_start();
        $this->db->query("CALL SPT_CANCEL_SUPPLIER_PAYMENT('$canDate','$paymentNo','$user','$remark','$customer','$cancelNo','$location')");
        
        $this->update_max_code('CancelSupPayment');
        $this->db->trans_complete();
       return $this->db->trans_status();
    }

    public function convert_number_to_words($number) {

                        $hyphen = ' ';
                        $conjunction = ' and ';
                        $separator = ' ';
                        $negative = 'negative ';
                        $decimal = ' point ';
                        $dictionary = array(
                            0 => 'zero',
                            1 => 'one',
                            2 => 'two',
                            3 => 'three',
                            4 => 'four',
                            5 => 'five',
                            6 => 'six',
                            7 => 'seven',
                            8 => 'eight',
                            9 => 'nine',
                            10 => 'ten',
                            11 => 'eleven',
                            12 => 'twelve',
                            13 => 'thirteen',
                            14 => 'fourteen',
                            15 => 'fifteen',
                            16 => 'sixteen',
                            17 => 'seventeen',
                            18 => 'eighteen',
                            19 => 'nineteen',
                            20 => 'twenty',
                            30 => 'thirty',
                            40 => 'fourty',
                            50 => 'fifty',
                            60 => 'sixty',
                            70 => 'seventy',
                            80 => 'eighty',
                            90 => 'ninety',
                            100 => 'hundred',
                            1000 => 'thousand',
                            1000000 => 'million',
                            1000000000 => 'billion',
                            1000000000000 => 'trillion',
                            1000000000000000 => 'quadrillion',
                            1000000000000000000 => 'quintillion'
                        );

                        if (!is_numeric($number)) {
                            return false;
                        }

                        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                            // overflow
                            trigger_error(
                                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
                            );
                            return false;
                        }

                        if ($number < 0) {
                            return $negative . $this->convert_number_to_words(abs($number));
                        }

                        $string = $fraction = null;

                        if (strpos($number, '.') !== false) {
                            list($number, $fraction) = explode('.', $number);
                        }

                        switch (true) {
                            case $number < 21:
                                $string = $dictionary[$number];
                                break;
                            case $number < 100:
                                $tens = ((int) ($number / 10)) * 10;
                                $units = $number % 10;
                                $string = $dictionary[$tens];
                                if ($units) {
                                    $string .= $hyphen . $dictionary[$units];
                                }
                                break;
                            case $number < 1000:
                                $hundreds = $number / 100;
                                $remainder = $number % 100;
                                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                                if ($remainder) {
                                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                                }
                                break;
                            default:
                                $baseUnit = pow(1000, floor(log($number, 1000)));
                                $numBaseUnits = (int) ($number / $baseUnit);
                                $remainder = $number % $baseUnit;
                                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                                if ($remainder) {
                                    $string .= $remainder < 100 ? $conjunction : $separator;
                                    $string .= $this->convert_number_to_words($remainder);
                                }
                                break;
                        }

                        if (null !== $fraction && is_numeric($fraction)) {
                            $string .= $decimal;
                            $words = array();
                            foreach (str_split((string) $fraction) as $number) {
                                $words[] = $dictionary[$number];
                            }
                            $string .= implode(' ', $words);
                        }

                        return $string;
                    }
    
}
