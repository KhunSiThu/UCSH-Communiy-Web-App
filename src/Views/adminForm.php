<?php require_once "../Components/header.php"; ?>

<div class="bg-white dark:bg-gray-900">
    <!-- Admin Login Section -->
    <div class="index login flex w-screen h-screen justify-center items-center">
        <div class="flex flex-col min-w-full justify-center p-10 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm flex flex-col justify-center items-center">
                <!-- Admin Login Title -->
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight dark:text-gray-100 text-gray-900">
                    Admin Login
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Access the admin dashboard securely.
                </p>
            </div>

            <!-- Login Form -->
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="../Controller/adminLogin.php" method="POST" id="login-form">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm/6 font-medium dark:text-gray-100 text-gray-900">Admin Email</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base dark:text-gray-100 text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                placeholder="Enter your admin email" />
                        </div>
                        <div id="email-error" class="text-sm text-red-500 mt-2"></div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Password</label>
                        <div class="mt-2 relative">
                            <input type="password" name="password" id="password" required
                                class="block w-full rounded-md bg-white dark:bg-gray-700 p-3 text-base text-gray-900 dark:text-gray-100 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                placeholder="Enter your password" />
                            <i class="eye-icon fa-regular fa-eye-slash absolute right-3 top-4 cursor-pointer dark:text-gray-100"></i>
                        </div>
                        <div id="password-error" class="text-sm text-red-500 mt-2"></div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button type="submit" id="login-btn"
                            class="flex w-full justify-center rounded-md bg-indigo-600 p-3 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Login
                        </button>
                    </div>
                </form>

                <!-- Forgot Password Link -->
                <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle Button -->
    <button id="theme-toggle" type="button" class="bg-white outline-none p-2 dark:bg-gray-900 fixed bottom-3 left-3 rounded-md">
        <i id="theme-icon" class="fa-solid fa-moon text-gray-800 dark:text-gray-100"></i>
    </button>
</div>

<?php require_once '../Components/footer.php'; ?>

<script>
    // Dark Mode Toggle
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

    // Toggle Password Visibility
    document.addEventListener("DOMContentLoaded", function() {
        const eyeIcon = document.querySelector('.eye-icon');
        const passwordField = document.getElementById('password');

        eyeIcon.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });

        // Admin Login Form Submission
        document.getElementById("login-form").addEventListener("submit", function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const emailError = document.getElementById("email-error");
            const passwordError = document.getElementById("password-error");

            emailError.textContent = "";
            passwordError.textContent = "";

            fetch("../Controller/adminLogin.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = './AdminDashboard.php'; // Redirect to admin dashboard
                    } else {
                        if (data.message === "Invalid email.") {
                            emailError.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message}`;
                        } else if (data.message === "Incorrect password.") {
                            passwordError.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${data.message}`;
                        } else {
                            alert("An error occurred. Please try again.");
                        }
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
</script>