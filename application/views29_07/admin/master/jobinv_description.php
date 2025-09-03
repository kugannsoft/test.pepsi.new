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
                        <button onclick="addp()" class="btn btn-flat btn-primary pull-right">Add Work Type Description</button>
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
                                    <td>Job type</td>
                                    <td>Name</td>
                                    <td>Job Cost</td>
                                    <td>VAT</td>
                                    <td>NBT</td>
                                    <td>NBT Ratio</td>
                                    <td>###</td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($transType as $trns) { ?>
                                <tr>
                                    <td><?php echo $trns->JobDescNo; ?></td>
                                    <td><?php echo $trns->jobtype_name; ?></td>
                                    <td><?php echo $trns->JobDescription; ?></td>
                                    <!-- <td>
                                    <?php if($trns->jobtype_name==1){?>
                                            <span class="label label-danger">Expenses</span>
                                    <?php }else if($trns->jobtype==0){ ?>
                                            <span class="label label-success">Earning</span>
                                    <?php } ?>
                                    </td> -->
                                    <td>
                                        <?php echo $trns->JobCost; ?>
                                    </td>
                                    <td><?php if($trns->isVat==1){ ?><label class="label label-info">Enabled</label><?php }else{?><label class="label label-danger">Disabled</label><?php }?></td>
                                    <td><?php if($trns->isNbt==1){ ?><label class="label label-info">Enabled</label><?php }else{?><label class="label label-danger">Disabled</label><?php }?></td>
                                    <td><?php echo $trns->nbtRatio; ?></td>
                                       <td><a  class="btn btn-xs btn-primary" href="#" onclick="editp(<?php echo $trns->JobDescNo; ?>)" >Edit</a></td>
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
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_addjobinv_description/', function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
    function editp(id) {
        console.log(id);
        $('.modal-content').load('<?php echo base_url() ?>admin/master/loadmodal_editjobinv_description/', {id: id}, function (result) {
            $('#productmodal').modal({show: true,backdrop: 'static', keyboard: false});
        });
    }
</script>
