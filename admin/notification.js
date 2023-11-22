function showNotification() {
  if (!("Notification" in window)) {
    console.log("This browser does not support system notifications");
  } else {
    Notification.requestPermission().then(function (permission) {
      if (permission === "granted") {
        var notification = new Notification("Hello, World!", {
          body: "This is an example notification.",
          icon: "path/to/icon.png"
        });

        notification.onclick = function () {
          console.log("Notification clicked");
          // You can add actions to perform when the notification is clicked
        };
      } else {
        console.log("Permission for notifications denied");
      }
    });
  }
}
