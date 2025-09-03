
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-power-off myclose"></i></button>
        <!-- <center><h4>Edit Spare Part Description</h4></center> -->
        <hr style="border-width: 3px; border-color: #63abd8;">
        </div>

    </div>
    <div class="modal-body" style="margin-left: 150px;">
        <div class="row">
            <div class="col-md-8">
                <form id="salespersons_payment">
                <div class="form-group">
                    <label for="salesPersons" class="control-label">Employee</label>
                    <select name="salesPersons" id="salesPersons" class="form-control" required="true">
                    <option value="0">------ Select ------</option> 
                    <?php foreach ($salesPersons as $trns) { ?>
                    <option value="<?php echo $trns->EmpNo; ?>"><?php echo $trns->RepName ?></option>                     
                    <?php } ?>
                    </select>
                </div> 
                <div class="form-group">
                    <label for="netamount" class="control-label">Net Amount</label>
                    <?php foreach ($jobinvoicedtl as $trn) { ?>
                    <input type="number" name="netamount" id="netamount" class="form-control" placeholder="Enter Amount "  required="true" value="<?php echo $trn->JobNetAmount; ?>">
                    <input type="hidden" name="jobinvNo" id="jobinvNo" value="<?php echo $trn->JobInvNo; ?>">
                    <input type="hidden" name="jobinvoicedtlid" id="jobinvoicedtlid" value="<?php echo $trn->jobinvoicedtlid; ?>">
                         <input type="hidden" name="JobCode" id="JobCode" value="<?php echo $trn->JobCode; ?>">

                    <?php } ?>
                </div> 
                <div class="form-group">
                    <label for="payment" class="control-label">Amount</label>
                    <input type="text" name="payment" id="payment" class="form-control" placeholder="Enter Amount " required="true">
                </div>    
                  <div class="form-group">
                <center>
                <button class="btn btn-s btn-primary" id="add" type="submit">Save</button>
                </center>
                </div>
                  </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $("#salespersons_payment").submit(function(e) { 
    var netAmount = $("#netamount").val();
    var amount = $("#payment").val();
    var salesPersons = $("#salesPersons").val();

    if(salesPersons=="0" || salesPersons==""){
        $.notify("Select Employee..", "warring");
    }else if(amount<netAmount || amount==netAmount){
        $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/saveSalepersonPayment",
                    data: $("#salespersons_payment").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];

                        if (feedback == true) {
                            $.notify("Employee Payment Successfuly Added..", "success");
                        }else if(feedback == 2){
                            $.notify("Employee Payment Already Exist..", "warring");
                        }else if(feedback == 4){
                            $.notify("Already Paid..", "warring");
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                }); 
    }else{
        $.notify("Enter Equal or Minumum Value less than Net Amount..", "warring");
    }  
        e.preventDefault();
        });

         
    
    </script>  

