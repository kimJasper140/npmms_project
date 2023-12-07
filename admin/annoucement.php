<?php
include "../config/config.php";
include "checking_user.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Announcements | admin</title>
    <link rel="icon" href="../image/logo.ico" type="image/x-icon">
    <style>
      

        h1 {
            color: #006400;
            text-align: center;
            margin-bottom: 20px;
        }

        .announcement {
            background-color: #FFF;
           padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .announcement h2 {
            color: #006400;
            margin-top: 0;
        }

        .announcement p {
            color: #333;
        }

        .announcement img {
            max-width: 50%;
            height: auto;
            margin-top: 10px;
            margin-left: 20%;
        }

        .announcement .action-btns {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .announcement .action-btns button {
            background-color: transparent;
            border: none;
            color: #006400;
            cursor: pointer;
            margin-left: 10px;
        }

        .announcement .action-btns button i {
            margin-right: 5px;
        }

        .form-container {
            background-color: #FFF;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin:10px;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .form-container input[type="text"],
        .form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #006400;
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #FFF;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .modal h2 {
            color: #006400;
            margin-top: 0;
        }

        .modal label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .modal input[type="text"],
        .modal textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 5px;
        }

        .modal input[type="submit"] {
            background-color: #006400;
            color: #FFF;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal .close:hover,
        .modal .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <script>
        function deleteAnnouncement(id) {
            var confirmed = confirm('Are you sure you want to Hide this announcement?');
            if (confirmed) {
                window.location.href = '../admin-functions/delete_announcement.php?id=' + id;
            } else {
                // Do nothing
            }
        }

        function openEditModal(id) {
            var modal = document.getElementById('editModal');
            var closeBtn = modal.getElementsByClassName('close')[0];
            var form = modal.getElementsByTagName('form')[0];
            var titleInput = form.elements['title'];
            var contentInput = form.elements['content'];
            var idInput = form.elements['id'];

            // Set the form values with the announcement data
            titleInput.value = document.getElementById('title_' + id).textContent;
            contentInput.value = document.getElementById('content_' + id).textContent;
            idInput.value = id;

            modal.style.display = 'block';

            // Close the modal when the user clicks on the close button or outside the modal
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }

            // Submit the form on modal submit
            form.onsubmit = function(event) {
                event.preventDefault(); // Prevent form submission

                // Prepare the form data
                var formData = new FormData(form);
                formData.append('id', id);

                // Send an AJAX request to update_announcement.php
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../admin-functions/update_announcement.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        
                        alert(xhr.responseText); // Show the response message
                        modal.style.display = 'none'; // Close the modal
                    } else {
                        alert('Error: ' + xhr.statusText);
                    }
                };
                xhr.send(formData);
            };
        }
    </script>
</head>

<body>
<?php
include "../admin/sidebar/sidebar.php";
?>
    <div class="container-fluid content">
    
        <h2>Announcements</h2>
        
        <button class="btn btn-secondary"  onclick="window.location.href='../admin/archived-announcement.php'">Go to Archived</button>
       
        <hr>
        <div class="form-container">
            <h2>Create New Announcement</h2>
           
            <form method="post" action="../admin-functions/post_announcement.php" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                
                <label for="content">Content:</label>
                <div class="form-floating mb-5">
                <textarea id="content"style="min-height: 20vh" name="content" rows="1" required></textarea>
                </div>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <input class="btn btn-success" style="float:right;" type="submit" value="Post Announcement">
            </form>
        </div>

        <?php
        $query = "SELECT * FROM announcements WHERE status = 'posted' ORDER BY id DESC";

        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $postDate = $row['post_date'];
            $image = $row['image'];
        ?>
            <div class="announcement">
                <h2 id="title_<?php echo $id; ?>"><?php echo $title; ?></h2>
                <div class="action-btns">
                    <button onclick="openEditModal(<?php echo $id; ?>)">
                        <i class="bi bi-pencil-square"></i>Edit
                    </button>
                    <button onclick="deleteAnnouncement(<?php echo $id; ?>)">
                        <i class="bi bi-trash"></i>Archive
                    </button>
                </div>
                <p id="content_<?php echo $id; ?>"><?php echo $content; ?></p>
                <p>Posted on: <?php echo $postDate; ?></p>
                <img src="../images/<?php echo $image; ?>" alt="Announcement Image">
            </div>
        <?php
        }
        ?>

       <!-- Edit Modal -->
       <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Edit Announcement</h2>
                <form method="post" action="#" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit_id">
                    <label for="edit_title">Title:</label>
                    <input type="text" name="title" id="edit_title" required>
                    <label for="edit_content">Content:</label>
                    <textarea name="content" id="edit_content" required></textarea>
                    <input type="submit" value="Update Announcement">
                </form>
            </div>
        </div>


    </div>

    <script>
        // You can place this script at the end of the file instead if you prefer

        // Escape key press event to close the modal
        document.onkeydown = function(event) {
            var modal = document.getElementById('editModal');
            if (event.key === 'Escape' && modal.style.display === 'block') {
                modal.style.display = 'none';
            }
        }
        
    </script>
</body>
    <script src="sidebar/js/jquery.min.js"></script>
    <script src="sidebar/js/popper.js"></script>
    <script src="sidebar/js/bootstrap.min.js"></script>
    <script src="sidebar/js/main.js"></script>

</html>


