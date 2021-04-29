<?php
    include "include/int.php";
?>


<?php 
    $now = now("date");
   $stmt = $conn->prepare("SELECT * from buyer where date LIKE ?");
   $stmt->execute(Array("%".$now."%"));
   $all = $stmt->fetchAll();

   $totalGain = $conn->prepare("SELECT sum(totalPrice) FROM buyer WHERE date LIKE ?");
   $totalGain->execute(Array("%".$now."%"));
   $totalGain = $totalGain->fetch()[0];
   
   
?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
              <h1 style="margin:20px 0" class="text-center font-weight-bold"> ( <?php echo $now; ?> )فواتير النهردا</h1>
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
                if(bdan($cNumber1,$wieght1)) {$errForm[] = "تقريبا نسيت وزن البلدي";}
                if(bdan($cNumber2,$wieght2)) {$errForm[] = "تقريبا نسيت وزن الاحمر";}
                if(bdan($cNumber3,$wieght3)) {$errForm[] = "تقريبا نسيت وزن الابيض";}


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
                            
                            $stmt = $conn->prepare("INSERT INTO buy(bID,type,number,totalWieght) values(?,?,?,?)");
                            $stmt->execute(Array($id,1,$cNumber1,$wieght1));
                            $stmt->execute(Array($id,2,$cNumber2,$wieght2));
                            $stmt->execute(Array($id,3,$cNumber3,$wieght3));
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


                <div dir="rtl" lang="ar">
                    <div class="table-responsive text-center">
                        <table class="table">
                                <tr class="bg-info font-weight-bold" style="color:white; ">
                                    <td > <i class="fa fa-globe" aria-hidden="true"></i> </td>
                                    <td > احصائيه اليوم </td>
                                    <td > <?php
                                        echo round(totalSold(1)[0],2)."KG <strong>(".totalSold(1)[1].")</strong>"; ?> 
                                    </td>
                                    <td > <?php
                                        echo round(totalSold(2)[0],2)."KG <strong>(".totalSold(2)[1].")</strong>"; ?> 
                                    </td>
                                    <td > <?php
                                        echo round(totalSold(3)[0],2)."KG <strong>(".totalSold(3)[1].")</strong>"; ?> 
                                    </td>
                                    <td > <?php echo round($totalGain,2); ?>LE </td>
                                </tr>
                            <thead >
                                <tr >
                                    <th scope="col">#</th>
                                    <th scope="col">الوقت</th>
                                    <th scope="col">بلدي</th>
                                    <th scope="col">احمر</th>
                                    <th scope="col">ابيض</th>
                                    <th scope="col">السعر الكلي</th>
                                    
                                </tr>
                            </thead>
                            <tbody >
                                <?php foreach($all as $key => $buyer){  ?>
                                <tr>
                                    <th scope="row"> <?php echo ++$key; ?> </th>
                                    <td> <?php echo explode(" ",$buyer['date'])[1] ; ?> </td>

                                    <?php for($i=1 ; $i<4 ; $i++){
                                        $chicken = $conn->prepare("SELECT * from buy 
                                                            where bId=? AND boxID = (SELECT id FROM box WHERE type=? AND date=?)");
                                        $chicken->execute(Array($buyer['id'],$i,$now));
                                        $type = $chicken->fetch();
                                    ?>
                                        <td>
                                            <?php
                                            if($chicken->rowCount() > 0)
                                                if($type['number'] == 0  && $type['wieght']==0)
                                                    echo "-";
                                                else
                                                    echo round($type['wieght'],2)."KG <strong>(".$type['number'].")</strong>";
                                            else
                                                echo 0;
                                            ?>
                                        </td>
                                    <?php } ?>

                                    <td> <?php echo round($buyer['totalPrice'],2) ; ?> </td>
                                </tr>
                                <?php } ?>

                               
                            </tbody>
                        </table>
                    </div>
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