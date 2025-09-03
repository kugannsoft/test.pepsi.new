<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function loadroot() {
        $this->db->select();
        $this->db->from('location');
        return $this->db->get()->result();
    }

    public function loadroute(){
        $this->db->select();
        $this->db->from('customer_routes');
        return $this->db->get()->result();
    }

    public function loademployee(){
        $this->db->select();
        $this->db->from('salespersons');
        return $this->db->get()->result();
    }

    public function loadproduct() {
        $this->db->select('ProductCode,Prd_Description');
        $this->db->from('product');
        return $this->db->get()->result();
    }

    public function loadSerialProduct() {
        $this->db->select('product.ProductCode,product.Prd_Description');
        $this->db->from('product');
        $this->db->join('productcondition', 'productcondition.ProductCode = product.ProductCode', 'INNER');
        $this->db->where('productcondition.IsSerial', 1);
        return $this->db->get()->result();
    }

    public function orderreportbydatewise($startdate, $enddate, $location = NULL,$locationAr = NULL,$invtype,$salesperson= NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('customer.CusCode,customer.MobileNo,DATE(customerorderhed.PO_Date) As InvDate,(customerorderhed.PO_TDisAmount) AS DisAmount,customerorderhed.PO_No,customerorderhed.IsComplate,customerorderhed.IsCancel,
                                (customerorderhed.PO_Amount) AS InvAmount,
                                (customerorderhed.POVatAmount) AS VatAmount,
                                (customerorderhed.PONbtAmount) AS NbtAmount,
                                (customerorderhed.PO_NetAmount) AS NetAmount,
                                customer.CusName,customer.RespectSign');
            $this->db->from('customerorderhed');
            $this->db->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER');
            // $this->db->join('salesinvoicedtl', 'salesinvoicedtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
//            $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = salesinvoicehed.SalesInvNo', 'left');
            $this->db->where('DATE(customerorderhed.PO_Date) <=', $enddate);
            $this->db->where('DATE(customerorderhed.PO_Date) >=', $startdate);
            $this->db->where_in('customerorderhed.PO_Location', $locationAr);
            $this->db->where('customerorderhed.IsCancel', 0);
//            if (isset($invtype) && $invtype != '') {
//                $this->db->where('salesinvoicehed.SalesInvType', $invtype);
//            }

//            if (isset($salesperson) && $salesperson != '') {
//                $this->db->where('salesinvoicehed.SalesPerson', $salesperson);
//            }

            // $this->db->group_by('DATE(SalesInvNo)');
            $this->db->order_by('customerorderhed.PO_Date', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('customer.CusCode,customer.MobileNo,DATE(customerorderhed.PO_Date) As InvDate,(customerorderhed.PO_TDisAmount) AS DisAmount,customerorderhed.PO_No,,customerorderhed.IsComplate,customerorderhed.IsCancel,
                                (customerorderhed.PO_Amount) AS InvAmount,
                                (customerorderhed.POVatAmount) AS VatAmount,
                                (customerorderhed.PONbtAmount) AS NbtAmount,
                                (customerorderhed.PO_NetAmount) AS NetAmount,
                                customer.CusName,customer.RespectSign');
            $this->db->from('customerorderhed');
            $this->db->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER');
            // $this->db->join('salesinvoicedtl', 'salesinvoicedtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
//            $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = salesinvoicehed.SalesInvNo', 'left');
            $this->db->where('DATE(customerorderhed.PO_Date) <=', $enddate);
            $this->db->where('DATE(customerorderhed.PO_Date) >=', $startdate);
            $this->db->where('customerorderhed.IsCancel', 0);
//            if (isset($invtype) && $invtype != '') {
//                $this->db->where('salesinvoicehed.SalesInvType', $invtype);
//            }

//            if (isset($salesperson) && $salesperson != '') {
//                $this->db->where('salesinvoicehed.SalesPerson', $salesperson);
//            }


            $this->db->order_by('customerorderhed.PO_Date', 'DESC');
            // $this->db->group_by('salesinvoicehed.SalesInvNo');
            // $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

 
    public function gensalesreportbyroute($startdate, $enddate,$invtype,$salesperson,$routeAr,$customer) {
      
            $this->db->select('customer.CusCode,customer.MobileNo,DATE(salesinvoicehed.SalesDate) As InvDate,(salesinvoicehed.SalesDisAmount) AS DisAmount,salesinvoicehed.SalesInvNo,
                                (salesinvoicehed.SalesCashAmount) AS CashAmount,
                                (salesinvoicehed.SalesCCardAmount) AS CCardAmount,
                                (salesinvoicehed.SalesCreditAmount) AS CreditAmount,
                                (salesinvoicehed.SalesGiftVAmount) AS GiftVAmount,
                                (salesinvoicehed.SalesLoyaltyAmount) AS LoyaltyAmount,
                                (salesinvoicehed.SalesStarPoints) AS StarPoints,
                                (salesinvoicehed.SalesChequeAmount) As ChequeAmount,
                                (salesinvoicehed.SalesInvAmount) AS InvAmount,
                                (salesinvoicehed.SalesVatAmount) AS VatAmount,
                                (salesinvoicehed.SalesNbtAmount) AS NbtAmount,
                                (salesinvoicehed.SalesNetAmount) AS NetAmount,
                                (salesinvoicehed.SalesAdvancePayment) AS AdvanceAmount,
                                (salesinvoicehed.SalesCustomerPayment) AS CustomerPayment,
                                (salesinvoicehed.SalesCostAmount) AS CostAmount,
                                (salesinvoicehed.SalesReturnAmount) AS ReturnAmount,customer.CusName,
                                salesinvoicehed.SalesPerson,
                                salesinvoicehed.RouteId,
                                salesinvoicehed.SalesCustomer,
                                customer.RespectSign,creditinvoicedetails.SettledAmount');
            $this->db->from('salesinvoicehed');
            $this->db->join('customer', 'customer.CusCode = salesinvoicehed.SalesCustomer', 'INNER');
            // $this->db->join('salesinvoicedtl', 'salesinvoicedtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = salesinvoicehed.SalesInvNo', 'left');
            $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
            $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
            
            
            $this->db->where('salesinvoicehed.InvIsCancel', 0);
            if (isset($invtype) && $invtype != '') {
                $this->db->where('salesinvoicehed.SalesInvType', $invtype);
            }
            
            if (isset($salesperson) && $salesperson != '') {
                $this->db->where('salesinvoicehed.SalesPerson', $salesperson);
            }

            if (isset($routeAr) && $routeAr != '') {
                $this->db->where_in('salesinvoicehed.RouteId', $routeAr);
            }

            if (isset($customer) && $customer != '') {
                $this->db->where('salesinvoicehed.SalesCustomer', $customer);
            }

            // $this->db->group_by('DATE(SalesInvNo)');
             $this->db->order_by('salesinvoicehed.SalesDate', 'DESC');
            // $this->db->limit(50);
        
        return $this->db->get()->result();
    }


    public function gensalesreportbyrouteforproduct($startdate, $enddate, $location = NULL, $locationAr = NULL, $invtype, $salesperson = NULL, $product = NULL, $department = NULL, $subdepartment = NULL) {
        // Select columns
        $this->db->select('customer.CusCode, customer.MobileNo, DATE(salesinvoicehed.SalesDate) AS InvDate, 
                       salesinvoicedtl.SalesDisValue AS DisAmount, salesinvoicehed.SalesInvNo,
                       salesinvoicedtl.SalesTotalAmount AS CashAmount,
                       salesinvoicedtl.SalesVatAmount AS VatAmount,
                       salesinvoicedtl.SalesNbtAmount AS NbtAmount,
                       salesinvoicedtl.SalesInvNetAmount AS NetAmount,
                       salesinvoicedtl.SalesCostPrice AS CostAmount,
                       salesinvoicedtl.SalesProductCode AS ProCode,
                       product.Prd_AppearName AS ProName,
                        salesinvoicedtl.SalesQty AS SalesQty,
                       customer.CusName, customer.RespectSign');

        // From tables
        $this->db->from('salesinvoicehed');
        $this->db->join('customer', 'customer.CusCode = salesinvoicehed.SalesCustomer', 'INNER');
        $this->db->join('salesinvoicedtl', 'salesinvoicedtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'INNER');
        $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = salesinvoicehed.SalesInvNo', 'LEFT');

        // Where conditions
        $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
        $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
        $this->db->where_in('salesinvoicehed.SalesLocation', $locationAr);
        $this->db->where('salesinvoicehed.InvIsCancel', 0);

        // Filter by invoice type if provided
        if (!empty($invtype)) {
            $this->db->where('salesinvoicehed.SalesInvType', $invtype);
        }

        // Filter by salesperson if provided
        if (!empty($salesperson)) {
            // First, get all customers handled by the specified salesperson
            $this->db->where('customer.Handelby', $salesperson);
        }

        // Filter by product if provided
        if (!empty($product)) {
            $this->db->where('salesinvoicedtl.SalesProductCode', $product);
        }

        // Filter by department if provided
        if (!empty($department)) {
            $this->db->where('product.DepCode', $department);
        }

        // Filter by subdepartment if provided
        if (!empty($subdepartment)) {
            $this->db->where('product.SubDepCode', $subdepartment);
        }

        // Order by SalesDate in descending order
        $this->db->order_by('salesinvoicehed.SalesDate', 'DESC');

        // Execute query and return results
        return $this->db->get()->result();
    }

    public function genreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) <=', $enddate);
            $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where_in('InvLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) <=', $enddate);
            $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function gencashreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) =', $enddate);
            // $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where_in('InvLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(InvDate) As InvDate,SUM(InvDisAmount) AS DisAmount,
                                SUM(InvCashAmount) AS CashAmount,
                                SUM(InvCCardAmount) AS CCardAmount,
                                SUM(InvCreditAmount) AS CreditAmount,
                                SUM(InvGiftVAmount) AS GiftVAmount,
                                SUM(InvLoyaltyAmount) AS LoyaltyAmount,
                                SUM(InvStarPoints) AS StarPoints,
                                SUM(InvChequeAmount) As ChequeAmount,
                                SUM(InvAmount) AS InvAmount,
                                SUM(InvVatAmount) AS VatAmount,
                                SUM(InvNbtAmount) AS NbtAmount,
                                SUM(InvNetAmount) AS NetAmount,
                                SUM(InvCustomerPayment) AS CustomerPayment,
                                SUM(InvCostAmount) AS CostAmount,
                                SUM(InvReturnPayment) AS ReturnAmount');
            $this->db->from('invoicehed');
            $this->db->where('DATE(InvDate) =', $enddate);
            // $this->db->where('DATE(InvDate) >=', $startdate);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(InvDate)');
            $this->db->order_by('InvDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genjobreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        // if (isset($location) && $location != '') {
        //     $this->db->select('DATE(JobInvoiceDate) As InvDate,SUM(JobTotalDiscount) AS DisAmount,
        //                         SUM(JobCashAmount)+ SUM(ThirdCashAmount) AS CashAmount,
        //                         SUM(JobCardAmount)+ SUM(ThirdCardAmount) AS CCardAmount,
        //                         SUM(JobCreditAmount)+ SUM(ThirdCreditAmount) AS CreditAmount,
        //                         SUM(JobChequeAmount)+ SUM(ThirdChequeAmount) As ChequeAmount,
        //                         SUM(JobCompanyAmount) AS CompanyAmount,
        //                         SUM(JobTotalAmount) AS InvAmount,
        //                         SUM(JobAdvance) AS AdvanceAmount,
        //                         SUM(JobNetAmount) AS NetAmount,
        //                         SUM(JobVatAmount) AS VatAmount,
        //                         SUM(JobNbtAmount) AS NbtAmount');
        //     $this->db->from('jobinvoicehed');
        //     $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
        //     $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
        //     $this->db->where_in('JobLocation', $locationAr);
        //     $this->db->where('IsCancel', 0);
        //     $this->db->group_by('DATE(JobInvoiceDate)');
        //     $this->db->order_by('JobInvoiceDate', 'DESC');
        //     // $this->db->limit(50);
        // } else {
        //     $this->db->select('DATE(JobInvoiceDate) As InvDate,SUM(JobTotalDiscount) AS DisAmount,
        //                         SUM(JobCashAmount)+ SUM(ThirdCashAmount) AS CashAmount,
        //                         SUM(JobCardAmount)+ SUM(ThirdCardAmount) AS CCardAmount,
        //                         SUM(JobCreditAmount)+ SUM(ThirdCreditAmount) AS CreditAmount,
        //                         SUM(JobChequeAmount)+ SUM(ThirdChequeAmount) As ChequeAmount,
        //                         SUM(JobCompanyAmount) AS CompanyAmount,
        //                         SUM(JobTotalAmount) AS InvAmount,
        //                         SUM(JobAdvance) AS AdvanceAmount,
        //                         SUM(JobNetAmount) AS NetAmount,
        //                         SUM(JobVatAmount) AS VatAmount,
        //                         SUM(JobNbtAmount) AS NbtAmount');
        //     $this->db->from('jobinvoicehed');
        //     $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
        //     $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
        //     $this->db->where('IsCancel', 0);
        //     $this->db->group_by('DATE(JobInvoiceDate)');
        //     $this->db->order_by('JobInvoiceDate', 'DESC');
        //     // $this->db->limit(50);
        // }
        if (isset($location) && $location != '') {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,(JobTotalDiscount) AS DisAmount,JobInvNo,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,
                                (JobCostAmount) AS CostAmount,customer.CusName,
                                customer.RespectSign,creditinvoicedetails.SettledAmount');
            $this->db->from('jobinvoicehed');
            $this->db->join('customer', 'customer.CusCode = jobinvoicehed.JCustomer', 'INNER');
            $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = jobinvoicehed.JobInvNo', 'left');
            $this->db->join('jobcardhed', 'jobcardhed.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('jobinvoicehed.IsCancel', 0);
            // if (isset($invtype) && $invtype != '') {
            //     $this->db->where('JobInvType', $invtype);
            // }

            // if (isset($salesperson) && $salesperson != '') {
            //     $this->db->where('jobcardhed.assignTo', $salesperson);
            // }

            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,(JobTotalDiscount) AS DisAmount,JobInvNo,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,
                                (JobCostAmount) AS CostAmount,customer.CusName,
                                customer.RespectSign,creditinvoicedetails.SettledAmount');
            $this->db->from('jobinvoicehed');
            $this->db->join('customer', 'customer.CusCode = jobinvoicehed.JCustomer', 'INNER');
            $this->db->join('creditinvoicedetails', 'creditinvoicedetails.InvoiceNo = jobinvoicehed.JobInvNo', 'left');
            $this->db->join('jobcardhed', 'jobcardhed.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('jobinvoicehed.IsCancel', 0);
            // if (isset($invtype) && $invtype != '') {
            //     $this->db->where('JobInvType', $invtype);
            // }

            // if (isset($salesperson) && $salesperson != '') {
            //     $this->db->where('jobcardhed.assignTo', $salesperson);
            // }

            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genjobsumreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,JobInvNo,(JobTotalDiscount) AS DisAmount,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,JRegNo');
            $this->db->from('jobinvoicehed');
            $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('IsCancel', 0);
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,JobInvNo,(JobTotalDiscount) AS DisAmount,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,JRegNo');
            $this->db->from('jobinvoicehed');
            $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('IsCancel', 0);
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genjobdaysumreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,JobInvNo,(JobTotalDiscount) AS DisAmount,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,JRegNo,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(JobInvoiceDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('IsCancel', 0);
            $this->db->group_by('DATE(jobinvoicehed.JobCardNo)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(JobInvoiceDate) As InvDate,JobInvNo,(JobTotalDiscount) AS DisAmount,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,JRegNo,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(JobInvoiceDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('IsCancel', 0);
            $this->db->group_by('DATE(jobinvoicehed.JobCardNo)');
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function gensalesdaysumreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('DATE(SalesDate) As InvDate,SalesInvNo,(SalesTotalDiscount) AS DisAmount,
                                (SalesCashAmount) AS CashAmount,
                                (SalesCCardAmount) AS CCardAmount,
                                (SalesCreditAmount) AS CreditAmount,
                                (SalesChequeAmount) As ChequeAmount,
                                (SalesBankAmount) AS BankAmount,
                                (SalesInvAmount) AS InvAmount,
                                (SalesAdvancePayment) AS AdvanceAmount,
                                (SalesNetAmount) AS NetAmount,
                                (SalesVatAmount) AS VatAmount,
                                (SalesNbtAmount) AS NbtAmount');
            $this->db->from('salesinvoicehed');
            // $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('DATE(SalesDate) As InvDate,SalesInvNo,(SalesTotalDiscount) AS DisAmount,
                                (SalesCashAmount) AS CashAmount,
                                (SalesCCardAmount) AS CCardAmount,
                                (SalesCreditAmount) AS CreditAmount,
                                (SalesChequeAmount) As ChequeAmount,
                                (SalesBankAmount) AS BankAmount,
                                (SalesInvAmount) AS InvAmount,
                                (SalesAdvancePayment) AS AdvanceAmount,
                                (SalesNetAmount) AS NetAmount,
                                (SalesVatAmount) AS VatAmount,
                                (SalesNbtAmount) AS NbtAmount');
            $this->db->from('salesinvoicehed');
            // $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            // $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
        }
        return $this->db->get()->result();
    }

    public function genjobdaysalesumreportbypayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('jobinvoicehed.*,jobinvoicepaydtl.*,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('IsCancel', 0);
            $this->db->group_by('(jobinvoicehed.JobCardNo)');
            $this->db->order_by('JobInvDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('jobinvoicehed.*,jobinvoicepaydtl.*,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('IsCancel', 0);

            $this->db->group_by('(jobinvoicehed.JobCardNo)');
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genjobmonthsalesumreportbypayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('jobinvoicehed.*,jobinvoicepaydtl.*,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvDate) <=', $enddate);
            $this->db->where('DATE(JobInvDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('IsCancel', 0);
            $this->db->group_by('(jobinvoicehed.JobCardNo)');
            $this->db->order_by('JobInvDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('jobinvoicehed.*,jobinvoicepaydtl.*,jobcarddtl.JobDescription');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('IsCancel', 0);

            $this->db->group_by('(jobinvoicehed.JobCardNo)');
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function gensalesdaysalesumreportbypayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            // $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function gensalemonthsalesumreportbypayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            $this->db->where('DATE(SalesDate) >=', $startdate);
            $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        } else {
             $this->db->select('salesinvoicehed.*,salesinvoicepaydtl.*');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            $this->db->where('DATE(SalesDate) >=', $startdate);
            // $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('(salesinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function genjobdaycashsumreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('JobInvPayAmount,JobCreditAmount');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
            $this->db->where('IsCancel', 0);
            $this->db->group_by('DATE(jobinvoicehed.JobCardNo)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('JobInvPayAmount,JobCreditAmount');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobinvoicepaydtl', 'jobinvoicepaydtl.JobInvNo = jobinvoicehed.JobInvNo', 'INNER');
            $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = jobinvoicehed.JobCardNo', 'INNER');
            $this->db->where('JobInvPayType =', 'Cash');
            $this->db->where('DATE(JobInvoiceDate) =', $enddate);
            // $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where('IsCancel', 0);

            $this->db->group_by('DATE(jobinvoicehed.JobCardNo)');
            // $this->db->group_by('DATE(JobInvoiceDate)');
            $this->db->order_by('JobInvoiceDate', 'DESC');
            // $this->db->limit(50);
        }
        return $this->db->get()->result();
    }

    public function gensalesdaycashsumreportbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('SalesInvPayAmount,SalesCreditAmount');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = salesinvoicehed.JobCardNo', 'INNER');
            $this->db->where('SalesInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(jobinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('SalesInvPayAmount,SalesCreditAmount');
            $this->db->from('salesinvoicehed');
            $this->db->join('salesinvoicepaydtl', 'salesinvoicepaydtl.SalesInvNo = salesinvoicehed.SalesInvNo', 'INNER');
            // $this->db->join('jobcarddtl', 'jobcarddtl.JobCardNo = salesinvoicehed.JobCardNo', 'INNER');
            $this->db->where('SalesInvPayType =', 'Cash');
            $this->db->where('DATE(SalesDate) =', $enddate);
            // $this->db->where('DATE(JobInvDate) >=', $startdate);
            // $this->db->where_in('SalesLocation', $locationAr);
            $this->db->where('InvIsCancel', 0);
            $this->db->group_by('DATE(jobinvoicehed.SalesInvNo)');
            $this->db->order_by('SalesDate', 'DESC');
        }
        return $this->db->get()->result();
    }

    public function genjobreportbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('JobCode,
                           jobinvoicehed.JobInvNo,
                           jobinvoicehed.JobInvoiceDate,
                           Prd_AppearName AS AppearName,
                           JobCost,
                           JobPrice,
                          (JobQty) AS Qty,
                          (JobCost * JobQty) AS CostValue,
                           (jobinvoicedtl.JobTotalAmount) AS TotalAmount,
                           (jobinvoicedtl.JobDiscount) AS DisAmount,
                           (jobinvoicedtl.JobNetAmount) AS NetAmount,
                           (jobinvoicehed.JobTotalDiscount) AS TotalDiscount,
                           department.Description,
                           product.DepCode,
                           product.SubCategoryCode');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobinvoicehed', 'jobinvoicehed.JobInvNo = jobinvoicedtl.JobInvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = jobinvoicedtl.JobCode', 'INNER');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'INNER');
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.InvLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('JobCode', $product);
        }
        
         if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
//        $this->db->group_by('invoicedtl.InvNo');
        $this->db->order_by('jobinvoicehed.JobInvoiceDate');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function genjobreportbyservices($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('JobCode,
                           jobinvoicehed.JobInvNo,
                           jobinvoicehed.JobInvoiceDate,
                           JobDescription AS AppearName,
                           JobCost,
                           JobPrice,
                          (JobQty) AS Qty,
                          (JobCost * JobQty) AS CostValue,
                           (jobinvoicedtl.JobTotalAmount) AS TotalAmount,
                           (jobinvoicedtl.JobDiscount) AS DisAmount,
                           (jobinvoicedtl.JobVatAmount) AS VatAmount,
                           (jobinvoicedtl.JobNbtAmount) AS NbtAmount,
                           (jobinvoicedtl.JobNetAmount) AS NetAmount,
                           (jobinvoicehed.JobTotalDiscount) AS TotalDiscount,
                           jobtype.jobtype_name,
                           jobtype.jobtype_code,
                           jobtype.jobtype_order');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobinvoicehed', 'jobinvoicehed.JobInvNo = jobinvoicedtl.JobInvNo', 'INNER');
        $this->db->join('jobtype', 'jobtype.jobtype_id = jobinvoicedtl.JobType', 'INNER');
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('jobinvoicedtl.JobType', $product);
        }
        
        //  if (isset($dep) && $dep != '' ) {
        //     $this->db->where('product.DepCode', $dep);
        // }
        
        // if (isset($subdep) && $subdep != '' ) {
        //     $this->db->where('product.SubDepCode', $subdep);
        // }
        
        // if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
        //     $this->db->where_in('product.SubCategoryCode', $subcat);
        // }
        
//        $this->db->group_by('invoicedtl.InvNo');
        $this->db->order_by('jobinvoicehed.JobInvNo');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->jobtype_name][] = $row;
        }
        return $list;
    }

    public function genjobreportbymake($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
         $this->db->select('(JobInvoiceDate) As InvDate,JobInvNo,jobinvoicehed.JobCardNo,(JobTotalDiscount) AS DisAmount,
                                (JobCashAmount)+ (ThirdCashAmount) AS CashAmount,
                                (JobCardAmount)+ (ThirdCardAmount) AS CCardAmount,
                                (JobCreditAmount)+ (ThirdCreditAmount) AS CreditAmount,
                                (JobChequeAmount)+ (ThirdChequeAmount) As ChequeAmount,
                                (JobCompanyAmount) AS CompanyAmount,
                                (JobTotalAmount) AS InvAmount,
                                (JobAdvance) AS AdvanceAmount,
                                (JobNetAmount) AS NetAmount,
                                (JobVatAmount) AS VatAmount,
                                (JobNbtAmount) AS NbtAmount,job_section.JobSection,make.make,jobinvoicehed.JRegNo,Count(JobInvNo) AS count');
            $this->db->from('jobinvoicehed');
            $this->db->join('jobcardhed', 'jobinvoicehed.JobCardNo = jobcardhed.JobCardNo', 'INNER');
            $this->db->join('job_section', 'job_section.JobSecNo = jobcardhed.Jsection', 'INNER');
            $this->db->join('vehicledetail', 'jobinvoicehed.JRegNo = vehicledetail.RegNo', 'INNER');
            $this->db->join('make', 'make.make_id = vehicledetail.Make', 'INNER');
            $this->db->where('DATE(JobInvoiceDate) <=', $enddate);
            $this->db->where('DATE(JobInvoiceDate) >=', $startdate);
            $this->db->where_in('JobLocation', $locationAr);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('jobcardhed.Jsection', $product);
        }
        
         if (isset($dep) && $dep != '' ) {
            $this->db->where('vehicledetail.Make', $dep);
        }
        
        // if (isset($subdep) && $subdep != '' ) {
        //     $this->db->where('product.SubDepCode', $subdep);
        // }
        
        // if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
        //     $this->db->where_in('product.SubCategoryCode', $subcat);
        // }
        
       $this->db->group_by('jobinvoicehed.JobInvNo');
        $this->db->order_by('jobinvoicehed.JobInvNo');
        $this->db->order_by('job_section.JobSecNo', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->JobSection][$row->make][] = $row;
        }
        return $list;
    }

    public function genjobreportbyinvoices($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('JobCode,
                           jobinvoicehed.JobInvNo,
                           jobinvoicehed.JobInvoiceDate,
                           JobDescription AS AppearName,
                           JobCost,
                           JobPrice,
                           (JobQty) AS Qty,
                           (JobCost * JobQty) AS CostValue,
                           (jobinvoicedtl.JobTotalAmount) AS TotalAmount,
                           (jobinvoicedtl.JobDiscount) AS DisAmount,
                           (jobinvoicedtl.JobVatAmount) AS VatAmount,
                           (jobinvoicedtl.JobNbtAmount) AS NbtAmount,
                           (jobinvoicedtl.JobNetAmount) AS NetAmount,
                           (jobinvoicehed.JobTotalDiscount) AS TotalDiscount,
                           jobtype.jobtype_name,
                           jobtype.jobtype_code,
                           jobtype.jobtype_order');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobinvoicehed', 'jobinvoicehed.JobInvNo = jobinvoicedtl.JobInvNo', 'INNER');
        $this->db->join('jobtype', 'jobtype.jobtype_id = jobinvoicedtl.JobType', 'INNER');
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('jobinvoicedtl.JobType', $product);
        }
        
        //  if (isset($dep) && $dep != '' ) {
        //     $this->db->where('product.DepCode', $dep);
        // }
        
        // if (isset($subdep) && $subdep != '' ) {
        //     $this->db->where('product.SubDepCode', $subdep);
        // }
        
        // if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
        //     $this->db->where_in('product.SubCategoryCode', $subcat);
        // }
        
//        $this->db->group_by('invoicedtl.InvNo');
        $this->db->order_by('jobinvoicehed.JobInvNo');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->JobInvNo." | ".$row->JobInvoiceDate][] = $row;
        }
        return $list;
    }

    public function genpaymentreportbyinvoices($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('jobinvoicehed.JobInvNo,
                           jobinvoicehed.JobInvoiceDate,
                           jobinvoicehed.JobCardNo,
                           jobinvoicehed.JobNetAmount,
                           jobinvoicepaydtl.*,customer.CusName
                           ');
        $this->db->from('jobinvoicepaydtl');
        $this->db->join('jobinvoicehed', 'jobinvoicehed.JobInvNo = jobinvoicepaydtl.JobInvNo', 'INNER');
        $this->db->join('customer', 'customer.CusCode = jobinvoicehed.JCustomer', 'INNER');
        $this->db->where('DATE(jobinvoicepaydtl.JobInvDate) <=', $enddate);
        $this->db->where('DATE(jobinvoicepaydtl.JobInvDate) >=', $startdate);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('jobinvoicedtl.JobType', $product);
        }
        
        //  if (isset($dep) && $dep != '' ) {
        //     $this->db->where('product.DepCode', $dep);
        // }
        
        // if (isset($subdep) && $subdep != '' ) {
        //     $this->db->where('product.SubDepCode', $subdep);
        // }
        
        // if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
        //     $this->db->where_in('product.SubCategoryCode', $subcat);
        // }
        
        // $this->db->group_by('invoicedtl.InvNo');
        $this->db->order_by('jobinvoicehed.JobInvNo');
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->JobInvNo." | ".$row->JobInvoiceDate." | ".$row->JobCardNo." | ".$row->CusName." ------------ Total Invoice Amount - ".$row->JobNetAmount][] = $row;
        }
        return $list;
    }


    public function genjobreporttotalDiscountbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('SUM(jobinvoicehed.JobTotalDiscount) AS TotalDiscount');
        $this->db->from('jobinvoicehed');
        $this->db->join('jobinvoicedtl', 'jobinvoicehed.JobInvNo = jobinvoicedtl.JobInvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = jobinvoicedtl.JobCode', 'INNER');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'left');
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
        $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('JobCode', $product);
        }
        
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        $this->db->group_by('jobinvoicedtl.JobInvNo');
        //$this->db->group_by('ProductCode');
        // $this->db->limit(50);
        $result=$this->db->get();
        $list=0;
        foreach ($result->result() as $row) {
            $list += $row->TotalDiscount;
        }
        return $list;
    }

    public function genreportbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('InvProductCode,
                           invoicehed.InvNo,
                           invoicehed.InvDate,
                           Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                          (InvQty) AS Qty,
                           (InvFreeQty) AS FreeQty,
                          (InvCostPrice * InvQty) AS CostValue,
                           (invoicedtl.InvTotalAmount) AS TotalAmount,
                           (invoicedtl.InvDisValue) AS DisAmount,
                           (invoicedtl.InvNetAmount) AS NetAmount,
                           (InvReturnQty) AS ReturnQty,
                           (invoicehed.InvDisAmount) AS TotalDiscount,
                           department.Description,
                           product.DepCode,
                           product.SubCategoryCode,
                (invoicedtl.InvSerialNo) AS Serial');
        $this->db->from('invoicedtl');
        $this->db->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'INNER');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'INNER');
        $this->db->where('DATE(invoicehed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('InvProductCode', $product);
        }
        
         if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
//        $this->db->group_by('invoicedtl.InvNo');
        $this->db->order_by('invoicehed.InvDate');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function gencashreportbyproduct($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('InvProductCode,
                           invoicehed.InvNo,invoicehed.InvCashAmount,invoicehed.InvChequeAmount,invoicehed.InvCreditAmount,invoicehed.InvCCardAmount,
                           DATE(invoicehed.InvDate) AS InvDate,
                           Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                          (InvQty) AS Qty,
                           (InvFreeQty) AS FreeQty,
                          (InvCostPrice * InvQty) AS CostValue,
                           (invoicedtl.InvTotalAmount) AS TotalAmount,
                           (invoicedtl.InvDisValue) AS DisAmount,
                           (invoicehed.InvNetAmount) AS NetAmount,
                           (InvReturnQty) AS ReturnQty,
                           (invoicehed.InvDisAmount) AS TotalDiscount,
                           product.DepCode,
                           product.SubCategoryCode,
                (invoicedtl.InvSerialNo) AS Serial');
        $this->db->from('invoicedtl');
        $this->db->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'INNER');
        $this->db->where('DATE(invoicehed.InvDate) =', $enddate);
        // $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        $this->db->group_by('invoicehed.InvDate');
        $this->db->order_by('invoicehed.InvDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashmonthreportbyproduct($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('InvProductCode,
                           invoicehed.InvNo,invoicehed.InvCashAmount,invoicehed.InvChequeAmount,invoicehed.InvCreditAmount,invoicehed.InvCCardAmount,
                           DATE(invoicehed.InvDate) AS InvDate,
                           Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                        (InvQty) AS Qty,
                        (InvFreeQty) AS FreeQty,
                        (InvCostPrice * InvQty) AS CostValue,
                           (invoicedtl.InvTotalAmount) AS TotalAmount,
                           (invoicedtl.InvDisValue) AS DisAmount,
                           (invoicehed.InvNetAmount) AS NetAmount,
                           (InvReturnQty) AS ReturnQty,
                           (invoicehed.InvDisAmount) AS TotalDiscount,
                           product.DepCode,
                           product.SubCategoryCode,
                (invoicedtl.InvSerialNo) AS Serial');
        $this->db->from('invoicedtl');
        $this->db->join('invoicehed', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'INNER');
        $this->db->where('DATE(invoicehed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        $this->db->group_by('invoicehed.InvDate');
        $this->db->order_by('invoicehed.InvDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashreportbypart($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('SalesProductCode,
                           salesinvoicehed.SalesInvNo,salesinvoicehed.SalesCashAmount,salesinvoicehed.SalesChequeAmount,salesinvoicehed.SalesBankAmount,salesinvoicehed.SalesCreditAmount,salesinvoicehed.SalesCCardAmount,SalesAdvancePayment,
                           DATE(salesinvoicehed.SalesDate) AS InvDate,
                           SalesProductName AS AppearName,
                           SalesCostPrice,SalesVehicle,
                           SalesUnitPrice,
                          (SalesQty) AS Qty,
                           (SalesFreeQty) AS FreeQty,
                          (SalesCostPrice * SalesQty) AS CostValue,
                           (salesinvoicedtl.SalesTotalAmount) AS TotalAmount,
                           (salesinvoicedtl.SalesDisValue) AS DisAmount,
                           (salesinvoicehed.SalesNetAmount) AS NetAmount,
                           (SalesReturnQty) AS ReturnQty,
                           (salesinvoicehed.SalesDisAmount) AS TotalDiscount,
                (salesinvoicedtl.SalesSerialNo) AS Serial');
        $this->db->from('salesinvoicedtl');
        $this->db->join('salesinvoicehed', 'salesinvoicehed.SalesInvNo = salesinvoicedtl.SalesInvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'left');
        $this->db->where('DATE(salesinvoicehed.SalesDate) =', $enddate);
       
        $this->db->where('salesinvoicehed.InvIsCancel', 0);
        // if (isset($location) && $location != '') {
        //     $this->db->where_in('salesinvoicehed.SalesLocation', $locationAr);
        // }
        $this->db->group_by('salesinvoicehed.SalesDate');
        $this->db->order_by('salesinvoicehed.SalesDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashreportbyeasy($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('InvProductCode,
                           invoice_hed.InvNo,invoice_hed.DownPayment,invoice_hed.FinalAmount, (invoice_hed.FinalAmount + invoice_hed.DownPayment) AS DueAmount,
                           DATE(invoice_hed.InvDate) AS InvDate,
                           product.Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                          (InvQty) AS Qty,
                           (InvFreeQty) AS FreeQty,
                          (InvCostPrice * InvQty) AS CostValue,
                           (invoice_dtl.InvTotalAmount) AS TotalAmount,
                           (invoice_dtl.InvDisValue) AS DisAmount,
                           (invoice_hed.FinalAmount) AS NetAmount,
                           (InvReturnQty) AS ReturnQty,
                           (invoice_hed.DisAmount) AS TotalDiscount,
                (invoice_dtl.InvSerialNo) AS Serial');
        $this->db->from('invoice_dtl');
        $this->db->join('invoice_hed', 'invoice_hed.InvNo = invoice_dtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoice_dtl.InvProductCode', 'left');
        $this->db->where('DATE(invoice_hed.InvDate) =', $enddate);
        // $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoice_hed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
        $this->db->group_by('invoice_hed.InvDate');
        $this->db->order_by('invoice_hed.InvDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashreportbycoder($startdate, $enddate, $location = NULL, $locationAr = NULL)
    {
        $this->db->select('customerorderdtl.ProductCode,
                           customerorderhed.PO_No,customerorderhed.PO_NetAmount,
                           DATE(customerorderhed.PO_Date) AS InvDate,
                           product.Prd_AppearName AS AppearName,
                           PO_UnitCost,
                           PO_UnitPrice,
                           (PO_Qty) AS Qty,
                           (PO_UnitCost * PO_Qty) AS CostValue,
                           (customerorderdtl.PO_TotalAmount) AS TotalAmount,
                           (customerorderdtl.PO_DisAmount) AS DisAmount,
                           (customerorderhed.PO_NetAmount) AS NetAmount,
                           (customerorderhed.PO_TDisAmount) AS TotalDiscount');
        $this->db->from('customerorderdtl');
        $this->db->join('customerorderhed', 'customerorderhed.PO_No = customerorderdtl.PO_No', 'INNER');
        $this->db->join('product', 'product.ProductCode = customerorderdtl.ProductCode', 'left');
        $this->db->where('DATE(customerorderhed.PO_Date) =', $enddate);
        // $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('customerorderhed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('customerorderhed.PO_Location', $locationAr);
        }
        $this->db->group_by('customerorderhed.PO_Date');
        $this->db->order_by('customerorderhed.PO_Date');
        $result=$this->db->get()->result();
        return $result;
    }
    
    public function gencashreportbycoderdaterange($startdate, $enddate, $location = NULL, $locationAr = NULL)
    {
        $this->db->select('customerorderdtl.ProductCode,
                           customerorderhed.PO_No,customerorderhed.PO_NetAmount,
                           DATE(customerorderhed.PO_Date) AS InvDate,
                           product.Prd_AppearName AS AppearName,
                           PO_UnitCost,
                           PO_UnitPrice,
                           (PO_Qty) AS Qty,
                           (PO_UnitCost * PO_Qty) AS CostValue,
                           (customerorderdtl.PO_TotalAmount) AS TotalAmount,
                           (customerorderdtl.PO_DisAmount) AS DisAmount,
                           (customerorderhed.PO_NetAmount) AS NetAmount,
                           (customerorderhed.PO_TDisAmount) AS TotalDiscount');
        $this->db->from('customerorderdtl');
        $this->db->join('customerorderhed', 'customerorderhed.PO_No = customerorderdtl.PO_No', 'INNER');
        $this->db->join('product', 'product.ProductCode = customerorderdtl.ProductCode', 'left');
        $this->db->where('DATE(customerorderhed.PO_Date) <=', $enddate);
         $this->db->where('DATE(customerorderhed.PO_Date) >=', $startdate);
        $this->db->where('customerorderhed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('customerorderhed.PO_Location', $locationAr);
        }
        $this->db->group_by('customerorderhed.PO_Date');
        $this->db->order_by('customerorderhed.PO_Date');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashreportbypartdaterange($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('SalesProductCode,
                           salesinvoicehed.SalesInvNo,salesinvoicehed.SalesCashAmount,salesinvoicehed.SalesChequeAmount,salesinvoicehed.SalesBankAmount,salesinvoicehed.SalesCreditAmount,salesinvoicehed.SalesCCardAmount,SalesAdvancePayment,
                           DATE(salesinvoicehed.SalesDate) AS InvDate,
                           SalesProductName AS AppearName,
                           SalesCostPrice,SalesVehicle,
                           SalesUnitPrice,
                          (SalesQty) AS Qty,
                           (SalesFreeQty) AS FreeQty,
                          (SalesCostPrice * SalesQty) AS CostValue,
                           (salesinvoicedtl.SalesTotalAmount) AS TotalAmount,
                           (salesinvoicedtl.SalesDisValue) AS DisAmount,
                           (salesinvoicehed.SalesNetAmount) AS NetAmount,
                           (SalesReturnQty) AS ReturnQty,
                           (salesinvoicehed.SalesDisAmount) AS TotalDiscount,
                (salesinvoicedtl.SalesSerialNo) AS Serial');
        $this->db->from('salesinvoicedtl');
        $this->db->join('salesinvoicehed', 'salesinvoicehed.SalesInvNo = salesinvoicedtl.SalesInvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'left');
        $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
         $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
        $this->db->where('salesinvoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('salesinvoicehed.SalesLocation', $locationAr);
        }
        $this->db->group_by('salesinvoicehed.SalesDate');
        $this->db->order_by('salesinvoicehed.SalesDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function totalcusodercuspaymentsummarydaterange($startdate, $enddate, $location = NULL,$locationAr = NULL,$type)
    {
        $this->db->select('customerorderpayment.*,customer.CusName,customerorderhed.PO_No,customerorderhed.SupCode');
        $this->db->from('customerorderpayment');
        $this->db->join('customerorderhed', 'customerorderhed.PO_No = customerorderpayment.OrderNo', 'INNER');
        $this->db->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('IsCancel', 0);

//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function gencashreportbyeasydaterange($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('InvProductCode,
                           invoice_hed.InvNo,invoice_hed.DownPayment,invoice_hed.FinalAmount, (invoice_hed.FinalAmount + invoice_hed.DownPayment) AS DueAmount,
                           DATE(invoice_hed.InvDate) AS InvDate,
                           product.Prd_AppearName AS AppearName,
                           InvCostPrice,
                           InvUnitPrice,
                          (InvQty) AS Qty,
                           (InvFreeQty) AS FreeQty,
                          (InvCostPrice * InvQty) AS CostValue,
                           (invoice_dtl.InvTotalAmount) AS TotalAmount,
                           (invoice_dtl.InvDisValue) AS DisAmount,
                           (invoice_hed.FinalAmount) AS NetAmount,
                           (InvReturnQty) AS ReturnQty,
                           (invoice_hed.DisAmount) AS TotalDiscount,
                (invoice_dtl.InvSerialNo) AS Serial');
        $this->db->from('invoice_dtl');
        $this->db->join('invoice_hed', 'invoice_hed.InvNo = invoice_dtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoice_dtl.InvProductCode', 'left');
        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
         $this->db->where('DATE(invoice_hed.InvDate) >=', $startdate);
        $this->db->where('invoice_hed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
        $this->db->group_by('invoice_hed.InvDate');
        $this->db->order_by('invoice_hed.InvDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function totaleasycuspaymentsummarydaterange($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {

        $this->db->select('rental_paid.*,customer.CusName,customer.CusCode,customer.RespectSign');
        $this->db->from('rental_paid');
        $this->db->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('IsCancel', 0);

//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function genreporttotalDiscountbyproduct($startdate, $enddate, $location = NULL, $product = NULL,$locationAr = NULL,$dep,$subdep,$subcat) {
        $this->db->select('SUM(invoicehed.InvDisAmount) AS TotalDiscount');
        $this->db->from('invoicehed');
        $this->db->join('invoicedtl', 'invoicehed.InvNo = invoicedtl.InvNo', 'INNER');
        $this->db->join('product', 'product.ProductCode = invoicedtl.InvProductCode', 'INNER');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'left');
        $this->db->where('DATE(invoicehed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoicehed.InvDate) >=', $startdate);
        $this->db->where('invoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoicehed.InvLocation', $locationAr);
        }
        if (isset($product) && $product != '') {
            $this->db->where('InvProductCode', $product);
        }
        
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        $this->db->group_by('invoicedtl.InvNo');
        //$this->db->group_by('ProductCode');
        // $this->db->limit(50);
        $result=$this->db->get();
        $list=0;
        foreach ($result->result() as $row) {
            $list += $row->TotalDiscount;
        }
        return $list;
    }
    
    public function expensesbydate($route,$startdate, $enddate, $isExp = NULL) {
        $this->db->select('SUM(FlotAmount) AS FlotAmount');
        $this->db->from('cashflot');
        $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashflot.TransactionCode', 'INNER');
        $this->db->where('DATE(cashflot.FlotDate) <=', $enddate);
        $this->db->where('DATE(cashflot.FlotDate) >=', $startdate);
        if (isset($route) && $route != '') {
            $this->db->where_in('cashflot.Location', $route);
        }
        
        $this->db->where('transactiontypes.IsExpenses', $isExp);
        $result=$this->db->get();
        
        $list=0;
        foreach ($result->result() as $row) {
            $list += $row->FlotAmount;
        }
        return $list;
    }
    
    public function searchproduct($q) {
        $this->db->select('ProductCode AS id,Prd_Description AS text');
        $this->db->from('product');
        $this->db->where('product.Prd_IsActive', 1);
        $this->db->like('CONCAT(ProductCode,Prd_Description)', $q, 'left');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsupplier($q) {
        $this->db->select('SupCode AS id,SupName AS text');
        $this->db->from('supplier');
        $this->db->like('CONCAT(SupCode,SupName)', $q, 'left');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchdepartment($q) {
        $this->db->select('DepCode AS id,Description AS text');
        $this->db->from('department');
        $this->db->like('CONCAT(DepCode,Description)', $q, 'left');
        $this->db->group_by('Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsubdepartment($q) {
        $this->db->select('SubDepCode AS id,Description AS text');
        $this->db->from('subdepartment');
        $this->db->like('CONCAT(SubDepCode,Description)', $q, 'left');
        $this->db->group_by('Description');
        $this->db->limit(50);
        return $this->db->get()->result();
    }
    
    public function searchsubcategory($q,$cat,$cat2) {

        $this->db->select('SubCategoryCode AS id,Description AS text');
        $this->db->from('subcategory');
        $this->db->like('CONCAT(SubCategoryCode,Description)', $q, 'left');
        $this->db->group_by('Description');
        $this->db->limit(50);
        return $this->db->get()->result();

    }

    public function searchcustomer($q) {
        $this->db->select('customer.CusCode AS id,customer.CusName AS text');
                        $this->db->from('customer');
                        $this->db->where('IsActive',1);
                        $this->db->like("CONCAT(customer.CusCode,' ',customer.CusName)", $q);
                        $this->db->group_by('customer.CusName');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }

    public function searchvehicle($q) {
        $this->db->select('vehicledetail.RegNo AS id,vehicledetail.RegNo AS text');
                        $this->db->from('vehicledetail');
                        $this->db->like("CONCAT(vehicledetail.RegNo)", $q);
                        $this->db->group_by('vehicledetail.VehicleId');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }

    public function searchmake($q) {
        $this->db->select('make.make_id AS id,make.make AS text');
                        $this->db->from('make');
                        $this->db->like("CONCAT(make.make)", $q);
                        $this->db->group_by('make.make_id');
                        $this->db->limit(50);
                    
        return $this->db->get()->result();
    }


    public function productdetail($route, $isall, $product = NULL, $dep = NULL, $subdep = NULL, $sup = NULL, $subcat = NULL) {
        $this->db->select('product.ProductCode,
                       product.Prd_Description,
                       product.Prd_CostPrice,
                       product.SubDepCode,
                       product.Prd_ROL,
                       product.Prd_ROQ,
                       department.Description,
                       location.location,
                       productstock.Stock,
                       productstock.Expired,
                       productstock.Damage,
                       productprice.ProductPrice,
                       productprice.PL_No,
                       supplier.SupName');

        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'LEFT');
        $this->db->join('productstock', 'productstock.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'INNER');
        $this->db->join('productprice', 'productprice.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'LEFT');
        $this->db->join('location', 'location.location_id = productstock.Location', 'INNER');
        $this->db->where('productprice.PL_No', 1);
        $this->db->where('product.Prd_IsActive', 1);



        // Apply filters regardless of isall
        if (!empty($route)) {
            $this->db->where_in('productstock.Location', $route);
        }
        if (!empty($dep)) {
            $this->db->where_in('product.DepCode', $dep);
        }
        if (!empty($subdep)) {
            $this->db->where_in('product.SubDepCode', $subdep);
        }
        if (!empty($subcat)) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        if (!empty($sup)) {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        if (!empty($product) && $isall == 1) {
            $this->db->where('product.ProductCode', $product);
        }

        // If isall == 0 and no filters applied at all, return empty result
        $noFilters = empty($route) && empty($product) && empty($dep) && empty($subdep) && empty($sup) && empty($subcat);
        if ($isall == 1 && $noFilters) {
            return []; // No data to return when filters are missing
        }

        // Order results
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('subcategory.Description', 'ASC');

        $result = $this->db->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }

        return $list;
    }


    public function lowproductdetail($route, $isall, $product = NULL,$dep,$subdep,$sup,$subcat) {
        $this->db->select('product.ProductCode,
                           product.Prd_Description,
                           product.Prd_CostPrice,
                           product.SubDepCode,
                           product.Prd_ROL,
                           product.Prd_ROQ,
                           department.Description,
                           location.location,
                           productstock.Stock,
                           productstock.Expired,
                            productstock.Damage,
                  
                           productprice.ProductPrice,
                           supplier.SupName');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'LEFT');
        $this->db->join('productstock', 'productstock.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('department', 'department.DepCode = product.DepCode', 'INNER');
        $this->db->join('productprice', 'productprice.ProductCode = product.ProductCode', 'LEFT');
        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'left');
        $this->db->join('location', 'location.location_id = productstock.Location', 'INNER');
        $this->db->where('productstock.Stock < product.Prd_ROL');
        $this->db->where('product.Prd_IsActive', 1);
        if (isset($route) && $route != '') {
            $this->db->where_in('productstock.Location', $route);
        }
        if (isset($product) && $isall == 1) {
            $this->db->where('product.ProductCode', $product);
        }
        // If isall == 0 and no filters applied at all, return empty result
        $noFilters = empty($route) && empty($product) && empty($dep) && empty($subdep) && empty($sup) && empty($subcat);
        if ($isall == 1 && $noFilters) {
            return []; // No data to return when filters are missing
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where_in('product.DepCode', $dep);
        }

        if (isset($subdep) && $subdep != '' ) {
            $this->db->where_in('product.SubDepCode', $subdep);
        }

        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }

        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }

        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
//        $this->db->order_by('product.SubCategoryCode', 'ASC');
        $this->db->order_by('subcategory.Description', 'ASC');

        $result=$this->db->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function priceproductdetail($route, $isall, $product = NULL,$dep,$subdep,$sup) {
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.SubDepCode,
                            product.Prd_ROL,
                             product.Prd_ROQ,
                             product.Prd_SetAPrice,
                            subdepartment.Description,
                            product.Prd_CostPrice,
                            location.location,
                            pricestock.Stock,
                            pricestock.UnitCost,
                            pricestock.Price,
                            pricestock.Expired,
                            pricestock.Damage,
                            supplier.SupName');
        $this->db->from('product');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->join('pricestock', 'pricestock.PSCode = product.ProductCode', 'LEFT');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
//        $this->db->join('subcategory', 'subcategory.SubCategoryCode = product.SubCategoryCode', 'INNER');
        $this->db->join('location', 'location.location_id = pricestock.PSLocation', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        if (isset($route) && $route != '') {
            $this->db->where('pricestock.PSLocation', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where('product.DepCode', $dep);
        }

        if (isset($dep) && $dep != '' && isset($subdep) && $subdep != '' ) {
            $this->db->where('product.SubDepCode', $subdep);
        }
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        $result= $this->db->get();
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }

    public function productdetailserial($transfer,$route, $isall, $product = NULL,$dep,$subdep,$sup,$subcat) {

        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.Prd_CostPrice AS Prd_CostPrice,
                            location.location,
                            productserialstock.Quantity,
                            productserialstock.SerialNo,
                            supplier.SupName,
                            subdepartment.Description,
                            goodsreceivenotehed.GRN_DateORG');
        $this->db->from('product');
        $this->db->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
        $this->db->join('location', 'location.location_id = productserialstock.Location', 'INNER');
        $this->db->join('goodsreceivenotehed', 'goodsreceivenotehed.GRN_No = productserialstock.GrnNo', 'Left');
        $this->db->join('goodsreceivenotedtl', 'goodsreceivenotehed.GRN_No = goodsreceivenotedtl.GRN_No', 'INNER');
        $this->db->join('supplier', 'supplier.SupCode = goodsreceivenotehed.GRN_SupCode', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        
        if (isset($isall) && $isall == 'all') {
        }elseif (isset($isall) && $isall == '1') {
            $this->db->where('productserialstock.Quantity', $isall);
        }elseif (isset($isall) && $isall == '0') {
            $this->db->where('productserialstock.Quantity', $isall);
        }
        
        if (isset($route) && $route != '' && count($route)>0) {
            $this->db->where_in('productserialstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where_in('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where_in('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->group_by('productserialstock.SerialNo');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        
        $result=$this->db->get();
        
        
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            product.Prd_CostPrice AS Prd_CostPrice,
                            location.location,
                            productserialstock.Quantity,
                            productserialstock.SerialNo,
                            supplier.SupName,
                            subdepartment.Description,
                            materialrequestnotehed.MrnDateORG As GRN_DateORG');
        $this->db->from('product');
        $this->db->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
        $this->db->join('location', 'location.location_id = productserialstock.Location', 'INNER');
        $this->db->join('materialrequestnotehed', 'materialrequestnotehed.MrnNo = productserialstock.GrnNo', 'Left');
        $this->db->join('materialrequestnotedtl', 'materialrequestnotehed.MrnNo = materialrequestnotedtl.MrnNo', 'INNER');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        
        if (isset($isall) && $isall == 'all') {
        }elseif (isset($isall) && $isall == '1') {
            $this->db->where('productserialstock.Quantity', $isall);
        }elseif (isset($isall) && $isall == '0') {
            $this->db->where('productserialstock.Quantity', $isall);
        }
        
        if (isset($route) && $route != '' && count($route)>0) {
            $this->db->where_in('productserialstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where_in('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where_in('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->group_by('productserialstock.SerialNo');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        
        $result2=$this->db->get();

        $list = array();
        if (isset($transfer) && $transfer == 'transfer'){
            foreach ($result2->result() as $row) {
                $list[$row->Description][] = $row;
            }
        } else{
            foreach ($result->result() as $row) {
                $list[$row->Description][] = $row;
            }
        }

        return $list;
    }
    
    
    public function productdetailserial2($route, $isall, $product = NULL,$dep,$subdep,$sup,$subcat) {
        $this->db->select('product.ProductCode,
                            product.Prd_Description,
                            stocktransferdtl.CostPrice AS Prd_CostPrice,
                            location.location,
                            productserialstock.Quantity,
                            productserialstock.SerialNo,
                            supplier.SupName,
                            subdepartment.Description,
                            stocktransferhed.GRN_DateORG');
        $this->db->from('product');
        $this->db->join('productserialstock', 'productserialstock.ProductCode = product.ProductCode', 'INNER');
        $this->db->join('subdepartment', 'subdepartment.SubDepCode = product.SubDepCode', 'INNER');
        $this->db->join('location', 'location.location_id = productserialstock.Location', 'INNER');
        $this->db->join('stocktransferhed', 'stocktransferhed.TrnsNo = productserialstock.GrnNo', 'Left');
        $this->db->join('stocktransferdtl', 'stocktransferhed.TrnsNo = stocktransferdtl.TrnsNo', 'INNER');
        $this->db->join('supplier', 'supplier.SupCode = product.Prd_Supplier', 'INNER');
        $this->db->where('product.Prd_IsActive', 1);
        
        if (isset($isall) && $isall == 'all') {
        }elseif (isset($isall) && $isall == '1') {
            $this->db->where('productserialstock.Quantity', $isall);
        }elseif (isset($isall) && $isall == '0') {
            $this->db->where('productserialstock.Quantity', $isall);
        }
        
        if (isset($route) && $route != '' && count($route)>0) {
            $this->db->where_in('productserialstock.Location', $route);
        }
        if (isset($product) && $product != '' && $isall == 0) {
            $this->db->where('product.ProductCode', $product);
        }
        if (isset($dep) && $dep != '' ) {
            $this->db->where_in('product.DepCode', $dep);
        }
        
        if (isset($subdep) && $subdep != '' ) {
            $this->db->where_in('product.SubDepCode', $subdep);
        }
        
        if ( isset($subcat) && $subcat != '' && count($subcat) != 0) {
            $this->db->where_in('product.SubCategoryCode', $subcat);
        }
        
        if (isset($sup) && $sup != '') {
            $this->db->where('product.Prd_Supplier', $sup);
        }
        $this->db->group_by('productserialstock.SerialNo');
        $this->db->order_by('product.DepCode', 'ASC');
        $this->db->order_by('product.SubDepCode', 'ASC');
        $this->db->order_by('product.CategoryCode', 'ASC');
        $this->db->order_by('product.SubCategoryCode', 'ASC');
//        $this->db->order_by('subcategory.Description', 'ASC');
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->Description][] = $row;
        }
        return $list;
    }
    
    public function cashfloatbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL) {
//        var_dump($startdate);die();
            $this->db->select('*,users.first_name,cashinout.Remark As Remark');
            $this->db->from('cashinout');
            $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashinout.TransCode', 'INNER');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'INNER');
            $this->db->where('DATE(InOutDate) <=', $enddate);
            $this->db->where('DATE(InOutDate) >=', $startdate);
            $this->db->where_in('cashinout.Location', $locationAr);
            // $this->db->limit(50);

        $result=$this->db->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->TransactionName	][] = $row;
        }
        return $list;


//        return $this->db->get()->result();
    }

    public function cashfloatbytype($startdate, $enddate, $location = NULL,$locationAr = NULL,$type,$emp) {
        
        $this->db->select('cashflot.*,transactiontypes.IsExpenses,users.first_name,cashflot.Remark As Remark');
        $this->db->from('cashflot');
        $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashflot.TransactionCode', 'INNER');
        $this->db->join('users', 'users.id = cashflot.SystemUser', 'INNER');
        $this->db->where('DATE(DateORG) <=', $enddate);
        $this->db->where('DATE(DateORG) >=', $startdate);
        $this->db->where('cashflot.TransactionCode!=', $type);
        if (isset($emp) && $emp != '') {
            $this->db->where('Emp', $emp);
        }
        $this->db->where_in('cashflot.Location', $locationAr);
        // $this->db->limit(50);
        return $this->db->get()->result();
    }

    public function cashfloatsalarybytype($startdate, $enddate, $location = NULL,$locationAr = NULL,$type,$emp,$exp) {
        
        $this->db->select('cashflot.*,users.first_name,cashflot.Remark As Remark');
        $this->db->from('cashflot');
        $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashflot.TransactionCode', 'INNER');
        $this->db->join('users', 'users.id = cashflot.SystemUser', 'INNER');
        $this->db->where('DATE(DateORG) <=', $enddate);
        $this->db->where('DATE(DateORG) >=', $startdate);
        $this->db->where('cashflot.TransactionCode', $type);
        if (isset($emp) && $emp != '') {
            $this->db->where('cashflot.Emp', $emp);
        }

        if (isset($exp) && $exp != '') {
            $this->db->where('transactiontypes.IsExpenses', $exp);
        }

        $this->db->where_in('cashflot.Location', $locationAr);
        // $this->db->limit(50);
        return $this->db->get()->result();
    }

    public function totalsupplierpayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        
        $this->db->select('CashPay,CardPay');
        $this->db->from('supplierpaymenthed');
        $this->db->where('DATE(PayDate) =', $enddate);
        if (isset($location) && $location != '') {
           $this->db->where_in('supplierpaymenthed.Location', $locationAr);
        }
        
        return $this->db->get()->result();
    }

    public function totalmonthsupplierpayment($startdate, $enddate, $location = NULL,$locationAr = NULL) {
        
        $this->db->select('CashPay,CardPay');
        $this->db->from('supplierpaymenthed');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        if (isset($location) && $location != '') {
           $this->db->where_in('supplierpaymenthed.Location', $locationAr);
        }
        
        return $this->db->get()->result();
    }

    public function totalcuspayment($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {
        
        $this->db->select('CashPay,CardPay');
        $this->db->from('customerpaymenthed');
        $this->db->where('DATE(PayDate) =', $enddate);
        $this->db->where('PaymentType', $type);
        $this->db->where('IsCancel', 0);
        
        if (isset($location) && $location != '') {
           $this->db->where_in('customerpaymenthed.Location', $locationAr);
        }
        
        return $this->db->get()->result();
    }

    public function totalcuspaymentsummary($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {
        
        $this->db->select('customerpaymenthed.*,customer.CusName');
        $this->db->from('customerpaymenthed');
         $this->db->join('customer', 'customer.CusCode = customerpaymenthed.CusCode', 'INNER');
        $this->db->where('DATE(PayDate) =', $enddate);
        $this->db->where('PaymentType', $type);
        $this->db->where('IsCancel', 0);
        
        if (isset($location) && $location != '') {
           $this->db->where_in('customerpaymenthed.Location', $locationAr);
        }
        
        return $this->db->get()->result();
    }

    public function totaleasycuspaymentsummary($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {

        $this->db->select('rental_paid.*,customer.CusName');
        $this->db->from('rental_paid');
        $this->db->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER');
        $this->db->where('DATE(PayDate) =', $enddate);
        $this->db->where('IsCancel', 0);

//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function totalcusodercuspaymentsummary($startdate, $enddate, $location = NULL,$locationAr = NULL,$type)
    {
        $this->db->select('customerorderpayment.*,customer.CusName,customerorderhed.PO_No,customerorderhed.SupCode');
        $this->db->from('customerorderpayment');
        $this->db->join('customerorderhed', 'customerorderhed.PO_No = customerorderpayment.OrderNo', 'INNER');
        $this->db->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER');
        $this->db->where('DATE(PayDate) =', $enddate);
        $this->db->where('IsCancel', 0);

//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function totalcusmonthpaymentsummary($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {
        
        $this->db->select('customerpaymenthed.*,customer.CusName');
        $this->db->from('customerpaymenthed');
         $this->db->join('customer', 'customer.CusCode = customerpaymenthed.CusCode', 'INNER');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('PaymentType', $type);
        $this->db->where('IsCancel', 0);
        
        if (isset($location) && $location != '') {
           $this->db->where_in('customerpaymenthed.Location', $locationAr);
        }
        
        return $this->db->get()->result();
    }


    
    public function cashinoutbyroute($startdate, $enddate, $location = NULL,$locationAr = NULL,$emp,$type) {
        
            $this->db->select('cashinout.*,transactiontypes.TransactionName,users.first_name');
            $this->db->from('cashinout');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'INNER');
            $this->db->join('transactiontypes', 'cashinout.TransCode = transactiontypes.TransactionCode','INNER');
            $this->db->where('DATE(InOutDate) <=', $enddate);
            $this->db->where('DATE(InOutDate) >=', $startdate);
            $this->db->where_in('cashinout.Location', $locationAr);
            if (isset($emp) && $emp != '') {
               $this->db->where('cashinout.Emp', $emp);
            }

            if (isset($type) && $type != '') {
               $this->db->where('cashinout.TransCode', $type);
            }
            // $this->db->limit(50);
        
        return $this->db->get()->result();
    }

    public function cashinoutsalarybytype($startdate, $enddate, $location = NULL,$locationAr = NULL, $type) {
        
            $this->db->select('cashinout.*,users.first_name');
            $this->db->from('cashinout');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'INNER');
            $this->db->where('DATE(InOutDate) =', $enddate);
            // $this->db->where('DATE(InOutDate) >=', $startdate);
            // $this->db->where('Emp!=', 0);
            $this->db->where('TransCode', $type);
            $this->db->where('Mode=', 'Out');
            $this->db->where_in('cashinout.Location', $locationAr);
            // $this->db->limit(50);
        
        return $this->db->get()->result();
    }

    public function cashinoutmonthsalarybytype($startdate, $enddate, $location = NULL,$locationAr = NULL, $type) {
        
            $this->db->select('cashinout.*,users.first_name');
            $this->db->from('cashinout');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'INNER');
            $this->db->where('DATE(InOutDate) <=', $enddate);
            $this->db->where('DATE(InOutDate) >=', $startdate);
            // $this->db->where('Emp!=', 0);
            $this->db->where('TransCode', $type);
            $this->db->where('Mode=', 'Out');
            $this->db->where_in('cashinout.Location', $locationAr);
            // $this->db->limit(50);
        
        return $this->db->get()->result();
    }

    public function cashinoutbyroutebytype($startdate, $enddate, $location = NULL,$locationAr = NULL, $type) {
        
            $this->db->select('cashinout.*,users.first_name,transactiontypes.TransactionName,salespersons.RepName');
            $this->db->from('cashinout');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'left');
            $this->db->join('salespersons','cashinout.Emp=salespersons.RepID','left');
            $this->db->join('transactiontypes','cashinout.TransCode=transactiontypes.TransactionCode','left');
            $this->db->where('DATE(InOutDate) =', $enddate);
            // $this->db->where('DATE(InOutDate) >=', $startdate);
            $this->db->where('TransCode!=', $type);
            $this->db->where_in('cashinout.Location', $locationAr);
            // $this->db->limit(50);
        return $this->db->get()->result();
    }

    public function cashinoutmonthbyroutebytype($startdate, $enddate, $location = NULL,$locationAr = NULL, $type) {
        
            $this->db->select('cashinout.*,users.first_name,transactiontypes.TransactionName,salespersons.RepName');
            $this->db->from('cashinout');
            $this->db->join('users', 'users.id = cashinout.SystemUser', 'left');
            $this->db->join('salespersons','cashinout.Emp=salespersons.RepID','left');
            $this->db->join('transactiontypes','cashinout.TransCode=transactiontypes.TransactionCode','left');
            $this->db->where('DATE(InOutDate) <=', $enddate);
            $this->db->where('DATE(InOutDate) >=', $startdate);
            $this->db->where('TransCode!=', $type);
            $this->db->where_in('cashinout.Location', $locationAr);
            // $this->db->limit(50);
        return $this->db->get()->result();
    }

    public function productdailyfinalstock($startdate, $enddate, $route, $product = NULL,$dep,$subdep,$subcat) {
        $query = $this->db->query("CALL SPR_STOCK_FINAL_V2('$startdate','$enddate','$route','$product','$dep','$subdep','$subcat')");
        $result = array();
        foreach ($query->result() as $rows) {
        $result[$rows->CategoryName][] = $rows;
        }
        return $result;
    }
    
     public function productdailyfinalstock2($startdate, $enddate, $route, $product = NULL) {
        $query = $this->db->query("CALL SPR_STOCK_FINAL('$startdate','$enddate','$route','$product')");
//        $result = array();
        $data = array(); 
while($row = $query->result()) { 
  $data[$row['country']][$row['city']] = $row['venue']; 
} 
foreach($row as $country => $cities) { 
  echo "<h1>$country</h1>\n"; 
  foreach($cities as $city => $venues) { 
    echo "<h2>$city</h2>\n"; 
    
  } 
}  
//        foreach ($query->result() as $rows) {
//            $result[] = $rows;
//        }
//        return $result;
    }

    public function laststockreportdate() {
        if (isset($this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate) &&
                $this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate != '') {
            return $this->db->select_max('StockDate')->from('stockdate')->get()->row()->StockDate;
        } else {
            return date("Y-m-d");
        }
    }

    public function dailyreportupdate($date, $user) {
        $now = date("Y-m-d H:i:s");
        if ($this->db->query("CALL SPT_UPDATE_DAILY_STOCK('$date','$user','$now')")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function dailyreportupdateuserdata() {
        $maxid = $this->db->select_max('id')->from('stockdateuser')->get()->row()->id;
        return $this->db->select()->from('stockdateuser')->where('id', $maxid)->get()->row();
    }

    public function suppliercredit($startdate, $enddate, $route = NULL,$isall,$customer) {
        
        $this->db->select('creditgrndetails.SupCode,
                    DATE(creditgrndetails.GRNDate) AS InvoiceDate,
                    creditgrndetails.GRNNo,
                    creditgrndetails.NetAmount,
                    creditgrndetails.CreditAmount,
                    creditgrndetails.SettledAmount,
                    supplier.SupName,
                    title.TitleName,
                    supplier.Address01,
                    supplier.Address02,
                    supplier.Address03,
                    goodsreceivenotehed.GRN_No');
        $this->db->from('creditgrndetails');
        $this->db->join('goodsreceivenotehed','creditgrndetails.GRNNo=goodsreceivenotehed.GRN_No','left');
        $this->db->join('supplier','creditgrndetails.SupCode = supplier.SupCode');
        $this->db->join('title','title.TitleId = supplier.SupTitle');
        $this->db->where('creditgrndetails.CreditAmount > creditgrndetails.SettledAmount');
        $this->db->where('creditgrndetails.IsCancel',0);
        if (isset($isall) && $isall == 0 ) {
            if (isset($enddate) && $enddate != '' ) {
            $this->db->where('DATE(creditgrndetails.GRNDate) <=', $enddate);
            }
            if (isset($startdate) && $startdate != '' ) {
            $this->db->where('DATE(creditgrndetails.GRNDate) >=', $startdate);
            }
        }
        if (isset($route) && $route != '' ) {
            $this->db->where('creditgrndetails.Location',$route);
        }
        if (isset($customer) && $customer != '' ) {
            $this->db->where('creditgrndetails.SupCode',$customer);
        }
        $this->db->order_by('creditgrndetails.SupCode,creditgrndetails.GRNDate');
        $result= $this->db->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->TitleName." ".$row->SupName][] = $row;
        }
        return $list;
    }

    public function customercredit($startdate, $enddate, $route, $isall,$customer,$salesperson) {
        
            $this->db->select('customer.MobileNo,creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            creditinvoicedetails.NetAmount,
                            creditinvoicedetails.CreditAmount,
                            creditinvoicedetails.SettledAmount,
                            SUM(creditinvoicedetails.returnAmount) AS ReturnAmount,
                            customer.CusName,
                            customer.RouteId,
                            customer.Address01,
                            salespersons.RepName,
                            salespersons.RepID,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo');
                $this->db->from('creditinvoicedetails');
                $this->db->join('jobinvoicehed','creditinvoicedetails.InvoiceNo=jobinvoicehed.JobInvNo','left');
                $this->db->join('customer','creditinvoicedetails.CusCode = customer.CusCode');
                $this->db->join('salespersons','salespersons.RepID = customer.HandelBy','left');
                // $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                }

                if (isset($salesperson) && $salesperson != '' ) {
                $this->db->where('salespersons.RepID',$salesperson);
                 }
                 if (isset($route) && $route != '' ) {
                $this->db->where_in('customer.RouteId',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('creditinvoicedetails.CusCode',$customer);
                  }
            }
                 // $this->db->where('creditinvoicedetails.CreditAmount !=creditinvoicedetails.SettledAmount');
                  $this->db->group_by('creditinvoicedetails.InvoiceDate');
                  $this->db->order_by('creditinvoicedetails.InvoiceDate');
                   
              return $this->db->get()->result();
    }

    public function customercreditstatement($startdate, $enddate, $loc = NULL,$isall,$customer) {
        
            $this->db->select('customer.MobileNo,creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            creditinvoicedetails.NetAmount,
                            creditinvoicedetails.CreditAmount,
                            creditinvoicedetails.SettledAmount,
                            creditinvoicedetails.returnAmount,
                            SUM(creditinvoicedetails.returnAmount) AS returnAmounts,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo');
                $this->db->from('creditinvoicedetails');
                $this->db->join('jobinvoicehed','creditinvoicedetails.InvoiceNo=jobinvoicehed.JobInvNo','left');
                $this->db->join('customer','creditinvoicedetails.CusCode = customer.CusCode');
                // $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                }
            }
                 if (isset($loc) && $loc != '' ) {
                // $this->db->where('creditinvoicedetails.Location',$loc);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('creditinvoicedetails.CusCode',$customer);
                  }
                 // $this->db->where('creditinvoicedetails.CreditAmount !=creditinvoicedetails.SettledAmount');
                  $this->db->group_by('creditinvoicedetails.InvoiceNo');
                  $this->db->order_by('creditinvoicedetails.InvoiceDate');

              return $this->db->get()->result();
    }

    public function customerpayment($startdate, $enddate, $route ,$isall,$customer,$salesperson) {
        
            $this->db->select('customerpaymenthed.CusPayNo,
                            customerpaymenthed.CusCode,
                            customerpaymenthed.TotalPayment,
                            customerpaymentdtl.`Mode`,
                            customerpaymentdtl.PayAmount,
                            customerpaymentdtl.BankNo,
                            customerpaymentdtl.ChequeNo,
                            DATE(customerpaymentdtl.ChequeDate) AS ChequeDate,
                            DATE(customerpaymentdtl.RecievedDate) AS RecievedDate,
                            customerpaymentdtl.Reference,
                            customerpaymenthed.PayDate,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                             customer.RouteId,
                            bank.BankName,
                            salespersons.RepID');
                $this->db->from('customerpaymenthed');
                $this->db->join('customerpaymentdtl','customerpaymentdtl.CusPayNo=customerpaymenthed.CusPayNo');
                $this->db->join('customer','customerpaymenthed.CusCode = customer.CusCode');
                 $this->db->join('salespersons','customerpaymenthed.SalesPerson = salespersons.RepID');
                $this->db->join('bank','customerpaymentdtl.BankNo = bank.BankCode','left');
                 $this->db->where('customerpaymenthed.IsCancel',0);

            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(customerpaymenthed.PayDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(customerpaymenthed.PayDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where_in(' customer.RouteId',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('customerpaymenthed.CusCode',$customer);
                  }
                 if (isset($salesperson) && $salesperson != '' ) {
                $this->db->where(' salespersons.RepID',$salesperson);
                  }
                   
              return $this->db->get()->result();
    }

    public function customercreditbyvehicle($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            creditinvoicedetails.NetAmount,
                            creditinvoicedetails.CreditAmount,
                            creditinvoicedetails.SettledAmount,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo');
                $this->db->from('creditinvoicedetails');
                $this->db->join('jobinvoicehed','creditinvoicedetails.InvoiceNo=jobinvoicehed.JobInvNo','left');
                $this->db->join('customer','creditinvoicedetails.CusCode = customer.CusCode');
                $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('creditinvoicedetails.Location',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('creditinvoicedetails.CusCode',$customer);
                  }
                   
              return $this->db->get()->result();
    }

    public function customerpaymentbyvehicle($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('customerpaymenthed.CusPayNo,
                            customerpaymenthed.CusCode,
                            customerpaymenthed.TotalPayment,
                            customerpaymentdtl.`Mode`,
                            customerpaymentdtl.PayAmount,
                            customerpaymentdtl.BankNo,
                            customerpaymentdtl.ChequeNo,
                            DATE(customerpaymentdtl.ChequeDate) AS ChequeDate,
                            DATE(customerpaymentdtl.RecievedDate) AS RecievedDate,
                            customerpaymentdtl.Reference,
                            customerpaymenthed.PayDate,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            bank.BankName');
                $this->db->from('customerpaymenthed');
                $this->db->join('customerpaymentdtl','customerpaymentdtl.CusPayNo=customerpaymenthed.CusPayNo');
                $this->db->join('customer','customerpaymenthed.CusCode = customer.CusCode');
                $this->db->join('bank','customerpaymentdtl.BankNo = bank.BankCode','left');
                 $this->db->where('customerpaymenthed.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(customerpaymenthed.PayDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(customerpaymenthed.PayDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('customerpaymenthed.Location',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('customerpaymenthed.CusCode',$customer);
                  }
                   
              return $this->db->get()->result();
    }

    public function invoicesbyvehicle($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('JobCode,
                           jobinvoicehed.JobInvNo,
                           DATE(jobinvoicehed.JobInvoiceDate) AS JobInvoiceDate,
                           JobDescription AS AppearName,
                           JobCost,
                           JobPrice,
                          (JobQty) AS Qty,
                          (JobCost * JobQty) AS CostValue,
                           (jobinvoicedtl.JobTotalAmount) AS TotalAmount,
                           (jobinvoicedtl.JobDiscount) AS DisAmount,
                           (jobinvoicedtl.JobNetAmount) AS NetAmount,
                           (jobinvoicehed.JobTotalDiscount) AS TotalDiscount,
                           jobtype.jobtype_name,
                           jobtype.jobtype_code,
                           jobtype.jobtype_order,
                           customer.CusName,
                           jobinvoicehed.JobCardNo,
                           jobinvoicehed.JRegNo');
        $this->db->from('jobinvoicedtl');
        $this->db->join('jobinvoicehed', 'jobinvoicehed.JobInvNo = jobinvoicedtl.JobInvNo', 'INNER');
        $this->db->join('jobtype', 'jobtype.jobtype_id = jobinvoicedtl.JobType', 'INNER');
        $this->db->join('customer', 'customer.CusCode = jobinvoicehed.JCustomer', 'INNER');

        if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
               $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                 $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
                }
            }

        $this->db->where('jobinvoicehed.IsCancel', 0);
        if (isset($route) && $route != '') {
            $this->db->where_in('jobinvoicehed.JobLocation', $route);
        }
        if (isset($customer) && $customer != '') {
            $this->db->where('jobinvoicehed.JRegNo', $customer);
        }
        
        $this->db->order_by('jobinvoicehed.JobInvNo');
        $this->db->order_by('jobinvoicehed.JobInvoiceDate');
        $this->db->order_by('jobtype.jobtype_order', 'ASC');
        // $this->db->limit(50);
        
        
        $result=$this->db->get();
        
        $list = array();
        foreach ($result->result() as $row) {
            $list["Invoice No: ".$row->JobInvNo." &nbsp; | &nbsp; Job Card No: ".$row->JobCardNo." &nbsp;| &nbsp;Customer : ".$row->CusName][] = $row;
        }
        return $list;
    }

    public function jobdelivery($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobcardhed.JobCardNo,
                            jobcardhed.JRegNo,deliveryDate,appoimnetDate,status_name');
                $this->db->from('jobcardhed');
                $this->db->join('customer','jobcardhed.JCustomer = customer.CusCode');
                $this->db->join('job_status','job_status.status_id = jobcardhed.IsCompelte');
                $this->db->where('DATE(jobcardhed.deliveryDate) <',$enddate);
                 $this->db->where('jobcardhed.IsCancel',0);
            // if (isset($isall) && $isall == 0 ) {
            //     if (isset($enddate) && $enddate != '' ) {
            //     $this->db->where('DATE(jobcardhed.appoimnetDate) <=', $enddate);
            //     }
            //     if (isset($startdate) && $startdate != '' ) {
            //     $this->db->where('DATE(jobcardhed.appoimnetDate) >=', $startdate);
            //     }
            // }
                 if (isset($route) && $route != '' ) {
                $this->db->where('jobcardhed.JLocation',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('jobcardhed.JCustomer',$customer);
                  }
                   
              return $this->db->get()->result();
    }


    ///////////////////////////////////////////////////////////////////////////////////////

    public function customercreditsummary($startdate, $enddate, $route,$isall,$customer,$newsalesperson) {
        
            $this->db->select('customer.MobileNo,creditinvoicedetails.CusCode,
                            DATE(creditinvoicedetails.InvoiceDate) AS InvoiceDate,
                            creditinvoicedetails.InvoiceNo,
                            SUM(creditinvoicedetails.NetAmount) AS NetAmount,
                            SUM(creditinvoicedetails.CreditAmount) AS CreditAmount,
                            SUM(creditinvoicedetails.SettledAmount) AS SettledAmount,
                            SUM(creditinvoicedetails.returnAmount) AS ReturnAmount,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobCardNo,
                            jobinvoicehed.JRegNo,
                            salespersons.RepName,
                            customer.RouteId');
                $this->db->from('creditinvoicedetails');
                $this->db->join('jobinvoicehed','creditinvoicedetails.InvoiceNo=jobinvoicehed.JobInvNo','left');
                $this->db->join('customer','creditinvoicedetails.CusCode = customer.CusCode');
                $this->db->join('salespersons','salespersons.RepID=customer.HandelBy','left');
                // $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('creditinvoicedetails.IsCancel',0);
//                 $this->db->where('creditinvoicedetails.Type!=',2);
                if (isset($isall) && $isall == 0 ) {
                    if (isset($enddate) && $enddate != '' ) {
                    $this->db->where('DATE(creditinvoicedetails.InvoiceDate) <=', $enddate);
                    }
                    if (isset($startdate) && $startdate != '' ) {
                    $this->db->where('DATE(creditinvoicedetails.InvoiceDate) >=', $startdate);
                    }
                }
                if (isset($newsalesperson) && $newsalesperson != '' ) {
                    $this->db->where('salespersons.RepID',$newsalesperson);
                 }

                 if (isset($route) && $route != '' ) {
                    $this->db->where_in(' customer.RouteId',$route);
                 }
                if (isset($customer) && $customer != '' ) {
                    $this->db->where('creditinvoicedetails.CusCode',$customer);
                } 
//                $this->db->where('creditinvoicedetails.CreditAmount !=creditinvoicedetails.SettledAmount');
                $this->db->group_by('creditinvoicedetails.CusCode');
                $this->db->order_by('customer.CusName', 'ASC');
                
              return $this->db->get()->result();
    }

    public function customerjobcommission($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('customer.MobileNo,
                            DATE(jobinvoicehed.JobInvoiceDate) AS InvoiceDate,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            jobinvoicehed.JobInvNo AS InvoiceNo,
                            jobinvoicehed.JobCommsion  AS commission');
                $this->db->from('jobinvoicehed');
                $this->db->join('customer','jobinvoicehed.JobComCus = customer.CusCode');
                // $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('jobinvoicehed.IsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(jobinvoicehed.JobInvoiceDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('jobinvoicehed.JobLocation',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('jobinvoicehed.JobComCus',$customer);
                  }
                 // $this->db->where('creditinvoicedetails.CreditAmount !=creditinvoicedetails.SettledAmount'); 
                  $this->db->order_by('jobinvoicehed.JobInvoiceDate');
                   
              return $this->db->get()->result();
    }

    public function customersalecommission($startdate, $enddate, $route = NULL,$isall,$customer) {
        
            $this->db->select('customer.MobileNo,
                            DATE(salesinvoicehed.SalesDate) AS InvoiceDate,
                            customer.CusName,
                            customer.RespectSign,
                            customer.Address01,
                            customer.Address02,
                            salesinvoicehed.SalesInvNo AS InvoiceNo,
                            salesinvoicehed.SalesCommsion AS commission');
                $this->db->from('salesinvoicehed');
                $this->db->join('customer','salesinvoicehed.SalesComCus = customer.CusCode');
                // $this->db->where('creditinvoicedetails.CreditAmount > creditinvoicedetails.SettledAmount');
                 $this->db->where('salesinvoicehed.InvIsCancel',0);
            if (isset($isall) && $isall == 0 ) {
                if (isset($enddate) && $enddate != '' ) {
                $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
                }
                if (isset($startdate) && $startdate != '' ) {
                $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
                }
            }
                 if (isset($route) && $route != '' ) {
                $this->db->where('salesinvoicehed.SalesLocation',$route);
                 }
                  if (isset($customer) && $customer != '' ) {
                $this->db->where('salesinvoicehed.SalesComCus',$customer);
                  }
                 // $this->db->where('creditinvoicedetails.CreditAmount !=creditinvoicedetails.SettledAmount'); 
                  $this->db->order_by('salesinvoicehed.SalesDate');
                   
              return $this->db->get()->result();
    }

    public function gencashreportbyeasydaterangesummary($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('invoice_hed.InvNo,SUM(invoice_hed.DownPayment) AS DownPayment,invoice_hed.FinalAmount, (invoice_hed.FinalAmount + invoice_hed.DownPayment) AS DueAmount,
                           DATE(invoice_hed.InvDate) AS InvDate,                                              
                           (invoice_hed.FinalAmount) AS NetAmount,
                           (invoice_hed.DisAmount) AS TotalDiscount');
        $this->db->from('invoice_hed');
//        $this->db->join('invoice_hed', 'invoice_hed.InvNo = invoice_dtl.InvNo', 'INNER');
//        $this->db->join('product', 'product.ProductCode = invoice_dtl.InvProductCode', 'left');
        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoice_hed.InvDate) >=', $startdate);
        $this->db->where('invoice_hed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
        $this->db->group_by('DATE(invoice_hed.InvDate)');
        $this->db->order_by('DATE(invoice_hed.InvDate)');
        $result=$this->db->get()->result();
        return $result;
    }

    public function gencashreportbypartdaterangesummery($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('salesinvoicehed.SalesInvNo,SUM(salesinvoicehed.SalesCashAmount) AS SalesCashAmount,salesinvoicehed.SalesChequeAmount,salesinvoicehed.SalesBankAmount,salesinvoicehed.SalesCreditAmount,salesinvoicehed.SalesCCardAmount,SalesAdvancePayment,
                           DATE(salesinvoicehed.SalesDate) AS InvDate,
                           (salesinvoicehed.SalesNetAmount) AS NetAmount,
                           (salesinvoicehed.SalesDisAmount) AS TotalDiscount');
        $this->db->from('salesinvoicehed');
//        $this->db->join('salesinvoicehed', 'salesinvoicehed.SalesInvNo = salesinvoicedtl.SalesInvNo', 'INNER');
//        $this->db->join('product', 'product.ProductCode = salesinvoicedtl.SalesProductCode', 'left');
        $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
        $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
        $this->db->where('salesinvoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('salesinvoicehed.SalesLocation', $locationAr);
        }
        $this->db->group_by('DATE(salesinvoicehed.SalesDate)');
        $this->db->order_by('DATE(salesinvoicehed.SalesDate)');
        $result=$this->db->get()->result();
        return $result;
    }

    public function totaleasycuspaymentsummarydaterangesummery($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {

        $this->db->select('rental_paid.*,SUM(rental_paid.PayAmount) AS PayAmount,customer.CusName,customer.CusCode,customer.RespectSign');
        $this->db->from('rental_paid');
        $this->db->join('customer', 'customer.CusCode = rental_paid.CusCode', 'INNER');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('IsCancel', 0);
        $this->db->where('rental_paid.PaymentType', 1);
        $this->db->group_by('DATE(rental_paid.PayDate)');
        $this->db->order_by('DATE(rental_paid.PayDate)');
//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function totalcusodercuspaymentsummarydaterangesummery($startdate, $enddate, $location = NULL,$locationAr = NULL,$type)
    {
        $this->db->select('customerorderpayment.*,SUM(customerorderpayment.PayAmount) AS PayAmount,customer.CusName,customerorderhed.PO_No,customerorderhed.SupCode');
        $this->db->from('customerorderpayment');
        $this->db->join('customerorderhed', 'customerorderhed.PO_No = customerorderpayment.OrderNo', 'INNER');
        $this->db->join('customer', 'customer.CusCode = customerorderhed.SupCode', 'INNER');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        // $this->db->where('IsCancel', 0);
        $this->db->where('customerorderpayment.PayType', 1);
        $this->db->group_by('DATE(customerorderpayment.PayDate)');
        $this->db->order_by('DATE(customerorderpayment.PayDate)');
//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }
    
    public function monthlyreportbydate($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select('SUM(salesinvoicehed.SalesCashAmount) AS SalesCashAmount,
        SUM(salesinvoicehed.SalesChequeAmount) AS SalesChequeAmount,
        SUM(salesinvoicehed.SalesBankAmount) AS SalesBankAmount,
        SUM(salesinvoicehed.SalesCreditAmount) AS SalesCreditAmount,
        SUM(salesinvoicehed.SalesCCardAmount) AS SalesCCardAmount,
        SUM(SalesAdvancePayment) AS SalesAdvancePayment,
        CONCAT(YEAR(salesinvoicehed.SalesDate),"-",MONTHNAME(salesinvoicehed.SalesDate)) AS sdDate,
        DATE(salesinvoicehed.SalesDate) AS InvDate,
        SUM(salesinvoicehed.SalesNetAmount) AS NetAmount,
        SUM(salesinvoicehed.SalesDisAmount) AS TotalDiscount');
        $this->db->from('salesinvoicehed');
        $this->db->where('DATE(salesinvoicehed.SalesDate) <=', $enddate);
        $this->db->where('DATE(salesinvoicehed.SalesDate) >=', $startdate);
        $this->db->where('salesinvoicehed.InvIsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('salesinvoicehed.SalesLocation', $locationAr);
        }
        $this->db->group_by('sdDate');
        $this->db->order_by('sdDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function monthlyreportbydateeasy($startdate, $enddate, $location = NULL, $locationAr = NULL) {
        $this->db->select(' SUM(invoice_hed.DownPayment) AS SalesCashAmount,
                            SUM(invoice_hed.FinalAmount) AS FinalAmount, 
                            SUM(invoice_hed.FinalAmount + invoice_hed.DownPayment) AS DueAmount,
                            CONCAT(YEAR(invoice_hed.InvDate),"-",MONTHNAME(invoice_hed.InvDate)) AS sdDate,
                            DATE(invoice_hed.InvDate) AS InvDate,
                           (invoice_hed.FinalAmount) AS NetAmount,
                           (invoice_hed.DisAmount) AS TotalDiscount');
        $this->db->from('invoice_hed');
        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
        $this->db->where('DATE(invoice_hed.InvDate) >=', $startdate);
        $this->db->where('invoice_hed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
        $this->db->group_by('sdDate');
        $this->db->order_by('sdDate');
        $result=$this->db->get()->result();
        return $result;
    }

    public function monthlyreportbydateeasypay($startdate, $enddate, $location = NULL,$locationAr = NULL) {

        $this->db->select('SUM(rental_paid.TotalPayment) AS TotalPayment,
        SUM(CASE WHEN rental_paid.PaymentType = 1 THEN rental_paid.PayAmount ELSE 0 END) AS SalesCashAmount,
        SUM(CASE WHEN rental_paid.PaymentType = 4 THEN rental_paid.PayAmount ELSE 0 END) AS SalesCCardAmount,
        SUM(CASE WHEN rental_paid.PaymentType = 8 THEN rental_paid.PayAmount ELSE 0 END) AS SalesBankAmount,
        SUM(rental_paid.ChequePayment) AS SalesChequeAmount,
        CONCAT(YEAR(rental_paid.PayDate),"-",MONTHNAME(rental_paid.PayDate)) AS sdDate,
        rental_paid.PayDate');
        $this->db->from('rental_paid');
        $this->db->where('DATE(PayDate) <=', $enddate);
        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('IsCancel', 0);

        $this->db->group_by('sdDate');
        $this->db->order_by('sdDate');
//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }
        $result=$this->db->get()->result();
//        echo $this->db->last_query(); die;

        return $result;
    }

    public function monthlyreportbydatecustomerorderpayment($startdate, $enddate, $location = NULL,$locationAr = NULL)
    {
        $this->db->select('SUM(customerorderpayment.PayAmount) AS TotalPayment,
        SUM(CASE WHEN customerorderpayment.PayType = 1 THEN customerorderpayment.PayAmount ELSE 0 END) AS SalesCashAmount,
        SUM(CASE WHEN customerorderpayment.PayType = 4 THEN customerorderpayment.PayAmount ELSE 0 END) AS SalesCCardAmount,
        SUM(CASE WHEN customerorderpayment.PayType = 3 THEN customerorderpayment.PayAmount ELSE 0 END) AS SalesChequeAmount,
        SUM(CASE WHEN customerorderpayment.PayType = 8 THEN customerorderpayment.PayAmount ELSE 0 END) AS SalesBankAmount,
        CONCAT(YEAR(customerorderpayment.payDate),"-",MONTHNAME(customerorderpayment.payDate)) AS sdDate,
        customerorderpayment.payDate');
        $this->db->from('customerorderpayment');
        $this->db->where('DATE(payDate) <=', $enddate);
        $this->db->where('DATE(payDate) >=', $startdate);
//        $this->db->where('IsCancel', 0);

        $this->db->group_by('sdDate');
        $this->db->order_by('sdDate');

//        if (isset($location) && $location != '') {
//            $this->db->where_in('customerpaymenthed.Location', $locationAr);
//        }

        return $this->db->get()->result();
    }

    public function monthlyreportbyexpensess($startdate, $enddate, $location = NULL,$locationAr = NULL) {

        $this->db->select('SUM(cashinout.CashAmount) AS Expenses,
        CONCAT(YEAR(cashinout.InOutDate),"-",MONTHNAME(cashinout.InOutDate)) AS sdDate');
        $this->db->from('cashinout');
        $this->db->join('transactiontypes', 'transactiontypes.TransactionCode = cashinout.TransCode', 'INNER');
        $this->db->where('DATE(InOutDate) <=', $enddate);
        $this->db->where('DATE(InOutDate) >=', $startdate);
        $this->db->where('Mode=', 'Out');
        $this->db->where_in('cashinout.Location', $locationAr);
        $this->db->group_by('sdDate');
        $this->db->order_by('sdDate');

        return $this->db->get()->result();
    }
    
    public function totaleasycuspaymentsummarybydate($startdate, $enddate, $location = NULL,$locationAr = NULL,$type) {

        $this->db->select('invoice_hed.*,customer.CusName,customer.CusCode,customer.RespectSign,customer.ContactNo');
        $this->db->from('invoice_hed');
        $this->db->join('customer', 'customer.CusCode = invoice_hed.CusCode', 'INNER');
        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
//        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
//        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('IsComplete', 0);
//        $this->db->group_by('rental_paid.InvNo');

        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
//        $this->db->get();
//        echo  $this->db->last_query(); die();
        return $this->db->get()->result();
    }

    public function totaleasycuspaymentsummarybydatepaydetails($enddate, $location = NULL,$locationAr = NULL,$type)
    {
        $this->db->select('invoice_hed.InvNo,COUNT(rental_payment_dtl.InvNo) AS dueterm');
        $this->db->from('invoice_hed');
        $this->db->join('rental_payment_dtl', 'rental_payment_dtl.InvNo = invoice_hed.InvNo', 'INNER');
        $this->db->where('DATE(rental_payment_dtl.PaymentDate) <=', $enddate);
//        $this->db->where('DATE(invoice_hed.InvDate) <=', $enddate);
//        $this->db->where('DATE(PayDate) >=', $startdate);
        $this->db->where('invoice_hed.IsComplete', 0);
        $this->db->where('rental_payment_dtl.IsPaid', 0);
//        $this->db->group_by('rental_paid.InvNo');

        if (isset($location) && $location != '') {
            $this->db->where_in('invoice_hed.Location', $locationAr);
        }
        $this->db->group_by('rental_payment_dtl.InvNo');
//        $this->db->get();
//        echo  $this->db->last_query(); die();
        return $this->db->get()->result();
    }

    public function genIssuenoteByDate($startdate, $enddate, $location = NULL,$locationAr = NULL,$invtype,$salesperson= NULL) {
        if (isset($location) && $location != '') {
            $this->db->select('issuenote_hed.SalesPONumber,customer.MobileNo,customer.CusCode,DATE(issuenote_hed.SalesDate) As InvDate,(issuenote_hed.SalesDisAmount) AS DisAmount,issuenote_hed.SalesInvNo,
                                (issuenote_hed.SalesCashAmount) AS CashAmount,                          
                                (issuenote_hed.SalesInvAmount) AS InvAmount,
                                (issuenote_hed.SalesVatAmount) AS VatAmount,
                                (issuenote_hed.SalesNbtAmount) AS NbtAmount,
                                (issuenote_hed.SalesNetAmount) AS NetAmount,customer.CusName,
                                customer.RespectSign');
            $this->db->from('issuenote_hed');
            $this->db->join('customer', 'customer.CusCode = salesinvoicehed.SalesCustomer', 'INNER');
            $this->db->where('DATE(issuenote_hed.SalesDate) <=', $enddate);
            $this->db->where('DATE(issuenote_hed.SalesDate) >=', $startdate);
            $this->db->where_in('issuenote_hed.SalesLocation', $locationAr);
            $this->db->where('issuenote_hed.InvIsCancel', 0);
            if (isset($invtype) && $invtype != '') {
                $this->db->where('issuenote_hed.SalesInvType', $invtype);
            }

            if (isset($salesperson) && $salesperson != '') {
                $this->db->where('issuenote_hed.SalesPerson', $salesperson);
            }

            // $this->db->group_by('DATE(SalesInvNo)');
            $this->db->order_by('issuenote_hed.SalesDate', 'DESC');
            // $this->db->limit(50);
        } else {
            $this->db->select('issuenote_hed.SalesPONumber,customer.MobileNo,customer.CusCode,DATE(issuenote_hed.SalesDate) As InvDate,(issuenote_hed.SalesDisAmount) AS DisAmount,issuenote_hed.SalesInvNo,
                                (issuenote_hed.SalesCashAmount) AS CashAmount,                          
                                (issuenote_hed.SalesInvAmount) AS InvAmount,
                                (issuenote_hed.SalesVatAmount) AS VatAmount,
                                (issuenote_hed.SalesNbtAmount) AS NbtAmount,
                                (issuenote_hed.SalesNetAmount) AS NetAmount,customer.CusName,
                                customer.RespectSign');
            $this->db->from('issuenote_hed');
            $this->db->join('customer', 'customer.CusCode = issuenote_hed.SalesCustomer', 'INNER');
            $this->db->where('DATE(issuenote_hed.SalesDate) <=', $enddate);
            $this->db->where('DATE(issuenote_hed.SalesDate) >=', $startdate);
            $this->db->where('issuenote_hed.InvIsCancel', 0);
            if (isset($invtype) && $invtype != '') {
                $this->db->where('issuenote_hed.SalesInvType', $invtype);
            }

            if (isset($salesperson) && $salesperson != '') {
                $this->db->where('issuenote_hed.SalesPerson', $salesperson);
            }


            $this->db->order_by('issuenote_hed.SalesDate', 'DESC');
        }
        return $this->db->get()->result();
    }
    
    public function loadIssueNoteByJobs($startdate, $enddate, $location = NULL, $locationAr = NULL, $SalesPerson = NULL) {
        $this->db->select('jobcardhed.JobCardNo,
                           jobcardhed.appoimnetDate,
                           jobcardhed.JestimateNo,
                           jobcardhed.Advance,
                           issuenote_hed.*,customer.CusName,customer.CusCode,customer.RespectSign
                           ');
        $this->db->from('issuenote_hed');
        $this->db->join('jobcardhed', 'jobcardhed.JobCardNo = issuenote_hed.SalesPONumber', 'INNER');
        $this->db->join('customer', 'customer.CusCode = jobcardhed.JCustomer', 'INNER');
        $this->db->where('DATE(jobcardhed.appoimnetDate) <=', $enddate);
        $this->db->where('DATE(jobcardhed.appoimnetDate) >=', $startdate);
        $this->db->where('jobcardhed.IsCancel', 0);
        if (isset($location) && $location != '') {
            $this->db->where_in('jobcardhed.JLocation', $locationAr);
        }

        if (isset($SalesPerson) && $SalesPerson != '') {
            $this->db->where_in('issuenote_hed.SalesPerson', $SalesPerson);
        }

        $this->db->order_by('jobcardhed.JobCardNo');

        $result=$this->db->get();

        $list = array();
        foreach ($result->result() as $row) {
            $list[$row->JobCardNo." | ".$row->appoimnetDate." | ".$row->JobCardNo." | ".$row->CusName." ------------ Total Advance Amount - ".$row->Advance][] = $row;
        }
        return $list;
    }
}
