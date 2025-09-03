$(document).ready(function() {
    var supcode;
     var customProCode='100001';
    var loc = 0;
    $('#grnDate,#deliverydate,#chequeReciveDate,#expenses_date,#quartPayDate,#chequeDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker({
        dateFormat: 'yy-mm-dd',
        startDate: '-3d'
    });

    $('#grnDate,#chequeReciveDate,#expenses_date,#quartPayDate,#downPayDate1,#downPayDate2,#downPayDate3,#downPayDate4,#downPayDate5,#downPayDate6').datepicker().datepicker("setDate", new Date());
    
    $("#customerDiv").hide();
 
    $("#cusImage").hide();
    $("#lotPriceLable").hide();
    $('#costTable').hide();
    $('#paymentTable').hide();
    $('#payView').hide();
    $("#dv_SN").hide();
    $("#dwnLink").hide();
    $("#loadBarCode").hide();

    $("#lbl_lotNo").hide();
    $("#lbl_polishWeight").hide();
    $("#lbl_buyAmount").hide();
    $("#lbl_cutWeight").hide();
    $("#chequeData").hide();
    $("#refundAmountLable").hide();
    $("#returnAmountLable").hide();
    $("#tbl_payment_schedule").hide();

//    $("#panel_down_payments").hide();
//    $("#panel_quarter").hide();
    var item_ref = 0;
    var itemImagesArr = [];
    var gemOption = [];
    var cusCode = 0;
    var acc_no = 0;
    var invNo = 0;
    var batchNo = 0;
    var cusType = 2;
    var customer_payment = 0;
    var accType = 0;
    var accCategory = 0;
    var totalExtraChrages = 0;
    var downPayment = 0;
    var totalIterest = 0;
    var finalAmount = 0;
    var Interest = 0;
    var dwnInt = 0;
    var return_amount = 0;
    var itemCode = '';

    var i = 0;
    var itemcode = [];
    var isBuy = 0;
    var isCut = 0;
    var isPolish = 0;
    var total_amount = 0;
    var total_amount2 = 0;
    var totalCost = 0;
    var cashAmount = 0;
    var chequeAmount = 0;
    var creditAmount = 0;
    var dueAmount = 0;
    var lotPrice = 0;
    var returnAmount = 0;
    var refundAmount = 0;
    var returnPayment = 0;

    var discount_precent = 0;
    var discount_amount = 0;
    var product_discount = 0;
    var totalNet2 = 0;
    var totalNet = 0;
    var totalNetAmount = 0;
    var total_discount = 0;
    var total_item_discount = 0;
    var discount = 0;
    var discount_type = 0;
    var total_dwn_interest = 0;
    var total_qur_interest = 0;
    var totalExtraAmount = 0;
    var totalProWiseDiscount = 0;
    var totalGrnDiscount = 0;

    var accType2 = 1;
    var price_level = 1;
    var supcode = 0;

    var isSup = 0;
    var jobNumArr = [];

$("#job_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadjobjson',
                dataType: "json",
                data: {
                    q: request.term
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
            // clearEstimateData();
            jobNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByJobNo",
                data: { jobNo: jobNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    // setGridandLabelData(resultData);

                    loadEstimateDatatoGrid(resultData);
                }
            });
        }
    });

var estNo = 0;

$("#est_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadestimatejson',
                dataType: "json",
                data: {
                    q: request.term
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
            // clearEstimateData();
            estNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../job/getEstimateDataByEstimateNo",
                data: { estimateNo: estNo, supplimentNo: 0 },
                success: function(data) {
                    var resultData = JSON.parse(data);
                    loadEstimateDatatoGrid(resultData);
                    
                }
            });
            
        }
    });

var mrnNo = 0;
$("#grn_no").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../mrn/loadrequestmrnjson',
                dataType: "json",
                data: {
                    q: request.term
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
            // clearEstimateData();
            mrnNo = ui.item.value;
            
            $("#tbl_payment tbody").html("");
            $("#tbl_job tbody").html('');
            total_due_amount = 0;
            total_over_payment = 0;
            $("#btnViewJob").attr('disabled', false);
            $.ajax({
                type: "POST",
                url: "../mrn/getMrnDataById",
                data: { mrnNo: mrnNo },
                success: function(data) {
                    var resultData = JSON.parse(data);

                    // setGridandLabelData(resultData);

                    loadMrnDatatoGrid(resultData);
                }
            });
        }
    });

    //======= set price levels ==========
    $("#priceLevel").change(function() {
        price_level = $("#priceLevel option:selected").val();
    });

    $("#supplier").change(function() {
        supcode = $("#supplier option:selected").val();
    });
     loc = $("#invlocation").val();

     $("#addpro").click(function(e){
        itemCode=customProCode;
        setCustomProduct();
        e.preventDefault();
        
    });

    function setCustomProduct(){
         var mname = $("#itemCode").val();
        $("#prdName").val(mname);
        $("#productName").html(mname);
        
        $("#qty").val(1);
        $("#qty").focus();
        $("#itemCode").val(itemCode);
        // $("#sellingPrice").val(0);
        // $("#orgSellPrice").val(0);
        // $("#proVatPrice").val(0);
        

        $("#unitcost").val(1);
        $("#isSerial").val(0);
        $("#upc").val(1);
        $("#upm").html(1);

            $("#dv_SN").hide();
        
            $("#dv_FreeQty").hide();
    }
    
//     $('#itemCode').on('keydown', function(e) {
//         if (e.which == 13) {
//             $("#errGrid").hide();
// //            $("#cart-table-notice").remove();
//             var barCode = $(this).val();
//             price_level = $("#priceLevel option:selected").val();

//             $.ajax({
//                 type: "post",
//                 url: "../../admin/Product/getProductByBarCodeforSTO",
//                 data: {proCode: barCode, prlevel: price_level, location: loc},
//                 success: function(json) {

//                     var resultData = JSON.parse(json);
//                     if (resultData) {
//                         itemCode = resultData.product.ProductCode;
//                         $.each(resultData.serial, function(key, value) {
//                             var serialNoArrIndex2 = $.inArray(value, stockSerialnoArr);
//                             if (serialNoArrIndex2 < 0) {
//                                 stockSerialnoArr.push(value);
//                             }
//                         });

//                         loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod);
// //                        $('html, body').animate({scrollTop: $('#cart-table-body').offset().top}, 'slow');
//                     } else {
//                         $("#errProduct").show();
//                         $("#errProduct").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
//                         $("#itemCode").val('');
//                         $("#itemCode").focus();
//                         return false;
//                     }
//                 },
//                 error: function() {
//                     alert('Error while request..');
//                 }
//             });
//             e.preventDefault();
//         }
//     });

//isSup =  $("[name='suppliercheck']:checked").val();

    $("input[name='suppliercheck']").on('ifChanged', function() {
        isSup = $("input[name='suppliercheck']:checked").val();
        if (!isSup) {
            isSup = 0;
        }
    });

//==============load products========================
    // $("#itemCode").autocomplete({
    //     source: function(request, response) {
    //         $.ajax({
    //             url: 'loadproductjson',
    //             dataType: "json",
    //             data: {
    //                 q: request.term,
    //                 type: 'getActiveProductCodes',
    //                 sup: isSup,
    //                 supcode: supcode,
    //                 row_num: 1,
    //                 action: "getActiveProductCodes",
    //                 price_level: price_level
    //             },
    //             success: function(data) {
    //                 response($.map(data, function(item) {
    //                     return {
    //                         label: item.label,
    //                         value: item.value,
    //                         data: item
    //                     }
    //                 }));
    //             }
    //         });
    //     },
    //     autoFocus: true,
    //     minLength: 0,
    //     select: function(event, ui) {

    //         itemCode = ui.item.value;
    //         $.ajax({
    //             type: "post",
    //             url: "../../admin/Product/getProductByIdforSTO",
    //             data: {proCode: itemCode, prlevel: price_level, location: loc},
    //             success: function(json) {
    //                 var resultData = JSON.parse(json);
    //                 if (resultData) {
    //                     $.each(resultData.serial, function(key, value) {
    //                         var serialNoArrIndex1 = $.inArray(value, stockSerialnoArr);
    //                         if (serialNoArrIndex1 < 0) {
    //                             stockSerialnoArr.push(value);
    //                         }
    //                     });
    //                     loadProModal(resultData.product.Prd_Description, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod);
    //                 } else {
    //                     $("#errProduct").show();
    //                     $("#errProduct").html('Product not found ').addClass('alert alert-danger alert-dismissible alert-sm').fadeOut(2000);
    //                     $("#itemCode").val('');
    //                     $("#itemCode").focus();
    //                     return false;
    //                 }
    //             },
    //             error: function() {
    //                 alert('Error while request..');
    //             }
    //         });
    //     }
    // });

//load model
    function loadProModal(mname, mcode, msellPrice, mcostPrice, mserial, misSerial, misFree, isOP, isMP, upc, waranty) {
//        clearProModal();
        $("#qty").focus();
//       alert(misSerial);
        if (misSerial == 1) {
           $("#serialNo").val(mserial);
           // $("#qty").val(1);
           $("#qty").attr('disabled', true);
            $("#dv_SN").show();
            $("#qty").focus();

        } else {
           $("#mSerial").val('');
            $("#qty").attr('disabled', false);
            $("#dv_SN").hide();
        }
        // $("#qty").val(1);
//        $("#mLProCode").html(mcode);
        $("#prdName").val(mname);
        $("#itemCode").val(mcode);
        $("#sellingPrice").val(msellPrice);
        $("#unitcost").val(mcostPrice);
        $("#isSerial").val(misSerial);
        $("#upc").val(upc);

        if (misSerial == 1) {
            $("#dv_SN").show();
        } else {
            $("#dv_SN").hide();
        }

    }
    discount_precent = parseFloat($("#disPercent").val());
    discount_amount = parseFloat($("#disAmount").val());
    discount = $("input[name='discount']:checked").val();
    discount_type = $("input[name='discount_type']:checked").val();

//===========discount types===========================
    $("input[name='discount']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    $("input[name='discount_type']").on('ifChanged', function() {
        var check = ($(this).val());

        if (check == 1) {
            $("#disAmount").val(0);
        } else if (check == 2) {
            $("#disPercent").val(0);
        }
    });

    var sellingPrice = 0;
    var costPrice = 0;
    var casecost = 0;
    $("#sellingPrice").blur(function() {
        sellingPrice = parseFloat($(this).val());
        costPrice = parseFloat($("#unitcost").val());

        if (costPrice > sellingPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        }
    });

    $("#unitcost").blur(function() {
        costPrice = parseFloat($(this).val());
        sellingPrice = parseFloat($("#sellingPrice").val());

        if (costPrice > sellingPrice) {
            $("#errProduct").show();
            $("#errProduct").html('Selling price can not be less than cost price').addClass('alert alert-danger alert-dismissible alert-sm').delay(1500).fadeOut(600);
            ;
            return false;
        }
    });

    $("#qty").blur(function() {
        $("#serialQty").val($(this).val());
    });
    var serialQty = 0;
    var newSerialQty = 0;
    var serialnoarr = [];
    var stockSerialnoArr = [];
//=========Add products===============================
    $("#addItem").click(function() {
        add_products();
     });
     
     $('#serialNo').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

     $('#qty').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });

    $('#sellingPrice').on('keydown', function(e) {
        if (e.which == 13) {
            add_products();
        }
    });
    
     var serialNo ='';
     function add_products(){
        sellingPrice = parseFloat($("#sellingPrice").val());
        var unit = $("#mUnit option:selected").val();
        var prdName = $("#prdName").val();
        serialNo = $("#serialNo").val();
        var is_serail = $("#isSerial").val();
        var priceLevel = $("#priceLevel option:selected").val();
        var qty = parseFloat($("#qty").val());
        var upc = parseFloat($("#upc").val());
        costPrice = parseFloat($("#unitcost").val());
        var freeQty = parseFloat($("#freeqty").val());
        var case1 = $("#mUnit option:selected").val();
        var preturn = $("#mReturn option:selected").val();
        newSerialQty = parseFloat($("#serialQty").val());
        var isvat = parseFloat($("#isVat").val());
        var isnbt = parseFloat($("#isNbt").val());
        var nbtratio = parseFloat($("#nbtRatio").val());
        var vat = parseFloat($("#vatAmount").val());
        var nbt = parseFloat($("#nbtAmount").val());
        var requestid = ($("#rowid").val());
        var brand = ($("#brand").val());
        var quality = ($("#quality").val());

        if (is_serail == 1) {
            serialQty = newSerialQty;
            qty = qty;
        } else {
            qty = qty;
        }

        if (case1 == 'Unit' || case1 == 'UNIT') {
            qty = qty;
        } else if (case1 == 'Case' || case1 == 'CASE') {
            qty = upc * qty;
            casecost = costPrice * qty;
        }

        var itemCodeArrIndex = $.inArray(itemCode, itemcode);

        if (itemCode == '' || itemCode == 0) {
            $.notify("Please select a item.", "warning");
            return false;
        } else if (qty == '' || qty == 0 || isNaN(qty) == true) {
            $.notify("Please enter a qty.", "warning");
            return false;
        } else {
            if(is_serail == 0) {
                if ((itemCodeArrIndex < 0 && is_serail == 0) || (itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1)) {
                    totalNet2 = parseFloat($("#totalAmount").val());
                    totalNet = parseFloat($("#netAmount").val());
                    //  if(itemCode!=customProCode){
                    //     itemcode.push(itemCode);
                    // }
                    itemcode.push(itemCode);
                    total_amount2 += totalNet2;
                    totalCost += costPrice;
                    $("#totalWithOutDiscount").val(total_amount2);

                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item2 tbody").append("<tr requestid='"+requestid+"' ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "' proReturn='" + preturn + "'  isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + i + "'>" + accounting.formatNumber(qty) + "</td><td>" + brand + "</td><td>" + quality + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                    $("#tbl_item tr td .plus"+requestid).attr('disabled',true);
                    if (is_serail != 1) {
                        clear_gem_data();
                    } else {
                        if (serialQty == 0) {
                            clear_gem_data();
                        } else {
                            $("#serialNo").val('');
                            $("#serialNo").focus();
                        }
                    }
                    
                    setProductTable();
                } else {
                    $.notify("Item already exists.", "warning");
                    return false;
                }
            } else if (is_serail == 1) {
                var serialNoArrIndex = $.inArray(serialNo, serialnoarr);
                var StockserialNoArrIndex = $.inArray(serialNo, stockSerialnoArr);

                if (serialNo == '' || serialNo == 0) {
                     $.notify("Serial Number can not be empty.", "warning");
                    $("#serialNo").focus();
                    return false;
                }
                else if (((serialNoArrIndex >= 0 && is_serail == 1))) {
                    $.notify("Serial Number already added.", "warning");
                    $("#serialNo").val('');
                    return false;
                } else if (((StockserialNoArrIndex < 0 && is_serail == 1))) {
                    $.notify("Serial Number product not in  stock.", "warning");
                    $("#serialNo").val('');
                    return false;
                }
                else if (((itemCodeArrIndex >= 0 && is_serail == 1) || (itemCodeArrIndex < 0 && is_serail == 1))) {
                    totalNet2 = parseFloat($("#totalAmount").val());
                    totalNet = parseFloat($("#netAmount").val());
                    if(itemCode!=customProCode){
                        itemcode.push(itemCode);
                    }
                    serialnoarr.push(serialNo);
                    total_amount2 += totalNet2;
                    totalCost += costPrice;
                    $("#totalWithOutDiscount").val(total_amount2);

                    calculateProductWiseDiscount(totalNet2, discount, discount_type, discount_precent, discount_amount, total_amount2);
                    cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
                    i++;
                    if (is_serail == 1) {
                        serialQty--;
                        $("#serialQty").val(serialQty);
                    }

                    $("#tbl_item2 tbody").append("<tr requestid='"+requestid+"'  ri=" + i + " id=" + i + " proCode='" + itemCode + "' uc='" + unit + "' brand='" + brand + "' quality='" + quality + "' qty='" + 1 + "' unit_price='" + sellingPrice + "' upc='" + upc + "' caseCost='" + casecost + "' isSerial='" + is_serail + "' serial='" + serialNo + "' discount_percent='" + discount_precent + "' cPrice='" + costPrice + "' pL='" + priceLevel + "' fQ='" + freeQty + "' nonDisTotalNet='" + totalNet2 + "' netAmount='" + totalNet + "' proDiscount='" + product_discount + "' proName='" + prdName + "' proReturn='" + preturn + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                <td class='text-center'>" + i + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + i + "'>" + accounting.formatNumber(1) + "</td><td>" + unit + "</td><td>" + serialNo + "</td><td class='rem" + i + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                    $("#tbl_item tr td .plus"+requestid).attr('disabled',true);
                    if (is_serail != 1) {
                        clear_gem_data();
                    } else {
                        if (serialQty == 0) {
                            clear_gem_data();
                        } else {
                            $("#serialNo").val('');
                            $("#serialNo").focus();
                        }
                    }
                    
                    setProductTable();
                    $("#serialNo").val('');
                } else {
                    $.notify("Item already exists.", "warning");
                    $("#serialNo").val('');
                    return false;
                }
            }
        }
     }



//=========calculate total item wise discount by precentage=============================
    $("#disPercent").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();

        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

//=========calculate total item wise discount by amount=============================
    $("#disAmount").blur(function() {
        discount_precent = parseFloat($("#disPercent").val());
        discount_amount = parseFloat($("#disAmount").val());
        discount = $("input[name='discount']:checked").val();
        discount_type = $("input[name='discount_type']:checked").val();
        var total_amount3 = $("#totalWithOutDiscount").val();
        if (discount_type == 2) {
            calculateTotalItemWiseDiscount(discount, discount_type, discount_precent, discount_amount, total_amount3);
        }
    });

    //================remove row from grid subtraction total amount and discount==============================================
    $("#tbl_item2").on('click', '.remove', function() {
        var rid = $(this).parent().parent().attr('ri');
        var r = confirm('Do you want to remove row no ' + rid + ' ?');
        if (r === true) {

            var totalNets = parseFloat(($(this).parent().parent().attr("nonDisTotalNet")));
            var proDiscount = parseFloat(($(this).parent().parent().attr("proDiscount")));
            var proCost = parseFloat(($(this).parent().parent().attr("cPrice")));
            var request_id = $(this).parent().parent().attr("requestid");

            $("#tbl_item tr td .plus"+request_id).attr('disabled',false);
            total_amount -= totalNets;
            total_amount2 -= totalNets;
//            total_discount -= proDiscount;
            totalCost -= proCost;
            totalProWiseDiscount -= proDiscount;

            total_discount = totalProWiseDiscount + totalGrnDiscount;
            $("#totalWithOutDiscount").val(total_amount2);
            $("#totalAmount").html(accounting.formatMoney(total_amount2));
            $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));

            cal_total(total_amount2, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest, totalExtraAmount);
            //remove product code from array
            var removeItem = $(this).parent().parent().attr("proCode");
            var removeSerial = $(this).parent().parent().attr("serial");

            itemcode = jQuery.grep(itemcode, function(value) {
                return value != removeItem;
            });

            serialnoarr = jQuery.grep(serialnoarr, function(value) {
                return value != removeSerial;
            });

            $(this).parent().parent().remove();
            setProductTable();
            return false;
        } else {
            return false;
        }
    });


     $("#tbl_item").on('click', '.add', function() {
        var rid = $(this).parent().parent().attr('ri');
        // $(this).attr('disabled',true);
        // var r = confirm('Do you want to add row no ' + rid + ' ?');
        // if (r === true) {
            // $(this).prop('disabled',true);
            var totalNets = parseFloat(($(this).parent().parent().attr("nonDisTotalNet")));
            var proDiscount = parseFloat(($(this).parent().parent().attr("proDiscount")));
            var proCost = parseFloat(($(this).parent().parent().attr("cPrice")));
            var proCode = (($(this).parent().parent().attr("proCode")));
            var isvat = parseFloat(($(this).parent().parent().attr("isVat")));
            var isnbt = parseFloat(($(this).parent().parent().attr("isNbt")));
            var nbtratio = parseFloat(($(this).parent().parent().attr("nbtRatio")));
            var vat = parseFloat(($(this).parent().parent().attr("vat")));
            var nbt = parseFloat(($(this).parent().parent().attr("nbt")));
            var net = parseFloat(($(this).parent().parent().attr("netAmount")));
            var qty = parseFloat(($(this).parent().parent().attr("qty")));
            var receive = parseFloat(($(this).parent().parent().attr("receive")));
            var quality =  (($(this).parent().parent().attr("quality")));
            var brand =  (($(this).parent().parent().attr("brand")));
            var proname =  (($(this).parent().parent().attr("proname")));

         

            if(receive==0){
                $("#isVat").val(isvat);
                $("#isNbt").val(isnbt);
                $("#nbtRatio").val(nbtratio);
                $("#vatAmount").val(vat);
                $("#nbtAmount").val(nbt);
                $("#netAmount").val(net);
                $("#totalAmount").val(totalNets);
                $("#qty").val(qty);
                $("#rowid").val(rid);
                $("#quality").val(quality);
                $("#brand").val(brand);
                $("#productName").html(proname);
                
                itemCode = proCode;
                $.ajax({
                    type: "post",
                    url: "../../admin/Product/getProductByIdforSTO",
                    data: {proCode: proCode, prlevel: price_level, location: loc},
                    success: function(json) {
                        var resultData = JSON.parse(json);
                        if (resultData) {
                            $.each(resultData.serial, function(key, value) {
                                var serialNoArrIndex1 = $.inArray(value, stockSerialnoArr);
                                if (serialNoArrIndex1 < 0) {
                                    stockSerialnoArr.push(value);
                                }
                            });

                            loadProModal(proname, resultData.product.ProductCode, resultData.product.ProductPrice, resultData.product.Prd_CostPrice, 0, resultData.product.IsSerial, resultData.product.IsFreeIssue, resultData.product.IsOpenPrice, resultData.product.IsMultiPrice, resultData.product.Prd_UPC, resultData.product.WarrantyPeriod);
                        } else {
                            $.notify("Product not found.", "warning");
                            $("#itemCode").val('');
                            $("#itemCode").focus();
                            return false;
                        }
                    },
                    error: function() {
                        alert('Error while request..');
                    }
                });
                return false;   
            }else{
                $.notify("Already item has issued.", "warning");
                return false;
            }

            
       
    });

//==========================================================

$("#serialNo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'loadproductSerial',
                dataType: "json",
                data: {
                    q: request.term,
                    location: loc,
                    row_num: 1,
                    proCode: itemCode
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            serialNo = ui.item.value;
            
        }
    });


//===============save products ==============================
    $("#saveItems").click(function() {
        setProductTable();
        var rowCount = $('#tbl_item2 tr').length;
        var product_code = new Array();

        var item_code = new Array();
        var serial_no = new Array();
        var pro_name = new Array();
        var qty = new Array();
        var unit_price = new Array();
        var unit_type = new Array();
        var unitPC = new Array();
        var caseCost = new Array();
        var discount_precent = new Array();
        var pro_discount = new Array();
        var total_net = new Array();
        var isSerial = new Array();
        var price_level = new Array();
        var fee_qty = new Array();
        var cost_price = new Array();
        var pro_total = new Array();
        var pro_return = new Array();
        var quality = new Array();
        var brand = new Array();


        var grnDate = $("#grnDate").val();
        var invUser = $("#invUser").val();
        var location = $("#invlocation").val();
        var location_from = $("#location_from option:selected").val();
        var location_to = $("#location_to option:selected").val();
        var invoicenumber = $("#invoicenumber").val();
        var additional = $("#additional").val();
        var grnremark = $("#grnremark").val();

//        customer_payment = cash_amount + cheque_amount + credit_amount + return_amount;

        $('#tbl_item2 tbody tr').each(function(rowIndex, element) {
            product_code.push($(this).attr('proCode'));
            serial_no.push($(this).attr('serial'));
            qty.push(($(this).attr('qty')));
            unit_price.push(($(this).attr('unit_price')));
            discount_precent.push(($(this).attr('discount_percent')));
            pro_discount.push($(this).attr('proDiscount'));
            total_net.push(($(this).attr('netAmount')));
            price_level.push($(this).attr("pL"));
            unit_type.push($(this).attr("uc"));
            fee_qty.push($(this).attr("fQ"));
            cost_price.push(($(this).attr("cPrice")));
            unitPC.push(($(this).attr("upc")));
            caseCost.push(($(this).attr("caseCost")));
            pro_total.push($(this).attr("nonDisTotalNet"));
            isSerial.push($(this).attr("isSerial"));
            pro_name.push($(this).attr("proName"));
            pro_return.push($(this).attr("proReturn"));
            brand.push($(this).attr('brand'));
            quality.push($(this).attr('quality'));

        });

        var sendProduct_code = JSON.stringify(product_code);
        var sendPro_name = JSON.stringify(pro_name);
        var sendSerial_no = JSON.stringify(serial_no);
        var sendQty = JSON.stringify(qty);
        var sendUnit_price = JSON.stringify(unit_price);
        var sendDiscount_precent = JSON.stringify(discount_precent);
        var sendPro_discount = JSON.stringify(pro_discount);
        var sendTotal_net = JSON.stringify(total_net);
        var sendPrice_level = JSON.stringify(price_level);
        var sendUnit_type = JSON.stringify(unit_type);
        var sendFree_qty = JSON.stringify(fee_qty);
        var sendCost_price = JSON.stringify(cost_price);
        var sendUpc = JSON.stringify(unitPC);
        var sendCaseCost = JSON.stringify(caseCost);
        var sendPro_total = JSON.stringify(pro_total);
        var sendIsSerial = JSON.stringify(isSerial);
        var sendProReturn = JSON.stringify(pro_return);
        var brandArr =JSON.stringify(brand);
        var qualityArr =JSON.stringify(quality);


        var r = confirm("Do you want to save this transaction.?");
        if (r == true) {
            if ((rowCount - 1) == '0' || (rowCount - 1) == '') {
                $.notify("Please add products.", "warning");
                return false;
            } else if ((location_from) == '0' || (location_from) == '') {
                 $.notify("Please Select a destination location.", "warning");
                return false;
            } else if ((mrnNo) == '0' || (mrnNo) == '') {
                $.notify("Please select a MRN No.", "warning");
                return false;
            } else {
                $("#saveItems").attr('disabled', true);
//            return false;
                $.ajax({
                    type: "post",
                    url: "issueMrn",
                    data: {cusCode:cusCode,mrnNo:mrnNo,estNo:estNo, jobNo:jobNo, invoicenumber: invoicenumber, additional: additional, grnremark: grnremark, product_code: sendProduct_code, serial_no: sendSerial_no, qty: sendQty, unit_price: sendUnit_price,
                        discount_precent: sendDiscount_precent,brand:brandArr,  quality:qualityArr, pro_discount: sendPro_discount, total_net: sendTotal_net, unit_type: sendUnit_type, price_level: sendPrice_level, upc: sendUpc,
                        case_cost: sendCaseCost, freeQty: sendFree_qty, cost_price: sendCost_price, pro_total: sendPro_total, isSerial: sendIsSerial, proName: sendPro_name,proReturn:sendProReturn, total_cost: totalCost, totalProDiscount: totalProWiseDiscount, totalGrnDiscount: totalGrnDiscount,
                        grnDate: grnDate, invUser: invUser, total_amount: total_amount, total_discount: total_discount, total_net_amount: totalNetAmount, location: location, location_from: location_from, location_to: location_to},
                    success: function(data) {
                        var resultData = JSON.parse(data);
                        var feedback = resultData['fb'];
                        var invNumber = resultData['InvNo'];
                        if (feedback != 1) {
                             $.notify("Material Issue not saved successfully.", "warning");
                            $("#loadBarCode").hide();
                            $("#dwnLink").hide();
                            $("#saveItems").attr('disabled', false);
                            return false;
                        } else {
                           
                            $.notify("Material Issue saved successfully.", "success");
                   
                            $("input[name=suppliercheck][value='1']").prop('checked', false);
//                        $('#tbl_item tbody').html("");
                            $("#invoicenumber").val("");
                            $("#supplier").val("");
                            $("#totalgrn").html('0.00');
                            $("#grndiscount").html('0.00');
                            $("#netgrnamount").html('0.00');
                            $("#grnremark").val('');

                            total_amount = 0;
                            total_discount = 0;
                            totalNetAmount = 0;
                            mrnNo = 0;
                            estNo =0;
                            jobNo = 0;
                            supcode = 0;
                            creditAmount = 0;
                            dueAmount = 0;
                            totalProWiseDiscount = 0;
                            totalGrnDiscount = 0;
                            $("#cashAmount").val(0);
                            $("#chequeAmount").val(0);
                            $("#creditAmount").val(0);

                            $("#totalExpenses").html(0);
//                        getLastBatchNo();
                            $('#itemTable').show();
                            $('#costTable').hide();
                            $('#totalAmount').html('0.00');
                            $('#totalgrndiscount').html('0.00');
                            $('#totalprodiscount').html('0.00');
                            $('#dueAmount2').html('0.00');
                            $("#loadBarCode").hide();
                            $("#dwnLink").show();
                            $("#saveItems").attr('disabled', true);
//                        location.reload();
                        }
                    }
                });

            }
        } else {
            return false;
        }
    });

    $("#resetItems").click(function() {
        var r = confirm("Do you want to Reset.?");
        if (r == true) {
            location.reload();
        } else {
            return false;
        }
    });
    

    var p = 0;
    //add expenses
    var expensesArr = [];
    var total_expenses = 0;


    //================Common Functions====================//



    //===========calculate total summery======================================
    function cal_total(total, discount, extra, downPay, downPayInt, qurPayInt, totalInt, totalExtra) {

        var total_net2 = parseFloat(total) - parseFloat(discount);
        finalAmount = parseFloat(total_net2);
//        alert(total); alert(discount);
        $("#netgrnamount").html(accounting.formatMoney(total_net2));
        $("#grndiscount").html(accounting.formatMoney(discount));
        $("#totalgrn").html(accounting.formatMoney(total));
        total_discount = discount;
        total_amount = total;
        total_amount2 = total;
        totalNetAmount = total_net2;
    }

    //===============calculate product wise discount================================
    function calculateProductWiseDiscount(totalNet3, discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount 
        if (discount_type == 1) {
            if (discount == 1) {
                //discount by percent
                product_discount = totalNet3 * (disPercent / 100);
                disAmount = 0;
            } else if (discount == 2) {
                //discount by amount
                product_discount = disAmount;
                disPercent = product_discount * 100 / totalNet3;
            }
            total_item_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            disPercent = 0;
        }
        totalProWiseDiscount += product_discount;
        total_discount = totalProWiseDiscount + totalGrnDiscount;
        total_amount += totalNet3;
        // totalNet = totalNet3 - parseFloat(product_discount);
        discount_precent = accounting.formatNumber(disPercent);
        totalNetAmount +=parseFloat(totalNet);
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest);
        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#totalprodiscount').html(accounting.formatMoney(totalProWiseDiscount));
    }

    //=============calculate total item wise discount================================
    function calculateTotalItemWiseDiscount(discount, discount_type, disPercent, disAmount, total_amount4) {

        //product wise discount 
        if (discount_type == 1) {
            product_discount = 0;
        } else if (discount_type == 2) {
            //total item wise discount
            total_discount = 0;
            product_discount = 0;
            if (discount == 1) {
                //discount by percent
                product_discount = total_amount4 * (disPercent / 100);

                disAmount = 0;
                disPercent = 0;
            } else if (discount == 2) {
                //discount by amount

                product_discount = disAmount;
                disPercent = 0;
            }
        }

//        total_discount = product_discount;
        totalGrnDiscount = product_discount;

        total_discount = totalProWiseDiscount + totalGrnDiscount;
        discount_precent = 0;
        total_amount2 += parseFloat(total_amount4) - parseFloat(product_discount);
        total_amount = parseFloat(total_amount4);
        totalNetAmount = total_amount - parseFloat(total_discount);
        cal_total(total_amount, total_discount, totalExtraChrages, downPayment, total_dwn_interest, total_qur_interest, totalIterest);

        $('#discountAmount').html(accounting.formatMoney(total_discount));
        $('#netgrnamount').html(accounting.formatMoney(totalNetAmount));
        $('#totalgrndiscount').html(accounting.formatMoney(totalGrnDiscount));
    }

    function clear_data_after_save() {
        $("input[name=isLot][value='0']").prop('checked', true);
        getLastBatchNo();
        $('#tbl_item tbody').html("");
        $('#table_expenses tbody').html("");
        $("#cusCode").html("");
        $("#customer").val("");
        $("#creditLimit").html('0.00');
        $("#creditPeriod").html('0');
        $("#cusOutstand").html('0.00');
        $("#availableCreditLimit").html('0.00');
        $("#city").html('');
        $("#cusImage").hide();
        expensesArr.length = 0;
        pcode.length = 0;
        total_expenses = 0;
        $("#totalExpenses").html(0);
    }

    function setProductTable() {
        $('#tbl_item2 tbody tr').each(function(rowIndex, element) {
            var row = rowIndex + 1;
            $(this).find("[class]").eq(0).html(row);
            $(this).find("[class]").eq(0).parent().attr("ri", row);
            $(this).find("[class]").eq(0).parent().attr("id", row);
        });
    }

    function clear_gem_data() {
        $("#sellingPrice").val('');
        $("#mReturn").val(0);
        $("#serialNo").val('');
        $("#quality").val('');
        $("#brand").val('');
        $("#dv_SN").hide();
        $("#itemCode").val('');
        $("#itemCode").focus();
        $("#batchCode").val('');
        $("#unitcost").val(0);
        $("#remark").val('');
        $("#guessAmount").val(0);
        $("#qty").val(0);
        $("#cutWeight").val(0);
        $("#polishWeight").val(0);
        $("#totalNet").val(0);
        $("#buyAmount").val(0);
        $("#isCut").val(1);
        $("#isPolish").val(1);
        $("#isBuy").val(1);
        $(".gemoption").prop('checked', false);
        $('.rank').val(0);
        $("#disPercent").val(0);
        $("#disAmount").val(0);

        $("#totalAmount").html(accounting.formatMoney(total_amount));
        $("#netAmount").html(accounting.formatMoney(totalNetAmount));

        $("input[name=isCut][value='1']").prop('checked', false);
        $("input[name=isPolish][value='1']").prop('checked', false);
        $("input[name=isBuy][value='1']").prop('checked', false);
        totalNet2 = 0;
        discount = 0;
        discount_type = 0;
        discount_precent = 0;
        discount_amount = 0;
        product_discount = 0;
        itemCode = 0;
        casecost = 0;
        costPrice = 0;
        sellingPrice = 0;
        preturn=0;

    }

    function deleteImg(imgid) {
        $.ajax({
            type: 'POST',
            url: "../Admin/Controller/Product.php",
            data: {action: 'deleteimagedata', pid: pid, imgid: imgid},
            success: function(data) {
                if (data == 'success') {
                    $("div[imgdata='" + imgid + "']").parent().hide();
                }
            }
        });
    }

    //customer autoload
    $("#customer").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '../job/loadcustomersjson',
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.text,value: item.id,data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function(event, ui) {
            cusCode = ui.item.value;
            clearCustomerData();
            loadCustomerDatabyId(cusCode);
        }
    });

    function loadCustomerDatabyId(customer){
        clearCustomerData();
        $.ajax({
                type: "POST",
                url: "../Payment/getCustomersDataById",
                data: { cusCode: customer},
                success: function(data)
                {
                    var resultData = JSON.parse(data);

                    cusCode = resultData.cus_data.CusCode;
                    outstanding = resultData.cus_data.CusOustandingAmount;
                    available_balance = parseFloat(resultData.cus_data.CreditLimit) - parseFloat(outstanding);
                    customer_name=resultData.cus_data.CusName;
                    $("#cusName").html(resultData.cus_data.CusName);
                    $("#customer,#cusCode").val(resultData.cus_data.CusCode);
                    $("#creditLimit").html(accounting.formatMoney(resultData.cus_data.CreditLimit));
                    $("#creditPeriod").html(resultData.cus_data.CreditPeriod);
                    $("#cusOutstand").html(accounting.formatMoney(outstanding));
                    $("#availableCreditLimit").html(accounting.formatMoney(available_balance));
                    $("#cusAddress").html(nl2br(resultData.cus_data.Address01));
                    $("#cusAddress2").html(resultData.cus_data.Address03);
                    $("#cusPhone").html(resultData.cus_data.MobileNo);
                    $("#cusType").val(resultData.cus_data.CusType);
                    $("#cusType2").val(resultData.cus_data.CusType);
                    if(resultData.cus_data.CusCompany>0){
                         $("#vehicleCompany").show();
                    }
                    $("#vehicleCompany").val(resultData.cus_data.CusCompany);
                }
            });
    }

     function clearCustomerData(){
        $("#cusName").html('');
        $("#cusAddress").html('');
        $("#cusAddress2").html('');
        $("#cusPhone").html('');
    }

 function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }


});


$('.supplier_icheck').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-blue',
    increaseArea: '50%' // optional
});



var jobNo=0;
//job no autoload
    

var proCodeArr =[];
// load grid data
function loadEstimateDatatoGrid(resultData) {
    
    $("#tbl_item tbody").html('');
    if (resultData.est_dtl){
        jobNo = resultData.est_hed.EstJobCardNo;
        $("#job_no").val(jobNo);
        $("#est_no").val(resultData.est_hed.EstimateNo);

        if (resultData.est_hed.EstJobType == 1) {
            // $("#vehicleCompany").show();
            // $("#dvInsurance").show();
        } else {
            $("#vehicleCompany").hide();
            $("#dvInsurance").hide();
        }
        var k = 1;
        for (var i = 0; i < resultData.est_dtl.length; i++) {
            if (resultData.est_dtl[i].EstJobType == 2) {
                if (resultData.est_dtl[i].EstJobId > 0) { proCodeArr.push(resultData.est_dtl[i].EstJobId) }
                var itemCode = resultData.est_dtl[i].EstJobId;
                var prdName = resultData.est_dtl[i].EstJobDescription;
                var qty = resultData.est_dtl[i].EstQty;
                var unit = '';var upc='';
            
                 $("#tbl_item tbody").append("<tr ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "' qty='" + qty + "' unit_price='" + resultData.est_dtl[i].EstPrice + "' upc='" + upc + "' >\n\
                <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + k+ "'>" + accounting.formatNumber(qty) + "</td><td>" + unit + "</td><td class='rem" + k + "'><a href='#' class='remove btn btn-xs btn-danger'><i class='fa fa-remove'></i></a></td></tr>");
                k++;
            }
        }
    } else {
        $("#btnSave").html('Save');
        $("#action").val(1);
        estimateNo = 0;
    }
}

function loadMrnDatatoGrid(resultData) {
     customProCode='100001';
    $("#tbl_item tbody").html('');
    if (resultData.mrn_dtl){
        jobNo = resultData.mrn_hed.MrnJobNo;
        $("#job_no").val(jobNo);
        $("#est_no").val(resultData.mrn_hed.MrnEstimateNo);
        cusCode = resultData.mrn_hed.ToCustomer;
        $("#customer").val(cusCode);
        $("#grnremark").val(resultData.mrn_hed.MrnRemark);
        $("#location_from").val(resultData.mrn_hed.ToLocation);
         var k = 1;
        for (var i = 0; i < resultData.mrn_dtl.length; i++) {

                if (resultData.mrn_dtl[i].ProductCode > 0) { 
                    if(resultData.mrn_dtl[i].ProductCode!=customProCode){
                        proCodeArr.push(resultData.mrn_dtl[i].ProductCode);
                    }}
                    // proCodeArr.push(resultData.mrn_dtl[i].ProductCode) }
                var itemCode = resultData.mrn_dtl[i].ProductCode;
                var prdName = resultData.mrn_dtl[i].ProName;
                var qty = resultData.mrn_dtl[i].RequestQty;
                var quality = resultData.mrn_dtl[i].ProQuality;
                var brand = resultData.mrn_dtl[i].ProBrand;
                var unit = 'UNIT';var upc='';
                var isvat = parseFloat(resultData.mrn_dtl[i].MrnIsVat);
                var isnbt = parseFloat(resultData.mrn_dtl[i].MrnIsNbt);
                var nbtratio = parseFloat(resultData.mrn_dtl[i].MrnNbtRatio);
                var vat = parseFloat(resultData.mrn_dtl[i].MrnVatAmount);
                var nbt = parseFloat(resultData.mrn_dtl[i].MrnNbtAmount);
                var receive = parseFloat(resultData.mrn_dtl[i].Receive);

                var disabled='';
                if(receive==1){
                     $("#tbl_item tbody").append("<tr receive=" + receive + " ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "'  brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + resultData.mrn_dtl[i].SellingPrice + "' upc='" + resultData.mrn_dtl[i].UnitPerCase + "' caseCost='" + 0 + "' isSerial='" + resultData.mrn_dtl[i].IsSerial + "' serial='" + '' + "' discount_percent='" + 0 + "' cPrice='" + resultData.mrn_dtl[i].Prd_CostPrice + "' pL='" + resultData.mrn_dtl[i].PriceLevel + "' fQ='" + 0 + "' nonDisTotalNet='" + resultData.mrn_dtl[i].TotalAmount + "' netAmount='" + resultData.mrn_dtl[i].NetAmount + "' proDiscount='" + 0 + "' proName='" + prdName + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                    <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + k+ "'>" + accounting.formatNumber(qty) + "</td><td class='add" + k + "'><a href='#' class='add btn btn-xs btn-warning plus"+k+"' disabled='disabled'><i class='fa fa-plus'></i></a></td></tr>");
                }else{
                     $("#tbl_item tbody").append("<tr receive=" + receive + " ri=" + k + " id=" + k + " proCode='" + itemCode + "' uc='" + unit + "'  brand='" + brand + "' quality='" + quality + "' qty='" + qty + "' unit_price='" + resultData.mrn_dtl[i].SellingPrice + "' upc='" + resultData.mrn_dtl[i].UnitPerCase + "' caseCost='" + 0 + "' isSerial='" + resultData.mrn_dtl[i].IsSerial + "' serial='" + '' + "' discount_percent='" + 0 + "' cPrice='" + resultData.mrn_dtl[i].Prd_CostPrice + "' pL='" + resultData.mrn_dtl[i].PriceLevel + "' fQ='" + 0 + "' nonDisTotalNet='" + resultData.mrn_dtl[i].TotalAmount + "' netAmount='" + resultData.mrn_dtl[i].NetAmount + "' proDiscount='" + 0 + "' proName='" + prdName + "' isVat='" + isvat + "' isNbt='" + isnbt + "' nbtRatio='"+nbtratio+"' vat='"+vat+"' nbt='"+nbt+"'>\n\
                    <td class='text-center'>" + k + "</td><td class='text-left'>" + itemCode + "</td><td>" + prdName + "</td><td class='qty" + k+ "'>" + accounting.formatNumber(qty) + "</td><td class='add" + k + "'><a href='#' class='add btn btn-xs btn-warning plus"+k+"'><i class='fa fa-plus'></i></a></td></tr>");
                }
                k++;
            
        }
    } else {
        $("#btnSave").html('Save');
        $("#action").val(1);
        estimateNo = 0;
    }
}
