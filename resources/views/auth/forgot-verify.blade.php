<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Your Email</title>
  <link rel="stylesheet" href="{{ asset('css/verifyemail.css') }}">
</head>
<body>

  <div class="container">
    <div class="verify-box">
      <div class="icon-box">📧</div>

      <h2>Verify your email</h2>
      <p>Please enter the 6-digit code sent to <b>{{ $email ?? session('reset_email') }}</b>.</p>

      @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
      @endif

      <form method="POST" action="{{ route('password.verify') }}">
        @csrf
        <div class="code-inputs">
          @for ($i = 0; $i < 6; $i++)
            <input type="text" maxlength="1" name="code[]" class="code-input" required />
          @endfor
        </div>

        <button type="submit">Verify</button>
      </form>
<br>
      <a href="{{ route('password.request') }}" class="back-login">← Back</a>
    </div>
  </div>

  <script>
    // autoplace focus
    document.addEventListener('DOMContentLoaded', () => {
      const inputs = document.querySelectorAll('.code-input');
      inputs[0].focus();
      inputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
          if (input.value.length > 0 && idx < inputs.length -1) inputs[idx+1].focus();
        });
        input.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && input.value === '' && idx > 0) {
            inputs[idx-1].focus();
          }
        });
      });
    });
  </script>
</body>
</html>
