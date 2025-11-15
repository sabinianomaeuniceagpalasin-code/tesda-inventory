<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link rel="stylesheet" href="{{ asset('css/createaccount.css') }}">
</head>
<body>

  <div class="form-box">
    <h2>CREATE ACCOUNT</h2>

    <form id="createAccountForm" action="{{ route('register') }}" method="POST">
      @csrf
      <div class="section-title"><span>Personal Information</span></div>

      <div class="row">
        <div class="form-group">
          <label>Full Name:</label>
          <input type="text" name="full_name" placeholder="Enter full name" required>
        </div>
        <div class="form-group">
          <label>Contact No.:</label>
          <input type="text" name="contact_no" placeholder="Enter contact number" required>
        </div>
      </div>

      <div class="role">
        <label>Role:</label>
        <div class="role-options">
          <label><input type="radio" name="role" value="Property Custodian" required> Property Custodian</label>
          <label><input type="radio" name="role" value="Regular Employee" required> Regular Employee</label>
        </div>
      </div>

      <div class="section-title"><span>Login Details</span></div>

      <div class="form-group">
        <label>Email Address:</label>
        <input type="email" name="email" placeholder="Enter email address" required>
      </div>

      <div class="form-group">
        <label>Create Password:</label>
        <input type="password" name="password" placeholder="Enter password" required>
      </div>

      <div class="form-group">
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" placeholder="Confirm password" required>
      </div>

      <div class="buttons">
        <a href="{{ route('login') }}" class="btn btn-cancel">Cancel</a>
        <button type="submit" class="btn btn-signup">Sign Up</button>
      </div>
    </form>
  </div>

</body>
</html>
