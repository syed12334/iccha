<?php //echo "<pre>";print_r($category);exit;?>
<?= $header;?>
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #cname-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                            <div class="card-title">Edit subategory</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>

                          <?php
                            if(count($subcategory)>0) {
                              ?>
                              <form action="<?= base_url().'master/subcategorysave';?>" id="category" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                  <input type="hidden" name="cid" value="<?= $subcategory[0]->id;?>">
                                  <div class="row">
                                                     <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                            <label>Select Category<span style="color:red">*</span></label>
                               <select name="sid" id="sid" class="form-control">
                                 <option value="">Select Category</option>
                                 <?php
                                  if(count($category) >0) {
                                    foreach ($category as $value) {
                                        ?>
                                        <option value="<?= $value->id;?>" <?php if($subcategory[0]->cat_id == $value->id) {echo "selected";}?>><?= $value->cname;?></option>
                                        <?php
                                    }
                                  }
                                 ?>
                               </select>
                           </div>
</div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                          <label>Subcategory Name<span style="color:red">*</span></label>
                                              <input type="text" name="cname" id="cname" class="form-control" placeholder="Eg: Men" required value="<?= $subcategory[0]->sname;?>">
                                       </div>
                                  </div>
                                  <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Subcategory Image<span class="text-danger" style="margin-left: 10px">(Imagesize should be 300px * 300px)</span></label>
                                        <input type="file" name="image" id="image" class="form-control"  >
                                        <?php
                                          if(!empty($subcategory[0]->sub_img)) {
                                            ?>
                                            <img src="<?= app_url().$subcategory[0]->sub_img; ?>" style="width:100px">
                                            <?php
                                          }
                                        ?>
                                      </div>
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
                              redirect(base_url().'subcategory');
                            }
                          ?>
                              
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
  
            },
            messages: {
                cname: "Please enter category name",
                
            },
              
        });
              
            });


});
</script>