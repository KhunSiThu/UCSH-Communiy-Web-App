<?php require_once "../Components/header.php";

require_once("../Controller/dbConnect.php");
session_start();

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM user WHERE userId = '$userId'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);

    if (!empty($userData['profileImage'])) {
        header("Location: ./MainPage.php");
        exit;
    }
?>

    <div class="relative min-h-screen bg-gray-50">

        <!-- Main Content Below Fixed Policy -->
        <div class="flex justify-center items-center min-h-screen bg-gray-50">
            <div class="w-full max-w-lg p-8 sm:p-10">
                <!-- Title Section -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl text-blue-500 sm:text-4xl font-semibold">Update Profile Picture</h2>
                    <p class="text-sm text-gray-500 my-2">Please upload a profile picture to continue.</p>
                </div>

                <!-- Profile Image Upload Section -->
                <form class="space-y-6" id="upload-form">
                    <!-- Profile Image Preview -->
                    <div class="flex justify-center mb-6">
                        <label for="profile-image" class="cursor-pointer">
                            <div class="w-40 h-40 md:h-60 md:w-60 flex justify-center items-center overflow-hidden bg-gray-200">
                                <img id="profile-preview" src="https://cdn-icons-png.flaticon.com/512/4211/4211763.png"
                                    alt="Default Profile"
                                    class="w-full h-full object-cover p-10 opacity-40 hover:opacity-100 border-dashed border-4 border-gray-400" />
                            </div>
                        </label>
                        <input type="file" id="profile-image" accept="image/*" class="hidden" />
                    </div>

                    <!-- Displaying User's Name -->
                    <div class="mb-6 text-center">
                        <p class="text-lg font-medium text-gray-700"><?=$userData['name']?></p>
                    </div>

                    <!-- Upload Button (Disabled if no image) -->
                    <div class="text-center">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-blue-400 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none transition duration-300"
                            id="upload-button" disabled>
                            Upload Profile Picture
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php }
require_once '../Components/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const profileImageInput = document.getElementById("profile-image");
        const profilePreview = document.getElementById("profile-preview");
        const uploadButton = document.getElementById("upload-button");
        const form = document.getElementById("upload-form");

        // Function to preview the selected image
        profileImageInput.addEventListener("change", function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;
                    profilePreview.classList.remove("opacity-40", "p-10");
                    profilePreview.classList.add("opacity-100");
                    uploadButton.disabled = false; // Enable upload button
                };
                reader.readAsDataURL(file);
            } else {
                resetPreview();
            }
        });

        // Reset to default image
        function resetPreview() {
            profilePreview.src = "https://cdn-icons-png.flaticon.com/512/4211/4211763.png";
            profilePreview.classList.add("opacity-40", "p-10");
            profilePreview.classList.remove("opacity-100");
            uploadButton.disabled = true;
        }

        form.addEventListener("submit", function(event) {
            event.preventDefault();

            const file = profileImageInput.files[0];
            if (!file) {
                alert("Please select an image to upload.");
                return;
            }

            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert("File size exceeds the limit of 5MB.");
                return;
            }

            const formData = new FormData();
            formData.append("profileImage", file);

            fetch("../Controller/uploadProfile.php", {
                    method: "POST",
                    body: formData,
                })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        window.location.href = "./UploadProfilePage.php"
                        // alert("Profile image uploaded successfully!");
                    } else {
                        alert("Upload failed: " + data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred: " + error.message);
                });
        });

    });
</script>