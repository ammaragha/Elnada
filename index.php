<?php
    include "include/int.php";
?>


<?php 
    $bldy   = cGet(1);
    $red    = cGet(2);
    $white  = cGet(3);
    $now = now("date");

?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <h1 style="margin:20px 0" class="text-center font-weight-bold">( <?php echo $now; ?> ) الندي للدواجن </h1>
              </br>
                <div class="text-center"> 
                    <div class="col-md-12 row" style="background-color: #dbc89d;margin-bottom: 20px;">
                        <div class="col-md-4 col-xs-12" > <i style="font-size: 110px;color: #c68282;" class="fa fa-twitter" aria-hidden="true"></i> بلدي </div>
                        <div class="col-md-4 col-xs-6" > <span style="font-size:110px"><?php echo round($bldy['kiloPrice'],2);  ?> </span>LE </div>
                        <div class="col-md-4 col-xs-6" style="font-size:110px"> <?php echo $bldy['cNumber'];  ?>  </div>
                    </div>

                    <div class="col-md-12 row" style="background-color: #dbc89d;margin-bottom: 20px;">
                        <div class="col-md-4 col-xs-12" > <i style="font-size: 110px;color: #ea3a3a;" class="fa fa-twitter" aria-hidden="true"></i> احمر </div>
                        <div class="col-md-4 col-xs-6" > <span style="font-size:110px"><?php echo round($red['kiloPrice'],2);  ?></span>LE </div>
                        <div class="col-md-4 col-xs-6" style="font-size:110px">  <?php echo $red['cNumber'];  ?>  </div>
                    </div>

                    <div class="col-md-12 row" style="background-color: #dbc89d;margin-bottom: 20px;">
                        <div class="col-md-4 col-xs-12" > <i style="font-size: 110px;color: #f7f7f7;" class="fa fa-twitter" aria-hidden="true"></i> ابيض </div>
                        <div class="col-md-4 col-xs-6" > <span style="font-size:110px"><?php echo round($white['kiloPrice'],2);  ?></span>LE </div>
                        <div class="col-md-4 col-xs-6" style="font-size:110px">  <?php echo $white['cNumber'];  ?>  </div>
                    </div>
                </div>

            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    
    <?php
        include "include/layout/footer.php";
    ?>