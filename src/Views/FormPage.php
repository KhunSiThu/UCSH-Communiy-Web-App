<?php require_once "../Components/header.php"; ?>


<div class="bg-white dark:bg-gray-900">
    <!-- Sign Up -->
    <div class="index signUp flex w-screen h-screen justify-center items-center ">
        <div class="flex flex-col min-w-full justify-center p-10 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm flex flex-col justify-center items-center" id="desktop">
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight  dark:text-gray-100 text-gray-900">
                    Sign up for your account
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="../Controller/signUp.php" method="POST" id="signup-form">
                    <div>
                        <label for="fullName" class="block text-sm/6 font-medium dark:text-gray-100 text-gray-900">Full Name</label>
                        <div class="mt-2">
                            <input type="text" name="name" id="fullName" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm/6 font-medium dark:text-gray-100 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input type="text" name="email" id="email" autocomplete="email" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        </div>
                        <div id="email-criteria" class="text-sm text-gray-600 mt-2">
                            <span id="email-message" class="text-red-500"></span>
                        </div>
                    </div>

                    <div>
                        <label for="password1" class="block text-sm font-medium dark:text-gray-100 text-gray-900">Create Password</label>
                        <div class="mt-2 pass-con relative">
                            <input type="password" name="password" id="password1" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            <i class="eye-icon1 fa-regular fa-eye-slash absolute right-3 top-4 cursor-pointer"></i>
                        </div>

                        <!-- Password Strength Criteria for password1 -->
                        <div id="password1-criteria" class="text-sm text-gray-600 mt-2">
                            <span id="password1-message" class="text-red-500"></span>
                        </div>
                    </div>

                    <div>
                        <label for="password2" class="block text-sm font-medium dark:text-gray-100 text-gray-900">Confirm Password</label>
                        <div class="mt-2 pass-con relative">
                            <input type="password" name="password2" id="password2" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            <i class="eye-icon2 fa-regular fa-eye-slash absolute right-3 top-4 cursor-pointer"></i>
                        </div>

                        <!-- Password Match Check for password2 -->
                        <div id="password2-criteria" class="text-sm text-gray-600 mt-2">
                            <span id="password2-message" class="text-red-500"></span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" id="submit-btn" class="flex w-1/3 mt-4 justify-center rounded-md bg-indigo-600 p-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Sign Up
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm/6 text-gray-500">
                    Already have an account?
                    <button type="button" id="login-link" class="login-link font-semibold text-indigo-600 hover:text-indigo-500">Login</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Login -->
    <div class="index login flex w-screen h-screen justify-center items-center ">
        <div class="flex flex-col min-w-full justify-center p-10 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm flex flex-col justify-center items-center">

                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight dark:text-gray-100 text-gray-900">
                    Sign in to your account
                </h2>
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="../Controller/login.php" method="POST" id="login-form">
                    <div>
                        <label for="email" class="block text-sm/6 font-medium dark:text-gray-100 text-gray-900">User Name or Email</label>
                        <div class="mt-2">
                            <input type="text" name="email" id="email1"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                        </div>
                        <div id="password2-criteria" class="text-sm text-gray-600 mt-2">
                            <span id="emailError" class="text-red-500"></span>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <div class="mt-2 relative">
                            <input type="password" name="password" id="password"
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                            <i class="eye-icon fa-regular fa-eye-slash absolute right-3 top-4 cursor-pointer"></i>
                        </div>
                        <div id="password2-criteria" class="text-sm text-gray-600 mt-2">
                            <span id="passwordError" class="text-red-500"></span>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" id="login-btn"
                            class="flex w-1/3 justify-center rounded-md bg-indigo-600 p-3 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Sign In
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center  text-sm/6 text-gray-500">
                    Don't have an account?
                    <button type="button" id="signup-link" class="signUp-link font-semibold text-indigo-600 hover:text-indigo-500">Sign Up</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle Button -->
    <button id="theme-toggle" type="button" class=" bg-white outline-none p-2 dark:bg-gray-900 fixed bottom-3 left-3 rounded-md">
        <i id="theme-icon" class="fa-solid fa-moon text-gray-800 dark:text-gray-100"></i>
    </button>

</div>

<?php require_once '../Components/footer.php'; ?>

<script>
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    function setTheme(mode) {
        if (mode === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    // Load theme from local storage
    const savedTheme = localStorage.getItem('color-theme') || 'light';
    setTheme(savedTheme);

    themeToggle.addEventListener('click', () => {
        if (document.documentElement.classList.contains('dark')) {
            setTheme('light');
        } else {
            setTheme('dark');
        }
    });



    document.addEventListener("DOMContentLoaded", function() {
        const signUpSection = document.querySelector('.signUp');
        const loginSection = document.querySelector('.login');
        const loginLink = document.getElementById('login-link');
        const signupLink = document.getElementById('signup-link');

        // Hide the Login section by default
        loginSection.style.display = 'none';

        // Add event listeners to toggle between sections
        loginLink.addEventListener('click', () => {
            signUpSection.style.display = 'none';
            loginSection.style.display = 'flex';
        });

        signupLink.addEventListener('click', () => {
            loginSection.style.display = 'none';
            signUpSection.style.display = 'flex';
        });

        // Toggle password visibility
        document.querySelector('.eye-icon1').addEventListener('click', function() {
            const passwordField = document.getElementById('password1');
            togglePasswordVisibility(passwordField, this);
        });

        document.querySelector('.eye-icon2').addEventListener('click', function() {
            const passwordField = document.getElementById('password2');
            togglePasswordVisibility(passwordField, this);
        });

        document.querySelector('.eye-icon').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            togglePasswordVisibility(passwordField, this);
        });

        function togglePasswordVisibility(passwordField, icon) {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        // Password Validation
        const password1 = document.getElementById("password1");
        const password2 = document.getElementById("password2");
        const password1Message = document.getElementById("password1-message");
        const password2Message = document.getElementById("password2-message");
        const submitBtn = document.getElementById("submit-btn");

        const fullName = document.getElementById("fullName");
        const email = document.getElementById("email");

        const emailMessage = document.getElementById("email-message");


        function validatePasswords() {
            const pass1 = password1.value;
            const pass2 = password2.value;
            let isValid = true;
            let errorMessage = "";

            // Password Criteria
            if (pass1.length < 8) {
                errorMessage = `<i class="fas fa-exclamation-circle text-red-500"></i> Password must be at least 8 characters.`;
            } else if (!/[A-Z]/.test(pass1)) {
                errorMessage = `<i class="fas fa-exclamation-circle text-red-500"></i> Password must contain at least one uppercase letter.`;
            } else if (!/[a-z]/.test(pass1)) {
                errorMessage = `<i class="fas fa-exclamation-circle text-red-500"></i> Password must contain at least one lowercase letter.`;
            } else if (!/\d/.test(pass1)) {
                errorMessage = `<i class="fas fa-exclamation-circle text-red-500"></i> Password must contain at least one number.`;
            } else if (!/[\W_]/.test(pass1)) {
                errorMessage = `<i class="fas fa-exclamation-circle text-red-500"></i> Password must contain at least one special character.`;
            } else {
                errorMessage = `<i class="fas fa-check-circle text-green-500"></i> <span class="text-green-500">Strong password</span>`;
            }

            password1Message.innerHTML = errorMessage;
            isValid = errorMessage.includes("fa-check-circle");

            // Password Match Check
            if (isValid && pass1 !== pass2) {
                password2Message.innerHTML = `<i class="fas fa-exclamation-circle text-red-500"></i> Passwords do not match.`;
                isValid = false;
            } else {
                password2Message.innerHTML = "";
            }

            // Enable/Disable Submit Button
            submitBtn.disabled = !isValid;
        }

        // Add event listeners
        password1.addEventListener("input", validatePasswords);
        password2.addEventListener("input", validatePasswords);

        document.getElementById("login-form").addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const emailError = document.getElementById("emailError");
            const passwordError = document.getElementById("passwordError");

            emailError.textContent = "";
            passwordError.textContent = "";

            fetch("../Controller/loginUser.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = './UploadProfilePage.php';
                    } else {
                        if (data.message === "User not found!") {
                            emailError.innerHTML = `<i class="fas fa-exclamation-circle text-red-500"></i> User not found!`;
                        } else if (data.message === "Incorrect password.") {
                            passwordError.innerHTML = `<i class="fas fa-exclamation-circle text-red-500"></i> Incorrect password.`;
                        }
                    }
                })
                .catch(error => console.error("Error:", error));
        });


        document.getElementById("signup-form").addEventListener("submit", function(event) {
            event.preventDefault();

            if (!validateInputFields()) {
                return;
            }

            const formData = new FormData(this);

            fetch("../Controller/registerUser.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        signUpSection.style.display = 'none';
                        loginSection.style.display = 'flex';
                    } else {
                        if (!data.success) {
                            emailMessage.innerText = data.message;
                            email.classList.add("border-red-500");
                            email.focus();
                            return false;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error with the request. Please try again.');
                });
        });

        function validateInputFields() {
            if (fullName.value.trim() === "") {
                fullName.focus();
                return false;
            }

            if (email.value.trim() === "") {
                emailMessage.innerText = "Email field is required.";
                email.classList.add("border-red-500");
                email.focus();
                return false;
            }

            if (!validateEmail(email.value.trim())) {
                emailMessage.innerText = "Please enter a valid UCS Hpa-An email (e.g., example@ucshpaan.edu.mm).";
                email.classList.add("border-red-500");
                email.focus();
                return false;
            } else {
                emailMessage.innerText = "";
                email.classList.remove("border-red-500");
            }

            if (password1.value.trim() === "") {
                password1.focus();
                return false;
            }

            if (password2.value.trim() === "") {
                password2.focus();
                return false;
            }

            return true;
        }

        function validateEmail(email) {
            const emailRegex = /^[a-zA-Z0-9]+@ucshpaan\.edu\.mm$/;
            return emailRegex.test(email);
        }
    });
</script>