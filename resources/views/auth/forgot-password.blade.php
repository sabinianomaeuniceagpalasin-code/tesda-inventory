<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="{{ asset('css/forgotpassword.css') }}">
</head>
<body>

  <div class="container">
    <div class="forgot-box">
      <div class="icon-box">🔒</div>
      <h2>Forgot your password?</h2>

      @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
      @endif
      @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
      @endif

      <p>Please enter your email address to receive a verification code.</p>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email Address:</label>
        <input type="email" name="email" placeholder="e.g. user@email.com" required>
        <button type="submit">Send</button>
      </form>

      <a href="{{ route('login') }}" class="back-login">← Back to login</a>
    </div>
  </div>

</body>
</html>
