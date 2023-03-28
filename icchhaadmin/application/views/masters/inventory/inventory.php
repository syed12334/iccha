<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
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
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Update Inventory</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                            <div id="processing"></div>
                              
                                  <input type="hidden" name="cid" value="">
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                      <form id="procode" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <div class="form-group">
                                          <label>Product Code<span style="color:red">*</span></label>
                                            <select name="pcode" id="pcode" class="form-control">
                                              <option value="">Select Product Code</option>
                                              <?php
                                                if(count($pcode) >0) {
                                                  foreach ($pcode as $key => $value) {
                                                    ?>
                                                      <option value="<?= icchaEncrypt($value->id);?>"><?= $value->pcode;?></option>
                                                    <?php
                                                  }
                                                }
                                              ?>
                                            </select>
                                            <span id="pcode_error" class="text-danger"></span>
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                         <div id="sizes"></div>
                                     <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                                  </div>
                                      
                                </form>
                                        
                                       
                                  </div>
                                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                     
                                    <?php 
                                      if(count($getSize) >0) {
                                        ?>
                                        <h4 style="font-weight: bold">Out of stock products</h4 style="font-weight: bold">
                                          <table class="table table-bordered">
                                              <thead>
                                                <tr>
                                                  <th>Product Title</th>
                                                  <th>Product Code</th>
                                                  <th>Stock</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                        <?php
                                        foreach ($getSize as $values) {
                                          ?>
                                          <tr>
                                            <td><?= $values->ptitle;?></td>
                                            <td><?= $values->pcode;?></td>
                                            <td><?= $values->stock;?></td>
                                          </tr>
                                               
                                          <?php
                                        }
                                        ?>
                                          </tbody>
                                            </table>
                                        <?php
                                      }else {
                                          ?>
                                          <p style="color:red;text-align: center;font-weight: bold;font-size:18px">There Are No Out Of Stock Product As Of Now</p>
                                          <?php
                                      }
                                    ?>
                                   
                                            
                                  </div>
                                  
                                 <div class="clearfix"></div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


<script>
$(document).ready(function() {
      $("#procode").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'master/inventoryUpdate';?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.pcode_error !='') {
                $("#pcode_error").html(data.pcode_error);
              }else {
                $("#pcode_error").html('');
              }
            }
            else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
              $("#processing").html('<div class="alert alert-danger alert-dismissible"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#pcode_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
                setTimeout(function() {window.location.href="<?= base_url().'inventory';?>";}, 1000);
            }
          }
      });
  });

      $(document).on('change',"#pcode",function(e) {
          e.preventDefault();
          var pid = $(this).val();
          $.ajax({
              url :"<?= base_url().'master/getSizedata'; ?>",
              method:"post",
              data :{
                pid :pid,
                "<?= $this->security->get_csrf_token_name();?>": $(".csrf_token").val()
              },
              dataType :"json",
              success:function(data) {
                  if(data.status ==true) {
                    $("#sizes").html(data.msg);
                  }
                  else if(data.status ==false) {
                    $("#sizes").html(data.msg);
                  }
              }
          });
      });
});
</script>