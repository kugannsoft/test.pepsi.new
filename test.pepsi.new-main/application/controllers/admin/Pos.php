<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/Product_model');
        date_default_timezone_set("Asia/Colombo");
        
    }

    public function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_pos'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
           $this->data['plv'] = $this->Product_model->loadpricelevel();
           $id = array('IsActive' => '1');
           $this->data['customers'] = $this->Product_model->get_data_by_where('customer',$id);
           $location =$_SESSION['location'];$id2 = array('IsActive' => '1','LocationCode' => $location);
           $this->data['salePerson'] = $this->Product_model->get_data_by_where('salespersons',$id2);
           $this->data['bank'] = $this->db->select()->from('bank')->get()->result();
           $this->load->model('admin/Pos_model');
           $id3 = array('CompanyID' => $location);
           $this->data['company'] = $this->Pos_model->get_data_by_where('company',$id3);

            /* Load Template */
            $this->template->admin_render('admin/pos/index', $this->data);
        }
    }

    public function all_pos_invoice() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        } else {
            /* Title Page */
            $this->page_title->push(lang('menu_pos'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
           $this->data['plv'] = $this->Product_model->loadpricelevel();
           $id = array('IsActive' => '1');
           $this->data['customers'] = $this->Product_model->get_data_by_where('customer',$id);
           $location =$_SESSION['location'];$id2 = array('IsActive' => '1','LocationCode' => $location);
           $this->data['salePerson'] = $this->Product_model->get_data_by_where('salespersons',$id2);
           $this->load->model('admin/Pos_model');
           $id3 = array('CompanyID' => $location);
           $this->data['company'] = $this->Pos_model->get_data_by_where('company',$id3);

            /* Load Template */
            $this->template->admin_render('admin/pos/all-pos-invoices', $this->data);
        }
    }

    public function printInvoice(){
        $this->load->model('admin/Pos_model');
        die;
    }

    public function saveInvoice2(){
        
       var_dump($_POST);die;
        $action = $_POST['action'];
        $this->load->model('admin/Pos_model');
        $invoiceNo = $this->Pos_model->get_max_code('Point Of Sales');
        $invDate =date("Y-m-d H:i:s");
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
        
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);
        
        $isComplete =0;
        $cashAmount = $_POST['cash_amount'];
        $cardAmount = $_POST['card_amount'];
        $creditAmount = $_POST['credit_amount'];
        
        $customer_payment =$cashAmount+$cardAmount;
        if($customer_payment>=$_POST['final_amount']){$isComplete=1;}
        $disPrent =(100*$_POST['total_discount'])/$_POST['total_amount'];
        $invHed = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvLocation'=>$_POST['location'],
            'Inv_PO_No'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvCounterNo'=>1,
            'InvRootNo'=>1,
            'InvCustomer'=>$_POST['cusCode'],
            'InvDisAmount'=>$_POST['total_discount'],
            'InvDisPercentage'=>$disPrent,
            'InvCashAmount'=>$_POST['cash_amount'],
            'InvCCardAmount'=>$_POST['card_amount'],
            'InvCreditAmount'=>$_POST['credit_amount'],
            'InvReturnPayment'=>$_POST['return_amount'],
            'InvGiftVAmount'=>0,
            'InvLoyaltyAmount'=>0,
            'InvStarPoints'=>0,
            'InvChequeAmount'=>0,
            'InvAmount'=>$_POST['total_amount'],
            'InvIsVat'=>$_POST['isTotalVat'],
            'InvVatAmount'=>$_POST['totalVat'],
            'InvIsNbt'=>$_POST['isTotalNbt'],
            'InvNbtRatioTotal'=>$_POST['nbtRatioRate'],
            'InvNbtAmount'=>$_POST['totalNbt'],
            'InvNetAmount'=>$_POST['final_amount'],
            'InvCustomerPayment'=>$customer_payment,
            'InvCostAmount'=>$_POST['total_cost'],
            'InvRefundAmount'=>$_POST['refund_amount'],
            'InvUser'=>$_POST['invUser'],
            'InvHold'=>0,
            'InvIsCancel'=>0,
            'IsComplete'=>$isComplete,
            'Flag'=>0);

         for ($i = 0; $i < count($product_codeArr); $i++) {
             $proDisPrent = (100*$pro_discountArr[$i])/$totalNetWODisArr[$i];
                $invDtl = array(
                    'AppNo' => '1',
                    'InvNo'=>$invoiceNo,
                    'InvLocation'=>$_POST['location'],
                    'InvDate'=>$invDate,
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
                $this->Pos_model->insert_data('invoicedtl',$invDtl);
                   // $this->Pos_model->stockUpdate($product_codeArr[$i],$qtyArr[$i],$price_levelArr[$i],$cost_priceArr[$i],$sell_priceArr[$i],$_POST['location'],$serial_noArr[$i],$freeQtyArr[$i],0,0);

         }
         
         if($cashAmount>0){
             $invPay = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvPayType'=>'Cash',
            'InvPayAmount'=>$cashAmount);
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay);
         }
         
         if($cardAmount>0){
             for ($k = 0; $k < count($ccNameArr); $k++) {
             $invPay2 = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvPayType'=>'Card',
            'Mode'=>$ccNameArr[$k],
            'Reference'=>$ccRefArr[$k],
            'InvPayAmount'=>$ccAmountArr[$k]);
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay2);
             }
         }
         
         if($creditAmount>0){
             $invPay3 = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvPayType'=>'Credit',
            'InvPayAmount'=>$creditAmount);
                     
             $this->Pos_model->insert_data('invoicepaydtl',$invPay3);
         }
         
     $res2 =$this->Pos_model->insert_data('invoicehed',$invHed);
       $this->Pos_model->update_max_code('Point Of Sales'); 
       $return = array(
           'InvNo'=>$invoiceNo,
           'InvDate'=>$invDate
        );
       $return['fb']=$res2;
         echo json_encode($return);
        die;
    }
    
     public function saveInvoice(){
         $location=$_POST['location'];
//        var_dump($_POST);die;
        $action = $_POST['action'];
        $this->load->model('admin/Pos_model');
        if($action ==1){
            $invoiceNo = $this->Pos_model->get_max_code('Point Of Sales'.$location);
        }elseif ($action ==2) {
            $invoiceNo = $_POST['invoiceNo'];
        }else{
            $invoiceNo = $this->Pos_model->get_max_code('Point Of Sales'.$location);
        }
        
        $invDate =date("Y-m-d H:i:s");
       if($_POST['invDate']=='invDate'){
           $invDate = date("Y-m-d H:i:s");
       }elseif(isset($_POST['invDate']) && $_POST['invDate']!=''){
           $invDate = $_POST['invDate'].date(" H:i:s");
       }else{
           $invDate =date("Y-m-d H:i:s");
       }
        $ccAmountArr =json_decode($_POST['ccAmount']);
        $ccTypeArr =json_decode($_POST['ccType']);
        $ccRefArr =json_decode($_POST['ccRef']);
        $ccNameArr =json_decode($_POST['ccName']);
        
        $isComplete =0;
        $cashAmount = $_POST['cash_amount'];
        $cardAmount = $_POST['card_amount'];
        $creditAmount = $_POST['credit_amount'];
        $chequeAmount= $_POST['cheque_amount'];
        
        $customer_payment =$cashAmount+$cardAmount+$chequeAmount;
        $cashAmount = $_POST['final_amount']-$creditAmount-$cardAmount-$chequeAmount;
        if($customer_payment>=$_POST['final_amount']){$isComplete=1;}
        if($_POST['total_amount']!=0){
            $disPrent =(100*$_POST['total_discount'])/$_POST['total_amount'];
        }else{
            $disPrent =0;
        }
        $invHed = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvLocation'=>$_POST['location'],
            'Inv_PO_No'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvCounterNo'=>1,
            'InvRootNo'=>1,
            'InvCustomer'=>$_POST['cusCode'],
            'InvDisAmount'=>$_POST['total_discount'],
            'InvDisPercentage'=>$disPrent,
            'InvCashAmount'=>$cashAmount,
            'InvCCardAmount'=>$_POST['card_amount'],
            'InvCreditAmount'=>$_POST['credit_amount'],
            'InvReturnPayment'=>$_POST['return_amount'],
            'InvGiftVAmount'=>0,
            'InvLoyaltyAmount'=>0,
            'InvStarPoints'=>0,
            'InvChequeAmount'=>0,
            'InvAmount'=>$_POST['total_amount'],
            'InvIsVat'=>$_POST['isTotalVat'],
            'InvVatAmount'=>$_POST['totalVat'],
            'InvIsNbt'=>$_POST['isTotalNbt'],
            'InvNbtRatioTotal'=>$_POST['nbtRatioRate'],
            'InvNbtAmount'=>$_POST['totalNbt'],
            'InvNetAmount'=>$_POST['final_amount'],
            'InvCustomerPayment'=>$customer_payment,
            'InvCostAmount'=>$_POST['total_cost'],
            'InvRefundAmount'=>$_POST['refund_amount'],
            'InvUser'=>$_POST['invUser'],
            'InvHold'=>0,
            'InvIsCancel'=>0,
            'IsComplete'=>$isComplete,
            'Flag'=>0,
            'InvType'=>$_POST['invoiceType']);
        
        
             $invPay = array(
            'AppNo' => '1',
            'InvNo'=>$invoiceNo,
            'InvDate'=>$invDate,
            'InvPayType'=>'Cash',
            'InvPayAmount'=>$cashAmount,
            'InvCusCode'=>$_POST['cusCode']);
        $res2=$this->Pos_model->saveInvoiceDtl($invHed,'',$invPay,$_POST,'',$invoiceNo);

        $return = array(
           'InvNo'=>$invoiceNo,
           'InvDate'=>$invDate
        );
       $return['fb']=$res2;
         echo json_encode($return);
        die;
    }

    public function loadallposinvoices() {
        $this->load->library('Datatables');
        $this->datatables->select('*');
        $this->datatables->from('invoicehed');
        echo $this->datatables->generate();
        die();
    }

    public function view_invoice($inv=null) {
            $this->load->model('admin/Pos_model');
            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Pos Invoices');
            $this->data['pagetitle'] = 'Pos Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Invoices', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'View Invoice', 'admin/pos/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;
            $this->data['inv_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->where('InvNo', $invNo)->get()->result();
            $this->data['invHed']=  $this->db->select('*')
                ->from('invoicehed')->where('InvNo',$invNo)->get()->row();
            $cusCode =  $this->db->select('InvCustomer')->from('invoicehed')->where('InvNo',$invNo)->get()->row()->InvCustomer;

            $isjob = $this->db->select('InvJobCardNo')->from('invoicehed')->where('InvNo', $invNo)->get()->row()->InvJobCardNo;
           if($isjob!=''){
                $regNo =  $this->db->select('JRegNo')->from('invoicehed')->join('jobcardhed','jobcardhed.JobCardNo=invoicehed.InvJobCardNo')->where('invoicehed.InvNo',$invNo)->get()->row()->JRegNo;
           }else{
                $regNo ='';
           }
            

            // echo $regNo;die;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode','left')->where('customer.CusCode',$cusCode)->get()->row();
                if($regNo!=''){
                    $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,RegNo')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make','left')->join('model','model.model_id=vehicledetail.Model','left')->where('vehicledetail.RegNo',$regNo)->get()->row();
                }else{
                     $this->data['invVehi']=null;
                }
            

            // $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn')
            //     ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();

            $isCard = $this->db->select('InvNo')->from('invoicepaydtl')->where('InvNo', $invNo)->where('InvPayType','Card')->get()->num_rows();
            if($isCard>0){
            $this->data['card_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName,FLOOR(invoicepaydtl.InvPayAmount)  As JobAmount')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->where('InvNo', $invNo)->where('InvPayType','Card')->get()->row();
        }else{
             $this->data['card_pay'] ='';
        }

        $isCheque = $this->db->select('InvNo')->from('invoicepaydtl')->where('InvNo', $invNo)->where('InvPayType','Cheque')->get()->num_rows();
            if($isCheque>0){
                $this->data['cheque_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName,chequedetails.*,FLOOR(invoicepaydtl.InvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->join('chequedetails', 'chequedetails.ReferenceNo = invoicepaydtl.InvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('InvNo', $invNo)->where('InvPayType','Cheque')->get()->row();   
            }else{
                $this->data['cheque_pay'] ='';
            }

            $result=$this->db->select('invoicedtl.*,product.Prd_AppearName AS Description')->from('invoicedtl')->join('product', 'invoicedtl.InvProductCode = product.ProductCode', 'INNER')->where('invoicedtl.InvNo', $invNo)->order_by('invoicedtl.InvLineNo','ASC')->get()->result();
            // $list = array();
            // foreach ($result->result() as $row) {
            //     $list[$row->Description][] = $row;
            // }
        
            $this->data['invDtl']=$result;         
            $this->template->admin_render('admin/pos/view-invoice', $this->data);
    }

    public function print_invoice_pdf($inv=null){
            $this->load->model('admin/Pos_model');
            $invNo=base64_decode($inv);
            /* Title Page */
            $id = isset($_GET['id'])?$_GET['id']:NULL;
            $type = isset($_GET['type'])?$_GET['type']:NULL;
            $sup = isset($_GET['sup'])?$_GET['sup']:0;

            $this->page_title->push('Sales Invoices');
            $this->data['pagetitle'] = 'Job Invoice-'.$invNo;
            /* Breadcrumbs */
            $this->breadcrumbs->unshift(1, 'Job Card', 'admin/sales/');
            $this->breadcrumbs->unshift(1, 'Create Job Card', 'admin/sales/view_invoice');
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            $location = $_SESSION['location'];
            $id3 = array('CompanyID' => $location);
            $this->data['company'] = $this->Pos_model->get_data_by_where('company', $id3);
            
            $this->data['jobtypes'] = $this->db->select()->from('jobtype')->order_by("jobtype_order", "asc")->get()->result();
            $this->data['id'] = $id;
            $this->data['type'] = $type;
            $this->data['sup'] = $sup;
            $this->data['invNo'] = $invNo;
            $this->data['inv_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->where('InvNo', $invNo)->get()->result();
            $this->data['invHed']=  $this->db->select('*')
                ->from('invoicehed')->where('InvNo',$invNo)->get()->row();
            $cusCode =  $this->db->select('InvCustomer')->from('invoicehed')->where('InvNo',$invNo)->get()->row()->InvCustomer;

            $isjob = $this->db->select('InvJobCardNo')->from('invoicehed')->where('InvNo', $invNo)->get()->row()->InvJobCardNo;
           if($isjob!=''){
                $regNo =  $this->db->select('JRegNo')->from('invoicehed')->join('jobcardhed','jobcardhed.JobCardNo=invoicehed.InvJobCardNo')->where('invoicehed.InvNo',$invNo)->get()->row()->JRegNo;
           }else{
                $regNo ='';
           }
            

            // echo $regNo;die;
            $this->data['invCus']= $this->db->select('customer.*')
                ->from('customer')->join('vehicledetail','vehicledetail.CusCode=customer.CusCode')->where('customer.CusCode',$cusCode)->get()->row();
                if($regNo!=''){
                    $this->data['invVehi']= $this->db->select('vehicledetail.ChassisNo,vehicledetail.contactName,make.make,model.model,RegNo')->from('vehicledetail')->join('make','make.make_id=vehicledetail.Make')->join('model','model.model_id=vehicledetail.Model')->where('vehicledetail.RegNo',$regNo)->get()->row();
                }else{
                     $this->data['invVehi']=null;
                }
            

            // $this->data['invjob']=  $this->db->select('customer_type.CusType,users.first_name,jobcardhed.OdoIn')
            //     ->from('jobinvoicehed')->join('jobcardhed','jobcardhed.JobCardNo=jobinvoicehed.JobCardNo')->join('customer_type','jobcardhed.JCusType=customer_type.CusTypeId')->join('users','jobinvoicehed.JobInvUser=users.id')->where('jobinvoicehed.JobInvNo',$invNo)->get()->row();

            $isCard = $this->db->select('InvNo')->from('invoicepaydtl')->where('InvNo', $invNo)->where('InvPayType','Card')->get()->num_rows();
            if($isCard>0){
            $this->data['card_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName,FLOOR(invoicepaydtl.InvPayAmount)  As JobAmount')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->where('InvNo', $invNo)->where('InvPayType','Card')->get()->row();
        }else{
             $this->data['card_pay'] ='';
        }

        $isCheque = $this->db->select('InvNo')->from('invoicepaydtl')->where('InvNo', $invNo)->where('InvPayType','Cheque')->get()->num_rows();
            if($isCheque>0){
                $this->data['cheque_pay'] = $this->db->select('invoicepaydtl.*,customer.CusName,chequedetails.*,FLOOR(invoicepaydtl.InvPayAmount)  As JobAmount,bank.BankName,DATE(chequedetails.ChequeDate) AS ChequeDate')->from('invoicepaydtl')->join('customer', 'customer.CusCode = invoicepaydtl.InvCusCode')->join('chequedetails', 'chequedetails.ReferenceNo = invoicepaydtl.InvNo','left')->join('bank', 'chequedetails.BankNo = bank.BankCode','left')->where('InvNo', $invNo)->where('InvPayType','Cheque')->get()->row();   
            }else{
                $this->data['cheque_pay'] ='';
            }

            $result=$this->db->select('invoicedtl.*,product.Prd_AppearName AS Description')->from('invoicedtl')->join('product', 'invoicedtl.InvProductCode = product.ProductCode', 'INNER')->where('invoicedtl.InvNo', $invNo)->order_by('invoicedtl.InvLineNo','ASC')->get()->result();
            // $list = array();
            // foreach ($result->result() as $row) {
            //     $list[$row->Description][] = $row;
            // }
        
            $this->data['invDtl']=$result;     
            $this->load->helper('file');
            $this->load->helper(array('dompdf'));

            // $this->load->view('admin/sales/sales-invoice-pdf', $this->data);

            $html = $this->load->view('admin/pos/pos-invoice-pdf', $this->data, true);
            pdf_create($html, 'filename', TRUE,'letter');
    }

}
