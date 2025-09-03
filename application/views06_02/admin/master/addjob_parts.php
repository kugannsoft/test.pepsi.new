<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <div style="margin-left:300px; ">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-8">
            <form name="spare_Parts" id="spare_Parts" action="#" method="post">
                <div class="form-group">
                    <label for="worktype" class="control-label">Job Type <span class="required">*</span></label>
                    <select name="workType" id="workType" class="form-control" required="true">
                    <option value="0">------Select------</option>
                    <?php foreach ($jobtype as $trns) { ?>
                        <option value="<?php echo $trns->jobtype_id; ?>" <?php if($trns->jobtype_id==2){echo 'disabled';} ?>  isVat="<?php echo $trns->isVat; ?>"  isNbt="<?php echo $trns->isNbt; ?>" nbtRatio="<?php echo $trns->nbtRatio; ?>"><?php echo $trns->jobtype_code."-".$trns->jobtype_name?></option>
                         <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Description <span class="required">*</span></label>
                    <select name="description" id="description" class="form-control" required="true">
                    <option value="0">------ Select ------</option>                  
                    </select>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Spare Parts</label>
                    <select name="spareParts" id="spareParts" class="form-control" required="true">
                    <option value="0">------ Select ------</option> 
                    <?php foreach ($spareParts as $trns) { ?>
                    <option value="<?php echo $trns->ProductCode; ?>"><?php echo $trns->Prd_Description.' =  Rs:'.$trns->Prd_CostPrice; ?></option>                     
                    <?php } ?>
                    </select>
                </div>
                 
                    <input type="hidden" id="cost" name="cost" class="form-control">
                <input type="hidden" id="desc" name="desc" class="form-control">
               
               
                <div class="form-group">
                    <label for="qty" class="control-label">Quantity of Spare Part</label>
                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Enter Quantity " required="true">
                </div>
                <div class="form-group">
                    <label for="qty" class="control-label">Free Issue</label>&nbsp &nbsp
                    <input class="prd_icheck"type="checkbox" name="freeIssue" id="freeIssue" value="1"> 
                </div>

                <center>
                <button class="btn btn-s btn-primary" id="add" type="submit">ADD</button>
                </center>
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
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                    <th>####</th>
                                    <th>####</th>
                                    <th>####</th>
                                </tr>
                            </thead>
                            <tbody  id="tbl_data">
                            
                            </tbody>
                        </table>
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

<script>
var id =0;
var Pid =0;
var idDes =0; 
   $('#workType').change(function() {
     id = $("#workType").val();
        $.ajax({
            url: "<?php echo base_url('admin/master/load_description/') ?>",
            type: 'POST',
            data: {id: id},
            success: function(data) {
                var resultData = JSON.parse(data);
                if (resultData) {
                    $.each(resultData, function(key, value) {
                        $("#description").append("<option value='" + value.JobDescNo + "'>" + value.JobDescription+ "</option>");
                    });
                }
            }
        });
    });
   $('#spareParts').change(function() {
     Pid = $("#spareParts").val();
        $.ajax({
            url: "<?php echo base_url('admin/master/Productdescription/') ?>",
            type: 'POST',
            data: {id: Pid},
            success: function(data) {
                var resultData = JSON.parse(data);
                if (resultData) {
                    $.each(resultData, function(key, value) {
                        $("#desc").val(value.Prd_Description);
                        $("#cost").val(value.Prd_CostPrice);
                        $("#code").val(value.ProductCode);
                    });


                }
            }
        });
    }); 



    $('#description').change(function(){
         idDes = $("#description").val();

        $.ajax({
            url: "<?php echo base_url('admin/master/Product_description/') ?>",
            type: 'POST',
            data: {id: idDes},
            success: function(data) {
                var resultData = JSON.parse(data);
                if (resultData) {
                    $.each(resultData, function(key, value){
                        if(value.free_issue==1){
                            var freeIssueStatus = "Free";
                        }else{
                            var freeIssueStatus = "Non";
                        }
                        $("#producttbl tbody").append("<tr><td>"+ value.spare_part_id +"</td><td>"+ value.spare_part_desc +"</td><td>"+ value.qty +"</td><td>"+ value.unit_price +"</td><td>"+ value.total_amount +"</td><td>"+freeIssueStatus+"</td><td><a  row_id="+ value.id +" onclick='edit("+ value.id +");' class='edit btn btn-xs btn-primary'>Edit</a></td><td><a  row_id="+ value.id +" onclick='del("+ value.id +");' class='del btn btn-xs btn-primary'>Delete</a></td></tr>");
                    });
                }
            }
        });
    }); 

    $("#spare_Parts").submit(function(e) {       
            if (id == '0' || id == '') {
                 $.notify("Please select a Job Type", "warning");
            } else if (idDes == '0' || idDes == '') {
                 $.notify("Please select a Description", "warning");
            } else if (Pid == '0' || Pid == '') {
                 $.notify("Please select a Spare Part", "warning");
            } else {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>" + "admin/master/saveSpareparts",
                    data: $("#spare_Parts").serialize(),
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        var feedback = resultData['fb'];

                        var id = resultData['id'];
                        var spare_part_id = resultData['spare_part_id'];
                        var spare_part_desc = resultData['spare_part_desc'];
                        var qty = resultData['qty'];
                        var unit_price = resultData['unit_price'];
                        var total_amount = resultData['total_amount'];
                        var free_issue = resultData['free_issue'];
                        if(free_issue==1){
                            var freeIssueStatus = "Free";
                        }else{
                            var freeIssueStatus = "Non";
                        }


                        if (feedback == true) {
                             $("#producttbl tbody").html('');
                            $("#producttbl tbody").append("<tr><td>" + spare_part_id + "</td><td>" + spare_part_desc + "</td><td>" + qty + "</td><td>" + unit_price + "</td><td>" + total_amount + "</td><td>" + freeIssueStatus + "</td><td><a  row_id="+ id +" onclick='edit("+ id +");' class='edit btn btn-xs btn-primary'>Edit</a></td><td><a  row_id="+ id +" onclick='del("+ id +");' class='del btn btn-xs btn-primary''>Delete</a></td></tr>");

                            $.notify("Spare Part Successfuly Added..", "success");
                            
                        }else if(feedback == 2){
                            $.notify("Spare Part Already Exist..", "warning");
                            
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
            }
            e.preventDefault();
        });

            function edit(id) {
                console.log(id);
                $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_edit_spareparts/', {id: id}, function (result) {
                    $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
                });
            }

            function del(id){
                $.ajax({
                    url: "<?php echo base_url('admin/master/deleteSpareParts/') ?>",
                    type: 'POST',
                    data: {id: id},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        if(feedback == true){

                            $.notify("Spare Parts Successfuly Deleted..", "success");

                       }
                    }
                });
            }
   
   
  
</script>