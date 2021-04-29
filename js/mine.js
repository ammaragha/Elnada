$('#test').click(function(){
    //bldy
    var bldyP = parseFloat($('#bldyP').text());
    var bldyW = parseFloat($('#bldyW').val());
    var bldyT = 0;
    if(isNaN(bldyW)){
        bldyW = parseFloat(bldyT);
    }

    bldyT = bldyP * bldyW;
    

    //red
    var redP = parseFloat($('#redP').text());
    var redW = parseFloat($('#redW').val());
    var redT = 0;
    if(isNaN(redW)){
        redW = parseFloat(redT);
    }

    redT = redP * redW;
    


    //white
    var whiteP = parseFloat($('#whiteP').text());
    var whiteW = parseFloat($('#whiteW').val());
    var whiteT = 0;
    if(isNaN(whiteW)){
        whiteW = parseFloat(whiteT);
    }
    whiteT = whiteP * whiteW;

    var total = bldyT + redT + whiteT;
    $("#total").val((total).toFixed(3));
    
    
    
})