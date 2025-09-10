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
                        <!--                            --><?php //if (in_array("SM21", $blockAdd) || $blockAdd == null) { ?>
                        <!--                                <button onclick="addm()" class="btn btn-flat btn-primary pull-right">Create Customer-->
                        <!--                                </button>-->
                        <!--                                --><?php
                        //                            } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="payType" class=" control-label">Account Type<span class="required">*</span></label>
                                    <select class="form-control" id="accType">
                                        <option value="0">-Select a category-</option>
                                        <?php foreach ($getCusAccountTypes as $getCusAccountType) { ?>
                                            <option value="<?php echo $getCusAccountType->DepNo; ?>"><?php echo $getCusAccountType->Description; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group" id="load_return">
                                    <label for="returnInvoice" class=" control-label">Account No<span class="required">*</span></label>
                                    <div class=" input-group">
                                        <span class="input-group-addon" id="accCode"></span>
                                        <input type="text" disabled class="form-control" required="required" style="z-index: 0;"  name="accNo2" id="accNo2" value="<?php echo $accountCode;?>">
                                        <input type="hidden" class="form-control" required="required" style="z-index: 0;"  name="accNo" id="accNo" value="<?php echo $accountCode;?>">
                                        <input type="hidden" class="form-control" required="required" style="z-index: 0;"  name="accCodes" id="accCodes">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invDate" class="col-sm-5 control-label">Date & time <span class="required">*</span></label>
                                    <input type="date" class="form-control" required="required"  name="invDate" id="invDate" placeholder="">
                                    <input type="hidden" class="form-control" required="required"  name="invUser" id="invUser" value="<?php echo $_SESSION['user_id'] ?>">

                                </div>

                                <div class="form-group">
                                    <label for="payAmount" class="col-sm-5 control-label">Remark<span class="required">*</span></label>
                                    <textarea class="form-control" required="required"  name="remark" id="remark"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <table></table>
                                <div class="form-group">
                                    <label for="refNo" class="control-label">Referral No </label>
                                    <input type="text" class="form-control"  name="refNo" id="refNo" placeholder="Enter Refer No">
                                </div>
                                <div class="form-group">
                                    <label for="customer_type" class="control-label">Customer Type<span class="required">*</span></label>
                                    <select class="form-control" id="CustType">
                                        <option value="0">-Select-</option>
                                        <?php foreach ($getCusTypes as $getCusType) { ?>
                                            <option value="<?php echo $getCusType->CusTypeId; ?>"   <?php
                                            if ($getCusType->CusTypeId == 1) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $getCusType->CusType; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="customer" class="control-label">Customer <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="customer" id="customer" placeholder="Enter Customer Name">
                                </div>
                                <div class="form-group">
                                    <label for="expenses_amount" class="control-label">Guarantee Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" required="required"  name="guarantee" id="guarantee" placeholder="Enter guarantee name or nic" >
                                    <input type="hidden" class="form-control" required="required"  name="guarantee_name" id="guarantee_name" placeholder="Enter guarantee name or nic" >
                                    <input type="hidden" class="form-control" required="required"  name="guarantee_nic" id="guarantee_nic" placeholder="Enter guarantee name or nic" >
                                    <input type="hidden" class="form-control" required="required"  name="guarantee_nic" id="guarantee_code" placeholder="Enter guarantee name or nic" >
                                </div>
                                <div class="form-group">
                                    <label for="expenses_amount" class="control-label"> </label>
                                    <input type="button" class="btn btn-primary pull-right" name="addGuarantee" id="addGuarantee" value="Add Guarantee">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <table>
                                    <tr>
                                        <td>Customer Name</td>
                                        <td> : </td>
                                        <td><span id="customerName"></span> </td>
                                    </tr>
                                    <tr>
                                        <td>Customer NIC</td>
                                        <td> : </td>
                                        <td><span id="cusCode"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Credit Limit</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="creditLimit"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Outstanding</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="cusOutstand"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Available Limit</td>
                                        <td> : </td>
                                        <td class="text-right"><span id="availableCreditLimit"></span> </td>
                                    </tr>
                                    <tr>
                                        <td>Location</td>
                                        <td> : </td>
                                        <td><span id="city"></span></td>
                                    </tr>
                                </table>
                                <br><br>
                                <table id="table_expenses" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guarantee NIC</th>
                                        <th>Guarantee Name</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                <div>
                                    <span  style="font-size: 25px;" id="totalExpenses"></span>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-success pull-right" id='pay'>Save Account </button>
                    </div>

                    <div class="row">
                        <div class="col-lg-4"><b><span id="lbl_batch_no"></span></b>
                            <!--<button class="btn btn-info pull-right" id='pay'>Pay</button>-->
                        </div>
                        <div class="col-lg-8">
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <!--add category modal-->
                    <div class="modal fade bs-add-category-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
                        <div class="modal-dialog modal-sm">

                        </div>
                    </div>
                    <!-- /modals -->

                    <!--edit category modal-->
                    <div class="modal fade bs-example2-modal-lg" tabindex="-1" role="dialog" aria-hidden="false">
                        <div class="modal-dialog modal-sm">

                        </div>
                    </div>
                    <!-- /modals -->
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->
</div>

<script>
    $(document).ready(function() {

        var cusCode = 0;
        var cusCodeG = 0;
        var cusNic = 0;
        var guarnt_code = 0;
        var guarantee_name = '';
        var guarantee_nic = '';
        var accCode = '';
        var code = '';
        var subCode = '';
        var cusType = 2;
        var location = 1;
        var accNo ='';

        var outstanding = 0;
        var available_balance = 0;

        function setAccCode(code1, code2) {
            var code = code1 + code2 + "/";
            accCode = code;
            $("#accCode").html(code);
            $("#accCodes").val(code);
        }

        $("#CustType").change(function() {
            $("#customer").val('');
            $("#tbl_payment tbody").html("");
        });

        $("#accType").change(function() {
            var accType = $(this).val();
            code = '';
            subCode = '';
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "admin/customer/getSubAccountType",
                data: {Category: accType},
                success: function(data)
                {

                    var resultData = JSON.parse(data);
                    $.each(resultData, function(key, value) {
                        code = value.Code;
                    });
                    setAccCode(code, subCode);

                }
            });
        });


        $("#customer").autocomplete({
            source: function(request, response) {
                cusType = $("#CustType option:selected").val();

                $.ajax({
                    url: "<?php echo base_url(); ?>" + "admin/customer/getActiveCustomers",
                    dataType: "json",
                    data: {
                        name_startsWith: request.term,
                        row_num: 1,
                        cus_type: cusType,
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.id,
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function(event, ui) {
                cusCode = ui.item.value;
                loadCustomerDatabyId(cusCode);
                $("#tbl_payment tbody").html("");

            }
        });

        function loadCustomerDatabyId(customer) {
            $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name = resultData.cus_data.CusName;
                    var encode_url = "../Payment/view_customer/"+(cusCode);

                    $("#customerName").html("<a href='"+encode_url+"'>"+resultData.cus_data.CusName+" "+resultData.cus_data.LastName+"</a>");
                    $("#cusCode").val(resultData.cus_data.CusCode);
                    $("#customer").val(resultData.cus_data.CusName+" "+resultData.cus_data.LastName);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#cusCode").html(resultData.cus_data.Nic);
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#city").html(resultData.cus_data.Address01 + ", " + resultData.cus_data.Address02);

                    cusCode = resultData.cus_data.CusCode;
                    cusNic = resultData.cus_data.Nic;
                    outstanding = outstanding;
                    available_balance = available_balance;
                }
            });
        }

        $("#guarantee").focus(function() {
            guarantee_name = '';
            guarantee_nic = '';
            guarnt_code = '';
        });

        $("#customer").focus(function() {
            cusCode = 0;
            cusNic = 0;
        });

        $("#guarantee").autocomplete({
            source: function(request, response) {
                cusType = 2;

                $.ajax({
                    url: "<?php echo base_url(); ?>" + "admin/customer/getActiveCustomers",
                    dataType: "json",
                    data: {
                        name_startsWith: request.term,
                        row_num: 1,
                        cus_type: cusType,
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.text,
                                value: item.id,
                                data: item
                            }
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function(event, ui) {
                cusCodeG = ui.item.value;
                loadGuaranteeDataById(cusCodeG);
                $("#tbl_payment tbody").html("");

            }
        });

        function loadGuaranteeDataById(customer) {
            $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer },
                success: function(data) {
                    var resultData = JSON.parse(data);
                      cusCodeG = resultData.cus_data.CusCode;

                    $("#guarantee_name").val(resultData.cus_data.CusName+" "+resultData.cus_data.LastName);
                    $("#guarantee_nic").val(resultData.cus_data.Nic);
                    $("#guarantee_code").val(cusCodeG);
                }
            });
        }

        $('#form2 .btn').on('click', function() {

            $('#form2').parsley().validate();
            validateFront();
        });
        var validateFront = function() {
            if (true === $('#form2').parsley().isValid()) {
                $('.bs-callout-info').removeClass('hidden');
                $('.bs-callout-warning').addClass('hidden');
            } else {
                $('.bs-callout-info').addClass('hidden');
                $('.bs-callout-warning').removeClass('hidden');
            }
        };

        var p = 0;
        var expensesArr = [];
        var total_expenses = 0;
        $("#addGuarantee").click(function() {

            var expensesType = $("#guarantee_code").val();
            var expensesName = $("#guarantee_nic").val();
            var expenseAmount = ($("#guarantee_name").val());
            var expensesArrIndex = $.inArray(expensesType, expensesArr);

            if (expensesType == '' || expensesType == 0) {
                alert('Please select a Guarantee');
                return false;
            } else {
                if (expensesArrIndex < 0) {
                    expensesArr.push(expensesType);
                    p++;
                    $("#table_expenses tbody").append("<tr rid=" + p + " id='exr" + p + "'><td>" + p + "</td><td class='expenses_nameEx" + p + "' expenseType='" + expensesType + "'>" + expensesName + "</td><td class='expense_amountEx" + p + " '>" + (expenseAmount) + "</td><td class='expense_rem" + p + "'><a href='#' class='expense_remove btn btn-xs btn-danger'>Remove</a></td></tr>");
                }
                else {
                    alert("Guarantee already exists");
                    $("#guarantee").val('');
                    $("#guarantee").focus();
                    return false;
                }

                $("#guarantee_name").val('');
                $("#guarantee_nic").val('');
                $("#guarantee_code").val(0);
                $("#guarantee").val('');
            }
        });

        $("#table_expenses").on('click', '.expense_remove', function() {
            var rid = $(this).parent().parent().attr('rid');

            var r = confirm('Do you want to remove row no ' + rid + ' ?');
            if (r === true) {
                var removeItem = $(".expenses_nameEx" + rid).attr("expenseType");

                expensesArr = jQuery.grep(expensesArr, function(value) {
                    return value != removeItem;
                });

                $(this).parent().parent().remove();
                return false;
            }
            else {
                return false;
            }
        });

        function setExpensesTable() {
            $('#table_expenses tbody tr').each(function(rowIndex2, element) {
                var row2 = rowIndex2 + 1;
                $(this).find("[class]").eq(0).parent().attr("rid", row2);
                $(this).find("[class]").eq(0).parent().attr("id", "exr" + row2);
                $(this).find("[class]").eq(0).attr("class", 'expenses_nameEx' + row2);
                $(this).find("[class]").eq(1).attr("class", 'expense_amountEx' + row2);
                $(this).find("[class]").eq(2).attr("class", 'expense_rem' + row2);
            });
        }

        $("#pay").click(function() {
            setExpensesTable();
            var accType = $("#accType option:selected").val();
            var invDate = $("#invDate").val();
            var remark = $("#remark").val();
            var invUser = $("#invUser").val();
            var refNo = $("#refNo").val();
            accNo = accCode + $("#accNo").val();


            if(accType == 0 || accType == ''){
                alert("Please Select Account Type.");
            } else if (accNo == 0 || accNo == '') {
                alert("Please enter account number.");
            } else if (cusCode == 0 || cusCode == '') {
                alert("Please select a customer.");
            } else if (expensesArr.length == 0 || expensesArr.length == '') {
                alert("Please select guarantees.");
            }
            else {

                var expense_type = new Array();
                var expense_amount = new Array();
                var expensRowCount = $('#table_expenses tr').length;
                for (var c = 1; c <= expensRowCount - 1; c++) {
                    expense_type.push($("#exr" + c + " .expenses_nameEx" + c).attr("expenseType"));
                    expense_amount.push($("#exr" + c + " .expenses_nameEx" + c).html());
                }
                var sendExpense_type = JSON.stringify(expense_type);
                var sendExpense_amount = JSON.stringify(expense_amount);
                $.ajax({
                    type: "POST",
                    url: "../customer/addAccount",
                    data: {action: "addAccount", acc_type: accType, acc_date: invDate, remark: remark, invUser: invUser, accNo: accNo, cusCode: cusCode, cusNic: cusNic, location: location, guarantNic: sendExpense_amount, guarantCode: sendExpense_type,accCode:accCode,refNo:refNo},
                    success: function(data)
                    {
                        if (data == 1) {
                            alert('Account successfully created');
                            clear_data_after_save();
                        }
                        else {
                            alert('Account not saved');
                        }
                    }
                });
            }

        });

        function clear_data_after_save() {
            var url = 'bill.php?ac_no='+accNo;
            $("#invUrl").attr('href',url);
            $("#invUrl").attr('class','btn btn-info pull-right');
            $('#table_expenses tbody').html("");
            $("#cusCode").html("");
            $("#customer").val("");
            $("#accType").val("");
            $("#accNo").val("");
            $("#refNo").val("");
            $("#invDate").val("");
            $("#remark").val("");
            $("#creditLimit").html('0.00');
            $("#creditPeriod").html('');
            $("#cusOutstand").html('0.00');
            $("#availableCreditLimit").html('0.00');
            $("#city").html('');
            $("#cusImage").hide();
            expensesArr.length = 0;
            $("#pay").prop('disabled',true);

        }

    });
</script>