<?php
    include "include/int.php";
?>
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <h1 class="text-center">add new <?php echo now("date"); ?> </h1>
        <br>

    <?php 
     
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){

            $type       = $_POST['type'];
            $price      = $_POST['price'];
            $wieght     = $_POST['wieght'];
            $cNumber    = $_POST['cNumber'];
            $kiloPrice  = $_POST['kiloPrice'];

            $errForm = Array();

            if(!is_numeric($price)){ $errForm[] = "سعر الكيلو (شراء) لازم يكون رقم :/"; }
            if(!is_numeric($wieght)){ $errForm[] = "الوزن الكلي لازم يكون رقم ياعم :/"; }
            if(!is_numeric($cNumber)){ $errForm[] = "chicken number must be a valid number :/"; }
            if(!is_numeric($kiloPrice)){ $errForm[] = "سعر الكيلو (بيع) لازم يكون رقم  :/"; }

            //............
            $now = now("date");
            $stmt = $conn->prepare("SELECT * FROM box WHERE type = ? AND date LIKE ? ");
            $stmt->execute(Array($type,"%".$now."%"));
            if($stmt->rowCount() > 0 ){
                $errForm[] = "(".type($type).") موجود اصلا ياسطا روح عدل عليه مينفعش تضيف";
            }
            //............

            if(!empty($errForm)){
                foreach($errForm as $err){
                    alert("err",$err);
                }
            }else{
                try {
                    $stmt = $conn->prepare("INSERT into box(type,price,wieght,cNumber,kiloPrice) VALUES(?,?,?,?,?)");
                    $stmt->execute(Array($type,$price,$wieght,$cNumber,$kiloPrice));
                    if($stmt->rowCount() > 0){
                      alert('k',"done !!");
                    }else{
                        alert("err","nope :D ");
                    }
                } catch (\Execption $th) {
                    dd($th);
                }
            }

            

            
        }else{
            ?>

              
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" dir="rtl">
                            <div class="form-group">
                                <label for="type">النوع :</label>
                                <select style="" id="type" class="form-control col-m-5" name="type" required>
                                    <option value="">..</option>
                                    <option value="1">بلدي</option>
                                    <option value="2">احمر</option>
                                    <option value="3">ابيض</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Kilo">سعر كيلو (شراء)</label>
                                <input type="number" min="0" step=".001" class="form-control" id="box" name="price"  required>
                            </div>
                            <div class="form-group">
                                <label for="wieght">الوزن الكلي</label>
                                <input type="number" min="0" step=".0001" class="form-control" id="wieght" name="wieght"  required>
                            </div>
                            <div class="form-group">
                                <label for="chicken">العدد</label>
                                <input type="number" class="form-control" id="chicken" name="cNumber" >
                            </div>
                            <div class="form-group">
                                <label for="Kilo">سعر الكيلو (بيع)</label>
                                <input type="number" min="0" step=".001"  class="form-control" id="Kilo" name="kiloPrice"  required>
                            </div>
                        
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                   
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