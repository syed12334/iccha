<?php
$rate = $this->home_db->getratings($products[0]->pid);
?>
<?= $header1;?>
<style type="text/css">
    <style>
        .btm-br{
            border-bottom: 1px solid #ccc;
            margin-right: 25px;
        }
         .availability {
            margin-top: 20px;
        }
        .availability input {
    display: inline-block;
    vertical-align: middle;
    margin-left: 0px;
    padding: 8px;
}
.fix-bottom {
    display: none!important
}


p {
    margin-bottom: 0px!important;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
#pincodeStatus {
    display: none
}
#checkpincode {
    margin-bottom: 10px;
}
    </style>

 <main class="main mb-10 pb-1">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav container">
                <ul class="breadcrumb bb-no">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="product-default.html">Products</a></li>
                    <li>Vertical Thumbs</li>
                </ul>
               
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <div class="product product-single row">
                        <div class="col-md-6 mb-6">
                            <div class="product-gallery product-gallery-sticky product-gallery-vertical">
                                <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                    'navigation': {
                                        'nextEl': '.swiper-button-next',
                                        'prevEl': '.swiper-button-prev'
                                    }
                                }">
                                    <div class="swiper-wrapper row cols-1 gutter-no">
                                       <?php 
                                            if(count($getImages) >0) {
                                                foreach ($getImages as $img) {
                                                    ?>
                                                    <div class="swiper-slide">
                                                        <figure class="product-image">
                                                            <img src="<?= base_url().$img->p_image;?>"
                                                                data-zoom-image="<?= base_url().$img->p_image;?>"
                                                                alt="Bright Green IPhone" width="800" height="900">
                                                        </figure>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <button class="swiper-button-next"></button>
                                    <button class="swiper-button-prev"></button>
                                    <a href="#" class="product-gallery-btn product-image-full"><i class="w-icon-zoom"></i></a>
                                </div>
                                <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                    'navigation': {
                                        'nextEl': '.swiper-button-next',
                                        'prevEl': '.swiper-button-prev'
                                    },
                                    'breakpoints': {
                                        '992': {
                                            'direction': 'vertical',
                                            'slidesPerView': 'auto'
                                        }
                                    }
                                }">
                                    <div class="product-thumbs swiper-wrapper row cols-lg-1 cols-4 gutter-sm">
                                        <?php 
                                            if(count($getImages) >0) {
                                                foreach ($getImages as $img) {
                                                    ?>
                                                    <div class="product-thumb swiper-slide">
                                                        <img src="<?= base_url().$img->p_image;?>" alt="Product Thumb" width="800" height="900">
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                    <button class="swiper-button-prev"></button>
                                    <button class="swiper-button-next"></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 mb-md-6">
                            <div class="product-details">
                                <h1 class="product-title"><?= ucfirst($products[0]->title);?></h1>
                                <div class="product-bm-wrapper">
                                         
                                    <?php
                                        if(!empty($products[0]->brand_id)) {
                                            $getBrand = $this->master_db->getRecords('brand',['brand'=>$products[0]->brand_id],'brand_img');
                                            ?>
                                           <figure class="brand">
                                                <img src="<?= base_url().$getBrand[0]->brand_img;?>" alt="Brand" width="105"
                                                height="48" />
                                            </figure>
                                            <?php
                                        }
                                    ?>
                                </div>

                                <hr class="product-divider">

                                <div class="product-price"><ins class="new-price"><i class="fas fa-rupee-sign"></i> <?= number_format($products[0]->price);?></ins></div>

                                <div class="ratings-container">
                                  
                                    <a href="#" class="rating-reviews">(<?= count($reviews);?> Reviews)</a>
                                </div>

                                <div class="product-short-desc lh-2">
                                 <!--   <ul class="list-type-check list-style-none">
                                        <li>Ultrices eros in cursus turpis massa cursus mattis.</li>
                                        <li>Volutpat ac tincidunt vitae semper quis lectus.</li>
                                        <li>Aliquam id diam maecenas ultricies mi eget mauris.</li>
                                    </ul> -->

                                   <?php
                                        if(!empty($products[0]->pspec)) {
                                            ?>
                                             <h4 class="mb-0 mt-3"> Specifications</h4>
                                             <?= $products[0]->pspec;?>
                                            <?php
                                        }
                                   ?>
                                    


                                </div>

                                <hr class="product-divider">

                                <div class="product-form product-variation-form product-color-swatch">
                                    <label>Color:</label>
                                    <div class="d-flex align-items-center product-variations">
                                         <?php 
                                            if(count($getSize) >0) {
                                                foreach ($getSize as $color) {
                                                    ?>
                                                    <a href="#" class="color <?php if($products[0]->coid == $color->cid) {echo 'active';}?>" data-coid="<?= $color->cid;?>" style="background-color: <?= $color->ccode;?>"></a>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                                 <div id="size_error" style="clear: both"></div><br />
                                <div class="product-form product-variation-form product-size-swatch">
                                    <label class="mb-1">Size:</label>
                                        <div class="flex-wrap d-flex align-items-center product-variations">

                                           <?php 
                                                if(count($getSize) >0) {
                                                    foreach ($getSize as $size) {
                                                        ?>
                                                        <a href="#" class="size <?php if($products[0]->sid ==$size->sid) {echo 'active';}?>" data-sid="<?= $size->sid;?>"><?= $size->sname;?></a>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                    </div>
                                 </div>
                                
                              
                                <div class="fix-bottom product-sticky-content sticky-content" style="margin-top: 20px">
                                    <div class="product-form container">
                                        <input type="hidden" name="colors" id="colors" value="<?= $products[0]->coid;?>">
                                        <input type="hidden" name="sizes" id="sizes" value="<?= $products[0]->sid;?>">
                                        <button class="btn btn-primary btn-cartbtn" data-pid="<?= encode($products[0]->pid);?>" id="cartBack<?= encode($products[0]->pid);?>" style="width:40%">
                                            <i class="w-icon-cart"></i>
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                </div>
                                
                                
                                <div class="availability p-0">
                                    <div id="checkpin" class="pincode_form">
                                            <label style="font-size: 17px;margin-bottom: 6px">Pincode Check</label>
                                            <br />
                                            <input type="number" maxlength="6" minlength="6" placeholder="Enter Pincode" class="checkpincode form-control" name="cpincode" id="cpincode" maxlength="6" minlength="6" pattern="/^-?\d+\.?\d*$/" onkeypress="if(this.value.length==6) return false;" style="width:50%">
                                          <br />
                                         <span id="pincode_error" class="text-danger" style="color:red"></span>
                                         <span id="showMsg"></span>
                                    </div>
                                    
                                </div>
                                <br />
                                  <button class="btn btn-primary btn-cartbtn" data-pid="<?= encode($products[0]->pid);?>" id="cartBack<?= encode($products[0]->pid);?>" style="width:50%">
                                            <i class="w-icon-cart"></i>
                                            <span>Add to Cart</span>
                                        </button>

                                <div class="social-links-wrapper">
                                    <div class="social-links">
                                        <div class="social-icons social-no-color border-thin">
                                            <a href="#" class="social-icon social-facebook w-icon-facebook"></a>
                                            <a href="#" class="social-icon social-twitter w-icon-twitter"></a>
                                            <a href="#" class="social-icon social-pinterest fab fa-pinterest-p"></a>
                                            <a href="#" class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                            <a href="#" class="social-icon social-youtube fab fa-linkedin-in"></a>
                                        </div>
                                    </div>
                                    <span class="divider d-xs-show"></span>
                                    <div class="product-link-wrapper d-flex">
                                        <a href="#" class="btn-product-icon btn-wishlist w-icon-heart" id="wishlist" data-pid="<?= encode($products[0]->pid);?>"><span></span></a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab tab-nav-boxed tab-nav-underline product-tabs mt-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#product-tab-description" class="nav-link active">Description</a>
                            </li>
                            <li class="nav-item">
                                <a href="#product-tab-reviews" class="nav-link">Customer Reviews (<?= count($reviews);?>)</a>
                            </li>
                             <?php
                                        if(!empty($products[0]->pbrochure)) {
                                            ?>
                            <li class="nav-item">
                                <a href="#pbrochure" class="nav-link">Product Brochure</a>
                            </li>
                            <?php
                        }
                        ?>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="product-tab-description">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-5">
                                       <?php 
                                        if(!empty($products[0]->pdesc)) {
                                            echo $products[0]->pdesc;
                                        }
                                       ?>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <div class="banner banner-video product-video br-xs">
                                            <?php
                                            if(!empty($products[0]->youtubelink)) {
                                                ?>
                                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?= $products[0]->youtubelink; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                <?php
                                            }
                                           ?>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="tab-pane" id="product-tab-reviews">
                                <div class="row mb-4">
                                    <div class="col-xl-4 col-lg-5 mb-4">
                                        <div class="ratings-wrapper">
                                            <div class="avg-rating-container">
                                                <h4 class="avg-mark font-weight-bolder ls-50"><?= ceil($rate);?></h4>
                                                <div class="avg-rating">
                                                    <p class="text-dark mb-1">Average Rating</p>
                                                    <div class="ratings-container">
                                                        <a href="#" class="rating-reviews">(<?= count($reviews);?> Reviews)</a>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-lg-7 mb-4">
                                        <div class="review-form-wrapper">
                                            <div id="processing"></div>
                                            <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your Review
                                            </h3>
                                           
                                            <form id="review" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                                <input type="hidden" name="pid" value="<?= encode($products[0]->pid);?>">
                                                <div class="rating-form">
                                                    <label for="rating">Your Rating Of This Product :</label>
                                                    <span class="rating-stars">
                                                        <a class="star-1" rel="1" href="#">1</a>
                                                        <a class="star-2" rel="2" href="#">2</a>
                                                        <a class="star-3" rel="3" href="#">3</a>
                                                        <a class="star-4" rel="4" href="#">4</a>
                                                        <a class="star-5" rel="5" href="#">5</a>
                                                    </span>
                                                   <input type="hidden" name="ratings" id="ratings">
                                                </div>
                                                <textarea cols="30" rows="6" placeholder="Write Your Review Here..."
                                                    class="form-control" name="reviews" id="reviews"></textarea>
                                                    <span id="rating_error" class="text-danger" style="color:red"></span>
                                              <br />
                                                <button type="submit" class="btn btn-dark">Submit Review</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                               
                            </div>

                             <div class="tab-pane " id="pbrochure">
                                <div class="row mb-4">
                                    <div class="col-md-12 col-xs-12 col-lg-12 mb-5">
                                      <?php
                                        if(!empty($products[0]->pbrochure)) {
                                            ?>
                                            <img src="<?= base_url().$products[0]->pbrochure;?>" class="form-control" style="width:100%">
                                            <?php
                                        }
                                      ?>
                                    </div>
                                   
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <section class="related-product-section">
                        <div class="title-link-wrapper mb-4">
                            <h4 class="title">Related Products</h4>
                         
                        </div>
                        <div class="swiper-container swiper-theme" data-swiper-options="{
                            'spaceBetween': 20,
                            'slidesPerView': 2,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 3
                                },
                                '768': {
                                    'slidesPerView': 4
                                },
                                '992': {
                                    'slidesPerView': 4
                                }
                            }
                        }">
                            <div class="swiper-wrapper row cols-lg-3 cols-md-3 cols-sm-3 cols-2">
                                <?php
                                    if(count($related) >0) {
                                        foreach ($related as $value) {
                                              ?>
                                         <div class="swiper-slide product">
                                            <figure class="product-media">
                                                <a href="<?= base_url().'products/'.$value->page_url;?>">
                                                    <img src="<?= base_url().$value->image;?>" alt="Product"
                                                        width="300" height="338" />
                                                </a>
                                                <div class="product-action-vertical">
                                                
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist" id="wishlist" data-pid="<?= encode($value->pid);?>"></a>
                                                    
                                                </div>
                                                
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="product-default.html"><?= ucfirst($value->title);?></a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 100%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="product-default.html" class="rating-reviews">(3 reviews)</a>
                                                </div>
                                                <div class="product-pa-wrapper">
                                                    <div class="product-price"><i class="fas fa-rupee-sign"></i> <?= number_format($value->price);?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                ?>
                             
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->
        <?php echo $footer; ?>
        <?php echo $js; ?>
            