<?php
    include "include/int.php";
?>


<?php 
    $bldy   = cGet(1);
    $red    = cGet(2);
    $white  = cGet(3);

?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <h1 style="margin:20px 0" class="text-center font-weight-bold">المفروض انت جاي تسجل مشتريات لزبون</h1>
              </br>

              <?php
              if(  $_SERVER['REQUEST_METHOD'] == 'POST'  ){
                $totalPrice = $_POST['totalPrice'];
                //bldy
                $cNumber1   = check($_POST['cNumber1']) ;
                $wieght1    = check($_POST['wieght1']) ;
                //red
                $cNumber2   = check($_POST['cNumber2']);
                $wieght2    = check($_POST['wieght2']);
                //white
                $cNumber3   = check($_POST['cNumber3']);
                $wieght3    = check($_POST['wieght3']);

                $errForm = Array();

                if(empty($totalPrice) || !is_numeric($totalPrice)) { $errForm[] = "السعر الكلي غلط ياعم";}
                if(bdan($cNumber1,$wieght1)) {$errForm[] = "تقريبا نسيت وزن او عدد البلدي";}
                if(bdan($cNumber2,$wieght2)) {$errForm[] = "تقريبا نسيت وزن او عدد الاحمر";}
                if(bdan($cNumber3,$wieght3)) {$errForm[] = "تقريبا نسيت وزن او عدد الابيض";}

                //check boxID
                

                if(!empty($errForm)){
                    foreach($errForm as $err){
                        alert("err",$err);
                    }
                }else{
                    try {
                        //insert buyer information
                        $stmt = $conn->prepare("INSERT INTO buyer(totalPrice,date) VALUES(?,?)" );
                        $now = new DateTime();
                        $now = $now->format('Y-m-d H:i:s');
                        $stmt->execute(Array($totalPrice,$now));
                        if($stmt->rowCount() > 0){
                            //insert buying information
                            $id = $conn->prepare("SELECT id FROM buyer WHERE date = ?");
                            $id->execute(Array($now));
                            $id =  $id->fetch()[0];//get buyer id again :()
                            
                            $stmt = $conn->prepare("INSERT INTO buy(bID,boxID,number,wieght) values(?,?,?,?)");
                            //---------------------------------------------------------------
                            $boxID = get("id","box","type",1,true)[0];
                            
                            if($boxID > 0){
                                $stmt->execute(Array($id,$boxID,$cNumber1,$wieght1));
                                decNumBox($boxID,$cNumber1);
                            }
                            //-----------------
                            $boxID = get("id","box","type",2,true)[0];
                            if($boxID > 0){
                                $stmt->execute(Array($id,$boxID,$cNumber2,$wieght2));
                                decNumBox($boxID,$cNumber2);
                            }
                            //-----------------
                            $boxID = get("id","box","type",3,true)[0];
                            if($boxID > 0){
                                $stmt->execute(Array($id,$boxID,$cNumber3,$wieght3));
                                decNumBox($boxID,$cNumber3);
                            }
                            //----------------------------------------------------------------
                            if($stmt->rowCount() > 0){
                                alert("k","خلاص كدا اتسجل يامعلم مساء العظمه");
                                ?>

                                <h5 class="text-center"><span> <?php echo $now; ?> </span> </h5>
                                <h6 class="text-center font-weight-bold"><span> <?php echo $totalPrice; ?> LE</span> </h6>

                                    <table class="table table-dark text-center" dir="rtl">
                                        <thead>
                                            <tr>
                                            <th scope="">النوع</th>
                                            <th scope="">العدد</th>
                                            <th scope="">الوزن الكلي</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>بلدي</td>
                                            <td><?php echo $cNumber1; ?> </td>
                                            <td><?php echo $wieght1; ?>kg </td>
                                            </tr>
                                            <tr>
                                            <td>احمر</td>
                                            <td><?php echo $cNumber2; ?> </td>
                                            <td><?php echo $wieght2; ?>kg </td>
                                            </tr>
                                            <tr>
                                            <td>ابيض</td>
                                            <td><?php echo $cNumber3; ?> </td>
                                            <td><?php echo $wieght3; ?>kg </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                <?php
                            }else{
                                alert("err","في حاجه غلط احه برجاء الاتصال بالفني 01061286091");
                            }
                        }else{
                            alert("err","nope");
                        }
                    } catch (Exception $th) {
                        dd($th);
                    }
                    
                }


              }else{ ?>


                <div dir="rtl">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">

                       
                        
                            <div class="form-group row">
                                <label for="bldy" class="col-sm-2 col-form-label">
                                    (<span id="bldyP"><?php echo round(get("kiloPrice","box","type",1,true)[0],"2"); ?></span>) بلدي
                                </label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="cNumber1"  id="bldy" placeholder="عدد الفرخات"
                                       min="0" max="<?php echo get("cNumber","box","type",1,true)[0]; ?>">
                                </div>
                                <div class="col-sm-5">
                                    <input id="bldyW" type="number" step="0.001" min="0" class="form-control" name="wieght1"  placeholder="الوزن الكلي"
                                    min="0" max="<?php// echo round(get("wieght","box","type",1)[0],"3"); ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="red" class="col-sm-2 col-form-label">
                                    (<span id="redP"><?php echo round(get("kiloPrice","box","type",2,true)[0],"2"); ?></span>)أحمر 
                                </label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="cNumber2"  id="red" placeholder="عدد الفرخات"
                                    min="0" max="<?php echo get("cNumber","box","type",2,true)[0]; ?>">
                                </div>
                                <div class="col-sm-5">
                                    <input id="redW" type="number" step="0.001" min="0" class="form-control" name="wieght2"  placeholder="الوزن الكلي"
                                    min="0" max="<?php// echo round(get("wieght","box","type",2)[0],"3"); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="red" class="col-sm-2 col-form-label">
                                    (<span id="whiteP"><?php echo round(get("kiloPrice","box","type",3,true)[0],"2"); ?></span>)ابيض 
                                </label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" name="cNumber3"  id="white" placeholder="عدد الفرخات"
                                    min="0" max="<?php echo get("cNumber","box","type",3,true)[0]; ?>">
                                </div>
                                <div class="col-sm-5">
                                    <input id="whiteW" type="number" step="0.001" min="0" class="form-control" name="wieght3"  id="white" placeholder="الوزن الكلي"
                                    min="0" max="<?php // echo round(get("wieght","box","type",3)[0],"3"); ?>">
                                </div>
                            </div>
                        

                        <div class="form-group">
                            <label for="Kilo">السعر الكلي</label>
                            <input id="total" type="text" class="form-control" id="box" name="totalPrice"  required>
                        </div>
                    
                    
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-handshake-o" aria-hidden="true"></i>  تومام
                         </button>
                        <div id="test" class="btn btn-primary pull-left">
                            <i class="fa fa-meh-o" aria-hidden="true"></i> احسب
                        </div>

                    </form>
                </div>

              <?php } ?>
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
