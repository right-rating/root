<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Right Review</title>
</head>

<body>
    <header>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <!-- Material Design Bootstrap -->
        <link href="css/mdb.min.css" rel="stylesheet">
        <!-- Your custom styles (optional) -->
        <link href="css/style.css" rel="stylesheet">

        <!--AG grid for Listings-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ag-grid/19.1.4/styles/ag-theme-balham-dark.css">
        <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
        <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-balham.css">

    </header>
<?php
  $page = "search";
  include "pagetools/page-top.php";
 ?>

    <form class="form-inline md-form mr-auto mx-auto" style="width: 80%;">
        <input id="searchBarId" class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-warning btn-rounded" type="submit">Search</button>
    </form>

    <div id="itemGridcontent" class="mx-auto text-center" style="width: 80%;">

        <div id="selector btn-group-justified" class="btn-group">
            <div class="row">
                <div class="col-4.5">
                    <button id="sortByURLAscBtn" type="button" class="btn btn-danger btn-sm">Website URL <i class="fa fa-sort-alpha-down"></i></button>
                    <button id="sortByURLDescBtn" type="button" class="btn btn-secondary btn-sm">Website URL <i class="fa fa-sort-alpha-up"></i></button>
                </div>
                <div class="col">
                    <button id="sortByRateAscBtn" type="button" class="btn btn-danger btn-sm">Rating <i class="fa fa-sort-numeric-down"></i></button>
                    <button id="sortByRateDescBtn" type="button" class="btn btn-secondary btn-sm">Rating <i class="fa fa-sort-numeric-up"></i></button>
                </div>
                <div class="col-4.5">
                    <button id="sortByIdAscBtn" type="button" class="btn btn-danger btn-sm">Website ID <i class="fa fa-sort-numeric-down"></i></button>
                    <button id="sortByIdDescBtn" type="button" class="btn btn-secondary btn-sm">Website ID <i class="fa fa-sort-numeric-up"></i></button>
                </div>
            </div>
        </div>
        <br/>
        <br/>

        <div id="itemGrid" class="ag-theme-balham-dark" style="width: 100%; height: 100%;">


        </div>
        <script>
            $(document).ready(function() {
                // specify the columns
                var columnDefs = [{
                        headerName: "Website URL",
                        field: "name",
                        icons: {
                            sortAscending: '<i class="fa fa-sort-alpha-down"/>',
                            sortDescending: '<i class="fa fa-sort-alpha-up"/>'
                        }
                    },
                    { headerName: "Description", field: "description" },
                    {
                        headerName: "Rating",
                        field: "rating",
                        icons: {
                            sortAscending: '<i class="fa fa-sort-numeric-down"/>',
                            sortDescending: '<i class="fa fa-sort-numeric-up"/>'
                        }
                    },
                    {
                        headerName: "Website ID",
                        field: "id",
                        icons: {
                            sortAscending: '<i class="fa fa-sort-numeric-down"/>',
                            sortDescending: '<i class="fa fa-sort-numeric-up"/>'
                        }
                    }
                ];

                // let the grid know which columns and what data to use
                var gridOptions = {
                    defaultColDef: {
                        sortable: true,
                        filter: true,
                        resizable: true
                    },
                    domLayout: 'autoHeight',
                    columnDefs: columnDefs,
                    rowSelection: 'single',
                    onSelectionChanged: onSelectionChanged,

                };

                function sizeToFit() {
                    gridOptions.api.sizeColumnsToFit();
                }

                $.ajax({
                    type: "GET",
                    url: "api/search.php",
                    dataType: "json",
                    data: {},
                    success: function(data, status) {

                        var rowData = [];
                        // specify the data
                        for (var idx in data) {

                            var rowElem = {
                                id: data[idx]['item_id'],
                                name: data[idx]['item_name'],
                                description: data[idx]['item_description'],
                                rating: parseFloat(data[idx]['AVG(rating.rating_val)']).toFixed(2)
                            };

                            rowData.push(rowElem);
                        }


                        // lookup the container we want the Grid to use
                        var eGridDiv = document.querySelector('#itemGrid');

                        // create the grid passing in the div to use together with the columns & data we want to use
                        new agGrid.Grid(eGridDiv, gridOptions);

                        gridOptions.api.setRowData(rowData);
                        sizeToFit();

                    }
                }); //ajax call

                function onSelectionChanged() {
                    var selectedRows = gridOptions.api.getSelectedRows();
                    var selectedRowsString = '';
                    selectedRows.forEach(function(selectedRow, index) {
                        if (index !== 0) {
                            selectedRowsString += ', ';
                        }
                        selectedRowsString += selectedRow.id;
                    });

                    //$_SESSION['item_id'] = selectedRowsString;
                    $.ajax({
                        type: "GET",
                        url: "api/changeItemId.php",
                        data: {
                            'new_id': selectedRowsString
                        },
                        success: function(data, status) {
                            //redirect
                            self.location = "item.php";

                        }
                    }); //ajax call

                }

                $("#sortByURLAscBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'name', sort: 'asc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#sortByURLDescBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'name', sort: 'desc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#sortByRateAscBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'rating', sort: 'asc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#sortByRateDescBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'rating', sort: 'desc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#sortByIdAscBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'id', sort: 'asc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#sortByIdDescBtn").on("click", function() {
                    $(this).addClass('active').siblings().removeClass('active');

                    var sort = [
                        { colId: 'id', sort: 'desc' }
                    ];
                    gridOptions.api.setSortModel(sort);
                }); // onclick

                $("#searchBarId").on('input', function() {
                    gridOptions.api.setQuickFilter($("#searchBarId").val());
                });

            }); //on ready
        </script>

        <footer></footer>
        <script>
            // on click of an Item, send ItemID
        </script>
</body>

</html>
