<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verification</title>
  <link rel="stylesheet" href="{{ asset('css/verification.css') }}">
</head>
<body>

  <div class="verify-box">
    <h2>VERIFICATION</h2>
    <p>
      A 6-digit verification code has been sent to your registered email
      <b>"{{ session('email') }}"</b>. Please enter the code below to confirm your identity.
    </p>

    <form action="{{ route('verify.code') }}" method="POST">
      @csrf
      <input type="hidden" name="email" value="{{ session('email') }}">

      <div class="code-container" id="codeContainer">
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
        <input type="text" maxlength="1" name="code[]" class="code-input" required />
      </div>

      <button class="btn-verify" type="submit">Verify</button>

      @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
      @endif
      @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
      @endif
    </form>
  </div>

  <script>
    const inputs = document.querySelectorAll(".code-input");
    inputs.forEach((input, index) => {
      input.addEventListener("input", () => {
        if (input.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });
      input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && input.value === "" && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });
  </script>

</body>
</html>
