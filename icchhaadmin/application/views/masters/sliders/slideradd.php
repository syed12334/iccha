<?php //echo "<pre>";print_r($city);exit;?>
<?= $header;?>
<style type="text/css">
  #sfile-error {
    color:red;
  }
   #city-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                       <?php 
                            if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                        ?>
                           <?php 
                        if(!empty($city) && is_array($city)) {
                            ?>
                            <div class="card-title">Edit Slider</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add Slider</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if(!empty($city)) {

                            ?>
                                             <form id="category" action="<?= base_url().'master/saveslider';?>" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="<?= $city[0]->id;?>">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                 
                           
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Slider Image<span style="color:red">*</span><span class="text-danger" style="margin-left: 10px">(Imagesize should be 1903px * 520px)</span></label>
                             <input type="file" name="sfile" class="form-control" id="sfiles">
                             <?php
                              if(!empty($city[0]->image)) {
                                ?>
                                <img src="<?= app_url().$city[0]->image;?>" style="width:100px">
                                <?php
                              }
                             ?>
                           </div>
                         </div>

                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Title</label>
                              <input type="text" name="stitle" class="form-control" placeholder="Enter slider title" value="<?php if(!empty($city[0]->stitle)) {echo $city[0]->stitle;}?>">
                            </div>
                         </div>
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Tagline</label>
                              <input type="text" name="stagline" class="form-control" placeholder="Enter slider tag line" value="<?php if(!empty($city[0]->stagline)) {echo $city[0]->stagline;}?>">
                            </div>
                         </div>
                               <div class="clearfix"></div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Link</label>
                              <input type="url" name="link" class="form-control" placeholder="Enter slider link" value="<?php if(!empty($city[0]->sliderlink)) {echo $city[0]->sliderlink;}?>">
                            </div>
                         </div>
                         <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></div>
                         <div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                        
                         </div>
                         <div class="clearfix"></div>
                           </div>
                       </form>
                            <?php
                          }else {
                            ?>
                               <form id="category" action="<?= base_url().'master/saveslider';?>" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                           <div class="form-group">
                            <label>Slider Image<span style="color:red">*</span><span class="text-danger" style="margin-left: 10px">(Imagesize should be 1903px * 520px)</span></label>
                             <input type="file" name="sfile" class="form-control" id="sfile" >
                           </div>
                         </div>
                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Title</label>
                              <input type="text" name="stitle" class="form-control" placeholder="Enter slider title">
                            </div>
                         </div>
                         <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Tagline</label>
                              <input type="text" name="stagline" class="form-control" placeholder="Enter slider tag line" >
                            </div>
                         </div>
                             <div class="clearfix"></div>
                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                              <label>Slider Link</label>
                              <input type="url" name="link" class="form-control" placeholder="Enter slider link">
                            </div>
                         </div>
                         <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"></div>
                         <div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                          
                         </div>
                         <div class="clearfix"></div>
                           </div>
                       </form>
                            <?php
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>
<?php
if(!empty($city)) {

}else {
  ?>
  <script type="text/javascript">
    $(document).ready(function() {
     
      $("#category").validate({
            rules: {
                sfile: {
                     required: true,
                  
                },
  
            },
            messages: {
                sfile: "Please upload image",
                
            },
              
        });
              
            });
</script>
  <?php
}
?>


