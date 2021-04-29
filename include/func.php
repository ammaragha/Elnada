<?php
    //super :()
    function get($select,$from,$where,$equl,$dateON = false)
    {
        global $conn;
        $now = now("date");
        if($dateON){
            $stmt = $conn->prepare("SELECT $select FROM $from WHERE $where = ? AND date = ?");
            $stmt->execute(Array($equl,$now));
        }else{
            $stmt = $conn->prepare("SELECT $select FROM $from WHERE $where = ?");
            $stmt->execute(Array($equl));
        }
        if($stmt->rowCount()>0)
            return $stmt->fetch();
        else
            return array(0);
    }

    function alert($type,$msg)
    {
        if($type == "k"){
            echo "<p class='alert alert-success text-center'>".$msg."</p>";
        }elseif($type == "err"){
            echo "<p class='alert alert-danger text-center'>".$msg."</p>";
        }else{
            echo "<p class='alert alert-danger text-center'>Wrong type of err alert(type,msg) </p>";
        }
    }

    function type($type)
    {
        switch ($type){
            case 1:
                return "بلدي"; break;
            case 2:
                return "احمر"; break;
            case 3:
                return "بيضة"; break;
            default :
                return "x"; break;
        }
    }

    function cGet($type)
    {
        global $conn;
        $now = now("date");
        $stmt = $conn->prepare("SELECT * FROM box WHERE type=? AND date =?");
        $stmt->execute(Array($type,$now));
        if($stmt->rowCount() >0 ){
            return $stmt->fetch();
        }else{
            return array("kiloPrice"=>"?","cNumber"=> 0);
        }   
    }

    function bdan($frist,$sec)
    {
        if(!empty($frist)){
            if(empty($sec)){
                return true;
            }
        }elseif(!empty($sec)){
            if(empty($frist)){
                return true;
            }
        }else{
            return false;
        }

    
    }
    
    function check($input)
    {
        return !empty($input) ? is_numeric($input)? $input :0: 0;
    }

    function totalSold($type)
    {
        global $conn;

        $now = now("date");

        $stmt = $conn->prepare("SELECT sum(wieght),sum(number) FROM buy WHERE boxID = (SELECT id FROM box WHERE type=? AND date=?)");
        $stmt->execute(Array($type,$now));
        return $stmt->fetch();

    }

    function now($type)
    {
        $now = new DateTime();
        $now = $now->format('Y-m-d H:i:s');
        if($type="date")
            return explode(" ",$now)[0];
        elseif($type=="time")
            return explode(" ",$now)[1];
        else
            return $now;
    }


    function decNumBox($boxID,$number)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE box SET cNumber = cNumber-? WHERE id=?");
        $stmt->execute(Array($number,$boxID));
        
    }
?>