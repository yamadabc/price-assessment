require('./bootstrap');

var options = {
    valueNames:['room_number','floor_number','layout','layout_type','direction','occupied_area','published_price','published_unit_price','expected_price','expected_unit_price','expected_rent_price','expected_unit_rent_price','rimawari','increase_rate','price','diffarence']
};

var roomList = new List('rooms',options);
