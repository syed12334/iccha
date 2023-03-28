<?php
    //echo "<pre>";print_r($categoryimg);exit;
?>
<?= $header;?>
<!-- Start of Main-->
<input type="hidden" class="csrf_token" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>">
        <main class="main">
            <section class="intro-section">

                <div class="swiper-container swiper-theme nav-inner pg-inner swiper-nav-lg animation-slider pg-xxl-hide nav-xxl-show nav-hide"
                    data-swiper-options="{
                    'slidesPerView': 1,
                    'autoplay': {
                        'delay': 8000,
                        'disableOnInteraction': false
                    }
                }">
                    <div class="swiper-wrapper">
                         <?php
                    if(count($slider)) {
                        foreach ($slider as $slide) {
                            ?>
                                <div class="swiper-slide banner banner-fixed intro-slide intro-slide1"
                            style="background-image: url(<?= base_url().$slide->image;?>); background-color: #ebeef2;">
                            <div class="container">
                                <div class="banner-content y-50 text-right">
                                    <h5 class="banner-subtitle font-weight-normal text-default ls-50 lh-1 mb-2 slide-animate"
                                        data-animation-options="{
                                    'name': 'fadeInRightShorter',
                                    'duration': '1s',
                                    'delay': '.2s'
                                }" style="font-weight: bold!important">
                                       <?= $slide->title;?>
                                    </h5>
                                    
                                    <p class="font-weight-normal text-default slide-animate" data-animation-options="{
                                    'name': 'fadeInRightShorter',
                                    'duration': '1s',
                                    'delay': '.6s'
                                }">
                                        <?= $slide->tagline;?>
                                    </p>

                                    <a href="<?php if(!empty($slide->link)) { echo $slide->link;}else {echo '#';}?>"
                                        class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                        data-animation-options="{
                                    'name': 'fadeInRightShorter',
                                    'duration': '1s',
                                    'delay': '.8s'
                                }">SHOP NOW<i class="w-icon-long-arrow-right"></i></a>

                                </div>
                                <!-- End of .banner-content -->
                            </div>
                            <!-- End of .container -->
                        </div>
                            <?php
                        }
                    }
                ?>
                        
                        <!-- End of .intro-slide1 -->

                    </div>
                    <div class="swiper-pagination"></div>
                    <button class="swiper-button-next"></button>
                    <button class="swiper-button-prev"></button>
                </div>
                <!-- End of .swiper-container -->
            </section>
            <!-- End of .intro-section -->

            <div class="container">
                <div class="swiper-container appear-animate icon-box-wrapper br-sm mt-6 mb-6" data-swiper-options="{
                    'slidesPerView': 1,
                    'loop': false,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 2
                        },
                        '768': {
                            'slidesPerView': 3
                        },
                        '1200': {
                            'slidesPerView': 4
                        }
                    }
                }">
                    <div class="swiper-wrapper row cols-md-4 cols-sm-3 cols-1">
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-shipping">
                                <i class="w-icon-truck"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Free Shipping </h4>
                                <p class="text-default">For all orders over $99</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-payment">
                                <i class="w-icon-return"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Free Returns</h4>
                                <p class="text-default">Returns are free within 2 days</p>
                            </div>
                        </div>

                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-payment">
                                <i class="w-icon-money"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">100% Payment Secure</h4>
                                <p class="text-default">Your payment are safe with us.</p>
                            </div>
                        </div>

                        <div class="swiper-slide icon-box icon-box-side icon-box-primary">
                            <span class="icon-box-icon icon-payment">
                                <i class="w-icon-hotline"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title font-weight-bold mb-1">Support 24/7</h4>
                                <p class="text-default">Contact us 24 hours a day</p>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End of Iocn Box Wrapper -->


                <div class="row category-banner-wrapper appear-animate pt-6 pb-8">
                    <?php 
                        if(count($ads1) >0) {
                            foreach ($ads1 as $ads) {
                                ?>
                                    <div class="col-md-6 mb-4">
                        <div class="banner banner-fixed br-xs">
                            <figure>
                                <a href="<?php if(!empty($ads->link)) {echo  $ads->link;}else {echo '#';}?>">
                                <img src="<?= base_url().$ads->ad_banner;?>" alt="Category Banner"
                                    width="610" height="160" style="background-color: #ecedec;" />
                                </a>
                            </figure>
                          
                        </div>
                    </div>
                                <?php
                            }
                        }
                    ?>
                    
                   
                </div>
                <!-- End of Category Banner Wrapper -->
            </div>

            <section class="category-section top-category bg-grey pt-10 pb-10 appear-animate">
                <div class="container pb-2">
                    <h2 class="title justify-content-center pt-1 ls-normal mb-5">Top Categories Of The Month</h2>
                    <div class="swiper">
                        <div class="swiper-container swiper-theme pg-show" data-swiper-options="{
                            'spaceBetween': 20,
                            'slidesPerView': 2,
                            'breakpoints': {
                                '576': {
                                    'slidesPerView': 3
                                },
                                '768': {
                                    'slidesPerView': 5
                                },
                                '992': {
                                    'slidesPerView': 6
                                }
                            }
                        }">
                            <div class="swiper-wrapper row cols-lg-6 cols-md-5 cols-sm-3 cols-2">
                                <?php 
                                    if(count($categoryimg) >0) {
                                        foreach ($categoryimg as $catimg) {
                                            ?>
                                             <div
                                    class="swiper-slide category category-classic category-absolute overlay-zoom br-xs">
                                    <a href="<?= base_url().$catimg->page_url;?>" class="category-media">
                                        <img src="<?= base_url().$catimg->image;?>" alt="Category"
                                            width="130" height="130">
                                    </a>
                                    <div class="category-content">
                                        <h4 class="category-name"><?= ucfirst($catimg->title);?></h4>
                                        <a href="<?= base_url().$catimg->page_url;?>" class="btn btn-primary btn-link btn-underline">Shop
                                            Now</a>
                                    </div>
                                </div>
                                            <?php
                                        }
                                    }
                                ?>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End of .category-section top-category -->

            <div class="container">
                <h2 class="title justify-content-center ls-normal mb-4 mt-10 pt-1 appear-animate">Popular Departments
                </h2>
                <div class="tab tab-nav-boxed tab-nav-outline appear-animate">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <li class="nav-item mr-2 mb-2">
                            <a class="nav-link active br-sm font-size-md ls-normal" href="#tab1-1">New arrivals</a>
                        </li>
                        <li class="nav-item mr-2 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-2">Best seller</a>
                        </li>
                       <!--  <li class="nav-item mr-2 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-3">most popular</a>
                        </li> -->
                        <li class="nav-item mr-0 mb-2">
                            <a class="nav-link br-sm font-size-md ls-normal" href="#tab1-4">Featured</a>
                        </li>
                    </ul>
                </div>
                <!-- End of Tab -->
                <div class="tab-content product-wrapper appear-animate">
                    <div class="tab-pane active pt-4" id="tab1-1">
                            <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                        <?php
                            if(count($newarrivals) >0) {
                                foreach ($newarrivals as $arrive) {
                                    ?>
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="<?= base_url().'products/'.$arrive->page_url;?>">
                                            <img src="<?= base_url().$arrive->image;?>" alt="Product"
                                                width="300" height="338" />
                                            <img src="<?= base_url().$arrive->image;?>" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <!-- <a href="#" data-pid="<?= encode($arrive->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                title="Add to cart" data-id="1" id="cartBack<?= encode($arrive->pid);?>"></a> -->
                                            <a href="<?= base_url().'products/'.$arrive->page_url;?>" class="btn-product-icon btn-wishlist w-icon-heart"
                                                title="Add to wishlist" id="wishlist" data-pid="<?= encode($arrive->pid);?>"></a>
                                        </div>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="#"><?php echo ucfirst($arrive->title);?></a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 60%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#" class="rating-reviews">(1 Reviews)</a>
                                        </div>
                                        <div class="product-price">
                                            <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?php echo  number_format($arrive->price);?></ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                                    <?php
                                }
                            }
                        ?>
                         </div>
                    </div>
                    <!-- End of Tab Pane -->
                    <div class="tab-pane pt-4" id="tab1-2">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                            <?php
                            if(count($best) >0) {
                                foreach ($best as $bes) {
                                    ?>
                                
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="<?= base_url().'products/'.$bes->page_url;?>">
                                            <img src="<?= base_url().$bes->image;?>" alt="Product"
                                                width="300" height="338" />
                                            <img src="<?= base_url().$bes->image;?>" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                            <!-- <a href="#" data-pid="<?= encode($bes->pid);?>" class="btn-product-icon btn-cart w-icon-cart" data-id="1"
                                                title="Add to cart"></a> -->
                                            <a href="<?= base_url().'products/'.$bes->page_url;?>" class="btn-product-icon btn-wishlist w-icon-heart"
                                                title="Add to wishlist" id="wishlist" data-pid="<?= encode($bes->pid);?>"></a>


                                        </div>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="#"><?php echo ucfirst($bes->title);?></a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 60%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#" class="rating-reviews">(1 Reviews)</a>
                                        </div>
                                        <div class="product-price">
                                            <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?php echo  number_format($bes->price);?></ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                                    <?php
                                }
                            }
                        ?>
                        </div>
                    </div>
                   
                    <!-- End of Tab Pane -->
                    <div class="tab-pane pt-4" id="tab1-4">
                        <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                            <?php
                            if(count($feature) >0) {
                                foreach ($feature as $feat) {
                                    ?>
                                
                            <div class="product-wrap">
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="<?= base_url().'products/'.$feat->page_url;?>">
                                            <img src="<?= base_url().$feat->image;?>" alt="Product"
                                                width="300" height="338" />
                                            <img src="<?= base_url().$feat->image;?>" alt="Product"
                                                width="300" height="338" />
                                        </a>
                                        <div class="product-action-vertical">
                                           <!--  <a href="#" data-id="1" data-pid="<?= encode($feat->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                title="Add to cart" id="cartBack<?= encode($feat->pid);?>"></a> -->
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                title="Add to wishlist" id="wishlist" data-pid="<?= encode($feat->pid);?>"></a>


                                        </div>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name"><a href="<?= base_url().'products/'.$feat->page_url;?>"><?php echo ucfirst($feat->title);?></a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 60%;"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="#" class="rating-reviews">(1 Reviews)</a>
                                        </div>
                                        <div class="product-price">
                                            <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?php echo  number_format($feat->price);?></ins>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       
                                    <?php
                                }
                            }
                        ?>
                        </div>
                    </div>
                    <!-- End of Tab Pane -->
                </div>
                <!-- End of Tab Content -->

                <div class="row category-cosmetic-lifestyle appear-animate mb-5">
                      <?php 
                        if(count($ads2) >0) {
                            foreach ($ads2 as $ads1) {
                                ?>
                             
                      <div class="col-md-6 mb-4">
                        <div class="banner banner-fixed category-banner-1 br-xs">
                            <figure>
                                <a href="<?php if(!empty($ads1->link)) {echo  $ads1->link;}else {echo '#';}?>">
                                <img src="<?= base_url().$ads1->ad_banner;?>" alt="Category Banner"
                                    width="610" height="200" style="background-color: #3B4B48;" />
                                </a>
                            </figure>
                         
                        </div>
                    </div>
                                <?php
                            }
                        }
                    ?>
                  
                </div>
                <!-- End of Category Cosmetic Lifestyle -->
                     <?php

                if(count($category) >0) {
                  foreach ($category as $cat) {
                    $id = $cat->cat_id;
                    $getProducts = $this->home_db->getCategorywiseproducts($id,'desc','4');
                    $getProducts1 = $this->home_db->getCategorywiseproducts($id,'asc','4');
                   //echo $this->db->last_query();
                    ?>
                    <div class="product-wrapper-1 appear-animate mb-5">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0"><?= ucfirst($cat->cname);?></h2>
                        <a href="shop-boxed-banner.html" class="font-size-normal font-weight-bold ls-25 mb-0">More
                            Products<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                    <div class="row">
                       <?php
                            if(!empty($cat->ads_image)) {
                                ?>
                                <div class="col-lg-3 col-sm-4 mb-4">
                            <div class="banner h-100 br-sm" style="background-image: url(<?= base_url().$cat->ads_image;?>); 
                                background-color: #ebeced;">
                            </div>
                        </div>
                        <!-- End of Banner -->
                        <div class="col-lg-9 col-sm-8">

                            <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">

                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
                                       <?php
                                if(count($getProducts) >0) {
                                    foreach ($getProducts as $products) {
                                        ?>
                                         <div class="swiper-slide product-col">
                                        <div class="product-wrap product text-center">
                                            <figure class="product-media">
                                                <a href="<?= base_url().'products/'.$products->page_url;?>">
                                                    <img src="<?= base_url().$products->image;?>" alt="Product"
                                                        width="216" height="243" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <!-- <a href="#" data-id="1" data-pid="<?= encode($products->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                        title="Add to cart"></a> -->
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist" id="wishlist" data-pid="<?= encode($products->pid);?>"></a>
                                                   
                                                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                        title="Add to Compare"></a>
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?= base_url().'products/'.$products->page_url;?>"><?= ucfirst($products->title);?></a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">(3
                                                        reviews)</a>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?= number_format($products->price)?></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                }
                             ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                             <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">

                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
                                       <?php
                                if(count($getProducts1) >0) {
                                    foreach ($getProducts1 as $products) {
                                        ?>
                                         <div class="swiper-slide product-col">
                                        <div class="product-wrap product text-center">
                                            <figure class="product-media">
                                                <a href="<?= base_url().'products/'.$products->page_url;?>">
                                                    <img src="<?= base_url().$products->image;?>" alt="Product"
                                                        width="216" height="243" />
                                                </a>
                                                <div class="product-action-vertical">
                                                   <!--  <a href="#" data-id="1" data-pid="<?= encode($products->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                        title="Add to cart"></a> -->
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist" id="wishlist" data-pid="<?= encode($products->pid);?>"></a>
                                                   
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?= base_url().'products/'.$products->page_url;?>"><?= ucfirst($products->title);?></a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">(3
                                                        reviews)</a>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?= number_format($products->price)?></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                }
                             ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                                <?php
                            }else {
                                 ?>
                                
                        <!-- End of Banner -->
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">

                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
                                       <?php
                                if(count($getProducts) >0) {
                                    foreach ($getProducts as $products) {
                                        ?>
                                         <div class="swiper-slide product-col">
                                        <div class="product-wrap product text-center">
                                            <figure class="product-media">
                                                <a href="<?= base_url().'products/'.$products->page_url;?>">
                                                    <img src="<?= base_url().$products->image;?>" alt="Product"
                                                        width="216" height="243" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <!-- <a href="#" data-id="1" data-pid="<?= encode($products->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                        title="Add to cart"></a> -->
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist" id="wishlist" data-pid="<?= encode($products->pid);?>"></a>
                                                  
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?= base_url().'products/'.$products->page_url;?>"><?= ucfirst($products->title);?></a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">(3
                                                        reviews)</a>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?= number_format($products->price)?></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                }
                             ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                             <div class="swiper-container swiper-theme" data-swiper-options="{
                                'spaceBetween': 20,
                                'slidesPerView': 2,
                                'breakpoints': {
                                    '992': {
                                        'slidesPerView': 3
                                    },
                                    '1200': {
                                        'slidesPerView': 4
                                    }
                                }
                            }">

                                <div class="swiper-wrapper row cols-xl-4 cols-lg-3 cols-2">
                                       <?php
                                if(count($getProducts1) >0) {
                                    foreach ($getProducts1 as $products) {
                                        ?>
                                         <div class="swiper-slide product-col">
                                        <div class="product-wrap product text-center">
                                            <figure class="product-media">
                                                <a href="<?= base_url().'products/'.$products->page_url;?>">
                                                    <img src="<?= base_url().$products->image;?>" alt="Product"
                                                        width="216" height="243" />
                                                </a>
                                                <div class="product-action-vertical">
                                                    <!-- <a href="#" data-id="1" data-pid="<?= encode($products->pid);?>" class="btn-product-icon btn-cart w-icon-cart"
                                                        title="Add to cart"></a> -->
                                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                        title="Add to wishlist" id="wishlist" data-pid="<?= encode($products->pid);?>"></a>
                                                    
                                                </div>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name"><a href="<?= base_url().'products/'.$products->page_url;?>"><?= ucfirst($products->title);?></a>
                                                </h4>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">(3
                                                        reviews)</a>
                                                </div>
                                                <div class="product-price">
                                                    <ins class="new-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i> <?= number_format($products->price)?></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                }
                             ?>

                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                                <?php
                            }
                       ?>
                        
                    </div>
                </div>
                    <?php
                  }
                }
                ?>
               
                <!-- End of Product Wrapper 1 -->
                <?php
                    if(count($ads3) >0) {
                        foreach ($ads3 as $ads) {
                           ?>
                           <div class="banner banner-fashion appear-animate br-sm mb-9" style="background-image: url(<?= base_url().$ads->ad_banner;?>);
                    background-color: #383839;">
                    <div class="banner-content align-items-center">
                        <div class="content-left d-flex align-items-center mb-3">
                            <div class="banner-price-info font-weight-bolder text-secondary text-uppercase lh-1 ls-25">
                                25
                                <sup class="font-weight-bold">%</sup><sub class="font-weight-bold ls-25">Off</sub>
                            </div>
                            <hr class="banner-divider bg-white mt-0 mb-0 mr-8">
                        </div>
                        <div class="content-right d-flex align-items-center flex-1 flex-wrap">
                            <div class="banner-info mb-0 mr-auto pr-4 mb-3">
                                <h3 class="banner-title text-white font-weight-bolder text-uppercase ls-25">For Today's
                                    Fashion</h3>
                                <p class="text-white mb-0">Use code
                                    <span
                                        class="text-dark bg-white font-weight-bold ls-50 pl-1 pr-1 d-inline-block">Black
                                        <strong>12345</strong></span> to get best offer.
                                </p>
                            </div>
                            <a href="#" class="btn btn-white btn-outline btn-rounded btn-icon-right mb-3">Shop Now<i
                                    class="w-icon-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                           <?php
                        }
                    }
                ?>
                
                <!-- End of Banner Fashion -->


                <h2 class="title title-underline mb-4 ls-normal appear-animate">Our Top Brands</h2>
                <?php
                    $brand = $this->master_db->getRecords('brand',['status'=>0],'brand_img','id desc','','','6');
                        $brand1 =$this->master_db->getRecords('brand',['status'=>0],'brand_img','id asc','','','6');
                ?>
                <div class="swiper-container swiper-theme brands-wrapper mb-9 appear-animate" data-swiper-options="{
                    'spaceBetween': 0,
                    'slidesPerView': 2,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 3
                        },
                        '768': {
                            'slidesPerView': 4
                        },
                        '992': {
                            'slidesPerView': 5
                        },
                        '1200': {
                            'slidesPerView': 6
                        }
                    }
                }" style="margin-bottom: 0px!important;border-top:1px solid #eee!important">
                    <div class="swiper-wrapper row gutter-no cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                        <?php
                        
                                if(count($brand) >0) {
                                    foreach ($brand as $bra) {
                                        #?>
                                         <div class="swiper-slide brand-col">
                            <figure class="brand-wrapper">
                                <img src="<?= base_url().$bra->brand_img;?>" alt="Brand" style="width:80%!important;padding: 20px" />
                            </figure>
                          </div>
                                        <?php
                                    }
                                }
                        ?>
                    </div>
                </div>
                <div class="swiper-container swiper-theme brands-wrapper mb-9 appear-animate" data-swiper-options="{
                    'spaceBetween': 0,
                    'slidesPerView': 2,
                    'breakpoints': {
                        '576': {
                            'slidesPerView': 3
                        },
                        '768': {
                            'slidesPerView': 4
                        },
                        '992': {
                            'slidesPerView': 5
                        },
                        '1200': {
                            'slidesPerView': 6
                        }
                    }
                }">
                    <div class="swiper-wrapper row gutter-no cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                        <?php
                        
                                if(count($brand1) >0) {
                                    foreach ($brand1 as $bra) {
                                        #?>
                                         <div class="swiper-slide brand-col">
                            <figure class="brand-wrapper">
                                <img src="<?= base_url().$bra->brand_img;?>" alt="Brand" style="width:80%!important;padding: 20px" />
                            </figure>
                          </div>
                                        <?php
                                    }
                                }
                        ?>
                    </div>
                </div>
                <!-- End of Brands Wrapper -->


                <!-- End of Reviewed Producs -->
            </div>
            <!--End of Catainer -->
        </main>
        <!-- End of Main -->
<?= $footer;?>
<?= $js;?>