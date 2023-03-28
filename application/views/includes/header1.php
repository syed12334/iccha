<?php //echo "<pre>";print_r($this->cart->contents());exit; ?>
<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from portotheme.com/html/wolmart/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 May 2022 08:11:04 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>ICCHHA Lifestyles</title>

    <meta name="keywords" content="Marketplace ecommerce responsive HTML5 Template" />
    <meta name="description"
        content="ICCHHA Lifestylesis powerful marketplace &amp; ecommerce responsive Html5 Template.">
    <meta name="author" content="D-THEMES">

    <!-- Favicon -->


    <!-- WebFont.js -->
    <script>
        WebFontConfig = {
            google: { families: ['Poppins:400,500,600,700'] }
        };
        (function (d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = 'assets/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>
<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="preload" href="<?= base_url();?>assets/vendor/fontawesome-free/webfonts/fa-regular-400.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
    <link rel="preload" href="<?= base_url();?>assets/vendor/fontawesome-free/webfonts/fa-solid-900.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
    <link rel="preload" href="<?= base_url();?>assets/vendor/fontawesome-free/webfonts/fa-brands-400.woff2" as="font" type="font/woff2"
        crossorigin="anonymous">
    <link rel="preload" href="<?= base_url();?>assets/fonts/wolmart87d5.woff?png09e" as="font" type="font/woff" crossorigin="anonymous">

    <!-- Vendor CSS -->
    

    <!-- Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/vendor/magnific-popup/magnific-popup.min.css">

    <!-- Default CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/style.min.css">
    <style type="text/css">
        .wcolors {
            color:#e358e1 !important;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Start of Header -->
        <header class="header header-border">
            <div class="header-top">
                <div class="container">

                    <div class="header-right">
                        <a href="<?= base_url(); ?>" class="d-lg-show">Contact Us</a>
                        <a href="<?= base_url().'my-account'; ?>" class="d-lg-show">My Account</a>
                         <?php
                            if($this->session->userdata(CUSTOMER_SESSION)) {
                                ?>
                                <a href="<?= base_url().'login';?>" class="d-lg-show  "><i class="w-icon-account"></i><?= ucfirst(substr($this->session->userdata(CUSTOMER_SESSION)['name'],0,4));?></a>
                                <?php
                            }else {
                                ?>
                                    <a href="<?= base_url().'login';?>" class="d-lg-show  "><i class="w-icon-account"></i>Sign In</a>
                        <span class="delimiter d-lg-show">/</span>
                        <a href="<?= base_url().'register?reg=register';?>" class="ml-0 d-lg-show  ">Register</a>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End of Header Top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left mr-md-4">
                        <a href="#" class="mobile-menu-toggle  w-icon-hamburger" aria-label="menu-toggle">
                        </a>
                        <a href="<?= base_url();?>" class="logo ml-lg-0">
                            <img src="<?= base_url();?>assets/images/logo.png" alt="logo" width="144" height="45" />
                        </a>
                        <form method="get" action="#"
                            class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                            <div class="select-box">
                               <select id="category" name="category">
                                    <option value="14">All Categories</option>
                                    <?php
                                        if(count($category) >0) {
                                            foreach ($category as $cat) {
                                                ?>
                                                    <option value="<?= $cat->cat_id; ?>"><?= $cat->cname;?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <input type="text" class="form-control" name="search" id="search" placeholder="Search in..."
                                required />
                            <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="header-right ml-4">
                        <div class="header-call d-xs-show d-lg-flex align-items-center">
                            <a href="tel:#" class="w-icon-call"></a>
                            <div class="call-info d-lg-show">
                                <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                                    <a href="tel:#" class="text-capitalize">Got Question? Call us</a>
                                </h4>
                                <a href="tel:#" class="phone-number font-weight-bolder ls-50">1-800-570-7777</a>
                            </div>
                        </div>

                        <a class="wishlist label-down link d-xs-show" href="<?= base_url().'my-account?rel=wishlist';?>" style="position: relative;">
                            <i class="w-icon-heart"></i>
                            <span class="wishlist-label d-lg-show">Wishlist</span>
                            <span class="cart-wishlist"><?php if($this->session->userdata(CUSTOMER_SESSION)) {echo count($wishcount);}else {echo '0';}?></span>
                        </a>

                           <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                            <div class="cart-overlay"></div>
                            <a href="#" class="cart-toggle label-down link">
                                <i class="w-icon-cart">
                                    <span class="cart-count"><?= count($this->cart->contents());?></span>
                                </i>
                                <span class="cart-label">Cart</span>
                            </a>
                            <div class="dropdown-box" id="appendProducts">
                                <div class="cart-header">
                                    <span>Shopping Cart</span>
                                    <a href="#" class="btn-close">Close<i class="w-icon-long-arrow-right"></i></a>
                                </div>

                                <div class="products" style="border-bottom: 0px!important">
                                    <?php
                                    $subtotal = [];
                                    if(count($this->cart->contents()) >0) {
                                        foreach ($this->cart->contents() as $cart) {
                                            $subtotal[] = $cart['subtotal'];
                                            ?>
                                            <div class="product product-cart">
                                               <div class="product-detail">
                                                 <a href="product-default.html" class="product-name"><?= ucfirst($cart['name']); ?></a>
                                                 <div class="price-box">
                                                    <span class="product-quantity"><?= $cart['qty'];?></span>
                                                    <span class="product-price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i><?= $cart['price'];?></span>
                                                 </div>
                                               </div>
                                               <figure class="product-media">
                                                 <a href="product-default.html">
                                                    <img src="<?= $cart['image'];?>" alt="product" />
                                                 </a>
                                                </figure>
                                                <button class="btn btn-link btn-close" aria-label="button" onClick="removeCart('<?= $cart['rowid'];?>',1)"><i class="fas fa-times"></i></button>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                         </div>
                                        <div class="cart-total" style="position: absolute;bottom: 130px">
                                           <label>Subtotal:</label>
                                           <span class="price"><i class="fas fa-rupee-sign" style="margin-right: 5px"></i><?= number_format($this->cart->total());?></span>
                                        </div>
                                        <div class="cart-action" style="position: absolute;bottom: 100px; width: 90%"> 
                                          <a href="<?= base_url().'cart';?>" class="btn btn-dark btn-outline btn-rounded">View Cart</a>
                                          <a href="<?php if($this->session->userdata(CUSTOMER_SESSION)) {echo base_url().'checkout';}else {echo base_url().'login';}?>" class="btn btn-dark  btn-rounded">Checkout</a>
                                        </div>
                                        <?php
                                    }else {
                                        ?>
                                         <br /><br /><br /><center><img src='<?= base_url()."assets/images/cart.png" ?>' style='width:230px' /><p style='font-size:16px;text-align:center;margin-top:10px;font-weight:bold'>Your Cart is empty</p></center>
                                        <?php
                                         
                                    }
                                ?>
                               
                            </div>
                            <!-- End of Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Header Middle -->

            <div class="header-bottom sticky-content fix-top sticky-header has-dropdown">
                <div class="container">
                    <div class="inner-wrap">
                        <div class="header-left">
                            <div class="dropdown category-dropdown has-border" data-visible="true">
                                <a href="#" class="category-toggle text-dark" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="true" data-display="static"
                                    title="Browse Categories">
                                    <i class="w-icon-category"></i>
                                    <span>Browse Categories</span>
                                </a>

                                <div class="dropdown-box">
                                    <ul class="menu vertical-menu category-menu">
                                            <?php
                                                if(count($category) >0) {
                                                    foreach ($category as $cat) {
                                                        $catid = $cat->cat_id;
                                                        $getSubcategory = $this->master_db->getRecords('subcategory',['status'=>0,'cat_id'=>$catid],'sname,id as subid,page_url','sname asc');
                                                        ?>
                                            <li>
                                                <a href="<?= base_url().$cat->page_url;?>">
                                                    <i class="<?= $cat->icons; ?>"></i><?= ucfirst($cat->cname);?>
                                                </a>
                                                <ul class="megamenu">
                                            <?php
                                                if(count($getSubcategory) >0) {
                                                    ?>
                                                     
                                                    <?php
                                                    foreach ($getSubcategory as $subcat) {
                                                        $subid = $subcat->subid;
                                                        $getsubSubcategory = $this->master_db->getRecords('subsubcategory',['status'=>0,'sub_id'=>$subid],'ssname,id as ssubid,page_url','ssname asc');
                                                        ?>
                                                <li>
                                                    <a href="<?= base_url().'home/products/'.$subcat->page_url;?>"><h4 class="menu-title"><?= ucfirst($subcat->sname);?></h4></a>
                                                    <hr class="divider">
                                                    <?php
                                                        if(count($getsubSubcategory) >0) {
                                                            ?>
                                                            <ul>
                                                            <?php
                                                            foreach($getsubSubcategory as $scat) {
                                                                ?>
                                                                    <li><a href="<?= base_url().'home/products/'.$scat->page_url;?>"><?= ucfirst($scat->ssname)?></a>
                                                                    </li>
                                                                <?php
                                                            }
                                                            ?>
                                                            </ul>
                                                            <?php
                                                        }
                                                    ?>
                                                </li>
                                                        <?php
                                                    }
                                                    ?>
                                                     
                                                    <?php
                                                }
                                            ?>
                                            <li>
                                                    <div class="menu-banner banner-fixed menu-banner3">
                                                        <figure>
                                                            <img src="<?= base_url().$cat->ads_image;?>" alt="Menu Banner"
                                                                width="235" height="461" />
                                                        </figure>
                                                    </div>
                                                </li>
                                            </ul>
                                         </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        <li>
                                            <a href="#" class="font-weight-bold text-primary text-uppercase ls-25">
                                                View All Categories<i class="w-icon-angle-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <nav class="main-nav">
                                <ul class="menu active-underline">
                                    <li class="active">
                                        <a href="#">Home</a>
                                    </li>
                                    <li class="">
                                        <a href="#">About ICCHHA Lifestyles</a>
                                    </li>
                                    <li class="">
                                        <a href="#">Special Offers</a>
                                    </li>
                                    <li class="">
                                        <a href="#">Careers</a>
                                    </li>
                                    <li class="">
                                        <a href="#">Contact Us</a>
                                    </li>

                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </header>