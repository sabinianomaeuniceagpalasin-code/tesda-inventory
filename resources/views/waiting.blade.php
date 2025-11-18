<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending</title>
    <link rel="stylesheet" href="{{ asset('css/waiting.css') }}">
</head>
<body>
    <div class="approval-box">
        <h2>Your account is pending approval.</h2>
        <p>{{ session('error') ?? 'Your account has been successfully verified. It is now pending review and approval 
      from the system administrator. This process ensures that only authorized users are 
      granted access to the TESDA Inventory System. You will receive a notification 
      once your account has been approved and activated.' }}</p>

        <div class="back-login">
            <a href="{{ route('login') }}">
                <button class="back-link">Back to Login</button>
            </a>
        </div>
    </div>
</body>
</html>