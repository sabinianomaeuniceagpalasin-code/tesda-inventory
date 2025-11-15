<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create New Password</title>
  <link rel="stylesheet" href="{{ asset('css/create-new-password.css') }}">
</head>
<body>
  <div class="container">
    <div class="box">
      <div class="icon">🔒</div>
      <h2>Create new password</h2>
      <p>Your new password must be different from previously used passwords</p>

      @if($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
      @endif

      <form method="POST" action="{{ route('password.reset') }}">
  @csrf
  <input type="password" name="password" placeholder="New password" required />
  <input type="password" name="password_confirmation" placeholder="Confirm password" required />
  <button type="submit">Save</button>
</form>
<br>
      <a href="{{ route('login') }}" class="back-login">← Back to login</a>
    </div>
  </div>
</body>
</html>
