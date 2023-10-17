<?php
	include("session.php");

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/mystyle.css" /> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<title>Annoucement | NPMMS</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script src="chart1.js"></script>
    <script src="chart2.js"></script>
    <style>
        /* .announcement {
    border: 1px solid #ccc;
    padding: 10px;
    width: 500px;
    margin-left: 50%;
    margin-top:100px;
}

.announcement.float-right {
    float: right;
    margin-left: 50%;
    margin-right: 20px;
}.no{
 
    margin-left: 55%;
    margin-right: 20px;
    margin-top:100px
} */

    </style>
<body>
<?php 
   //include "template/header.php";?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Announcement Board</h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Announcement 1</h5>
                    <p class="card-text"></p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="1" data-title="Announcement 1" data-content="This is the content of Announcement 1.">Edit</button>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text">This is the content of Announcement 2.</p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-id="2" data-title="Announcement 2" data-content="This is the content of Announcement 2.">Edit</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h2>Add Announcement</h2>
            <form method="post" action="add_announcement.php">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Announcement</button>
            </form>
        </div>
    </div>
    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="edit_announcement.php">
                    <div class="form-group">
                        <label for="editTitle">Title:</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editContent">Content:</label>
                        <textarea class="form-control" id="editContent" name="content" rows="5" required></textarea>
                    </div>
                    <input type="hidden" id="editId" name="id">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
