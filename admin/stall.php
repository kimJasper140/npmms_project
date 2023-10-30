<?php
include "../config/config.php";
include "checking_user.php";?>
<!DOCTYPE html>
<html>
<head>
    <title>Stall Management System</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .custom-style{
            padding-left: 15%;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: white ;
            margin: 0;
           padding-top: 5%;
          
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            padding: 8px 16px;
            background-color: #fff;
            color: #333;
            border: 1px solid #ccc;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .tab:hover {
            background-color: #e6e6e6;
        }

        .tab.active {
            background-color: #e6e6e6;
            border-bottom-color: #fff;
        }

        .filters {
            margin-bottom: 20px;
            text-align: center;
        }

        #stall-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .stall-card {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .stall-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stall-card h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .stall-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .counts {
            font-weight: bold;
            color: #333;
        }

        .custom-form-control {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .custom-form-control:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 4px #1877f2;
        }

        .btn {
            padding: 8px 16px;
            background-color: #1877f2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #3b5998;
        }

        .btn:active {
            background-color: #115293;
        }

        .message {
            color: #f44336;
            font-size: 14px;
            margin-top: 10px;
        }
        .tab#occupied-stalls.active {
            background-color: #e6e6e6;
            border-bottom-color: #fff;
        }
    </style>
    <script>
        function loadStalls() {
            var section = $('#section').val();
            var search = $('#search').val();
            var tab = $('.tab.active').attr('id');

            $.ajax({
                url: 'get_stalls.php',
                method: 'POST',
                data: { section: section, search: search, tab: tab },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var stalls = response.stalls;

                        displayStalls(stalls);
                    } else {
                        $('#stall-list').empty().append('<p class="message">No stalls found.</p>');
                    }
                },
                error: function() {
                    console.log('Error occurred while fetching stalls.');
                }
            });
        }

        function displayStalls(stalls) {
            var stallList = $('#stall-list');
            stallList.empty();

            $.each(stalls, function(index, stall) {
                var stallCard = $('<div class="stall-card">')
                    .append('<h2>Stall Number: ' + stall.stall_number + '</h2>')
                    .append('<p>Category: ' + stall.category + '</p>')
                    .append('<p>Status: ' + stall.status + '</p>');
                stallList.append(stallCard);
            });
        }

        $(document).ready(function() {
            loadStalls(); // Initial load of all stalls

            // Triggered when the section or search input changes
            $('#section, #search').on('change keyup', function() {
                loadStalls();
            });

            // Triggered when a tab is clicked
            $('.tab').on('click', function() {
                $('.tab').removeClass('active');
                $(this).addClass('active');
                loadStalls();
            });
        });
    </script>
</head>
<?php 
include "sidebar-admin.php";
?>
<body>
    <div class="custom-style">
    <h1>Stall Management System</h1>

    <div class="tabs">
        <div class="tab active" id="all-stalls">All Stalls</div>
        <div class="tab" id="occupied-stalls">Occupied Stalls</div>
    </div>

    <div class="filters">
        <label for="section">Section:</label>
        <select id="section" class="custom-form-control">
            <option value="all">All Sections</option>
            <option value="Grain Section">Grain Section</option>
            <option value="Fast Food Section">Fast Food Section</option>
            <option value="Grocery Section">Grocery Section</option>
            <option value="Steel Section">Steel Section</option>
            <option value="Wet Section">Wet Section</option>
            <option value="Fruit and Vegetable Section">Fruit and Vegetable Section</option>
            <option value="Dry Goods Section">Dry Goods Section</option>
        </select>
        <input type="text" id="search" class="custom-form-control" placeholder="Search Stall Name">
    </div>

    <div id="stall-list">
        <!-- Stall data will be dynamically populated here -->
    </div>
    </div>
</body>
</html>
