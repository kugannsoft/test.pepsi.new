<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <div style="margin-left:370px; ">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4">
            <form name="spare_Parts" id="spare_Parts" action="#" method="post">
                <div class="form-group">
                    <label for="invoiceNo" class="control-label">Invoice No<span class="required"></span></label>
                    <select name="invoiceNo" id="invoiceNo" class="form-control" required="true">
                    <option value="0">------------- Select -------------</option>
                    <?php foreach ($invoiceNo as $trns) { ?>
                        <option value="<?php echo $trns->JobInvNo; ?>"><?php echo $trns->JobInvNo; ?></option>
                         <?php } ?>
                    </select>
                </div>
                <center><p name="alert" id="alert" style="color: red;"></p></center>
                </form>
                 
                 <div class="form-group">
                 <center><h6 id="success" class="successs"></h6></center>
                 </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="producttbl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Job</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Price (Rs)</th>
                                    <th>Discount (Rs)</th>
                                    <th>VAT (Rs)</th>
                                    <th>NBT (Rs)</th>
                                    <th>Invoice Amount (Rs)</th>
                                    <th>####</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div style="margin-left: 35px; margin-right: 35px;">
            <div class="col-md-12">
                <div class="box" id="catDiv">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="paymentDetails">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Job Code</th>
                                    <th>Job Description</th>
                                    <th>Invoice No</th>
                                    <th>Amount (Rs)</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
    </div>
    <!--add department modal-->
    <div id="productmodal" class="modal fade bs-add-category-modal-lg"  role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-lg" style="width: 50%;">
            <div class="modal-content">
                <!-- load data -->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#invoiceNo').change(function(){
         var invoiceNO = $("#invoiceNo").val();
        $.ajax({
            url: "<?php echo base_url('admin/master/employee_payment_description/') ?>",
            type: 'POST',
            data: {id: invoiceNO},
            success: function(data) {
                var resultData = JSON.parse(data);
                var id=1;
                if (resultData) {
                    $("#producttbl tbody").html('');
                    $("#paymentDetails tbody").html('');
                    $.each(resultData.invoiceDetails, function(key, value){ 
                        var inId = value.jobinvoicedtlid;
                     $("#producttbl tbody").append("<tr><td>"+ id +"</td><td>"+ value.jobtype_name +"</td><td>"+ value.JobDescription +"</td><td>"+ value.JobQty +"</td><td>"+ value.JobPrice +"</td><td>"+ value.JobDiscount +"</td><td>"+ value.JobVatAmount +"</td><td>"+ value.JobNbtAmount +"</td><td>"+value.JobNetAmount+"</td><td><a  row_id="+ inId +" onclick='payment("+ inId +");' class='pay btn btn-xs btn-primary'>Payment</a></td></tr>");
                        id++;
                        });
                    
                    $.each(resultData.paymentDetails, function(key, value){ 
                        $("#paymentDetails tbody").append("<tr><td>"+ value.empNo +"</td><td>"+ value.jobCode +"</td><td>" + value.JobDescription+"</td><td>"+ value.jobinvNo +"</td><td>"+ value.amount +"</td></tr>");
                    });

                }
            }
        });
    }); 


            function payment(inId) {
                console.log(inId);
                $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_payment/', {id: inId}, function (result) {
                    $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
                });
            }
</script>
