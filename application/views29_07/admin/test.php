<?php
public
function cancelSalesInvoice()
{
    $checkRole = $_SESSION['role'];

// if Role is ADMIN (Role id ==1)
    if ($checkRole == 1) {

        $salesInvNo = $this->input->post('salesinvno');

        $this->db->trans_start();

        $cancelNo = $this->get_max_code('CancelSalesInvoice');
        $invCanel = array(
            'AppNo' => '1',
            'CancelNo' => $cancelNo,
            'Location' => $_SESSION['location'],
            'CancelDate' => date("Y-m-d H:i:s"),
            'SalesInvoiceNo' => $salesInvNo,
            'Remark' => $_POST['remark'],
            'CancelUser' => $_SESSION['user_id']);
        $this->db->insert('cancelsalesinvoice', $invCanel);

//check is made any previous paymen
        $isPay = $this->db->select('count(invoicesettlementdetails.InvNo) AS inv')->from('invoicesettlementdetails')->join('customerpaymenthed', 'invoicesettlementdetails.CusPayNo = customerpaymenthed.CusPayNo', 'INNER')->where('invoicesettlementdetails.InvNo', $salesInvNo)->where('customerpaymenthed.IsCancel', 0)->get()->row()->inv;

        if ($isPay > 0) {
            echo 2;
        } else {
//check invoice already cancel or not
            $query0 = $this->db->get_where('salesinvoicehed', array('SalesInvNo' => $invCanel['SalesInvoiceNo'], 'InvIsCancel' => 0));
            if ($query0->num_rows() > 0) {
                $query = $this->db->get_where('salesinvoicedtl', array('SalesInvNo' => $invCanel['SalesInvoiceNo']));
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as $row) {
//update serial stock
                        $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo'], 'Location' => $row['SalesInvLocation']))->get();
                        if ($ps->num_rows() > 0) {
                            $isPro = $this->db->select('SalesProductCode')->from('salesinvoicedtl')->where(array('SalesProductCode' => $row['SalesProductCode'], 'SalesSerialNo' => $row['SalesSerialNo'], 'SalesInvLocation' => $row['SalesInvLocation'], 'SalesInvNo' => $invCanel['SalesInvoiceNo']))->get();
// echo $isPro->num_rows();die;
                            if ($isPro->num_rows() > 0) {
// $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo']));
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
//$this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

//update product stock
//$this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')");
// }
                    }
                }

//update/ cancel credit invoice
                $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['SalesInvoiceNo']));
                if ($query2->num_rows() > 0) {
                    $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['SalesInvoiceNo']));
                    foreach ($query2->result_array() as $row) {
//update customer outstanding
                        $creditAmount = $row['CreditAmount'];
                        $cuscode = $row['CusCode'];
                        $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                    }
                }

//cancel cheques
                $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $invCanel['SalesInvoiceNo'], 'IsCancel' => 0, 'IsRelease' => 0,));
                if ($query3->num_rows() > 0) {
                    $this->db->update('chequedetails', array('IsCancel' => 1), array('ReferenceNo' => $invCanel['SalesInvoiceNo']));
                }

                $this->db->update('salesinvoicehed', array('InvIsCancel' => 1), array('SalesInvNo' => $invCanel['SalesInvoiceNo']));
                $this->update_max_code('CancelSalesInvoice');
                $this->db->trans_complete();
                echo $this->db->trans_status();
            } else {
                echo 3;
            }
        }
        die;
    } //  if login using other roles
    else {
        $salesInvNo = $this->input->post('salesinvno');
        $checkInvoiceAvailable = $this->db->get_where('salesinvoicehed', array('SalesInvNo' => $salesInvNo, 'SalesLocation' => $_SESSION['location']));

        if ($checkInvoiceAvailable->num_rows() > 0) {

            $this->db->trans_start();

            $cancelNo = $this->get_max_code('CancelSalesInvoice');
            $invCanel = array(
                'AppNo' => '1',
                'CancelNo' => $cancelNo,
                'Location' => $_SESSION['location'],
                'CancelDate' => date("Y-m-d H:i:s"),
                'SalesInvoiceNo' => $salesInvNo,
                'Remark' => $_POST['remark'],
                'CancelUser' => $_SESSION['user_id']);
            $this->db->insert('cancelsalesinvoice', $invCanel);

//check is made any previous paymen
            $isPay = $this->db->select('count(invoicesettlementdetails.InvNo) AS inv')->from('invoicesettlementdetails')->join('customerpaymenthed', 'invoicesettlementdetails.CusPayNo = customerpaymenthed.CusPayNo', 'INNER')->where('invoicesettlementdetails.InvNo', $salesInvNo)->where('customerpaymenthed.IsCancel', 0)->get()->row()->inv;

            if ($isPay > 0) {
                echo 2;
            } else {
//check invoice already cancel or not
                $query0 = $this->db->get_where('salesinvoicehed', array('SalesInvNo' => $invCanel['SalesInvoiceNo'], 'InvIsCancel' => 0));
                if ($query0->num_rows() > 0) {
                    $query = $this->db->get_where('salesinvoicedtl', array('SalesInvNo' => $invCanel['SalesInvoiceNo']));
                    if ($query->num_rows() > 0) {
                        foreach ($query->result_array() as $row) {
//update serial stock
                            $ps = $this->db->select('ProductCode')->from('productserialstock')->where(array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo'], 'Location' => $row['SalesInvLocation']))->get();
                            if ($ps->num_rows() > 0) {
                                $isPro = $this->db->select('SalesProductCode')->from('salesinvoicedtl')->where(array('SalesProductCode' => $row['SalesProductCode'], 'SalesSerialNo' => $row['SalesSerialNo'], 'SalesInvLocation' => $row['SalesInvLocation'], 'SalesInvNo' => $invCanel['SalesInvoiceNo']))->get();
// echo $isPro->num_rows();die;
                                if ($isPro->num_rows() > 0) {
// $this->db->update('productserialstock', array('Quantity' => 1), array('ProductCode' => $row['SalesProductCode'], 'SerialNo' => $row['SalesSerialNo']));
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
//$this->db->query("CALL SPT_UPDATE_PRICE_STOCK('$proCode','$totalGrnQty','$pl','$costp','$selp','$loc')");

//update product stock
//$this->db->query("CALL SPT_UPDATE_PRO_STOCK('$proCode','$totalGrnQty',0,'$loc')");
// }
                        }
                    }

//update/ cancel credit invoice
                    $query2 = $this->db->get_where('creditinvoicedetails', array('InvoiceNo' => $invCanel['SalesInvoiceNo'], 'Location' => $invCanel['Location']));
                    if ($query2->num_rows() > 0) {
                        $this->db->update('creditinvoicedetails', array('IsCancel' => 1), array('InvoiceNo' => $invCanel['SalesInvoiceNo'], 'Location' => $invCanel['Location']));
                        foreach ($query2->result_array() as $row) {
//update customer outstanding
                            $creditAmount = $row['CreditAmount'];
                            $cuscode = $row['CusCode'];
                            $this->db->query("CALL SPT_UPDATE_CUSOUTSTAND_RBACK('$cuscode','0','$creditAmount','0');");
                        }
                    }

//cancel cheques
                    $query3 = $this->db->get_where('chequedetails', array('ReferenceNo' => $invCanel['SalesInvoiceNo'], 'IsCancel' => 0, 'IsRelease' => 0,));
                    if ($query3->num_rows() > 0) {
                        $this->db->update('chequedetails', array('IsCancel' => 1), array('ReferenceNo' => $invCanel['SalesInvoiceNo']));
                    }

                    $this->db->update('salesinvoicehed', array('InvIsCancel' => 1), array('SalesInvNo' => $invCanel['SalesInvoiceNo'], 'SalesLocation' => $invCanel['Location']));
                    $this->update_max_code('CancelSalesInvoice');
                    $this->db->trans_complete();
                    echo $this->db->trans_status();
                } else {
                    echo 3;
                }
            }
            die;
        } else {
            echo 4;
            die;
        }
    }
}

?>