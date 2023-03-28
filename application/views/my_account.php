<?php
    //echo "<pre>";print_r($wishlist);exit;
?>
<?= $header;?>
<style type="text/css">
    .btn {
        padding: 10px!important
    }
    .table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.order-list {
    border: 1px solid #efe9cf;
    margin-bottom: 30px;
    border-radius: 5px;
    background-color: #fff;
    float: left;
    width: 100%;
}
.top-order, .bottom-order {
    padding: 12px 25px 12px 25px;
    background: #e358e1;
    float: left;
    width: 100%;
    color: #fff;
}
.pull-left {
    float: left!important;
}
.pull-right {
    float: right!important;
}

.shop-tracking-status {
    float: left;
    width: 96%;
    padding: 35px;
}

.shop-tracking-status .order-status {
    margin-top: 21px;
    position: relative;
    margin-bottom: 36px;
}
.shop-tracking-status .order-status-timeline {
    height: 5px;
    border-radius: 7px;
    background: #e5e5e5;
}

.shop-tracking-status .image-order-status {
    border: 1px solid #ddd;
    padding: 7px;
    background-color: #fdfdfd;
    position: absolute;
    margin-top: -32px;
}
.shop-tracking-status .image-order-status-new {
    left: 0;
}
.shop-tracking-status .image-order-status {
    border-radius: 150px;
    border: 1px solid #ddd;
    padding: 7px;
    background-color: #fdfdfd;
    position: absolute;
    margin-top: -32px;
}

.shop-tracking-status .image-order-status-active {
    left: 29%;
}

.shop-tracking-status .image-order-status-intransit {
    left: 63%;
}

.shop-tracking-status .image-order-status-delivered {
    left: 97%;
}

.bottom-order {
    background: #fff;
    border-top: 1px dashed #ccc;
    padding: 20px 20px 12px 20px;
    color: #2b2b2b;
}

.shop-tracking-status .image-order-status .icon {
    height: 40px;
    width: 40px;
    background-size: contain;
    background-position: no-repeat;
}

.service-details img {
    border-radius: 0px;
    max-width: 100%;
}


.shop-tracking-status .image-order-status .status {
    position: absolute;
    color: #777;
    width: 94px;
    bottom: -26px;
    left: -38%;
    text-align: center;
    font-size: 12px;
    font-weight: 600;
}

.service-sidebar {
    margin-bottom: 50px;
}

.myaccount .service-sidebar__links {
    margin-bottom: 30px;
    background-color: #36648b;
    border-radius: 5px;
}

.service-sidebar__links ul {
    margin: 0;
    padding: 0;
    list-style: none;
    padding-left: 20px;
    padding-right: 20px;
}

.service-sidebar__links ul li {
    display: block;
}

.myaccount .service-sidebar__links ul li a {
    color: #fff;
    padding-left: 15px;
    padding-right: 15px;
}

.myaccount .service-sidebar__links ul li a i {
    margin-right: 10px;
}


.service-sidebar__links ul li a {
    display: block;
    font-size: 16px;
    color: #69af07;
    line-height: 50px;
    font-weight: 500;
    -webkit-transition: all .5s ease;
    transition: all .5s ease;
    padding-left: 20px;
    padding-right: 20px;
    border-radius: 5px;
}

.myaccount .service-sidebar__links ul li a.active, .myaccount .service-sidebar__links ul li a.active:hover, .myaccount .service-sidebar__links ul li a:hover {
    color: #36648b;
    background-color: #fff
}

.myaccount .service-sidebar__links ul li a:hover {
    background-color: rgba(255, 255, 255, .3);
    color: #fff
}

.btn-info {
    color: #fff;
    background-color: #36648b!important;
    border-color: #36648b!important;
}

@media (min-width: 992px)
.service-sidebar__links ul li a {
    line-height: 55px;
    font-size: 18px;
    padding-left: 40px;
    padding-right: 40px;
}
}
.active {
    background: #fff!important;
    color:#000!important;
}
.shop-tracking-status .order-status-timeline .order-status-timeline-completion.c2 {
    width: 33%;
}
.shop-tracking-status .order-status-timeline .order-status-timeline-completion.c3 {
    width: 66%;
}
.shop-tracking-status .order-status-timeline .order-status-timeline-completion.c4 {
    width: 99%;
}
.shop-tracking-status .order-status-timeline .order-status-timeline-completion {
    height: 5px;
    margin: 1px;
    border-radius: 7px;
    background: #e358e1;
    width: 0;
}

</style>
<div id="processing"></div>
 <main class="main">
            <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">My Account</h1>
                </div>
            </div>
            <!-- End of Page Header -->

            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li>My account</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content pt-2">
                <div class="container">
                    <div class="tab tab-vertical row gutter-lg">
                        <ul class="nav nav-tabs mb-6" role="tablist" style="background: #e358e1;color: #fff;height: 200px;margin-top: 30px">

                            <li class="nav-item" style="color:#fff;margin-top: 10px">
                                <a href="#account-orders" class="nav-link <?php if(!isset($_GET['rel'])) {echo 'active';}?>" style="color:#fff">Orders</a>
                            </li>
                            <li class="nav-item" style="color:#fff">
                                <a href="#account-details" class="nav-link <?php if(!isset($_GET['rel'])) {echo '';}?>" style="color:#fff">Account details</a>
                            </li>
                            <li class="nav-item" style="color:#fff">
                                <a href="#wishlist" class="nav-link <?php if(!isset($_GET['rel'])) {echo '';}else {echo 'active';}?>" style="color:#fff">Wishlist</a>
                            </li>
                            <li class="nav-item" style="color:#fff">
                                <a href="<?= base_url().'Login/logout';?>" style="color:#fff;font-weight: 600!important;font-size: 1.4rem!important;margin-left:21px!important;text-transform: uppercase;padding:1.5rem 0rem!important">Logout</a>
                            </li>
                        </ul>

                        <div class="tab-content mb-6">


                            <div class="tab-pane mb-4 <?php if(!isset($_GET['rel'])) {echo 'active in';}?>" id="account-orders">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title text-capitalize ls-normal mb-0">Orders</h4>
                                    </div>
                                </div>
                               
                                                    
                                <?php
                                    if(count($orders) >0) {
                                        
                                            
                                                foreach ($orders as $order) {
                                                    ?>
                                                     <div class="service-details myaccount">
                                     <div class="order-list">


    <div class="order-list">
        <div class="top-order">
            <div class="pull-left"><b>Order Id :</b> <?= $order->orderid;?> </div>
            <div class="pull-right">Ordered Date : <?= date('M d, Y',strtotime($order->order_date));?> </div>
        </div>
        
        <div class="shop-tracking-status">
            <div class="order-status">

                <div class="order-status-timeline">
                      <?php
                    if($order->status ==1) {
                            ?>

                            <?php
                        }
                        if($order->status ==2) {
                            ?>
                                <div class="order-status-timeline-completion c2"></div>
                            <?php
                        }

                         if($order->status ==3) {
                            ?>
                                <div class="order-status-timeline-completion c3"></div>
                            <?php
                        }

                        if($order->status ==4) {
                            ?>
                             
                                <div class="order-status-timeline-completion c4"></div>
                            <?php
                        }
                        ?>
                            
                    
                </div>

                <div class="image-order-status image-order-status-new  img-circle">
                    <div class="icon fir"><img src="<?= base_url();?>assets/images/Placed.svg"></div>
                                                <span class="status" style="color:#56ac56">Placed</span>
                                                
                </div>

                <div class="image-order-status image-order-status-active    img-circle">
                    <div class="icon secv"><img src="<?= base_url();?>assets/images/Processing.svg"></div>
                                                    <span class="status">Processing</span>
                                
                </div>

                <div class="image-order-status image-order-status-intransit  img-circle">
                    <div class="icon thiv"><img src="<?= base_url();?>assets/images/shipped.svg"></div>
                                                    <span class="status">Shipped</span>
                                                    <span class="status"></span>
                </div>

                <div class="image-order-status image-order-status-delivered  img-circle">
                    <div class="icon forv"><img src="<?= base_url();?>assets/images/tick.svg"></div>
                                                    <span class="status">Delivered</span>
                                                </div>
            </div>
        </div>


        <div class="bottom-order">
            <div class="pull-left"><i class="fas fa-rupee-sign"></i> <?= number_format($order->totalamount,2);?>           </div>
            <div class="pull-right"><a href="<?= base_url().'order-view/'.icchaEncrypt($order->oid);?>"  class="btn btn-info btn-sm" align="center" style="background: #e358e1!important;border-color:#e358e1!important"><i class="fas fa-eye"></i> View Order Details</a>     <?php
                                                                        if($order->status ==4) {
                                                                        
                                                                        }else {
                                                                            ?>
                                                                            <button class="btn btn-danger cancel<?= icchaEncrypt($order->oid);?>" title="Cancel Order" id="cancelOrder" data-pid="<?= icchaEncrypt($order->oid);?>" style="background: #dc3545!important;color:#fff!important;border-color:#dc3545!important"><i class="fas fa-ban"></i></button>
                                                                            <?php
                                                                        }
                                                                    ?></div>
        </div>

    </div>

</div>
                                 </div> 
                                                      


                                                    <?php
                                                }
                                           
                                        ?>
                                      
                                       
                                    
                                            <?php
                                    }  else {
                                        echo "No orders found";
                                    } 
                                ?>
                                

                                <a href="shop-banner-sidebar.html" class="btn btn-dark btn-rounded btn-icon-right">Go
                                    Shop<i class="w-icon-long-arrow-right"></i></a>
                            </div>

                            <div class="tab-pane <?php if(!isset($_GET['rel'])) {echo '';}?>" id="account-details">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-account mr-2">
                                        <i class="w-icon-user"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title mb-0 ls-normal">Account Details</h4>
                                    </div>
                                </div>
                                <form class="form account-details-form" id="saveProfile" method="post">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>" value="<?= $this->security->get_csrf_hash();?>" class="csrf_token">
                                    <input type="hidden" name="uid" value="<?= $users[0]->u_id;?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstname">Name *</label>
                                                <input type="text" id="name" name="name" placeholder="John"
                                                    class="form-control form-control-md" value="<?= $users[0]->name;?>">
                                                    <span id="name_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastname">Email *</label>
                                                <input type="email" id="email" name="email" placeholder="john@gmail.com"
                                                    class="form-control form-control-md" value="<?= $users[0]->email;?>">
                                                    <span id="email_error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="display-name">Mobile Number *</label>
                                        <input type="number" id="phone" name="phone" placeholder="9999999999"
                                            class="form-control form-control-md mb-0" min="0" value="<?= $users[0]->phone;?>">
                                       <span id="phone_error" class="text-danger"></span>
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save
                                        Changes</button>
                                </form>
                            </div>

                            <div class="tab-pane <?php if(@$_GET['rel'] == 'wishlist') {echo 'active in';}else {echo '';}?>" id="wishlist">
                                <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-account mr-2">
                                        <i class="w-icon-heart"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title mb-0 ls-normal">Wishlist</h4>
                                    </div>
                                </div>
                                <?php
                                    if(count($wishlist) >0) {
                                        ?>
                                             <table class="shop-table wishlist-table">
                                    <thead>
                                        <tr>
                                            <th class="product-name"><span>Product</span></th>
                                            <th></th>
                                            <th class="product-price"><span>Price</span></th>
                                            <th class="product-stock-status"><span>Stock Status</span></th>
                                            <th class="wishlist-action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            
                                                foreach ($wishlist as $wish) {
                                                    ?>
                                                    <tr id="removeTable<?= icchaEncrypt($wish->wid);?>">
                                                        <td class="product-thumbnail">
                                                            <div class="p-relative">
                                                                <a href="<?= base_url().'products/'.$wish->ppage_url;?>">
                                                                    <figure>
                                                                        <img src="<?= base_url().$wish->image;?>" alt="product"
                                                                            width="300" height="338">
                                                                    </figure>
                                                                </a>
                                                                <button type="submit" id="removeWishlist" class="btn btn-close" data-pids="<?= icchaEncrypt($wish->wid);?>"><i class="fas fa-times" style="position: relative;
    top: -5px;
    right: 4px;"></i></button>
                                                            </div>
                                                        </td>
                                                        <td class="product-name">
                                                            <a href="<?= base_url().'products/'.$wish->ppage_url;?>">
                                                                <?= ucfirst($wish->title);?>
                                                            </a>
                                                        </td>
                                                        <td class="product-price">
                                                            <ins class="new-price"><i class="fas fa-rupee-sign"></i> <?= number_format($wish->price,2);?></ins>
                                                        </td>
                                                        <td class="product-stock-status">
                                                            <?php
                                                                if(!empty($wish->stock) && $wish->stock !=0) {
                                                                    ?>
                                                                    <span class="wishlist-in-stock">In Stock</span>
                                                                    <?php
                                                                }else {
                                                                    ?>
                                                                    <span class="wishlist-in-stock" style="color:red!important">Out of Stock</span>
                                                                    <?php
                                                                }
                                                            ?>
                                                            
                                                        </td>
                                                        <td class="wishlist-action">
                                                            <div class="d-lg-flex">

                                                                <button type="button"
                                                                    class="btn btn-dark btn-rounded btn-sm ml-lg-2 btn-cartbtn" data-pid="<?= encode($wish->pid);?>" id="cartBack<?= encode($wish->pid);?>">Add to
                                                                    cart</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                          
                                        ?>
                                       
                                    </tbody>
                                </table>
                                        <?php
                                    }else {
                                        echo "No wishlist found";
                                    }
                                    ?>
                               

                            </div>

                        </div>




                        
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
<?= $footer;?>
<?= $js;?>