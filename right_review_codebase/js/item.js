//global vars
var item_id;

//RUNS ON LOAD OF PAGE
//************************************************************************
$(document).ready(function() {
    $.ajax({
        type: "get",
        url: "api/getSession.php",
        dataType: "json",
        success: function(data, status) {
            item_id = data['item_id'];
            loadPage(data['item_id']);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
//************************************************************************

//FILLS INFO ABOUT SPECIFIC ITEM (NAME, DESCRIPTION, AND LOGO IMAGE)
//************************************************************************
function fillItemInfo(itemId) {
    $.ajax({
        type: "get",
        url: "api/getItemInfo.php",
        dataType: "json",
        data: {
            'item_id' : itemId,
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
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
}
//************************************************************************

//FILLS AVGS OF RATINGS FOR ALL CATEGORIES
//************************************************************************
function fillRatingCategoryInfo(itemId) {
    //get all categories for later use
    $.ajax({
        type: "get",
        url: "api/getAllCategories.php",
        dataType: "json",
        success: function(data, status) {
            // console.log(data);
            $('#categoryRatingTotal').html("")
            for (var i = 0; i < data.length; i++) {
                $.ajax({
                    type: "get",
                    url: "api/getAvgRatingOfCategory.php",
                    dataType: "json",
                    data: {
                        'rating_category_id' : data[i]['rating_category_id'],
                        'item_id' : item_id,
                    },
                    success: function(data, status) {
                        // console.log(data);
                        $('#categoryRatingTotal').append("<tr>");
                        $('#categoryRatingTotal').append("<td><img class='ratingCategoryLogos' src='img/" + data[0]['rating_category_image_url'] + "'></img></td>");
                        $('#categoryRatingTotal').append("<td>" + data[0]['rating_category_name'] + "</td>");
                        $('#categoryRatingTotal').append("<td>" + Math.round( data[0]['AVG(rating.rating_val)'] * 10 ) / 10 + "/5</td>");
                        $('#categoryRatingTotal').append("</tr>");
                    },
                    error: function(error) {
                          console.log(error);
                          $('#error').html(error['responseText']);
                    },
                    complete: function(data, status) {
                        //console.log(status);
                    },
                });
            }
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
}
//************************************************************************

//FILLS INDIVIDUAL RATINGS
//************************************************************************
function fillIndividualRatings(itemId, user_role, user_email, user_id) {
    //hide submission button
    $('#ratingSubmissionButton').hide();

    //for users to give input
    if (user_role == "user") {
        //set user role title part
        $('#userRoleTitle').html("Rate This Website (1-5)");

        //allow submission button to be shown
        $('#ratingSubmissionButton').show();
        //get all categories to display rating in each
        $.ajax({
            type: "get",
            url: "api/getAllCategories.php",
            dataType: "json",
            success: function(data, status) {
                // console.log(data);
                //clear ratings box
                $('#individualRatings').html("");
                for (var i = 0; i < data.length; i++) {
                    //add specific row to table reguarding rating of this category
                    addRowToRatingsUser(user_id, itemId, data[i]['rating_category_id'], data[i]['rating_category_image_url'], data[i]['rating_category_name']);
                }
            },
            error: function(error) {
                console.log(error);
                $('#error').html(error['responseText']);
            },
            complete: function(data, status) {
                //console.log(status);
            },
        });
    }
    else if (user_role == "moderator") {
        //set user role title part
        $('#userRoleTitle').html("Moderator Rating Hiding Feature");

        //get all rating for moderator to hide/unhide
        $.ajax({
            type: "get",
            url: "api/getRatingsForModerator.php",
            dataType: "json",
            data: {
                'item_id' : item_id,
            },
            success: function(data, status) {
                // console.log(data);

                //add all items to table
                var individualRatingsString = "";
                individualRatingsString += "<tr>";
                individualRatingsString += "<th></th>";
                individualRatingsString += "<th>User Email</th>";
                individualRatingsString += "<th>Rating Category</th>";
                individualRatingsString += "<th>Rating Value</th>";
                individualRatingsString += "<th>Rating Hidden</th>";
                individualRatingsString += "</tr>";
                for (var i = 0; i < data.length; i++) {
                    individualRatingsString += "<tr>";

                    //is rating hidden or no
                    if (data[i]['rating_hidden'] == 1) individualRatingsString += "<td><button class='showRatingButton' rating_id='" + data[i]['rating_id'] + "' item_id='" + data[i]['item_id'] + "'>Show Rating</button></td>";
                    else individualRatingsString += "<td><button class='hideRatingButton' rating_id='" + data[i]['rating_id'] + "' item_id='" + data[i]['item_id'] + "'>Hide Rating</button></td>";

                    individualRatingsString += "<td>" + data[i]['user_email'] + "</td>";
                    individualRatingsString += "<td>" + data[i]['rating_category_name'] + "</td>";
                    individualRatingsString += "<td>" + data[i]['rating_val'] + "/5</td>";

                    //display hidden
                    if (data[i]['rating_hidden'] == 1) individualRatingsString += "<td>Yes</td>";
                    else individualRatingsString += "<td>No</td>";

                    individualRatingsString += "</tr>";
                }
                $('#individualRatings').html(individualRatingsString);
            },
            error: function(error) {
                console.log(error);
                $('#error').html(error['responseText']);
            },
            complete: function(data, status) {
                //console.log(status);
            },
        });
    }
    else if (user_role == "admin") {
        //set user role title part
        $('#userRoleTitle').html("Administrator Rating Deletion Feature");

        //get all rating for moderator to hide/unhide
        $.ajax({
            type: "get",
            url: "api/getRatingsForModerator.php",
            dataType: "json",
            data: {
                'item_id' : item_id,
            },
            success: function(data, status) {
                // console.log(data);

                //add all items to table
                var individualRatingsString = "";
                individualRatingsString += "<tr>";
                individualRatingsString += "<th></th>";
                individualRatingsString += "<th>User Email</th>";
                individualRatingsString += "<th>Rating Category</th>";
                individualRatingsString += "<th>Rating Value</th>";
                individualRatingsString += "<th>Rating Hidden</th>";
                individualRatingsString += "</tr>";
                for (var i = 0; i < data.length; i++) {
                    individualRatingsString += "<tr>";
                    individualRatingsString += "<td><button class='deleteRatingButton' rating_id='" + data[i]['rating_id'] + "' item_id='" + data[i]['item_id'] + "'>Delete Rating</button></td>";

                    individualRatingsString += "<td>" + data[i]['user_email'] + "</td>";
                    individualRatingsString += "<td>" + data[i]['rating_category_name'] + "</td>";
                    individualRatingsString += "<td>" + data[i]['rating_val'] + "/5</td>";

                    //display hidden
                    if (data[i]['rating_hidden'] == 1) individualRatingsString += "<td>Yes</td>";
                    else individualRatingsString += "<td>No</td>";

                    individualRatingsString += "</tr>";
                }
                $('#individualRatings').html(individualRatingsString);
            },
            error: function(error) {
                console.log(error);
                $('#error').html(error['responseText']);
            },
            complete: function(data, status) {
                //console.log(status);
            },
        });
    }
}

//FUNCTION THAT ADDS A ROW TO THE INDIVIDUAL RATINGS
function addRowToRatingsUser(user_id, item_id, rating_category_id, rating_category_image_url, rating_category_name) {
    // console.log("" + user_id + " " + item_id + " " + rating_category_id + " " + rating_category_image_url);
    $.ajax({
        type: "get",
        url: "api/getUserRatingsByCategory.php",
        dataType: "json",
        data: {
            'rating_category_id' : rating_category_id,
            'item_id' : item_id,
            'user_id' : user_id,
        },
        success: function(data, status) {
            // console.log(data);

            //fill select boxes with info to be used on submission
            if (data.length > 0) {
                // console.log('there is data');
                // console.log(data);
                var individualRatingsString = "<tr>";
                individualRatingsString += "<td><img class='ratingCategoryLogos' src='img/" + rating_category_image_url + "'></img></td>";
                individualRatingsString += "<td>" + rating_category_name + "</td>";
                individualRatingsString += "<td><select class='userReviewChoice' user_id='" + user_id + "' item_id='" + item_id + "' rating_category_id='" + rating_category_id + "' rating_id='" + data[0]['rating_id'] + "'><option value='0'>No Rating</option>";
                for (var k = 1; k < 6; k++) {
                    if (k == data[0]['rating_val']) individualRatingsString += "<option selected='selected' value='" + k + "'>" + k + "</option>";
                    else individualRatingsString += "<option value='" + k + "'>" + k + "</option>";
                }
                individualRatingsString += "</select></td>";
                individualRatingsString += "</tr>";
                $('#individualRatings').append(individualRatingsString);

            }
            else {
                // console.log('nope');
                var individualRatingsString = "<tr>";
                individualRatingsString += "<td><img class='ratingCategoryLogos' src='img/" + rating_category_image_url + "'></img></td>";
                individualRatingsString += "<td>" + rating_category_name + "</td>";
                individualRatingsString += "<td><select class='userReviewChoice' user_id='" + user_id + "' item_id='" + item_id + "' rating_category_id='" + rating_category_id + "' rating_id=''><option value='0'>No Rating</option>";
                for (var k = 1; k < 6; k++) {
                    individualRatingsString += "<option value='" + k + "'>" + k + "</option>";
                }
                individualRatingsString += "</select></td>";
                individualRatingsString += "</tr>";
                $('#individualRatings').append(individualRatingsString);
            }

        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
}

//functions that acts on hide and show buttons being pressed
$(document).on('click', '.hideRatingButton', function() {
    var item_id = $(this).attr('item_id');
    var rating_id = $(this).attr('rating_id');

    //hide rating and reload page
    $.ajax({
        type: "post",
        url: "api/hideShowRating.php",
        dataType: "json",
        data: {
            'op' : 'hide',
            'rating_id' : rating_id,
        },
        success: function(data, status) {
            // console.log(data);
            loadPage(item_id);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
$(document).on('click', '.showRatingButton', function() {
    var item_id = $(this).attr('item_id');
    var rating_id = $(this).attr('rating_id');

    //show rating and reload page
    $.ajax({
        type: "post",
        url: "api/hideShowRating.php",
        dataType: "json",
        data: {
            'op' : 'show',
            'rating_id' : rating_id,
        },
        success: function(data, status) {
            // console.log(data);
            loadPage(item_id);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
//when delete button is pressed
$(document).on('click', '.deleteRatingButton', function() {
    var item_id = $(this).attr('item_id');
    var rating_id = $(this).attr('rating_id');

    //hide rating and reload page
    $.ajax({
        type: "post",
        url: "api/addDeleteUpdateRating.php",
        dataType: "json",
        data: {
            'operation' : 'delete',
            'rating_id' : rating_id,
        },
        success: function(data, status) {
            console.log(data);
            loadPage(item_id);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
});
//************************************************************************

//THIS FUNCTIONN SUBMITS A RATINGS USING THE VALUES HELD IN THE RATINGS TABLE
//************************************************************************
function submitRatingsInTable() {
    //loop through table of user ratings and submit them
    var list = document.getElementsByClassName("userReviewChoice");
    for (let item of list) {
        // console.log(item);
        //new review
        if (item.getAttribute('rating_id') === '') {
            //add to database if option isn't 'No Rating'
            if (item.value != '0') {
                // console.log(item.value);
                addDeleteUpdateRating('insert', '0', item.value, item.getAttribute('rating_category_id'), item.getAttribute('item_id'), item.getAttribute('user_id'));
            }
        }
        //existing review
        else {
            //delete review
            if (item.value == 0) addDeleteUpdateRating('delete', item.getAttribute('rating_id'), item.value, item.getAttribute('rating_category_id'), item.getAttribute('item_id'), item.getAttribute('user_id'));
            //update review
            else addDeleteUpdateRating('update', item.getAttribute('rating_id'), item.value, item.getAttribute('rating_category_id'), item.getAttribute('item_id'), item.getAttribute('user_id'));
        }
    }
    //load page with item_id
    loadPage(item_id);
}
//add, deletes, and updates ratings in the rating table (also refreshes page after each change to rating table)
function addDeleteUpdateRating(operation, rating_id, rating_val, rating_category_id, item_id, user_id) {
    // console.log("operation: " + operation);

    //convert inputs to ints
    rating_id = parseInt(rating_id);
    rating_val = parseInt(rating_val);
    rating_category_id = parseInt(rating_category_id);
    item_id = parseInt(item_id);
    user_id = parseInt(user_id);

    //print inputs
    // console.log("rating_id: " + rating_id);
    // console.log("rating_val: " + rating_val);
    // console.log("rating_category_id: " + rating_category_id);
    // console.log("item_id: " + item_id);
    // console.log("user_id: " + user_id);

    //make ajax call with info to change rating table
    $.ajax({
        type: "post",
        url: "api/addDeleteUpdateRating.php",
        dataType: "json",
        data: {
            'operation' : operation,
            'rating_id' : rating_id,
            'rating_val' : rating_val,
            'rating_category_id' : rating_category_id,
            'item_id' : item_id,
            'user_id' : user_id,
        },
        success: function(data, status) {
            // console.log(data);
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });

}
//************************************************************************

//THIS FUNCTION LOADS THE ENTIRE PAGE WITH NEW INFO
//************************************************************************
function loadPage(item_id) {
    //get user info
    $.ajax({
        type: "get",
        url: "api/getSession.php",
        dataType: "json",
        success: function(data, status) {
            // console.log(data);
            $.ajax({
                type: "get",
                url: "api/getUserInfo.php",
                dataType: "json",
                data: {
                    'user_email' : data['user_email'],
                },
                success: function(data, status) {
                    // console.log(data);
                    // item_id = data[item_id];
                    user_email = data['user_email'];
                    user_role = data['user_role'];
                    user_id = data['user_id'];
                    fillIndividualRatings(item_id, user_role, user_email, user_id);
                },
                error: function(error) {
                    console.log(error);
                    $('#error').html(error['responseText']);
                },
                complete: function(data, status) {
                    //console.log(status);
                },
            });
        },
        error: function(error) {
            console.log(error);
            $('#error').html(error['responseText']);
        },
        complete: function(data, status) {
            //console.log(status);
        },
    });
    //get item info
    fillItemInfo(item_id);
    //get category rating info
    fillRatingCategoryInfo(item_id);
}
//************************************************************************

//LOGOUT BUTTON IS PRESSED
//************************************************************************
$("#logoutButton").on("click", function() {
    window.location = "api/logout.php";
});
//************************************************************************

//BACK TO SEARCH PAGE BUTTON IS PRESSED
//************************************************************************
/*
$("#backToSearchPageButton").on("click", function() {
    window.location = "search.php";
});
*/
//************************************************************************
