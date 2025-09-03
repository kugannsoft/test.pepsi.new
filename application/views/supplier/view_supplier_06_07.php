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
                        <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Supplier</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="customertbl">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Mobile</td>
                                    <td>Lan Line</td>
                                    <td>Email</td>
                                    <td>Oustanding Amount</td>
                                    <td>###</td>
                                    <td>###</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="suppliermodal" class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- load data -->
        </div>
    </div>
</div>
<script>
    var suppliertbl = $('#customertbl').dataTable({
        "processing": true,
        "serverSide": true,
        "order": [[0, "desc"]],
        "language": {
            "processing": "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>"
        },
        "ajax": {
            "url": "supplier/allsuppliers",
            "type": "POST"
        },
        "columns":
                [
                    {"data": "SupCode", searchable: false},
                    {"data": "SupName"},
                    {"data": "MobileNo"},
                    {"data": "LanLineNo"},
                    {"data": "Email"},
                    {"data": "SupOustandingAmount"},
                    {
                    "data": null, orderable: false, searchable: false,
                    mRender: function (data, type, row) {
                        if (row.IsActive == 1) {
                            return '<span class="label label-xs label-success" >Active</span>';
                        } else if (row.IsActive == 0) {
                            return '<span class="label label-xs label-danger" >Inactive</span>';
                        }

                    }
                },
                    {"data": null, orderable: false, searchable: false,
                        mRender: function (data, type, row) {
                            return '<a href="<?php echo base_url() ?>admin/payment/view_supplier/' + (row.SupCode) +'"  class="btn btn-xs btn-default" >View</a> &nbsp;<button class="btn btn-xs btn-default" onclick="editm(\'' + row.SupCode + '\')">Edit</button>';
                        }
                    }
                ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData.IsActive == 1)
            {
                $('td:eq(6)', nRow).html('<label class="btn btn-success btn-xs">active</label>');
            }
        }
    });

    function editm(d) {
        $('.modal-content').load('<?php echo base_url() ?>admin/supplier/loadmodal_editsupplier/' + d, function (result) {
            $('#suppliermodal').modal({show: true});
        });
    }
    function addm() {
        $('.modal-content').load('<?php echo base_url() ?>admin/supplier/loadmodal_addsupplier/', function (result) {
            $('#suppliermodal').modal({show: true});
        });
    }
</script>