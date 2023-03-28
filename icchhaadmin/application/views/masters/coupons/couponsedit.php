<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cname-error {
    color:red;
  }
  #processing {
    position: fixed;
    z-index:9999999;
    width: 24%;
    padding: 10px;
    right:20px;
    top:70px;
   
  }
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<div id="processing"></div>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Edit Coupon</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                            <?php
                              if(count($coupons) >0) {
                                  ?>
                                     <form id="coupons" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="<?= $coupons[0]->id;?>">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Coupon Type<span style="color:red">*</span></label>
                                              <select name="type" id="type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="0" <?php if($coupons[0]->type ==0) {echo "selected";}?>>Flat Discount</option>
                                                <option value="1" <?php if($coupons[0]->type ==1) {echo "selected";}?>>Percentage Discount</option>
                                              </select>
                                              <span id="type_error" class="text-danger"></span>
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Coupon Code</label>
                                        <input type="text" name="ccode" id="ccode" class="form-control"  placeholder="Eg:SS123" value="<?php if(!empty($coupons[0]->title)) {echo $coupons[0]->title;} ?>">
                                        <span id="ccode_error" class="text-danger" ></span>
                                      </div>
                                 </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="fdate" id="fdate" class="form-control"  placeholder="Select From Date" value="<?php if(!empty($coupons[0]->from_date)) {echo date('d-m-Y',strtotime($coupons[0]->from_date));} ?>">
                                        <span id="fdate_error" class="text-danger"></span>
                                      </div>
                                 </div>
                                 <div class="clearfix"></div>
                                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                      <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="tdate" id="tdate" class="form-control"  placeholder="Select To Date" value="<?php if(!empty($coupons[0]->to_date)) {echo date('d-m-Y',strtotime($coupons[0]->to_date));} ?>">
                                        <span id="tdate_error" class="text-danger"></span>
                                      </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Discount</label>
                                        <input type="number" name="discount" id="discount" class="form-control"  placeholder="Enter Coupon Dicount" placeholder="Eg:10" value="<?php if(!empty($coupons[0]->discount)) {echo $coupons[0]->discount;} ?>">
                                        <span id="dicount_error" class="text-danger"></span>
                                      </div>
                                 </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                    
                                 </div>
                                 <div class="clearfix"></div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <center> <button class="btn btn-primary" type="submit" id="submit">Submit</button></center>
                                  </div>
                                <div class="clearfix"></div>
                          </div>
                       </form>
                                  <?php
                              }else {
                                  redirect(base_url().'coupons');
                              }
                            ?>
                             
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

<script>

  $("#tdate").datepicker({
        dateFormat :"dd-mm-yy",
        changeMonth:true,
        changeYear :true
    });
    $("#fdate").datepicker({
        dateFormat :"dd-mm-yy",
        changeMonth:true,
        changeYear :true
    });
    $('#fdate').change(function() {
startDate = $(this).datepicker('getDate');
$("#tdate").datepicker("option", "minDate", startDate );
});
$('#tdate').change(function() {
endDate = $(this).datepicker('getDate');
$("#fdate").datepicker("option", "maxDate", endDate );
});

  $(document).ready(function() {
      $("#coupons").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'master/couponsave';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.type_error !='') {
                $("#type_error").html(data.type_error);
              }else {
                $("#type_error").html('');
              }
              if(data.ccode_error !='') {
                $("#ccode_error").html(data.ccode_error);
              }else {
                $("#ccode_error").html('');
              }
              if(data.fdate_error !='') {
                $("#fdate_error").html(data.fdate_error);
              }else {
                $("#fdate_error").html('');
              }
              if(data.tdate_error !='') {
                $("#tdate_error").html(data.tdate_error);
              }else {
                $("#tdate_error").html('');
              }
              if(data.dicount_error !='') {
                $("#dicount_error").html(data.dicount_error);
              }else {
                $("#dicount_error").html('');
              }
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#type_error").html('');
               $("#ccode_error").html('');
               $("#fdate_error").html('');
               $("#tdate_error").html('');
               $("#dicount_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
               
               
                setTimeout(function() {window.location.href="<?= base_url().'coupons';?>";}, 1000);
            }
          }
      });
  });


});
</script>