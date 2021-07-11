function updateRoomSelection() {
    $('.room').hide();
    var extraction_val = $('.roomNumber').val();
    console.log(extraction_val);
    if (extraction_val == "1") {
        $('.room1').show();
    } else if(extraction_val == "2") {
        $('.room1').show();
        $('.room2').show();
    } else if(extraction_val == "3") {
        $('.room1').show();
        $('.room2').show();
        $('.room3').show();
    } else if(extraction_val == "4") {
        $('.room1').show();
        $('.room2').show();
        $('.room3').show();
        $('.room4').show();
    } else if(extraction_val == "5") {
        $('.room').show();
    }
}
            
$(function() {
    console.log("test");
    updateRoomSelection();

    // 部屋数の選択に応じて、人数選択フォームの表示切替
    $('.roomNumber').on('change', function() {
        updateRoomSelection();
    });
    
    console.log()
    $('.form').submit(function() {
        // 部屋数が選択されていない場合のアラート表示
        var roomNumber = $('.roomNumber').val();
        if (roomNumber == "0") {
            alert("部屋数を選択してください");
            return false;
        }
        // 人数入力がされていない場合にエラー
        var personCount1 = $('.room1Adult').val() + $('.room1Child').val() + $('.room1NoBed').val();
        if (personCount1 == "0") {
            alert("大人1名以上選択してください");
            return false;
        }
    });


    // 未入力欄がある際のアラート表示
    $('.customerForm').submit(function() {	
        var nameValue = $('.name').val();
        var phoneValue = $('.phone').val();
        var emailValue = $('.email').val();
        
        if(nameValue == "") {	
            alert("名前を入力してください");	
            return false;	
        }
        if(phoneValue == "") {	
            alert("電話番号を入力してください");	
            return false;	
        }
        if(emailValue == "") {	
            alert("メールアドレスを入力してください");	
            return false;	
        }
    });

});
