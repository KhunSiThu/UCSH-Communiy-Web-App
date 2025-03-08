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



const sound = document.getElementById("messNotificationSound");
const alertBox = document.getElementById("messCustomAlert");

let userInteracted = false; // Flag to track user interaction

document.addEventListener("click", () => {
    userInteracted = true;
});

document.addEventListener("DOMContentLoaded", async function() {
    await updateMessageCount();
    setInterval(updateMessageCount, 1000); // Check for new messages every second
});

document.getElementById("chatBoxBtn").addEventListener("click", async function() {
    let messageCount = await getMessageCount();
    sessionStorage.setItem("groupMessCounts", messageCount);
});

async function getMessageCount() {
    try {
        const response = await fetch("../Controller/getMessageCount.php");
        const data = await response.json();

        if (data.status === "success") {
            return data.message_count;
        } else {
            console.error("Error fetching messages:", data.message);
            return 0; // Default to 0 on error
        }
    } catch (error) {
        console.error("Fetch error:", error);
        return 0; // Default to 0 on fetch failure
    }
}

let i = 0;


async function updateMessageCount() {
    let newCount = await getMessageCount();
    let storedCount = parseInt(sessionStorage.getItem("messCounts")) || 0;


    if (newCount > storedCount) {
        let newMessages = newCount - storedCount;
        document.getElementById("messageCount").textContent = newMessages;
        document.getElementById("messageCount").classList.remove("hidden");

        if (userInteracted && newMessages > i) {
            await playMessNotificationSound();
            i = newMessages;
        }

    } else {

        document.getElementById("messageCount").classList.add("hidden");
    }


}

async function playMessNotificationSound() {
    
    try {
        await sound.play();

        // Show the custom alert
        
        alertBox.classList.remove("hidden");
        alertBox.style.opacity = "1"; // Ensure opacity is visible

        // Hide alert after 5 seconds
        setTimeout(() => {
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.classList.add("hidden");
            }, 500); // Delay to match fade-out animation
        }, 4000);

    } catch (error) {
        console.error("Error playing notification sound:", error);
    }
}

    document.addEventListener("DOMContentLoaded", async function() {
        // Initial message count check
        await updateGroupMessageCount();
        // Set an interval to check for new messages every second
        setInterval(updateGroupMessageCount, 1000);
    });

    // When the group button is clicked, store the message count in sessionStorage
    document.getElementById("groupBtn").addEventListener("click", async function() {
        let messageCount = await getGroupMessageCount();
        sessionStorage.setItem("groupMessCounts", messageCount);
    });

    // Function to get the current group message count from the server
    async function getGroupMessageCount() {
        try {
            const response = await fetch("../Controller/getGroupMessageCount.php");
            const data = await response.json();

            // Check for success or error response
            if (data.status === "success") {
                return data.message_count;
            } else {
                console.error("Error fetching messages:", data.message);
                return 0; // Default to 0 on error
            }
        } catch (error) {
            console.error("Fetch error:", error);
            return 0; // Default to 0 on fetch failure
        }
    }

    let k = 0; // Used to track previous new message count

    // Function to update the message count in the UI
    async function updateGroupMessageCount() {
        // Get the current message count from the server
        let newCount = await getGroupMessageCount();
        // Get the stored count from sessionStorage
        let storedCount = parseInt(sessionStorage.getItem("groupMessCounts")) || 0;

        // If the new count is greater than the stored count, show new messages
        if (newCount > storedCount) {
            let newMessages = newCount - storedCount;
            document.getElementById("groupMessageCount").textContent = newMessages;
            document.getElementById("groupMessageCount").classList.remove("hidden");

            // Check if user has interacted and play notification sound if necessary
            if (newMessages > k && userInteracted) {
                await playMessNotificationSound();
                k = newMessages; // Update k to the new message count
            }

        } else {
            // If no new messages, hide the count
            document.getElementById("groupMessageCount").classList.add("hidden");
        }
    }

    // Function to play the notification sound and show custom alert
    async function playMessNotificationSound() {
        
        try {
            await sound.play();

            // Show the custom alert
           
            alertBox.classList.remove("hidden");
            alertBox.style.opacity = "1"; // Ensure opacity is visible

            // Hide the alert after 5 seconds
            setTimeout(() => {
                alertBox.style.opacity = "0";
                setTimeout(() => {
                    alertBox.classList.add("hidden");
                }, 500); // Delay to match fade-out animation
            }, 4000);

        } catch (error) {
            console.error("Error playing notification sound:", error);
        }
    }




