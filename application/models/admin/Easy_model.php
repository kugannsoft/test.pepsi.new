<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Easy_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function pricelevel() {
        return $this->db->select()->from('pricelevel')->where('IsActive', 1)->get()->result();
    }

    public function getActiveAccounts($query,$cusType) {
        $q = $this->db->select('account_details.AccNo AS id,CONCAT(" ",account_details.AccNo," ",customer.CusName) AS text,account_details.AccType,customer.CusCode,customer.CreditLimit,customer.CreditPeriod,customer.Nic,customer.CusName,account_details.refNo')
            ->from('account_details')
            ->join('customer','customer.CusCode = account_details.CusCode')
            ->like('CONCAT(" ",account_details.AccNo,customer.Nic," ",account_details.CusCode,customer.CusName)', $query)
            ->where('account_details.IsCreate',0)
            ->where('customer.IsActive',1)
            ->where('customer.CusType_easy',$cusType)
            ->where('customer.IsEasy',1)
            ->get()->result();
        return json_encode($q);
    }

    public function getActiveProductCodes($keyword, $price_level)
    {

        $q2 = $this->db->select('product.ProductCode AS value,product.Prd_Description AS label,productprice.ProductPrice,product.Prd_UPC AS InvQty,product.Prd_CostPrice')
            ->from('product')
            ->join('productprice', 'productprice.ProductCode = product.ProductCode', 'INNER')
            ->like("CONCAT(' ',product.ProductCode,product.Prd_Description)", $keyword, 'left')
            ->where('productprice.PL_No',$price_level)
            ->limit(50)->get()->result();

        return $q2;
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

    public function getHolidayArray($startDate, $endDate)
    {
        $query = $this->db->select('date')->from('holiday_schedule')->where('date >=', $startDate)->where('date <=', $endDate)->get()->result();

        return $query;
    }

    public function saveInvoice($acc_no, $accType, $accCategory, $location, $product_codeArr, $serial_noArr, $qtyArr, $unit_priceArr,
        $discount_precentArr, $pro_discountArr, $total_netArr, $price_levelArr, $extra_dateArr, $extra_descArr, $extra_amountArr,
        $dwn_paymentArr, $dwn_pay_interestArr, $dwn_pay_int_rateArr, $dwn_pay_dateArr, $dwn_is_intArr, $monthArr, $monPayArr, $pricArr,
        $intArr, $balAr, $instalPymentTypes, $acc_no, $down_payment, $qur_payment, $qur_pay_interest, $qur_pay_int_rate, $qur_pay_date,
        $qur_is_int, $tot_extra_chrages, $tot_extra_amount, $isPolishArr, $total_discount, $gross_amount, $int_term, $isSoldArr,
        $int_term_interest, $int_term_rate, $is_int_term, $invDate, $cusCode, $user, $invNo, $chequeNo, $chequeReference, $chequeRecivedDate,
        $chequeDate, $cash_amount, $cheque_amount, $credit_amount, $total_amount, $return_amount, $refund_amount, $invUser, $totalDwnPayment,
        $final_amount, $totalDisPercent,$mothly_payment_date, $holidays) {

        $this->db->trans_start();
        $isComplete = 0;
        // payment is complete
        if ($total_amount >= ($cash_amount + $cheque_amount)) {
            $isComplete = 1;
        }

        $this->db->query("CALL SPT_SAVE_INV_HED('$invNo','$acc_no','$location','$invDate','$accType','$accCategory','$total_amount','$total_discount','$cash_amount','$down_payment','$tot_extra_chrages','$refund_amount','$tot_extra_amount','$totalDwnPayment','$qur_payment','$int_term','$int_term_interest','$int_term_rate','$gross_amount','$int_term','$monPayArr[1]','$invUser',0,0,0,'$final_amount','$totalDisPercent','$instalPymentTypes','$mothly_payment_date',0.00,0.00,0,0.00,'$cusCode');");

        $lastInvAmountQuery = $this->db->query("SELECT CusTotalInvAmount AS invAmount FROM customeroutstanding WHERE CusCode='$cusCode'");
        $lastInv = $lastInvAmountQuery->row()->invAmount;
        $lastInvAmount = $lastInv;
        $newInvoiceAmount = $lastInvAmount + $final_amount;


        $this->db->query("UPDATE customeroutstanding SET CusTotalInvAmount='$newInvoiceAmount' WHERE CusCode='$cusCode'");
//        var_dump($invNo,$acc_no,$accType,$location,$invDate,$product_codeArr,$serial_noArr,$qtyArr,$price_levelArr,$unit_priceArr,$pro_discountArr,$discount_precentArr,$unit_priceArr,$total_netArr);die();
        if (count($product_codeArr) != 0) {

            for ($j = 0; $j < count($product_codeArr); $j++) {
                $m = $j + 1;
                $this->db->query("CALL SPT_SAVE_INV_DTL('$invNo','$acc_no','$accType','$location','$invDate','$product_codeArr[$j]','$serial_noArr[$j]','$m','$qtyArr[$j]','$price_levelArr[$j]','$unit_priceArr[$j]','$unit_priceArr[$j]','$pro_discountArr[$j]','$discount_precentArr[$j]','$unit_priceArr[$j]','$total_netArr[$j]','0');");

//                $this->db->query("CALL SPT_UPDATE_PRO_STOCK('$product_codeArr[$j]','$qtyArr[$j]',0,'$location')");
                $this->db->query("CALL SPP_UPDATE_PRICE_STOCK('$product_codeArr[$j]','$qtyArr[$j]','$price_levelArr[$j]','$unit_priceArr[$j]','$unit_priceArr[$j]','$location','$serial_noArr[$j]','0','0','0')");

            }
        }
//        var_dump(count($product_codeArr));die();
        if (count($extra_amountArr) != 0) {
            for ($e = 0; $e < count($extra_amountArr); $e++) {
                $n = $e + 1;
                $this->db->query("CALL SPT_SAVE_EXTRA_AMOUNT('$invNo','$acc_no','$extra_dateArr[$e]','$extra_descArr[$e]','$extra_amountArr[$e]','','$n');");
            }
        }

        if (count($dwn_paymentArr) != 0) {
            for ($i = 0; $i < count($dwn_paymentArr); $i++) {
                $k = $i + 1;
                $this->db->query("CALL SPT_SAVE_DWN_PAYMENT('$invNo','$k','$dwn_paymentArr[$i]','$dwn_pay_int_rateArr[$i]','$dwn_pay_interestArr[$i]','$dwn_pay_dateArr[$i]','$dwn_is_intArr[$i]');");
            }
        }

                // add cash payment details
                $time2 = strtotime($mothly_payment_date);
                $payment_date_month = date("Y-m-d", strtotime("+1 month", $time2));
                $payment_date_week = date("Y-m-d", strtotime("+1 week", $time2));
                $payment_date_date = date("Y-m-d", strtotime("+1 day", $time2));


                //Monthly
                if ($instalPymentTypes == 1) {
                    for ($l = 0; $l < count($monthArr); $l++) {
                        $this->db->query("CALL SPT_SAVE_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$l]','$monPayArr[$l]','$pricArr[$l]','$intArr[$l]',0,'$balAr[$l]','$payment_date_month');");
                        $payment_date_month = strtotime($payment_date_month);
                        $payment_date_month = date("Y-m-d", strtotime("+1 month", $payment_date_month));
                    }
                //Weekly
                } elseif ($instalPymentTypes == 2) {
                    for ($l = 0; $l < count($monthArr); $l++) {
                        $this->db->query("CALL SPT_SAVE_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$l]','$monPayArr[$l]','$pricArr[$l]','$intArr[$l]',0,'$balAr[$l]','$payment_date_week');");
                        $payment_date_week = strtotime($payment_date_week);
                        $payment_date_week = date("Y-m-d", strtotime("+1 week", $payment_date_week));
                    }
                //Daily $holidays
                } elseif ($instalPymentTypes == 3) {
                    for ($l = 0; $l < count($monthArr); $l++) {

                        if (in_array($payment_date_date,$holidays)){
                            $payment_date_date = strtotime($payment_date_date);
                            $payment_date_date = date("Y-m-d", strtotime("+1 day", $payment_date_date));
                        }
                        $this->db->query("CALL SPT_SAVE_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$l]','$monPayArr[$l]','$pricArr[$l]','$intArr[$l]',0,'$balAr[$l]','$payment_date_date');");
                        $payment_date_date = strtotime($payment_date_date);
                        $payment_date_date = date("Y-m-d", strtotime("+1 day", $payment_date_date));
                    }
                }

                    $rentalRate = 0;
                    $retalDates = 0;
                    $totalBalance = 0;
                    $time = strtotime($mothly_payment_date);
                    $payment_date_month = date("Y-m-d", strtotime("+1 month", $time));
                    $payment_date_week = date("Y-m-d", strtotime("+1 week", $time));
                    $payment_date_date = date("Y-m-d", strtotime("+1 day", $time));

                    //Monthly
                    if ($instalPymentTypes == 1) {
                        for ($s = 0; $s < count($monthArr); $s++) {
                            $totalBalance += $monPayArr[$s];
                            $this->db->query("CALL SPT_SAVE_RENTAL_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$s]','$monPayArr[$s]','$pricArr[$s]','$intArr[$s]',0,'$balAr[$s]','$payment_date_month','$monPayArr[$s]',0,'$monPayArr[$s]','$monPayArr[$s]','$totalBalance','$rentalRate','$retalDates');");
                            $payment_date_month = strtotime($payment_date_month);
                            $payment_date_month = date("Y-m-d", strtotime("+1 month", $payment_date_month));
                        }
                        //Weekly
                    } elseif ($instalPymentTypes == 2) {
                        for ($s = 0; $s < count($monthArr); $s++) {
                            $totalBalance += $monPayArr[$s];
                            $this->db->query("CALL SPT_SAVE_RENTAL_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$s]','$monPayArr[$s]','$pricArr[$s]','$intArr[$s]',0,'$balAr[$s]','$payment_date_week','$monPayArr[$s]',0,'$monPayArr[$s]','$monPayArr[$s]','$totalBalance','$rentalRate','$retalDates');");
                            $payment_date_week = strtotime($payment_date_week);
                            $payment_date_week = date("Y-m-d", strtotime("+1 week", $payment_date_week));
                        }
                        //Daily
                    } elseif ($instalPymentTypes == 3) {
                        for ($s = 0; $s < count($monthArr); $s++) {
                            if (in_array($payment_date_date,$holidays)){
                                $payment_date_date = strtotime($payment_date_date);
                                $payment_date_date = date("Y-m-d", strtotime("+1 day", $payment_date_date));
                            }
                            $totalBalance += $monPayArr[$s];
                            $this->db->query("CALL SPT_SAVE_RENTAL_PAYMENT_DTL('$invNo','$acc_no','$monthArr[$s]','$monPayArr[$s]','$pricArr[$s]','$intArr[$s]',0,'$balAr[$s]','$payment_date_date','$monPayArr[$s]',0,'$monPayArr[$s]','$monPayArr[$s]','$totalBalance','$rentalRate','$retalDates');");
                            $payment_date_date = strtotime($payment_date_date);
                            $payment_date_date = date("Y-m-d", strtotime("+1 day", $payment_date_date));
                        }
                    }

        $this->update_max_code('LoanInvoiceNo');
        $this->db->trans_complete();
        return $this->db->trans_status();

    }

    public function update_max_code($form)
    {
        $query = $this->db->select('*')->where('FormName',$form)->get('codegenerate');
        foreach ($query->result_array() as $row) {
            $input = $row['AutoNumber'];
        }
        $this->db->update('codegenerate',array('AutoNumber'=>($input+1)),array('FormName'=>($form)));
    }

    public function loadAccounts($keyword)
    {
        $q2 = $this->db->select('account_details.*, customer.*, invoice_hed.*')
            ->from('account_details')
            ->join('customer', 'customer.CusCode = account_details.CusCode', 'INNER')
            ->join('invoice_hed', 'invoice_hed.AccNo = account_details.AccNo', 'INNER')
            ->like("CONCAT(' ',account_details.AccNo,customer.Nic)", $keyword, 'left')
            ->where('account_details.IsCreate', 1)
//            ->where('account_details.ItemType !=', 2)
            ->get()->result();

        return $q2;
    }

    public function getRentalPaymentData($accNo)
    {
        $q2 = $this->db->select('rental_payment_dtl.*')
            ->from('rental_payment_dtl')
            ->where('rental_payment_dtl.AccNo', $accNo)
            ->get()->result();

        return $q2;
    }

    public function checkIsReschedule($accNo)
    {
        $q2 = $this->db->select('reschedule.*')
            ->from('reschedule')
            ->where('reschedule.last_account', $accNo)
            ->get()->row();

        return $q2;
    }

    public function getDownPaymentData($invoiceNo)
    {
        $q2 = $this->db->select('down_payment_dtl.*')
            ->from('down_payment_dtl')
            ->where('down_payment_dtl.InvNo', $invoiceNo)
            ->order_by('down_payment_dtl.PaymentDate', 'ASC')
            ->get()->row();

        return $q2;
    }

    public function getRentalExtraAmount($invoiceNo)
    {
        $q2 = $this->db->select('rental_extra_amount.*')
            ->from('rental_extra_amount')
            ->where('rental_extra_amount.InvNo', $invoiceNo)
            ->order_by('rental_extra_amount.PayDate', 'ASC')
            ->get()->row();

        return $q2;
    }

    public function getPaymentDataByAccNo($invoiceNo)
    {
        $q2 = $this->db->select('rental_paid.*, paytype.*')
            ->from('rental_paid')
            ->join('paytype', 'paytype.payTypeId = rental_paid.PaymentType', 'INNER')
            ->where('rental_paid.InvNo', $invoiceNo)
            ->where('rental_paid.IsCancel', 0)
            ->order_by('rental_paid.PayDate', 'ASC')
            ->get()->result();

        return $q2;
    }

    public function paymentType()
    {
        return $this->db->select()->from('paytype')->get()->result();
    }

    public function getPenaltySetting()
    {
        return $this->db->select()->from('penalty_setting')->get()->row();
    }

    public function addCustomerPayment($paymentNo, $invNo,$accNo, $payType, $payDate, $payAmount, $cusCode, $chequeNo, $chequeReference, $chequeRecivedDate, $chequeDate, $settle_amount, $isInvoiceColse, $credit_invoiceArr, $cus_settle_amountArr,$cus_credit_amountArr, $total_settle,$cash_amount,$cheque_amount,$cus_inv_paymentArr,$rental_default,$over_pay_amount,$over_pay_inv,$month,$extra_amount,$insu_amount,$invDate,$extAmounts,$totalPaidAmount,$totalDueAmount)
    {
        $this->db->trans_start();

        $this->db->query("CALL SPT_SAVE_RENTAL_PAID('$paymentNo','$payType','$payDate','$invNo','$cusCode','$chequeRecivedDate','$chequeDate','$chequeReference','$total_settle','$settle_amount','$isInvoiceColse','$chequeNo','$cash_amount','$cheque_amount','$over_pay_amount','$over_pay_inv','$extra_amount', '$insu_amount','$invDate','$accNo');");

        for ($a = 0; $a < count($month); $a++) {
            if ($cus_inv_paymentArr[$a] != 0) {
                $this->db->query("CALL SPT_SAVE_RENTAL_PAID_DTL('$paymentNo','$payType','$invNo','$cus_inv_paymentArr[$a]','$month[$a]','$accNo');");
            }
        }

        //update rental details
        for ($p = 0; $p < count($month); $p++) {
            $isPaid = 0;
            if ($cus_credit_amountArr[$p] <= $cus_settle_amountArr[$p]) {
                $isPaid = 1;
            }
            $this->db->query("CALL SPT_UPDATE_RENTAL('$invNo','$accNo','$rental_default[$p]','$cus_credit_amountArr[$p]','$cus_credit_amountArr[$p]','$cus_settle_amountArr[$p]', '$month[$p]','$isPaid','$extAmounts[$p]','$totalPaidAmount','$totalDueAmount');");
        }

        $this->update_max_code('LoanPaymentNo');
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function addDownPayment($paymentNo, $invNo, $accNo, $payType, $payDate, $payAmount, $cusCode, $chequeNo, $chequeReference, $chequeRecivedDate, $chequeDate, $settle_amount, $isInvoiceColse, $credit_invoiceArr, $cus_settle_amountArr, $cus_credit_amountArr, $total_settle, $cash_amount, $cheque_amount, $cus_inv_paymentArr, $rental_default, $over_pay_amount, $over_pay_inv, $month, $extra_amount, $insu_amount,$invDate,$extAmounts)
    {

        $this->db->trans_start();

        $this->db->query("CALL SPT_SAVE_DOWN_PAID('$paymentNo','$payType','$payDate','$invNo','$cusCode','$chequeRecivedDate','$chequeDate','$chequeReference','$total_settle','$settle_amount','$isInvoiceColse','$chequeNo','$cash_amount','$cheque_amount','$over_pay_amount','$over_pay_inv','$extra_amount', '$insu_amount','$invDate','$accNo');");

            for ($a = 0; $a < count($month); $a++) {
                if ($cus_inv_paymentArr[$a] != 0) {
                    $this->db->query("CALL SPT_SAVE_DOWN_PAID_DTL('$paymentNo','$payType','$invNo','$cus_inv_paymentArr[$a]','$month[$a]','$accNo');");
                }
            }

            //update rental details
            for ($p = 0; $p < count($month); $p++) {
                $isPaid = 0;
                if ($cus_credit_amountArr[$p] <= $cus_settle_amountArr[$p]) {
                    $isPaid = 1;
                }
                $this->db->query("CALL SPT_UPDATE_DOWN('$invNo','$accNo','$rental_default[$p]','$cus_credit_amountArr[$p]','$cus_credit_amountArr[$p]','$cus_settle_amountArr[$p]', '$month[$p]','$isPaid','$extAmounts[$p]');");
            }

        $this->update_max_code('DwPayNo');
        $this->db->trans_complete();
        return $this->db->trans_status();

    }

    public function addRescheduleAccount($accId,$accNo,$accCode, $cusCode, $cusNic, $acc_date, $remark, $acc_type, $acc_category, $location, $inv_user, $guarantNicArr, $guarantCodeArr, $invDate, $cusCode_last, $acc_no_last, $finale_balance)
    {
        $this->db->trans_start();

        $this->db->query("CALL SPM_SAVE_ACCOUNT('$accNo','$acc_date','$cusCode','$acc_type','$acc_category','$cusNic','$location','$remark','$inv_user','$accId');");

        if (count($guarantCodeArr) != 0) {

            for ($i = 0; $i < count($guarantCodeArr); $i++) {
                $gNo = $i + 1;
                $this->db->query("CALL SPM_SAVE_ACC_GUARANTEE('$accNo','$guarantNicArr[$i]','$guarantCodeArr[$i]','$gNo');");
            }
        }

        $getLastAccId = $this->getLastRecord();
        $newAcc = array(
            'id' => null,
            're_date' => $invDate,
            're_cus' => $cusCode_last,
            're_account' => $getLastAccId,
            'last_account' => $acc_no_last,
            're_amount' => $finale_balance,
        );

        $this->db->insert('reschedule', $newAcc);

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getLastRecord()
    {
        $q2 = $this->db->select('AccNo')->from('account_details')->order_by('AccId', 'DESC')->limit(1)->get()->row();

        return $q2->AccNo;
    }

    public function getPaymentDataByAccountNo($ac_no)
    {
        $q2 = $this->db->select('rental_paid.*, paytype.*')
            ->from('rental_paid')
            ->join('paytype', 'paytype.payTypeId = rental_paid.PaymentType', 'INNER')
            ->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER')
            ->where('rental_paid.AccNo', $ac_no)
            ->where('rental_paid.IsCancel', 0)
            ->order_by('rental_paid.PayDate', 'ASC')
            ->get()->result();

        return $q2;
    }

    public function invoicePrint($ac_no)
    {
        $q2 = $this->db->select('item_payment_dtl.*')
            ->from('item_payment_dtl')
            ->where('item_payment_dtl.AccNo', $ac_no)
            ->order_by('item_payment_dtl.Month', 'ASC')
            ->get()->result();

        return $q2;
    }

    public function getInvoiceDetailsByNo($ac_no)
    {
        $q2 = $this->db->select('invoice_dtl.*, invoice_hed.*, customer.CusName, product.*, account_details.AccDate')
            ->from('invoice_dtl')
            ->join('invoice_hed', 'invoice_hed.InvNo = invoice_dtl.InvNo', 'INNER')
            ->join('account_details', 'account_details.AccNo = invoice_hed.AccNo', 'INNER')
            ->join('customer', 'customer.CusCode = account_details.CusCode', 'INNER')
            ->join('product', 'product.ProductCode = invoice_dtl.InvProductCode', 'INNER')
            ->where('invoice_hed.AccNo', $ac_no)
            ->get()->result();

        return $q2;
    }

    public function getInvoiceByNo($ac_no)
    {
        $q2 = $this->db->select('invoice_hed.*,customer.*,account_details.AccDate,account_details.refNo')
            ->from('invoice_hed')
            ->join('account_details', 'account_details.AccNo = invoice_hed.AccNo', 'INNER')
            ->join('customer', 'customer.CusCode = account_details.CusCode', 'INNER')
            ->where('invoice_hed.AccNo', $ac_no)
            ->get()->row();

        return $q2;
    }

    public function getGuranteeDataByNo($ac_no)
    {
        $q2 = $this->db->select('customer.*')
            ->from('customer')
            ->join('acc_gurantee', 'acc_gurantee.GuranteeCode = customer.CusCode', 'INNER')
            ->where('acc_gurantee.AccNo', $ac_no)
            ->get()->result();

        return $q2;
    }

    public function getReceiptHed($invNo)
    {

        $q2 = $this->db->select('rental_paid.*,customer.*,paytype.payType,')
            ->from('rental_paid')
            ->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER')
            ->join('paytype', 'paytype.payTypeId = rental_paid.PaymentType', 'INNER')
            ->where('rental_paid.InvNo', $invNo)
            ->order_by('rental_paid.PaymentId', 'DESC')
            ->limit(1)
            ->get()->row();
        return $q2;
    }

    public function getReceiptHedByReceiptId($invNo)
    {

        $q2 = $this->db->select('rental_paid.*,customer.*,paytype.payType,')
            ->from('rental_paid')
            ->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER')
            ->join('paytype', 'paytype.payTypeId = rental_paid.PaymentType', 'INNER')
            ->where('rental_paid.PaymentId', $invNo)
            ->get()->row();
        return $q2;
    }
    
    public function getActiveEasyPayment($keyword,$accNo)
    {
        $q2 = $this->db->select('rental_paid.*,customer.*')
            ->from('rental_paid')
            ->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER')
            ->like("CONCAT(' ',rental_paid.PaymentId)", $keyword, 'left')
            ->where('rental_paid.AccNo', $accNo)
            ->where('rental_paid.IsCancel', 0)
            ->order_by('rental_paid.PaymentId', 'DESC')
            ->limit(1)
            ->get()->result();
        return $q2;
    }

    public function getEasyPaymentDataById($paymentId)
    {
        $q2 = $this->db->select('rental_paid.*,customer.*,rental_paid_dtl.*')
            ->from('rental_paid')
            ->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER')
            ->join('rental_paid_dtl', 'rental_paid_dtl.PaymentId = rental_paid.PaymentId', 'INNER')
            ->where('rental_paid.PaymentId', $paymentId)
            ->where('rental_paid.IsCancel', 0)
            ->get()->result();
        return $q2;
    }

    public function cancelEasyPayment($paymentId, $remark, $invUser, $canDate, $cusCode, $invno, $cus_settle_amountArr, $credit_invoiceArr,$monthArr)
    {
        $this->db->trans_start();

        for ($p = 0; $p < count($cus_settle_amountArr); $p++) {
            $this->db->query("CALL SPT_UPDATE_RENTAL_INVOICE('$credit_invoiceArr[$p]','$cus_settle_amountArr[$p]','$monthArr[$p]')");
        }

        $this->db->query("CALL SPT_CANCEL_EASY_PAYMENT('$canDate','$paymentId','$invUser','$remark','$cusCode','$invno')");

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}