<?= $header;?>
<style type="text/css">
  #name-error {
    color:red;
  }
    #location-error {
    color:red;
  }
    #msg-error {
    color:red;
  }
    #vmonths-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
         
                    <div class="card my-3 no-b" style="width:100%">
                    <div class="card-body">
                           <?php 
                        if(!empty($testimonials) && is_array($testimonials)) {
                            ?>
                            <div class="card-title">Edit Testimonials</div>
                            <?php
                        }else {
                           ?>
                            <div class="card-title">Add Testimonials</div>
                            <?php
                        }
                      ?>
                                    <?php
                               if(!empty($testimonials) && is_array($testimonials)) {
                            ?>
                            <?php
                              if(count($testimonials) >0) {
                                ?>
                                          <form action="<?= base_url().'master/testimonialssave';?>" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
    <div class="row">
                                                                  <input type="hidden" name="id" id="tid" value="<?= $testimonials[0]->id;?>">
                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                           <div class="form-group">
                            <label>Name <span style="color:red">*</span></label>
                               <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="<?= $testimonials[0]->name;?>">
                           </div>
                         </div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
         <div class="form-group">
                            <label>Location <span style="color:red">*</span></label>
                               <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="<?= $testimonials[0]->location;?>">
                           </div>                
</div>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
                            <label>Image <span style="color:red">*</span></label>
                               <input type="file" name="file" id="file" class="form-control"  >
                           </div>   
                           <?php
                            if(!empty($testimonials[0]->image)) {
                              ?>
                              <img src="<?= app_url().$testimonials[0]->image;?>" style="width:100px">
                              <?php
                            }
                           ?>               
</div>
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                            <label>Description <span style="color:red">*</span></label>
                             <textarea cols="2" rows="2" class="form-control" id="msg" name="msg"><?= $testimonials[0]->tdesc;?></textarea>
                           </div>
                         </div>
              
<div class="clearfix"></div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <center>
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                           </center>
                           </div>
                           </div>
                           
                       </form>

                                <?php
                              }else {
                                  redirect('subscription');
                              }
                            ?>
                       
                            <?php
                          }else {
                            ?>
                               <form action="<?= base_url().'master/testimonialssave';?>" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                  <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                <div class="row">
                                                                  <input type="hidden" name="id" id="pid" value="">
                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                           <div class="form-group">
                            <label>Name <span style="color:red">*</span></label>
                               <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"  required>
                           </div>
                         </div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
         <div class="form-group">
                            <label>Location <span style="color:red">*</span></label>
                               <input type="text" name="location" id="location" class="form-control" placeholder="Enter Location"  required>
                           </div>                
</div>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
                            <label>Image <span style="color:red">*</span></label>
                               <input type="file" name="file" id="file" class="form-control"  >
                           </div>                  
</div>
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                            <label>Description <span style="color:red">*</span></label>
                             <textarea cols="2" rows="2" class="form-control" id="msg" name="msg" required></textarea>
                           </div>
                         </div>
              
<div class="clearfix"></div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <center>
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                           </center>
                           </div>
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
<?= $footer;?>


<script type="text/javascript">
  $(document).ready(function() {
     
      $("#testimonials").validate({
            rules: {
                name: {
                     required: true,
                     minlength: 3,
                     maxlength:30
                  
                },
                location: {
                    required: true,
                    minlength: 3,
                     maxlength:30
                },
               
                
            },
            messages: {
                name: "Name must be 3 to 30 characters long",
                
                location: "Location must be 3-30 characters long",
                
            }
        });
              
            });
</script>