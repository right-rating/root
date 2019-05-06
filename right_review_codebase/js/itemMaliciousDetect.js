var item_id;

//Get email with the corresponding id
var apiCallURL = "";

$(document).ready(function() {
    $.ajax({
        type: "get",
        url: "api/getSession.php",
        dataType: "json",
        success: function(data, status) {
            item_id = data['item_id'];
            $.ajax({
                type: "get",
                url: "api/getUrlInfo.php",
                dataType: "json",
                data: {
                    'item_id': item_id,
                },
                success: function(data, status) {
                    //fill in information about item selected
                    var item = data[0];
                    apiCallURL = item['item_name'];
                    //Pass it to the google API to check
                    $.ajax({
                        type: "GET",
                        url: "googleSafeBrowsingApi/googleSafeBrowsingApi.php",
                        dataType: 'json',
                        data: {
                            'item_url': apiCallURL,
                        },
                        success: function(data, status) {
                            //redirect
                            data = data['matches'];

                            if (data == null || data == undefined) {
                                console.log("SAFE: No malicious URL link is detected");
                            }
                            else {
                                $("#warningMsg").append('<div class="alert alert-danger" role="alert">' +
                                    '<h3>This is a WARNING:</h3>' +
                                    '<br>' +
                                    'This URL was detected as Malicious Website by Google Safe Browsing API' +
                                    '</div>');
                            }
                            $('#warningMsg').addClass('animated fadeInLeftBig');
                        }
                    }); //ajax call
                }
            }); //ajax call : get URL
        }
    }); //ajax call : get item id



}); //on ready
