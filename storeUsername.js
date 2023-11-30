document.addEventListener("DOMContentLoaded", function () {
    // Check if the form is present
    var loginForm = document.querySelector('form');

    if (loginForm) {
        // Add event listener to the form submit
        loginForm.addEventListener('submit', function (event) {
            // Get the entered username
            var enteredUsername = document.getElementById('username').value;

            // Store the username in local storage
            localStorage.setItem('enteredUsername', enteredUsername);
        });
    }
});