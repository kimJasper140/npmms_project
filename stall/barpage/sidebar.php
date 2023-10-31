<style>
      
        .sidebar {
            width: 200px;
            padding: 20px;
            background: #299B63;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #f2f2f2;
        }
</style>
<div class="sidebar">
            <ul>
            <li><a href="profile.php"><i class="fas fa-store"></i>Profile</a></li>
            <li><a href="transactions.php"><i class="fas fa-shopping-cart"></i>Transaction</a></li>
                <li><a href="violation.php"><i class="fas fa-exclamation-triangle"></i>Stall Violation</a></li>
                <li><a href="notification.php"><i class="fas fa-bell"></i>Notification</a></li>
                <li><a href="maintainance.php"><i class="fas fa-chart-bar"></i>Maintenance Reports</a></li>
                <li><a href="feedback.php"><i class="fas fa-comment"></i>Feedback</a></li>
                <li><a href="profile-setting.php"><i class="fas fa-cog"></i>Account Settings</a></li>
                <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
