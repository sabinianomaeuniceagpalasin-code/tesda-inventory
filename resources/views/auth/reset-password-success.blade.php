<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset Success</title>
  <link rel="stylesheet" href="{{ asset('css/reset-success.css') }}">
</head>
<body>
  <div class="container">
    <img src="https://cdn-icons-png.flaticon.com/512/992/992703.png" alt="Success Icon">
    <p>Your password has been reset</p>
    <h2>Successfully</h2>
    <br>
    <br>
    <a class="btn" href="{{ route('login') }}">Back to login</a>
  </div>
</body>
</html>
