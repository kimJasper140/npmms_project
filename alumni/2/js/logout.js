function logout() {
    // Prompt the user to confirm logout
    var confirmed = confirm("Are you sure you want to log out?");
  
    if (confirmed) {
      // If the user confirms, redirect to the logout page
      window.location.href = "logout.php";
    } else {
      // If the user cancels, do nothing
      return;
    }
  }
  