<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">

</style>
<div class="content-wrapper" id="app">
	<section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <?php if (in_array("SM42", $blockAdd) || $blockAdd == null) { ?>
                            <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                            <a href="<?php echo base_url('admin/Salesinvoice/Invoice'); ?>"
                               class="btn btn-flat btn-primary pull-right">All Received Invoices</a>
                        <?php } ?>
                        <!-- <input type="text" name="q" id="q" value="<?php echo $q; ?>"> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-md-12">
    			<table class="table table-bordered" id="invoicetbl">
	                <thead>
	                    <tr>
	                        <td>Received Invoice No</td>
                            <td>Customer</td>
	                        <td>Cus.Code</td>
	                        <td>Invoice Date</td>
	                        <td>Qty</td>
                            <td>###</td>
	                    </tr>
	                </thead>
	                <tbody>

	                </tbody>
	            </table>
    		</div>
    		
    	</div>
    </section>
</div>
<script type="text/javascript">
	 $('#invoicetbl').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('admin/invoice/loadallreceivedinvoices'); ?>",
            type: "POST"
        },
        columns: [
            { data: "InvoiceNo" },
            { data: "DisplayName" },
            { data: "CustomerID" },
            { data: "ReceivedDate" },
            { data: "Qty" },
            { 
              
                "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        return '<a href="<?php echo base_url() ?>admin/invoice/view_received_invoice/' + (row.id) + '"  class="btn btn-xs btn-default" >View</a>';
                    }
            },
            
        ]
    });


</script>