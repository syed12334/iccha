<?php //echo "<pre>";print_r($property);exit;?>
<?= $header;?>
<style type="text/css">
  #title-error {
    color:red;
  }
</style>
<div class="page has-sidebar-left bg-light height-full">
 <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                    <div class="card my-3 no-b">
                    <div class="card-body">
                  <div class="card-title">Social Links</div>
                           
                            <?php
                              if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>    
                               <form action="<?= base_url().'master/sociallinksave';?>" method="post" style="margin-top:40px">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         
                        <div class="row">
                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                               <label>Facebook</label>
                               <input type="url" name="facebook" placeholder="Enter Facbook URL" class="form-control" value="<?php if(!empty($sociallinks[0]->facebook)) { echo $sociallinks[0]->facebook;}?>">
                           </div>
                          </div>
                           <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                               <label>Twitter</label>
                               <input type="url" name="twitter" placeholder="Enter Twitter URL" class="form-control" value="<?php if(!empty($sociallinks[0]->twitter)) { echo $sociallinks[0]->twitter;}?>">
                           </div>
                          </div>

                           <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                             <div class="form-group">
                               <label>Linkedin</label>
                               <input type="url" name="linkedin" placeholder="Enter Linkedin URL" class="form-control" value="<?php if(!empty($sociallinks[0]->linkedin)) { echo $sociallinks[0]->linkedin;}?>">
                           </div>
                          </div>
                         
                          <div class="clearfix"></div>
                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                               <label>Instagram</label>
                               <input type="url" name="instagram" placeholder="Enter Instagram URL" class="form-control" value="<?php if(!empty($sociallinks[0]->instagram)) { echo $sociallinks[0]->instagram;}?>">
                           </div>
                          </div>
                           <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                               <label>Youtube</label>
                               <input type="url" name="youtube" placeholder="Enter Youtube URL" class="form-control" value="<?php if(!empty($sociallinks[0]->youtube)) { echo $sociallinks[0]->youtube;}?>">
                           </div>
                          </div>
                          <div class="clearfix"></div>
                        </div>


                            <br />

                           <center>
                             <button class="btn btn-primary" type="submit" id="submit">Submit</button>
                           </center>
                           
                       </form>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $footer;?>

