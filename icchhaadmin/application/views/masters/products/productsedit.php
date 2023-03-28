<?= $header;?>
<style type="text/css">
  #pincode-error {
    color:red;
  }
  #image-error {
    color:red;
  }
  #processing {
    position: fixed;
    z-index:99999999!important;
    width: 27%;
    padding: 10px;
    top:80px;
  right: 20%;
  transform: translate(-50%, -50%);
  -webkit-transform: translate(-50%, -50%);
  -moz-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  -o-transform: translate(-50%, -50%);
  opacity: 1!important;
  }
  label {
    font-size: 15px!important;
    font-weight: bold!important
  }
   p {
    font-size: 15px!important;
    font-weight: bold!important;

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
                            <div class="card-title">Edit Products</div>
                            <?php
                              if(@$this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                              }
                            ?>
                            <?php
                              if(count($products) >0) {
                                ?>
                                         <form id="products" method="post" style="margin-top:40px" enctype="multipart/form-data">
                                        <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
                                        <input type="hidden" name="pid" value="<?= $products[0]->id;?>">
                                        <div class="row">
                                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                             <div class="form-group">
                                                <label>Select Category <font style="color:red;margin-left: 5px">*</font></label>
                                                   <select name="category" id="category" class="form-control" >
                                                     <option value="">Select Category</option>
                                                     <?php 
                                                      if(count($category) >0 ) {
                                                        foreach ($category as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" <?php if($products[0]->cat_id == $value->id) {echo "selected";}?>><?= $value->cname;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                                   </select>
                                                     <span id="cat_error" class="text-danger"></span>
                                             </div>
                                        </div>
                                          <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                              <label>Select Subcategory<font style="color:red;margin-left: 5px">*</font></label>
                                               <select name="subcategory" id="subcategory" class="form-control" >
                                                 <option value="">Select Subcategory</option>
                                                  <?php 
                                                      if(count($subcategory) >0 ) {
                                                        foreach ($subcategory as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" <?php if($products[0]->subcat_id == $value->id) {echo "selected";}?>><?= $value->sname;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                               <span id="sub_error" class="text-danger"></span>
                                            </div>
                                       </div>
                                        <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                              <label>Sub Subcategory</label>
                                               <select name="subsubcategory" id="subsubcategory" class="form-control">
                                                 <option value="">Select Sub Subcategory</option>
                                                   <?php 
                                                      if(count($subsubcategory) >0 ) {
                                                        foreach ($subsubcategory as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" <?php if($products[0]->sub_sub_id == $value->id) {echo "selected";}?>><?= $value->ssname;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                               <span id="subsub_error" class="text-danger"></span>
                                            </div>
                                       </div>
                                        <div class="clearfix"></div>
                                       <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                              <label>Brand</label>
                                               <select name="brand" id="brand" class="form-control" >
                                                 <option value="">Select Brand</option>
                                                 <?php
                                                  if(count($brand) >0) {
                                                    foreach ($brand as $bran) {
                                                      ?>
                                                      <option value="<?= $bran->id;?>" <?php if($products[0]->brand_id == $bran->id) {echo "selected";}?>><?= $bran->name;?></option>
                                                      <?php
                                                    }
                                                  }
                                                 ?>
                                               </select>
                                            </div>
                                       </div>
                                        <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                              <label>Product Title<font style="color:red;margin-left: 5px">*</font></label>
                                               <input type="text" name="ptitle" id="ptitle" class="form-control" placeholder="Enter Product Title" value="<?php if(!empty($products[0]->ptitle)){echo $products[0]->ptitle;}?>">
                                               <span id="pro_error" class="text-danger"></span>
                                            </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                              <label>Product Code<font style="color:red;margin-left: 5px">*</font></label>
                                               <input type="text" name="pcode" id="pcode" class="form-control" placeholder="Enter Product Code" value="<?php if(!empty($products[0]->pcode)){echo $products[0]->pcode;}?>">
                                               <span id="pcode_error" class="text-danger"></span>
                                            </div>
                                       </div>
                                       <div class="clearfix"></div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                          <div class="form-group">
                                            <label>Product Description <font style="color:red;margin-left:5px">*</font></label>
                                            <textarea class="commontexteditor form-control" name="pdesc" id="pdesc" ><?php if(!empty($products[0]->overview)){echo $products[0]->overview;}?></textarea>
                                            <span id="pdesc_error" class="text-danger"></span>
                                          </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                          <div class="form-group">
                                            <label>Product Specification</label>
                                            <textarea class="commontexteditor form-control" name="pspec" id="pspec"><?php if(!empty($products[0]->pspec)){echo $products[0]->pspec;}?></textarea>
                                          </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom: 10px">
                                    <div class="form-group">
                                      <label>Featured Image <font style="color:red;margin-left:5px">*(Imagesize should be 200px * 240px)</font></label>
                                      <input type="file" name="fimage" id="fimage" class="form-control">
                                      <span id="pfeature_error" class="text-danger"></span>
                                    </div>
                                     <?php if(!empty($products[0]->featuredimg)){
                                        ?>
                                        <img src="<?= app_url().$products[0]->featuredimg; ?>" style="width:130px">
                                        <?php
                                      }
                                      ?>
                                  </div>
                                  <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5" style="margin-bottom: 10px">
                                    <div class="form-group">
                                      <label>Product Brochure<span class="text-danger" style="margin-left: 10px">(Imagesize should be 1250px * 800px)</span></label>
                                      <input type="file" name="pbrochure" id="pbrochure" class="form-control">
                                      <span id="pbrochure_error" class="text-danger"></span>
                                    </div>
                                    <?php if(!empty($products[0]->pbrochure)){
                                        ?>
                                        <img src="<?= app_url().$products[0]->pbrochure; ?>" style="width:130px">
                                        <?php
                                      }
                                      ?>
                                  </div>
                                  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 10px">
                                    <div class="form-group">
                                      <label>Modal Number</label>
                                      <input type="text" name="mno" id="mno" class="form-control" placeholder="Eg: ABD123" value="<?php if(!empty($products[0]->modalno)){echo $products[0]->modalno;}?>">
                                      <span id="mno_error" class="text-danger"></span>
                                    </div>
                                  </div>
                                  <div class="clearfix"></div>
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px">
                                         <button type="button" class="btn btn-success" style="float: right;" onclick="return addmoresizes()"><i class="fas fa-plus"></i> Add Sizes</button>
                                       </div>
                                        <div class="clearfix"></div>
                                       <div id="sizeappend" style="width: 100%">
                                       
                                          <?php
                                            if(count($product_size) >0) {
                                                foreach ($product_size as $size) {
                                                    ?>
                                                    <input type="hidden" name="sizeid[]" value="<?= $size->pro_size?>">
                                           <div class="row" id="sizesdata<?php echo icchaEncrypt($size->pro_size);?>">
                                                     <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                             <div class="form-group">
                                               <label>Sizes</label>
                                               <select name="psize[]" id="psize" class="form-control">
                                                 <option value="">Select Size</option>
                                                  <?php 
                                                      if(count($sizes) >0 ) {
                                                        foreach ($sizes as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" <?php if($size->sid == $value->id) {echo "selected";}?>><?= $value->sname;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                                <span id="size_error" class="text-danger"></span>
                                             </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                               <label>Colors </label>
                                               <select name="colors[]" id="colors" class="form-control">
                                                 <option value="">Select Colors</option>
                                                  <?php 
                                                      if(count($sizes) >0 ) {
                                                        foreach ($colors as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" <?php if($size->coid == $value->id) {echo "selected";}?>><?= $value->name;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                             </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                                  <label>Selling Price<font style="color:red;margin-left: 5px">*</font></label>
                                                  <input type="number" name="sell[]" id="sell" class="form-control" placeholder="Enter Selling Price" value="<?php if(!empty($size->selling_price)){echo $size->selling_price;}?>">
                                                  <span id="sell_error" class="text-danger"></span>
                                                </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                                  <label>Stock</label>
                                                  <input type="number" name="stock[]" id="stock" class="form-control" placeholder="Enter Stock" value="<?php if(!empty($size->stock)){echo $size->stock;}?>">
                                                </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                            <div class="form-group">
                                              <label>Color Image <span class="text-danger" style="margin-left: 10px">(Imagesize should be 400px * 400px)</span></label>
                                              <input type="file" name="cfile[]" id="cfile" class="form-control">
                                             <!--  <?php
                                                if(!empty($size->coimg)) {
                                                  ?>
                                                    <img src="<?= app_url().$size->coimg;?>" style="width:70px">
                                                  <?php
                                                }
                                              ?> -->
                                            </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                             <button type="button" class="btn btn-danger" style="margin-top:32px" id="removeSize" data-id="<?php echo icchaEncrypt($size->pro_size);?>"><i class="fas fa-minus"></i></button>
                                           </div>
                                           <div class="clearfix"></div>
                                           </div>
                                                    <?php
                                                }
                                            }else {
                                              ?>
                                              <input type="hidden" name="sizeid[]" value="">
                                           <div class="row" id="sizesdata">
                                                     <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                             <div class="form-group">
                                               <label>Sizes</label>
                                               <select name="psize[]" id="psize" class="form-control">
                                                 <option value="">Select Size</option>
                                                  <?php 
                                                      if(count($sizes) >0 ) {
                                                        foreach ($sizes as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" ><?= $value->sname;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                                <span id="size_error" class="text-danger"></span>
                                             </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                               <label>Colors </label>
                                               <select name="colors[]" id="colors" class="form-control">
                                                 <option value="">Select Colors</option>
                                                  <?php 
                                                      if(count($sizes) >0 ) {
                                                        foreach ($colors as $key => $value) {
                                                          ?>
                                                          <option value="<?= $value->id;?>" ><?= $value->name;?></option>
                                                          <?php
                                                        }
                                                      }
                                                     ?>
                                               </select>
                                             </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                                  <label>Selling Price<font style="color:red;margin-left: 5px">*</font></label>
                                                  <input type="number" name="sell[]" id="sell" class="form-control" placeholder="Enter Selling Price" >
                                                  <span id="sell_error" class="text-danger"></span>
                                                </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                              <div class="form-group">
                                                  <label>Stock</label>
                                                  <input type="number" name="stock[]" id="stock" class="form-control" placeholder="Enter Stock">
                                                </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                            <div class="form-group">
                                              <label>Color Image <span class="text-danger" style="margin-left: 10px">(Imagesize should be 400px * 400px)</span></label>
                                              <input type="file" name="cfile[]" id="cfile" class="form-control">
                                             <!--  <?php
                                                if(!empty($size->coimg)) {
                                                  ?>
                                                    <img src="<?= app_url().$size->coimg;?>" style="width:70px">
                                                  <?php
                                                }
                                              ?> -->
                                            </div>
                                           </div>
                                           <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
                                             <button type="button" class="btn btn-danger" style="margin-top:32px" id="removeSize" ><i class="fas fa-minus"></i></button>
                                           </div>
                                           <div class="clearfix"></div>
                                           </div>
                                                    <?php
                                            }
                                          ?>
                                         
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px">
                                         <button type="button" id="imagesadd" class="btn btn-success" style="float:right;"><i class="fas fa-plus"></i> Add Image </button>
                                       </div>
                                       <div class="clearfix"></div>
                                       <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                         <div class="form-group">
                                           <label>Discount(%)</label>
                                           <input type="number" name="discount" class="form-control" placeholder="Enter Discount" value="<?php if(!empty($products[0]->discount)){echo $products[0]->discount;}?>">
                                         </div>
                                       </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                         <div class="form-group">
                                           <label>Tax(%)</label>
                                           <input type="number" name="tax" class="form-control" placeholder="Enter Tax" value="<?php if(!empty($products[0]->tax)){echo $products[0]->tax;}?>">
                                         </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                           <label>Length</label>
                                           <input type="number" name="length" class="form-control" placeholder="Enter Length" value="<?php if(!empty($products[0]->length)){echo $products[0]->length;}?>">
                                         </div>
                                       </div>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" id="addpimages">
                                          <label>Product image<font style="color:red;margin-left: 5px">* (Imagesize should be 800px * 900px)</font> </label>
                                          <?php
                                            if(count($product_img) >0) {
                                              foreach ($product_img as $images) {
                                                  ?>
                                                   <input type="hidden" name="imgid[]" value="<?= $images->id;?>">
                                                 <div class="form-group" id="images<?= icchaEncrypt($images->id)?>">
                                                  <input type="file" name="pfile[]" class="form-control" style="width: 84.6%;float:left;margin-right: 20px;margin-bottom: 10px;">
                                                  <button type="button" class="btn btn-danger" id="removeImgdata" data-id="<?= icchaEncrypt($images->id)?>" style="margin-top:3px;float:left;"><i class="fas fa-minus"></i> </button>
                                                  <?php 
                                                    if(!empty($images->p_image)) {
                                                      ?>
                                                        <img src="<?= app_url().$images->p_image;?>"  style="width:130px">
                                                      <?php
                                                    }
                                                  ?>
                                                </div>
                                                  <?php
                                              }
                                            }else {
                                              ?>
                                                  <input type="hidden" name="imgid[]" value="">
                                                 <div class="form-group">
                                                  <input type="file" name="pfile[]" class="form-control">
                                                  
                                                
                                                </div>
                                              <?php
                                            }
                                          ?>
                                          
                                       </div>
                                       <div class="clearfix"></div>
                                       <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                         <div class="form-group">
                                           <label>Breadth</label>
                                           <input type="number" name="breadth" class="form-control" placeholder="Enter Breadth" value="<?php if(!empty($products[0]->breadth)){echo $products[0]->breadth;}?>">
                                         </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                         <div class="form-group">
                                           <label>Weight</label>
                                           <input type="number" name="weight" class="form-control" placeholder="Enter Weight" value="<?php if(!empty($products[0]->weight)){echo $products[0]->weight;}?>">
                                         </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                         <div class="form-group">
                                           <label>Height</label>
                                           <input type="number" name="height" class="form-control" placeholder="Enter Height" value="<?php if(!empty($products[0]->height)){echo $products[0]->height;}?>">
                                         </div>
                                       </div>
                                       <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                          <div class="form-group">
                                           <label>Youtube Link</label>
                                           <input type="url" name="ylink" id="ylink" class="form-control" placeholder="Enter Youtube Link" value="https://www.youtube.com/watch?v=<?php if(!empty($products[0]->youtubelink)){echo $products[0]->youtubelink;}?>">
                                           <span id="ylink_error" class="text-danger"></span>
                                         </div>
                                       </div>
                                       <div class="clearfix"></div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                          <div class="form-group">
                                            <label>Meta Title<span style="color:red">(Maximum 60 characters are allowed)</span></label>
                                            <textarea class=" form-control" cols="9" rows="9" name="mtitle" id="mtitle"><?php if(!empty($products[0]->meta_title)){echo $products[0]->meta_title;}?></textarea>
                                          </div>
                                           <span class="text-danger" id="mtitle_error"></span>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                          <div class="form-group">
                                            <label>Meta Description <span style="color:red">(Maximum 160 characters are allowed)</span></label>
                                            <textarea class=" form-control" cols="9" rows="9" name="mdesc" id="mdesc"><?php if(!empty($products[0]->meta_description)){echo $products[0]->meta_description;}?></textarea>
                                          </div>
                                          <span class="text-danger" id="mdesc_error"></span>
                                        </div>
                                        <div class="clearfix"></div>
                                           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 10px">
                                          <div class="form-group">
                                            <label>Meta Keywords</label>
                                            <textarea class=" form-control" cols="9" rows="9" name="mkeywords" id="mkeywords"><?php if(!empty($products[0]->meta_keywords)){echo $products[0]->meta_keywords;}?></textarea>
                                          </div>
                                          <span class="text-danger" id="mkeywords_error"></span>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
                                          <div class="form-group">
                                      <label>Customer Q & A</label>
                                      <textarea class="commontexteditor form-control" name="cqa" id="cqa"><?php if(!empty($products[0]->cqa)){echo $products[0]->cqa;}?></textarea>
                                    </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <center> <button class="btn btn-primary" type="submit" id="prosubmit" style="width:20%!important">Submit</button>
                                              <button type="reset" class="btn btn-danger" style="width:20%!important">Reset</button></center>
                                        </div>
                                      <div class="clearfix"></div>
                                </div>
                             </form>
                                <?php
                              }else {
                                redirect(base_url().'products');
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
  $("#products").on("submit",function(e) {
    e.preventDefault();
      var formdata =new FormData(this);
      $.ajax({
          url :"<?= base_url().'master/productseditdata'; ?>",
          method :"post",
          dataType:"json",
          data :formdata,
          contentType: false,
            cache: false,
            processData:false,
            success:function(data) {
            if(data.formerror ==false) {
              $(".csrf_token").val(data.csrf_token);
              if(data.cat_error !='') {
                $("#cat_error").html(data.cat_error);
              }else {
                $("#cat_error").html('');
              }
              if(data.sub_error !='') {
                $("#sub_error").html(data.sub_error);
              }else {
                $("#sub_error").html('');
              }
              if(data.subsub_error !='') {
                $("#subsub_error").html(data.subsub_error);
              }else {
                $("#subsub_error").html('');
              }
              if(data.pro_error !='') {
                $("#pro_error").html(data.pro_error);
              }else {
                $("#pro_error").html('');
              }
              if(data.pcode_error !='') {
                $("#pcode_error").html(data.pcode_error);
              }else {
                $("#pcode_error").html('');
              }
              if(data.mrp_error !='') {
                $("#mrp_error").html(data.mrp_error);
              }else {
                $("#mrp_error").html('');
              }
               if(data.sell_error !='') {
                $("#sell_error").html(data.sell_error);
              }else {
                $("#sell_error").html('');
              }
              if(data.pimage_error !='') {
                $("#pimage_error").html(data.pimage_error);
              }else {
                $("#pimage_error").html('');
              }
               if(data.size_error !='') {
                $("#size_error").html(data.size_error);
              }else {
                $("#size_error").html('');
              }
               if(data.ylink_error !='') {
                $("#ylink_error").html(data.ylink_error);
              }else {
                $("#ylink_error").html('');
              }
              if(data.pdesc_error !='') {
                $("#pdesc_error").html(data.pdesc_error);
              }else {
                $("#pdesc_error").html('');
              }
              if(data.pimage_error !='') {
                $("#pimage_error").html(data.pimage_error);
              }else {
                $("#pimage_error").html('');
              }
              if(data.pimage_error !='') {
                $("#pimage_error").html(data.pimage_error);
              }else {
                $("#pimage_error").html('');
              }
              if(data.pfeature_error !='') {
                $("#pfeature_error").html(data.pfeature_error);
              }else {
                $("#pfeature_error").html('');
              }
              if(data.mno_error !='') {
                $("#mno_error").html(data.mno_error);
              }else {
                $("#mno_error").html('');
              }
              if(data.mtitle_error !='') {
                $("#mtitle_error").html(data.mtitle_error);
              }else {
                $("#mtitle_error").html('');
              }
              if(data.mdesc_error !='') {
                $("#mdesc_error").html(data.mdesc_error);
              }else {
                $("#mdesc_error").html('');
              }
              if(data.mkeywords_error !='') {
                $("#mkeywords_error").html(data.mkeywords_error);
              }else {
                $("#mkeywords_error").html('');
              }
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==false) {
              $("#processing").html('<div class="alert alert-danger alert-dismissible" style="font-size:18px!important"><i class="fas fa-ban"></i> '+data.msg+'</div>').show();
              $("#prosubmit").prop('disabled',false);
            }
            else if(data.status ==true) {
               $(".csrf_token").val(data.csrf_token);
               $("#cat_error").html('');
               $("#sub_error").html('');
               $("#subsub_error").html('');
               $("#sell_error").html('');
               $("#pro_error").html('');
               $("#pimage_error").html('');
               $("#pimage_error").html('');
                $("#mtitle_error").html('');
               $("#mdesc_error").html('');
               $("#mkeywords_error").html('');
               $("#pfeature_error").html('');
               $("#mno_error").html('');
               $("#processing").html('<div class="alert alert-success alert-dismissible" style="font-size:18px!important"><i class="fas fa-circle-check"></i> '+data.msg+'</div>');
               $("#saved").show();
               $("#prosubmit").prop('disabled',true);
               $("#products")[0].reset();
               setTimeout(function() {window.location.href="<?= base_url().'products';?>"}, 1500);
            }
          }
      });
  });
  $("#category").on("change",function(e) {
      e.preventDefault();
      var catid = $(this).val();
      $.ajax({
          url :"<?= base_url().'master/getSubcategoryview'; ?>",
          method :"post",
          dataType :"json",
          data : {
            catid :catid,
            "<?= $this->security->get_csrf_token_name();?>":$(".csrf_token").val()
          },
          success:function(data) {
            if(data.status ==true) {
              $(".csrf_token").val(data.csrf_token);
              $("#subcategory").append(data.msg);
            }else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
            }
          }
      });
  });
  $("#subcategory").on("change",function(e) {
      e.preventDefault();
      var catid = $(this).val();
      $.ajax({
          url :"<?= base_url().'master/getSubsubcategoryview'; ?>",
          method :"post",
          dataType :"json",
          data : {
            subid :catid,
            "<?= $this->security->get_csrf_token_name();?>":$(".csrf_token").val()
          },
          success:function(data) {
            if(data.status ==true) {
              $(".csrf_token").val(data.csrf_token);
              $("#subsubcategory").append(data.msg);
            }else if(data.status ==false) {
              $(".csrf_token").val(data.csrf_token);
            }
          }
      });
  });
});
var i=0;
function addmoresizes() {
  var j = Math.floor((Math.random() * 10000) + 1);
  var data = '<div class="row" id="table'+j+'"><input type="hidden" name="sizeid[]" value=""><div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><div class="form-group"><label>Sizes</label><select name="psize[]" id="psize" class="form-control">'+ $('#psize').html() +'</select></div></div><div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><div class="form-group"><label>Colors</label><select name="colors[]" id="colors" class="form-control">'+ $('#colors').html() +'</select></div></div><div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><div class="form-group"><label>Selling Price</label><input type="number" name="sell[]" id="sell" class="form-control" placeholder="Enter Selling Price"><span id="sell_error" class="text-danger"></span></div></div><div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><div class="form-group"><label>Stock</label><input type="number" name="stock[]" id="stock" class="form-control" placeholder="Enter Stock"></div></div><div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><div class="form-group"><label>Color Image</label><input type="file" name="cfile[]" id="cfile" class="form-control"></div></div><div class="col-xs-12 col-sm-1 col-md-1 col-lg-1"><button type="button" onclick="remove123('+j+')" class="btn btn-danger" style="margin-top:32px" title="Remove Size"><i class="fas fa-minus"></i></button></div><div class="clearfix"></div></div>';
    $('#sizeappend').append(data); 
}
$(document).on('click',"#imagesadd",function() {
   i++;
    var data = '<div class="form-group" id="rimg'+i+'"><input type="hidden" name="imgid[]" value=""><input type="file" name="pfile[]" class="form-control" style="width: 84.6%;float:left;margin-right: 20px;margin-bottom: 10px;"><button type="button" class="btn btn-danger" style="margin-top:3px;float:left;" onclick="removeImage('+i+')"><i class="fas fa-minus"></i> </button></div>';
    $('#addpimages').append(data);
});
$(document).on("click","#removeSize",function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  if(confirm('Are u sure you want to delete')) {
    $.ajax({
        url :"<?= base_url().'master/deleteSizes'; ?>",
        method :"post",
        data : {
          id :id,
          "<?= $this->security->get_csrf_token_name();?>":$(".csrf_token").val()
        },
        dataType :"json",
        success:function(data) {
          if(data.status ==true) {
            $("#sizesdata"+id).fadeOut(500, function () { $("#sizesdata"+id).remove(); });
          }
        }
    });
  }
});
$(document).on("click","#removeImgdata",function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  if(confirm('Are u sure you want to delete')) {
    $.ajax({
        url :"<?= base_url().'master/deleteImages'; ?>",
        method :"post",
        data : {
          id :id,
          "<?= $this->security->get_csrf_token_name();?>":$(".csrf_token").val()
        },
        dataType :"json",
        success:function(data) {
          if(data.status ==true) {
            $("#images"+id).fadeOut(500, function () { $("#sizesdata"+id).remove(); });
          }
        }
    });
  }
});
function remove123(trid)
{
  $("#table"+trid).fadeOut(500, function () { $("#table"+trid).remove(); });
}
function removeImage(trid)
{
  $("#rimg"+trid).fadeOut(500, function () { $("#rimg"+trid).remove(); });
}
</script>