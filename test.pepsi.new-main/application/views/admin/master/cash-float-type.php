<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                    <b><span class="alert alert-success pull-left" id="lastProduct"></span></b>
                        <button onclick="addp()" class="btn btn-flat btn-primary pull-right">Add Transaction type</button>
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
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Is Expenses</td>
                                    <td>Remark</td>
                                    <td>Is Active</td>
                                    <td>###</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($transType as $trns) { ?>
                                <tr>
                                    <td><?php echo $trns->TransactionCode; ?></td>
                                    <td><?php echo $trns->TransactionName; ?></td>
                                    <td>
                                    <?php if($trns->IsExpenses==1){?>
                                            <span class="label label-danger">Expenses</span>
                                    <?php }else if($trns->IsExpenses==0){ ?>
                                            <span class="label label-success">Earning</span>
                                    <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $trns->Remark; ?>
                                    </td>
                                    <td>
                                        <?php if($trns->IsActive==0){?>
                                            <span class="label label-waring">Cancel</span>
                                    <?php }else if($trns->IsActive==1){ ?>
                                            <span class="label label-success">Active</span>
                                    <?php } ?>
                                       </td>
                                       <td><a  class="btn btn-xs btn-primary" href="#" onclick="editp(<?php echo $trns->TransactionCode; ?>)" >Edit</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    $(document).ready(function () {

        var producttbl = $('#producttbl').dataTable();
    });
    function addp() {
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_addTransType/', function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
    function editp(id) {
        console.log(id);
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_editproduct/', {id: id}, function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
</script>
