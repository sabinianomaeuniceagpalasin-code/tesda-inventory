<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESDA Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="{{ asset('images/Lingap.png') }}" alt="TESDA Logo">
    </div>
    <div class="right">
      <h2>Log in</h2>

      {{-- ✅ Laravel Login Form --}}
      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
          <label>Email:</label>
          <input type="email" name="email" placeholder="Enter your email..." value="{{ old('email') }}" required autofocus>
          @error('email')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>

        <div class="form-group">
          <label>Password:</label>
          <input type="password" name="password" placeholder="Enter your password..." required>
          @error('password')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>

        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

        <button class="btn" type="submit">Log in</button>

        <div class="register">
          {{-- ✅ Link to Create Account page --}}
          <a href="{{ route('create.account') }}">Create an account</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
