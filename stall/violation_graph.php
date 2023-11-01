<!DOCTYPE html>
<html>
<head>
    <title>Graph Example</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 10px;
            padding: 0;

        }

        .announcement {
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
        }

        .violation-type {
            font-weight: bold;
            font-size: 18px;
        }

        .description {
            margin-top: 5px;
            font-size: 16px;
        }

        .violation-date {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .stall-number {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .appeal {
            margin-top: 10px;
            font-size: 16px;
        }

        .remarks {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }

        .remediation {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        @media screen and (max-width: 600px) {
            .announcement {
                max-width: 90%;
            }
            body{
                padding-top: 5%;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .modal-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .appeal-form textarea {
            width: 100%;
            height: 100px;
            resize: vertical;
        }

        .appeal-form input[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .appeal-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .appeal-form input[type="submit"]:focus {
            outline: none;
        }
	</style>
    <?php 
		session_start();
		include "../config/config.php";
		include "barpage/topbar.php";
		// Replace this with the correct session variable that holds the logged-in user's ID
		$loggedInUserId = $_SESSION['id'];
	?>
</head>
<body>
    <center><h1 style="margin-top: 70px;">Violation Graph</h1>
    <img src="generate_graph.php" alt="Generated Graph">
	</center>
</body>
</html>
