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


// Message Notification



// Message Notification

const sound = document.getElementById("messNotificationSound");
const alertBox = document.getElementById("messCustomAlert");

let userInteracted = false; 


document.addEventListener("click", () => {
    userInteracted = true;
});

document.addEventListener("DOMContentLoaded", async function() {
    setInterval(updateMessageCount, 1000); // Check for new messages every second
    setInterval(updateGroupMessageCount, 1000);
});

document.getElementById("chatBoxBtn").addEventListener("click", async function() {
    let messageCount = await getMessageCount();
    sessionStorage.setItem("messCounts", messageCount);
});

document.getElementById("groupBtn").addEventListener("click", async function() {
    let messageCount = await getGroupMessageCount();
    sessionStorage.setItem("groupMessCounts", messageCount);
});

async function getMessageCount() {
    return await fetchMessageCount("../Controller/getMessageCount.php");
}

async function getGroupMessageCount() {
    return await fetchMessageCount("../Controller/getGroupMessageCount.php");
}

async function fetchMessageCount(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.status === "success") {
            return data.message_count;
        } else {
            console.error("Error fetching messages:", data.message);
            return 0;
        }
    } catch (error) {
        console.error("Fetch error:", error);
        return 0;
    }
}

let i = 0, k = 0;

async function updateMessageCount() {
    i = await updateCount("messageCount", "messCounts", getMessageCount, i);
}

async function updateGroupMessageCount() {
    k = await updateCount("groupMessageCount", "groupMessCounts", getGroupMessageCount, k);
}

async function updateCount(elementId, storageKey, fetchCount, counter) {
    let newCount = await fetchCount();
    let storedCount = parseInt(sessionStorage.getItem(storageKey)) || 0;

    if (newCount > storedCount) {
        let newMessages = newCount - storedCount;
        document.getElementById(elementId).textContent = newMessages;
        document.getElementById(elementId).classList.remove("hidden");

        if (userInteracted && newMessages > counter) {
            await playMessNotificationSound();
            return newMessages;
        }
    } else {
        document.getElementById(elementId).classList.add("hidden");
    }
    return counter;
}

async function playMessNotificationSound() {
    try {
 
        sound.play();
        alertBox.classList.remove("hidden");
        alertBox.style.opacity = "1";
        setTimeout(() => {
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.classList.add("hidden");
            }, 500);
        }, 4000);
    } catch (error) {
        console.error("Error playing notification sound:", error);
    }
}
