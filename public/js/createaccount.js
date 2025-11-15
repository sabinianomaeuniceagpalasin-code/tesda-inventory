form.addEventListener("submit", function (e) {
  // do NOT prevent default if valid
  document.querySelectorAll(".error").forEach(el => el.textContent = "");

  let isValid = true;

  const fullName = form.querySelector("[name='full_name']");
  const contact = form.querySelector("[name='contact_no']");
  const email = form.querySelector("[name='email']");
  const password = form.querySelector("[name='password']");
  const confirmPassword = form.querySelector("[name='password_confirmation']");
  const role = form.querySelector('input[name="role"]:checked');

  // validation checks
  if (fullName.value.trim() === "") {
    setError(fullName, "Full name is required");
    isValid = false;
  }

  if (contact.value.trim() === "" || !/^[0-9]{10,}$/.test(contact.value)) {
    setError(contact, "Enter a valid contact number (at least 10 digits)");
    isValid = false;
  }

  if (!role) {
    const roleError = document.querySelector(".role small");
    roleError.textContent = "Please select a role";
    isValid = false;
  }

  if (email.value.trim() === "" || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value)) {
    setError(email, "Enter a valid email address");
    isValid = false;
  }

  if (password.value.length < 6) {
    setError(password, "Password must be at least 6 characters long");
    isValid = false;
  }

  if (confirmPassword.value !== password.value) {
    setError(confirmPassword, "Passwords do not match");
    isValid = false;
  }

  // ✅ If valid, let the form submit normally to Laravel
  if (!isValid) {
    e.preventDefault();
  }
});
