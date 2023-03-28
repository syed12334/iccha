<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cname-error {
    color:red;
  }
  #sid-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Add Subcategory</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                              <form action="<?= base_url().'master/subsubcategorysave';?>" id="category" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="">
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                            <label>Select Subcategory<span style="color:red">*</span></label>
                               <select name="sid" id="sid" class="form-control">
                                 <option value="">Select Subcategory</option>
                                 <?php
                                  if(count($category) >0) {
                                    foreach ($category as $value) {
                                        ?>
                                        <option value="<?= $value->id;?>" ><?= $value->cname;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
</div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Sub Subcategory Name<span style="color:red">*</span></label>
                                              <input type="text" name="cname" id="cname" class="form-control" placeholder="Eg:Shirts" required>
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Sub Subcategory Image<span class="text-danger" style="margin-left: 10px">(Imagesize should be 300px * 300px)</span></label>
                                        <input type="file" name="image" id="image" class="form-control"  >
                                      </div>
                                 </div>
                                 <div class="clearfix"></div>
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                      <center> <button class="btn btn-primary" type="submit" id="submit">Submit</button></center>
                                  </div>
                                <div class="clearfix"></div>
                          </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>


<script>
$(document).ready(function(){


  $(document).ready(function() {
     
      $("#category").validate({
            rules: {
                cname: {
                     required: true,
                     minlength:3,
                  maxlength:30,

                  
                },
                sid : {
                  required:true
                }
  
            },
            messages: {
                cname: "Please enter category name",
                sid: "Please select subcategory name"
                
            },
              
        });
              
            });


});
</script>