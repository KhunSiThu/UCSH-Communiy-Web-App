const themeToggleBtn = document.getElementById('theme-toggle');
const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');


if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
    themeToggleLightIcon.classList.remove('hidden');
    themeToggleDarkIcon.classList.add('hidden');
} else {
    document.documentElement.classList.remove('dark');
    themeToggleLightIcon.classList.add('hidden');
    themeToggleDarkIcon.classList.remove('hidden');
}

themeToggleBtn.addEventListener('click', function () {
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
    }
});


// Open Logout Modal
function openLogoutModal() {
    document.getElementById("logoutModal").classList.remove("hidden");
}

// Close Logout Modal
function closeLogoutModal() {
    document.getElementById("logoutModal").classList.add("hidden");
}

// Logout Logic
document.getElementById("confirmLogout").addEventListener("click", () => {
    localStorage.clear();
    localStorage.setItem('color-theme', 'light');

    fetch("../Controller/logout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sessionStorage.clear();
            window.location.href = "../../Public/index.php"; // Redirect after logout
        } else {
            alert("Logout failed: " + data.error);
        }
    })
    .catch(error => {
        console.error("Error during logout:", error);
    });
});


// moblie Light and Dark
document.addEventListener("DOMContentLoaded", function () {
    const themeSwitch = document.querySelector("#theme-switch");
    const htmlElement = document.documentElement;

    // Check and apply saved theme
    if (localStorage.getItem("color-theme") === "dark") {
        htmlElement.classList.add("dark");
        themeSwitch.checked = true;
    }

    // Toggle theme when switch is clicked
    themeSwitch.addEventListener("change", function () {
        if (themeSwitch.checked) {
            htmlElement.classList.add("dark");
            localStorage.setItem("color-theme", "dark");
        } else {
            htmlElement.classList.remove("dark");
            localStorage.setItem("color-theme", "light");
        }
    });


});