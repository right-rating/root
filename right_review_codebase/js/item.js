//current item id store in $_SESSION['item_id']
item_id = 32;

//on load of page
$(document).ready(function() {
    //ajax call to get current item information
    $.ajax({
        type: "get",
        url: "api/getItemInfo.php",
        dataType: "json",
        data: {
            'item_id' : item_id,
        },
        success: function(data, status) {
            // console.log(data);
            
            //fill in information about item selected
            var item = data[0];
            $('#pageTitle').html(item['item_name'] + " Review Page");
            $('#itemLogoImage').attr('src', 'img/'+item['item_image_url']);
            $('#itemName').html("<a href='//" + item['item_name'] + "'>" + item['item_name'] + "<a>");
            $('#itemDescription').html(item['item_description']);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText'])
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
    
    //get all categories for later use
    $.ajax({
        type: "get",
        url: "api/getAllCategories.php",
        dataType: "json",
        success: function(data, status) {
            console.log(data);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText'])
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
    
});