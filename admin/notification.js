// Check if the browser supports service workers and Push API
if ('serviceWorker' in navigator && 'PushManager' in window) {
  // Register a service worker
  navigator.serviceWorker.register('/service-worker.js')
    .then(function(registration) {
      console.log('Service Worker registered with scope:', registration.scope);

      // Request notification permission from the user
      return Notification.requestPermission();
    })
    .then(function(permissionResult) {
      if (permissionResult === 'granted') {
        console.log('Notification permission granted.');

        // Subscribe the user to push notifications
        return navigator.serviceWorker.ready.then(function(serviceWorkerRegistration) {
          return serviceWorkerRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: 'Your_Public_Key_From_VAPID'
          });
        });
      } else {
        console.log('Notification permission denied.');
      }
    })
    .then(function(subscription) {
      console.log('User is subscribed:', subscription.endpoint);
      // Send the subscription details to the server for future use
      // You'd typically send this subscription to your server for storing

      // Handle incoming push notifications
      self.addEventListener('push', function(event) {
        if (event.data) {
          const data = event.data.json();
          // Display the notification to the user
          self.registration.showNotification(data.title, {
            body: data.body,
            icon: 'path_to_icon/icon.png'
            // Additional options for notification can be added here
          });
        }
      });
    })
    .catch(function(error) {
      console.error('Service Worker registration failed:', error);
    });
} else {
  console.log('Push messaging is not supported.');
}
