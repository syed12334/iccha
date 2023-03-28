<?php
	//echo "<pre>";print_r($products);exit;
?>
<?= $header1;?>
<style type="text/css">
    label {
        cursor:pointer!important;
    }
</style>

    <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="index.html">Home</a></li>
                        <li>Shop</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">



                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg mb-10">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                            <!-- Start of Sidebar Content -->
                            <div class="sidebar-content scrollable">
                                <!-- Start of Sticky Sidebar -->
                                <div class="sticky-sidebar">
                                    <div class="filter-actions">
                                        <label>Filter :</label>
                                        <a href="#" class="btn btn-dark btn-link filter-clean">Clean All</a>
                                    </div>


                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Price</label></h3>
                                        <div class="widget-body">
                                            <ul class="filter-items search-ul">
                                                <li><a href="#">$0.00 - $100.00</a></li>
                                                <li><a href="#">$100.00 - $200.00</a></li>
                                                <li><a href="#">$200.00 - $300.00</a></li>
                                                <li><a href="#">$300.00 - $500.00</a></li>
                                                <li><a href="#">$500.00+</a></li>
                                            </ul>
                                            <form class="price-range">
                                                <input type="number" name="min_price" class="min_price text-center"
                                                    placeholder="$min"><span class="delimiter">-</span><input
                                                    type="number" name="max_price" class="max_price text-center"
                                                    placeholder="$max"><a href="#"
                                                    class="btn btn-primary btn-rounded">Go</a>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Size</label></h3>
                                       
                                            <?php
                                               if(count($filters) >0) {
                                                ?>
                                                 <ul class="widget-body filter-items item-check mt-1">
                                                <?php
                                                foreach ($filters as $size) {
                                                    if(!empty($size->sname) && $size->sname != NULL) {
                                                         ?>
                                                     <li style="margin-bottom: 7px"><input type="checkbox" name="size[]" id="size<?= $size->sid;?>" class="checkedbox sizeid" value="<?= $size->sid;?>"  style="margin-right:7px"/><label for="size<?= $size->sid;?>"><?= ucfirst($size->sname);?></label></li>
                                                    <?php 
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        <?php
                                               } 
                                            ?>
                                         
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Brand</label></h3>
                                       <?php
                                               if(count($filters) >0) {
                                                ?>
                                                 <ul class="widget-body filter-items item-check mt-1">
                                                <?php
                                                foreach ($filters as $brand) {
                                                    if(!empty($brand->bname) && $brand->bname != NULL) {
                                                         ?>
                                                     <li style="margin-bottom: 7px"><input type="checkbox" class="checkedbox brand" name="brand[]" id="brand<?= $brand->bid;?>" value="<?= $brand->bid;?>" style="margin-right:7px"/><label for="brand<?= $brand->bid;?>"><?= ucfirst($size->bname);?></label></li>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        <?php
                                               } 
                                            ?>
                                    </div>
                                    <!-- End of Collapsible Widget -->

                                    <!-- Start of Collapsible Widget -->
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title"><label>Color</label></h3>
                                        <?php
                                               if(count($filters) >0) {
                                                ?>
                                                 <ul class="widget-body filter-items item-check mt-1">
                                                <?php
                                                foreach ($filters as $color) {
                                                    if(!empty($color->coname) && $color->coname != NULL) {
                                                         ?>
                                                     <li style="margin-bottom: 7px"><input type="checkbox" name="color[]" id="color<?= $color->cid;?>" class="checkedbox colors" value="<?= $color->cid;?>" style="margin-right:7px"/><label for="color<?= $color->cid;?>"><?= ucfirst($color->coname);?></label></li>
                                                    <?php 
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        <?php
                                               } 
                                            ?>
                                    </div>
                                    <!-- End of Collapsible Widget -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </div>
                            <!-- End of Sidebar Content -->
                        </aside>
                        <!-- End of Shop Sidebar -->

                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                           
                            <div class="product-wrapper row cols-md-4 cols-sm-2 cols-2" id="products">
                              
                              
                            </div>

                            <div class="toolbox toolbox-pagination justify-content-end">
                             <span id="newpage"></span>
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
<?= $footer;?>
<?= $js;?>

<script type="text/javascript">
     function filter_data(page)
    {
    
         var size = get_filter('sizeid');
        var colors = get_filter('colors');
        var brand = get_filter('brand');
        // var carpark = get_filter('carpark');
        // var furnished = get_filter('furnished');
        // var floors = get_filter('floors');
        var id = "<?= $this->uri->segment(3);?>";       
       $.ajax({
            url:"<?= base_url();?>home/productsFilters/"+page,
            method:"POST",
             dataType :"json",
            data:{id:id,size:size,brand:brand,colors:colors},
            success:function(data){
                $("#products").html(data.products);
                $("#newpage").html(data.links);
            }
        });
    }
filter_data(1);
$(document).ready(function() {
     $(document).on("click", ".pagination li a", function(event){
          event.preventDefault();
          var page = $(this).data("ci-pagination-page");
          filter_data(page);
         });
});

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }
  $('.checkedbox').click(function(){
       filter_data(1);    
   });
</script>
