require('./bootstrap');

var options = {
    valueNames:['room_number','floor_number','layout','layout_type','direction','occupied_area','published_price','published_unit_price','expected_price','expected_unit_price','expected_rent_price','expected_unit_rent_price','rimawari','increase_rate','price','diffarence']
};

var roomList = new List('rooms',options);

var optionsForBuildings = {
    valueNames:['name','total_unit','countPublishedPrice','countExpectedPrice','percent']
};
var buildingList = new List('buildings',optionsForBuildings);

var optionsForSales = {
    valueNames:['price','previous_price','registered_at','changed_at','sold_price','sold_previous_price','sold_registered_at','sold_changed_at','expected_price']
};

//delete確認ダイアログ
$(function(){
    $(".dell").click(function(){
        if(confirm("売買情報を削除してよろしいですか？")){
        }else{
            return false;
        }
    });
});