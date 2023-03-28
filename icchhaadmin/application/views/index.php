<?= $header;?>
<style type="text/css">
	#toporders {
		padding: 20px;
		border-radius: 5px;
		box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-webkit-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-moz-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-ms-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		-o-box-shadow: 0 0 var(--spacing--xs) var(--color-ui--grey-90);
		background: #fff;
	}
	.topor {
		background: #f56954!important
	}
	.products {
		background: #00a65a!important
	}
	.reviews {
		background: #00c0ef!important
	}
	.reguser {
		background: #0073b7!important
	}
	#toporders h1 {
		font-weight: bold;
		font-size: 35px;
		color:#fff;
	}
	#toporders h3 {
		font-size: 20px;
		color:#fff;
	}
</style>
<div class="page has-sidebar-left bg-light height-full">
<div class="container-fluid">
        <div class="row my-3">
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="topor">
        			<h1>10</h1>
        			<h3>Total Orders</h3>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="products">
        			<h1>8</h1>
        			<h3>Top Products</h3>
        		</div>
        	</div>
        	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="reviews">
        			<h1>5</h1>
        			<h3>Reviews</h3>
        		</div>
        	</div>
        		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="margin-bottom: 20px">
        		<div id="toporders" class="reguser">
        			<h1>12</h1>
        			<h3>Registered Users</h3>
        		</div>
        	</div>
        	<div class="clearfix"></div>
        	<br />
            <!-- bar chart -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card ">
                    <div class="card-header white">
                            <strong> Total Sales</strong>
                        </div>
                    <div class="card-body p-0">
                        <div id="graph_bar" style="width:100%; height:280px;"></div>
                    </div>
                </div>
            </div>
            <!-- /bar charts -->

            <!-- bar charts group -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card">

                    <div class="card-header white">
                            <h6> Total Sales(Monthwise)</h6>
                        </div>
                    <div class="card-body p-0">
                        <div id="graph_bar_group" style="width:100%; height:280px;"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- /bar charts group -->
        </div>
        <div class="row my-3">
            <!-- bar charts group -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card ">
                    <div class="card-header white">
                        <h6>Total Order Cancellation</h6>
                    </div>
                    <div class="card-body p-0">
                        <div id="graphx" style="width:100%; height:300px;" ></div>
                    </div>
                </div>
            </div>
            <!-- /bar charts group -->

            <!-- pie chart -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header white">
                        <h6>Total Reviews</small></h6>
                    </div>
                    <div class="card-body p-0">
                        <div id="graph_area" style="width:100%; height:300px;"></div>
                    </div>
                </div>
            </div>
            <!-- /Pie chart -->
        </div>
        
    </div>
</div>
<?= $footer;?>
