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
                  <div class="card-title">Contact Us</div>
                           
                            <?php
                              if($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>    
                               <form action="<?= base_url().'master/contactsave';?>" method="post" style="margin-top:40px">
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                         
                        <div class="row">
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                             <div class="form-group">
                               <label>Email</label>
                               <input type="email" name="email" placeholder="Enter Email" class="form-control" value="<?php if(!empty($contact[0]->email)) { echo $contact[0]->email;}?>">
                           </div>
                          </div>
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                             <div class="form-group">
                               <label>Phone Number</label>
                               <input type="number" name="phone" placeholder="Enter Phone Number" class="form-control" value="<?php if(!empty($contact[0]->phone)) { echo $contact[0]->phone;}?>" maxlength="12">
                           </div>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <textarea cols="2" rows="2" class="form-control" placeholder="Enter Address" name="address"><?php if(!empty($contact[0]->address)) { echo $contact[0]->address;}?></textarea>
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

