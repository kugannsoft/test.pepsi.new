<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    #gridarea {
        display: flex;
        overflow:scroll;
        background: rgba(136, 153, 119, 0.23);
        height: 300px;
        padding: 2px;
    }
    #tbl_est_data tbody tr td{
        padding: 13px;
    }
    .editrowClass {
      background-color: #f1b9b9;
    }
</style>
<div class="content-wrapper" id="app">
    <section class="content-header">
        <span style="font-size: 25px;"><?php echo $pagetitle; ?></span>
        <div class="pull-right">
          <span style="font-size: 25px;color: #337ab7;" v-if="totalcount">total: {{totalcount}}</span>
        </div>
    </section>
    <section class="content">
        <div class="row">
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="jobNo" id="jobNo" placeholder="Job No" v-model='jobcardNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="estimateNo" id="estimateNo" placeholder="Estimate No" v-model='estimateNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="invoiceNo" id="invoiceNo" placeholder="Invoice No" v-model='invoiceNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="regNo" id="regNo" placeholder="Registration No" v-model='regNo'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="customerCode" id="customerCode" placeholder="Customer No" v-model='customerCode'>
                </div>
           </div>
           <div class="col-md-2">
               <div class="form-group">
                    <input type="text" class="form-control"  name="date" id="date" placeholder="Date" v-model='date'>
                </div>
           </div> 
        </div>
        <div class="row">
        <form id="addform">
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="jobtype" v-model='vrow.jobtype'>
                        <option value="">--select--</option>
                        <?php foreach ($jobtypes as $k => $v) { ?>
                            <option value="<?php echo $v->jobtype_id ?>"><?php echo $v->jobtype_code." - ".$v->jobtype_name ?>
                            </option>
                       <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input class="form-control" type="text" name="description" id="description" v-model='vrow.description'>
                </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="number" name="qty" id="qty" placeholder="Qty" class="form-control" v-model='vrow.qty' @keyup.enter='addrow' />
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <input type="number" name="price" id="price" placeholder="Price" class="form-control" v-model='vrow.price' @keyup.enter='addrow' />
              </div>
            </div>
            <div class="col-md-2">
                <div class="input-group" style=""> 
                  <input type="text" class="form-control" name="snpid" style="width:60%" v-model="vrow.discountval" @keyup.enter='addrow' />
                  <select id="lunch" class="form-control" style="width:40%" v-model="vrow.discountmethod">
                      <option value="1" style="font-weight: bold;">CSH</option>
                      <option value="2" style="font-weight: bold;">%</option>
                  </select> 
              </div>
            </div>
            <div class="col-md-1">
                <button @click='addrow' class="btn btn-primary" type="button" v-show="!isUpdateRow">Add</button>
                <button @click='updaterow' class="btn btn-primary" type="button" v-show="isUpdateRow">Update</button>
            </div>
          </form>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div id="gridarea">
                    <table class="table table-bordered" style="table-layout: fixed;" >
                        <thead>
                            <tr>
                                <td width="10%"><b>##</b></td>
                                <td width="35%"><b>Description</b></td>
                                <td width="5%"><b>Qty</b></td>
                                <td width="10%"><b>Price</b></td>
                                <td width="10%"><b>Total</b></td>
                                <td width="10%"><b>Discount</b></td>
                                <td width="10%"><b>Net Total</b></td>
                                <td width="10%"><b>###</b></td>
                            </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item,key in vgriddata" >

                            <td>{{key+1}}</td>
                            <td class="text-nowrap" style="overflow: hidden;">{{item.description}}</td>
                            <td>{{item.qty}}</td>
                            <td align="right">{{item.price | currency}}</td>
                            <td align="right">{{item.total | currency}}</td>
                            <td align="right">{{item.discountval | currency}}</td>
                            <td align="right">{{item.netamount | currency}}</td>
                            <td>
                              <button @click="removeitem(key)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-remove-circle"></i></button>
                              <button @click="edititem(item)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-2">
              <button type="button" class="btn btn-default btn-lg btn-block">Cancel</button>
              <button type="button" @click='printinvoice' class="btn btn-default btn-lg btn-block">Print</button>
              <button type="button" class="btn btn-default btn-lg btn-block" v-show="state==='save'" @click='saveinvoice' >Save</button>
              <button type="button" class="btn btn-default btn-lg btn-block" v-show="state==='update'" @click='updateinvoice'>Update</button>
            </div>
        </div>
        <!-- print parts goes here -->
        <div class="modal fade bs-payment-modal-lg" id="modelInvoice" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content"><div class="modal-body" >
                                <div class="row"  id="printArea" align="center" style='margin:5px;'>
                                <table style="border-collapse:collapse;width:700px;margin:5px;font-family: Arial, Helvetica, sans-serif;" border="0">
            <tr style="text-align:center;font-size:35px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6" style="font-size:25px;font-family: Arial, Helvetica, sans-serif;"><b> <?php echo $company['CompanyName'] ?> <?php echo $company['CompanyName2'] ?></b></td>
            </tr> 
            <tr style="text-align:center;font-size:15px;font-family: Arial, Helvetica, sans-serif;">
                <td colspan="6"><b><?php echo $company['AddressLine01'] ?><?php echo $company['AddressLine02'] ?><?php echo $company['AddressLine03'] ?> &nbsp;&nbsp;  <?php echo $company['LanLineNo'] ?>, <?php echo $company['Fax'] ?> <?php echo  $company['MobileNo'] ?></b></td>
            </tr>
            <tr style="text-align:center;font-size:14px;border-bottom: #000 solid 1px;padding-bottom:5px;">
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Customer Code</td>
                <td> :</td>
                <td id="lblcusCode"> &nbsp;</td>
                <td colspan="3" style="text-align:center;font-size:20px;"> <b>Genaral Estimate</b></td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Customer Name</td>
                <td> :</td>
                <td id="lblcusName"> &nbsp;</td>
                <td > Date</td>
                <td> :</td>
                <td  id="lblinvDate"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Address</td>
                <td> :</td>
                <td rowspan="3" id="lblAddress" valign="top"> &nbsp;</td>
                <td> Tel</td>
                <td> :</td>
                <td  id="lbltel"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> </td>
                <td></td>
                <td > Make</td>
                <td> :</td>
                <td  id="lblmake"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> </td>
                <td> </td>
                <td > Model No</td>
                <td> :</td>
                <td  id="lblmodel"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> Contact Name</td>
                <td>:</td>
                <td  id="lblConName"> &nbsp;</td>
                <td > Estimate No</td>
                <td> :</td>
                <td  id="lblestimateNo"> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td> V. I. No </td>
                <td>:</td>
                <td  id="lblviNo"> &nbsp;</td>
                <td > </td>
                <td> </td>
                <td> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td>Reg No</td>
                <td>:</td>
                <td  id="lblregNo"> &nbsp;</td>
                <td > </td>
                <td> </td>
                <td> &nbsp;</td>
            </tr>
            <tr style="text-align:left;font-size:15px;">
                <td colspan="6">&nbsp;</td>
            </tr>
        </table>
                      <table id="tbl_est_data" style="border-collapse:collapse;width:700px;padding:5px;" border="1">
                          <thead>
                              <tr>
                                  <th style='padding: 3px;'>Item</th>
                                  <th style='padding: 3px;'>Description</th>
                                  <th style='padding: 3px;'></th>
                                  <th style='padding: 3px;'>Qty</th>
                                  <th style='padding: 3px;'>Unit Price</th>
                                  <th style='padding: 3px;'>Quoted Price</th>
                              </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item,key in vgriddata">
                              <td> {{key+1}}</td>
                              <td class="text-nowrap" style="overflow: hidden;">{{item.description}}</td>
                              <td align="right">{{item.total | currency}}</td>
                              <td>{{item.qty}}</td>
                              <td align="right">{{item.price | currency}}</td>
                              <td align="right">{{item.netamount | currency}}</td>
                            </tr>
                          </tbody>
                          <tfoot>
                              <tr><th colspan="5" style='text-align:right'>Estimate Amount  </th><th id="totalEsAmount"   style='text-align:right'></th></tr>
                              <tr><th colspan="6"></th></tr>
                          </tfoot>
                      </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

Vue.filter('currency', function(val){
    return accounting.formatNumber(val)
});
var app = new Vue({
  el:'#app',
  data:{
      isUpdateRow:false,
      state:'',
      vgriddata:[],
      vrow:{
        jobtype:'',
        description:'',
        qty:'',
        price:'',
        total:'',
        netamount:0,
        discountval:0,
        discountmethod:1,
        timestamp:''
    },
    jobcardNo:'',
    estimateNo:'',
    invoiceNo:'',
    regNo:'',
    customerCode:'',
    date:''
  },
  methods:{
    addrow: function() {
      if(this.vrow.jobtype !='' && this.vrow.qty !='' && this.vrow.discountmethod !=''){
          this.vrow.total = this.totalcount;
          this.vrow.netamount = this.adddiscount;
          this.vrow.timestamp = Date.now();
          this.vgriddata.push(this.vrow);
          this.vrow = {jobtype:'',description:'',qty:'',price:'',total:0,discount:0,discountval:0,discountmethod:1,timestamp:''};
          $('#jobtype').focus();
      }
    },
    updaterow() {
      var that = this.vrow.timestamp;
      return this.vgriddata.forEach(function(itm) {
          if(itm.timestamp == that){
            itm.description = app.vrow.description;
            itm.jobtype = app.vrow.jobtype;
            itm.discountmethod = app.vrow.discountmethod;
            itm.discountval = app.vrow.discountval;
            itm.netamount = app.adddiscount;
            itm.price = app.vrow.price;
            itm.qty = app.vrow.qty;
            itm.total = app.totalcount;
          }
      });
    },
    removeitem: function(index) {
      if (index > -1) {
        this.vgriddata.splice(index, 1)
      }
    },
    edititem(item) {
      console.log(item);
      this.vrow.jobtype = item.jobtype;
      this.vrow.description = item.description;
      this.vrow.qty = item.qty;
      this.vrow.price = item.price;

      this.vrow.netamount = item.netamount;
      this.vrow.discountval = item.discountval;
      this.vrow.discountmethod = item.discountmethod;

      this.state = '';
      this.isUpdateRow = true;

    },
    printinvoice: function() {
      $('#printArea').focus().print();
    },
    saveinvoice: function() {
      $.ajax({
        url:'salesinvoice/saveinvoice',
        dataType:'json',
        type:'POST',
        data:{
          data: app.vgriddata,
                jobcardno:this.jobcardNo,
                estimateNo:this.estimateNo,
                invoiceNo:this.invoiceNo,
                regNo:this.regNo,
                customerCode:this.customerCode,
                date:this.date
              },
        success:function(data) {
          if(data==1) {
            app.vgriddata = [];
            app.jobcardNo = '';
            app.estimateNo= '';
            app.invoiceNo = '';
            app.regNo = '';
            app.customerCode = '';
            app.date = '';
            app.state = '';

            $('#printArea').focus().print();
          }
        }
      });
    },
    updateinvoice: function() {
      $.ajax({
        url:'<?php echo base_url('admin') ?>/salesinvoice/updateinvoice',
        dataType:'json',
        type:'POST',
        data:{data: app.vgriddata,
                jobcardno:this.jobcardNo,
                estimateNo:this.estimateNo,
                invoiceNo:this.invoiceNo,
                regNo:this.regNo,
                customerCode:this.customerCode,
                date:this.date},

        success:function(data) {
          if(data==1) {
            app.vgriddata = [];
            app.jobcardNo = '';
            app.estimateNo= '';
            app.invoiceNo = '';
            app.regNo = '';
            app.customerCode = '';
            app.date = '';
            app.state = '';

            $('#printArea').focus().print();
          }
        }
      });
    }
  },
  computed:{
    totalcount(){
      return this.vrow.price*this.vrow.qty
    },
    adddiscount(){
      if(this.vrow.discountmethod == 1){
          return (this.vrow.price*this.vrow.qty) - this.vrow.discountval;
      } else if(this.vrow.discountmethod == 2) {
          return (this.vrow.price*this.vrow.qty) - (this.vrow.price*this.vrow.qty*this.vrow.discountval/100);
      } else {
          return 0;
      }
      
    }
  },
  mounted() {
      var type = '<?php echo $type ?>';
      var id = '<?php echo $id; ?>';

      if(type == 'inv') {
         $.ajax({
          url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail2/'+id,
          dataType: 'json',
          success: function(data) {
              app.state = 'update';
              app.invoiceNo = data.JobInvNo;
              app.jobcardNo = data.jobcardNo;
              app.date = data.date;
              app.regNo = data.regNo;
              app.customerCode = data.customerCode; 
              app.vgriddata = data.detail;
          }
        });
      } else if(type == 'job') {
          $.ajax({
          url:'<?php echo base_url('admin') ?>/salesinvoice/loadjobonload/'+ id,
          dataType:'json',
          success: function(data) {
              app.jobcardNo = data.JobCardNo;
              app.estimateNo = data.JestimateNo;
              app.regNo = data.JRegNo;
              app.customerCode = data.JCustomer;
              app.state = 'save';

          }
        });
      }
}

});


$('#date').datepicker({ autoclose: true, format: 'yyyy-mm-dd',todayBtn: "linked", });
$('#date').on('changeDate', function(){
    app.date = $(this).val();
});

$('#jobNo').autocomplete({
  autoFocus: true,
  minLength: 2,
  maxLength:3,
  source:function(request,response) {
    $.ajax({
        url: '<?php echo base_url('admin') ?>/salesinvoice/loadjobjson',
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
   select: function(event, ui) {
    app.jobcardNo = ui.item.value;

    app.vgriddata = [];
      $.ajax({
        url:'<?php echo base_url('admin') ?>/salesinvoice/loadjob/'+ ui.item.value,
        dataType:'json',
        success: function(data) {
          if(data == ''){

          } else {
            app.estimateNo = data.JestimateNo;
            app.regNo = data.JRegNo;
            app.customerCode = data.JCustomer;
            app.state = 'save';
          }
        }
      });
    }
});

$('#description').autocomplete({
  autoFocus: true,
   minLength: 0,
  source:function(request,response) {
    $.ajax({
        url: '<?php echo base_url('admin') ?>/salesinvoice/loaddescription',
        dataType: "json",
        data: {q: request.term, jtype: app.$data.vrow.jobtype},
        success: function(data) {
            response($.map(data, function(item) {
                app.vrow.description =  item.text;
                return {label: item.text,value: item.text,data: item}
            }));
        }
    });
  },
  select: function(event, ui) {
      app.vrow.description = ui.item.label;
      app.vrow.price = ui.item.data.price;
    }
});

$('#estimateNo').autocomplete({
  autoFocus:true,
  minLength: 0,
  source: function(request, response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadestimate',
      dataType: 'json',
      data: {q: request.term},
      success: function(data) {
        response($.map(data, function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },
  select: function(event, ui) {
    $.ajax({
      url:'<?php echo base_url('admin') ?>/salesinvoice/loadestimatedetail/'+ui.item.value,
      dataType: 'json',
      success: function(data) {
        app.invoiceNo = data.JobInvNo;
        app.estimateNo = data.EstimateNo;
        app.jobcardNo = data.EstJobCardNo;
        app.date = data.EstDate;
        app.regNo = data.EstRegNo;
        app.customerCode = data.EstCustomer; 
        app.vgriddata = data.detail;
        app.state = 'save';
      }
    });
  }
});

$('#invoiceNo').autocomplete({
  autoFocus: true,
  minLength: 0,
  source: function (request,response) {
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicejson',
      dataType: 'json',
      data: {q:request.term},
      success: function(data) {
        response($.map(data,function(item) {
          return {label: item.text,value: item.text,data: item}
        }));
      }
    });
  },select: function(event,ui) {
    console.log(ui.item.label);
    $.ajax({
      url: '<?php echo base_url('admin') ?>/salesinvoice/loadinvoicedetail/'+ui.item.label,
      dataType: 'json',
      success: function(data) {
          app.state = 'update';
          app.invoiceNo = ui.item.label;
          app.jobcardNo = data.jobcardNo;
          app.date = data.date;
          app.regNo = data.regNo;
          app.customerCode = data.customerCode; 
          app.vgriddata = data.detail;
      }
    });
  }
});

</script>