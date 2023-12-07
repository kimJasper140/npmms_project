<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #f5f5f5;
      z-index: 9999;
    }

    .loader-spinner {
      position: absolute;
      top: 40%;
      left: 45%;
      transform: translate(-50%, -50%);
      border: 8px solid #ccc;
      border-top: 8px solid #3498db;
      border-radius: 50%;
      width: 60px;
      height: 60px;
      animation: spin 1.2s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

    .hidden {
      display: none;
    }
  </style>
</head>

<body>
  <div id="loader">
    <div class="loader-spinner"></div>
  </div>

  <div id="content" class="hidden">
   
    <script>
      window.addEventListener('load', function () {
        const loader = document.getElementById('loader');
        const content = document.getElementById('content');

        // Simulate delay for demonstration purposes
        setTimeout(function () {
          loader.style.display = 'none';
          content.classList.remove('hidden');
        }, 500);
      });
    </script>
  </div>
</body>

