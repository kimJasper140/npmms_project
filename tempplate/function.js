function logout() {
	var result = confirm("Are you sure you want to logout?");

	if (result) {
		window.location.href = "logout.php";
	} else {
		// User cancelled logout, do nothing
	}
}