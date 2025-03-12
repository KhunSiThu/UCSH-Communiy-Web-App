<!-- Updated Sticky Header -->
<div class="w-full flex items-center justify-between sticky top-0 left-0 z-40 md:h-20 h-16 bg-slate-100/90 dark:bg-slate-950/90 shadow-lg md:px-6 px-2 py-4 backdrop-blur-md">
    <!-- Sidebar Toggle Button -->
    <div class="md:hidden block">
        <button type="button" onclick="openMobileSideBar()" class="inline-flex items-center p-2 text-gray-500 rounded-md bg-gray-200 dark:text-gray-400 dark:bg-gray-800 transition-all focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
            <svg class="md:size-6 size-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
    </div>


    <!-- Search Form -->
    <form id="search-form" class="md:w-2/6 w-4/6 flex">
        <div class="relative w-full md:h-11 h-9 flex items-center bg-gray-100 dark:bg-gray-800 rounded-md border border-gray-300 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all">
            <input name="searchText" type="search" id="searchPostsText" class="md:px-4 px-2 w-full h-full small md:text-sm text-gray-900 dark:text-white bg-transparent border-none rounded-l-md" placeholder="Search posts by title or friend name ..." required />
            <button id="searchPostsBtn" type="submit" class="md:w-12 w-8 h-full flex items-center justify-center rounded-r-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                <svg class="size-3 md:size-4 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Navigation Menu -->

    <ul id="filterPosts" class="md:flex hidden filterPosts w-2/6 items-center justify-center space-x-6">
        <li><button id="1filterBtnall" class="all px-4 py-2 focus:outline-none  hover:text-blue-600  transition-all">All</button></li>
        <li><button id="1filterBtnpost" class="posts px-4 py-2 focus:outline-none  hover:text-blue-600  transition-all">Posts</button></li>
        <li><button id="1filterBtnvideo" class="videos px-4 py-2 focus:outline-none  hover:text-blue-600  transition-all">Videos</button></li>
        <li><button id="1filterBtndoc" class="docs px-4 py-2 focus:outline-none  hover:text-blue-600  transition-all">Documents</button></li>
    </ul>



    <!-- Notification Button -->
    <div id="notiBtn" class="relative hs-tooltip [--placement:right] inline-block">
        <a id="dropdownUsersButton" data-dropdown-toggle="dropdownUsers" data-dropdown-placement="bottom"
            class="hs-tooltip-toggle p-2 inline-flex justify-start items-center gap-x-2 text-xl font-semibold rounded-md border border-transparent text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 focus:outline-none focus:bg-blue-400 focus:text-white dark:focus:bg-blue-400 disabled:opacity-50 cursor-pointer">
            <i id="notiIcon" class="fa-solid fa-bell"></i>
            <div id="notiCount"
                class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full -top-2 -end-1.5 dark:border-gray-900 hidden">
                0
            </div>
        </a>

        <!-- Dropdown Menu -->
        <div id="dropdownUsers"
            class="z-10 hidden bg-white rounded-lg shadow-lg w-72 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">

            <!-- Header -->
            <div class="flex justify-between items-center px-4 py-3 border-b dark:border-gray-600">
                <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Notifications</h2>
            </div>

            <!-- Notifications Section -->
            <div class="p-3">
                <!-- Likes on Your Posts -->
                <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">Recent Activity on Your Posts</h3>
                <ul id="likesList" class="max-h-40 overflow-y-auto">
                    <li class="text-gray-500 text-sm italic">Your posts haven't received any likes yet. Keep sharing great content!</li>
                </ul>

                <!-- Admin Deleted Your Posts -->
                <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-400 my-2">Post Moderation</h3>
                <ul id="deletedPostList" class="max-h-40 overflow-y-auto">
                    <li class="text-gray-500 text-sm italic">No posts have been removed by the admin. Keep following the guidelines!</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.getElementById('dropdownUsersButton').addEventListener('click', async function(event) {
            event.preventDefault();
            document.getElementById('dropdownUsers').classList.toggle('hidden');
            let notiCounts = await fetchUserNotis();
            sessionStorage.setItem("notiCounts", notiCounts);
        });

        function updateNotificationCount(count) {
            const notiCountElement = document.getElementById('notiCount');
            notiCountElement.textContent = count;
            notiCountElement.classList.toggle('hidden', count === 0);
        }

        let j = 0;

        async function fetchUserNotis() {
            try {
                const response = await fetch('../Controller/getUserPostLikes.php');
                const data = await response.json();

                const response1 = await fetch('../Controller/getAdminDeletedPost.php');
                const data1 = await response1.json();

                const deletedPostList = document.getElementById('deletedPostList');
                deletedPostList.innerHTML = '';

                if (data1.error) {
                    deletedPostList.innerHTML = `<li class="text-red-500 text-sm italic">${data1.error}</li>`;
                    updateNotificationCount(0);
                    return;
                }

                if (data1.length === 0) {
                    deletedPostList.innerHTML = '<li class="text-gray-500 text-sm italic">No delete Posts yet.</li>';
                } else {
                    data1.forEach(user => {
                        // Convert timestamp to readable format
                        const formattedDate = user.deleted_at ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            }).format(new Date(user.deleted_at)) :
                            'Unknown Date';

                            deletedPostList.innerHTML += `
                            <li>
                                <a href="#Post${user.post_id}" class="px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 block">
                                    <!-- Admin Info -->
                                    <div class="text-sm text-gray-700 dark:text-gray-200 flex items-center gap-2">
                                        <div class="flex items-center gap-2">
                                            <img class="w-8 h-8 rounded-full border border-blue-300" 
                                                src="https://cdn-icons-png.flaticon.com/512/4201/4201973.png" 
                                                alt="${user.name}">
                                            <h3 class="font-medium">Admin</h3>
                                        </div>
                                        <time class="text-xs text-gray-500">${formattedDate}</time>
                                    </div>

                                    <!-- Reason for Deletion -->
                                    <div class="mt-1">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            <span class="font-semibold">Reason:</span> ${user.reason}
                                        </p>
                                    </div>
                                </a>
                            </li>
                        `;
                    });
                }




                const likesList = document.getElementById('likesList');
                likesList.innerHTML = '';

                if (data.error) {
                    likesList.innerHTML = `<li class="text-red-500 text-sm italic">${data.error}</li>`;
                    updateNotificationCount(0);
                    return;
                }

                if (data.length === 0) {
                    likesList.innerHTML = '<li class="text-gray-500 text-sm italic">No likes yet.</li>';
                } else {
                    data.forEach(user => {
                        // Convert timestamp to readable format
                        const formattedDate = user.createdAt ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            }).format(new Date(user.createdAt)) :
                            'Unknown Date';

                        likesList.innerHTML += `
                    <li>
                        <a href="#Post${user.post_id}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                            <img class="w-8 h-8 rounded-full" src="../uploads/profiles/${user.profileImage || 'default.png'}" alt="${user.name}">
                            <div class="text-sm text-gray-700 dark:text-gray-200">
                            <h3>${user.name}</h3>
                            <time class="text-xs text-gray-500 so-small">${formattedDate}</time>
                            </div>

                        </a>
                    </li>
                `;
                    });
                }

                async function playNotificationSound() {
                    const sound = document.getElementById("notificationSound");
                    try {
                        await sound.play();

                        // Show the custom alert
                        const notiIcon = document.getElementById("notiIcon");
                        notiIcon.classList.add("fa-shake");

                        // Hide alert after 5 seconds
                        setTimeout(() => {
                            notiIcon.classList.remove("fa-shake");
                        }, 4000);

                    } catch (error) {
                        console.error("Error playing notification sound:", error);
                    }
                }

                let notiCounts = sessionStorage.getItem("notiCounts");

                let totalLength = data.length + data1.length;

                if (notiCounts < totalLength) {
                    let likes = totalLength - notiCounts;
                    updateNotificationCount(likes);

                    if (userInteracted && totalLength > j) {
                        await playNotificationSound();
                        j = totalLength;
                    }
                } else {
                    updateNotificationCount(0);
                }

                return totalLength;

            } catch (error) {
                console.error('Error fetching likes:', error);
            }
        }

        // Fetch likes initially when the page loads
        setInterval(fetchUserNotis, 500);
    </script>


</div>

<!-- User Profile -->
<div id="userProfileShowCon" class="hidden w-full overflow-auto relative bg-white text-gray-900 dark:bg-gray-900 dark:text-white scroll-none">

    <!-- Banner Section -->
    <section class="relative block h-48 sm:h-64 md:h-80 lg:h-96 bg-slate-300 dark:bg-gray-950">
        <img alt="cover"
            src="<?= !empty($userData['coverImage']) ? "../uploads/covers/" . $userData['coverImage'] : "https://www.pixelstalk.net/wp-content/uploads/images6/Aesthetic-Minimalist-Wallpaper-Paper-Airplanes.png" ?>"
            class="w-full h-full object-cover">
    </section>

    <!-- Profile Info Section -->
    <div class="relative md:flex-row flex flex-col items-center bg-slate-100 dark:bg-gray-800 w-full">
        <div class="p-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between w-full items-center">
            <!-- Profile Picture and Details -->
            <div class="flex flex-col sm:flex-row items-center justify-center ">
                <div class="md:relative absolute -top-20">
                    <button onclick="showProfileImageChangeModal()" class="md:w-12 md:h-12 w-8 h-8 flex justify-center items-center text-white rounded-full bg-black/95 absolute right-0 bottom-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="md:size-6 size-4">
                            <path d="M12 9a3.75 3.75 0 1 0 0 7.5A3.75 3.75 0 0 0 12 9Z" />
                            <path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 0 1 5.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 0 1-3 3h-15a3 3 0 0 1-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 0 0 1.11-.71l.822-1.315a2.942 2.942 0 0 1 2.332-1.39ZM6.75 12.75a5.25 5.25 0 1 1 10.5 0 5.25 5.25 0 0 1-10.5 0Zm12-1.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <img alt="Profile" src="../uploads/profiles/<?= $userData['profileImage'] ?>" class="border-2 p-1 border-blue-400 bg-black/40  h-36 w-36 md:h-48 md:w-48 rounded-full object-cover">
                </div>
                <div class="relative md:ml-1 mt-16 md:mt-0 sm:ml-6 lg:ml-10  flex flex-col justify-center">
                    <h3 class="text-xl sm:text-2xl text-center md:text-start  lg:text-3xl font-semibold text-gray-700 dark:text-gray-300">
                        <?= $userData['name'] ?>
                        <small class="text-xs opacity-80">
                            <?php
                            if ($userData['role']) {
                                echo "(" . $userData['role'] . ")";
                            }

                            ?>
                        </small>
                    </h3>
                    <span class="text-xs text-center md:text-start opacity-40"><?= $userData['email'] ?></span>
                    <ul class="text-sm mt-3 opacity-90 text-center md:block grid grid-cols-2 gap-1 items-center justify-between">
                        <?php if ($userData['year']) { ?>
                            <li class="flex items-center space-x-1">
                                <span>Year : <b><?= $userData['year'] ?> Year</b></span>
                            </li>
                        <?php } ?>
                        <?php if ($userData['rollNo']) { ?>
                            <li class="flex items-center space-x-1 md:mt-2">
                                <span>Roll No : <b><?= $userData['rollNo'] ?></b></span>
                            </li>
                        <?php } ?>
                        <?php if ($userData['address']) { ?>
                            <li class="flex items-center space-x-1 md:mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                <span><?= $userData['address'] ?> City</span>
                            </li>
                        <?php } ?>
                        <?php if ($userData['phoneNo']) { ?>
                            <li class="flex items-center space-x-1 md:mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                                <span><?= $userData['phoneNo'] ?></span>
                            </li>
                        <?php } ?>
                    </ul>

                    <button id="editUserInfoBtn" onclick="showEditUserInfo()" type="button" class="inline-flex mt-4 underline items-center gap-x-2 text-sm font-semibold rounded-lg focus:outline-none text-blue-500 focus:text-blue-700 disabled:opacity-50 disabled:pointer-events-none ">
                        Edit Info
                    </button>

                </div>
            </div>

            <!-- Stats Section -->
            <div class="flex justify-between items-center mt-6 sm:mt-0">

                <ul class="text-sm mt-3 opacity-90">
                    <li class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        <span>University Of Computer Studies ( Hpa-An )</span>
                    </li>
                    <li class="flex items-center space-x-1 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span>Kayin State, Hpa-An City</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Edit Profile Button -->
        <button id="addCoverBtn" onclick="showCoverImageChangeModal()" class="flex items-center justify-center bg-blue-500 absolute md:-top-10 -top-9 right-3 uppercase text-white font-bold hover:shadow-md shadow so-small md:text-xs md:px-4 p-1.5 rounded outline-none focus:outline-none mb-1 ease-linear transition-all duration-150" type="button">
            Add Cover
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="md:size-4 size-3 ml-1">
                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
            </svg>

        </button>

    </div>


</div>

<!-- Friend Profile -->
<div id="friendProfileShowCon" class="hidden mb-10 w-full overflow-auto relative bg-white text-gray-900 dark:bg-gray-900 dark:text-white scroll-none">

    <!-- Banner Section -->
    <section class="profileCoverImg relative block h-48 sm:h-64 md:h-80 lg:h-96 bg-slate-300 dark:bg-gray-950">
        <img alt="cover"
            src=""
            class="w-full h-full object-cover">
    </section>

    <!-- Profile Info Section -->
    <div id="friendInfoCon" class="relative md:flex-row flex flex-col items-center bg-slate-100 dark:bg-gray-800 w-full">


    </div>


</div>

<!-- Update Cover Photo Modal -->
<div id="updateCoverImageModal" class="bg-blur hidden w-full h-screen flex justify-center items-center z-50 fixed inset-0">
    <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-md shadow-xl md:p-10 p-6 mx-2 relative">
        <button id="closeModalButton" class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition" onclick="closeCoverChangeModal()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h1 class="md:text-3xl text-xl font-extrabold text-center text-gray-800 dark:text-gray-200 mb-4">Update Your Cover Photo</h1>
        <p class="text-center md:text-xl text-xs text-gray-500 dark:text-gray-400 mb-6">Choose an image to personalize your profile cover.</p>
        <div class="relative w-full h-48 sm:h-64 md:h-80 lg:h-96 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden shadow-md flex items-center justify-center border-2 border-dashed border-gray-400 dark:border-gray-600">
            <img id="coverImage" src="<?= !empty($userData['coverImage']) ? '../uploads/covers/' . htmlspecialchars($userData['coverImage']) : '' ?>"
                class="w-full hidden h-full object-cover" />
            <span id="placeholder" class="text-gray-500 dark:text-gray-300 text-lg font-semibold">Click below to upload</span>
            <label class="absolute bottom-4 right-4 bg-blue-600 dark:bg-blue-500 md:p-3 p-2 rounded-full shadow-lg cursor-pointer hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="md:size-6 size-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v4.5a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-4.5m-12-6.5l3-3m0 0l3 3m-3-3v12" />
                </svg>
                <input type="file" accept="image/*" class="hidden" id="coverFileInput" onchange="handleCoverImageChange(event)" />
            </label>
        </div>
        <div class="flex gap-4 mt-6 justify-between">
            <button id="resetButton" class="md:w-1/2 w-1/3 bg-red-500 dark:bg-red-600 text-white md:py-3 md:px-6 py-2 rounded-lg shadow-lg font-semibold text-base md:text-lg transition duration-300 hover:bg-red-600 dark:hover:bg-red-700" onclick="resetCoverImage()">
                Reset
            </button>
            <button id="coverSubmitButton" class="md:w-1/2 w-1/3 bg-blue-500 dark:bg-blue-600 text-white md:py-3 md:px-6 py-2 rounded-lg shadow-lg font-semibold text-base md:text-lg transition duration-300 hover:bg-blue-600 dark:hover:bg-blue-700 cursor-not-allowed opacity-50" disabled>
                Submit
            </button>
        </div>
    </div>
</div>

<!-- Update Profile Image Modal -->
<div id="updateProfileImageModal" class="bg-blur hidden w-full h-screen flex justify-center items-center z-50 fixed inset-0">
    <div class="w-full max-w-xl bg-white dark:bg-gray-800 rounded-lg shadow-xl md:p-10 p-6 m-2 relative">
        <button id="closeModalButton" class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition" onclick="closeProfileChangeModal()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h1 class="md:text-3xl text-xl font-extrabold text-center text-gray-800 dark:text-gray-200 mb-4">Update Your Profile Image</h1>
        <p class="text-center text-gray-500 text-sm md:text-xl dark:text-gray-400 mb-6">Choose an image to personalize your profile.</p>
        <div class="relative w-40 h-40 md:w-60 md:h-60 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden shadow-md flex items-center justify-center border-2 border-dashed border-gray-400 dark:border-gray-600 mx-auto">
            <img id="profileImage" src="../uploads/profiles/<?= $userData['profileImage'] ?>" class="w-full h-full object-cover rounded-full" />
            <label class="absolute opacity-0 hover:opacity-100 inset-0 flex items-center justify-center cursor-pointer transition hover:bg-opacity-70">
                <input type="file" accept="image/*" class="hidden" id="profileFileInput" onchange="handleProfileImageChange(event)" />
                <div class="bg-blue-600 dark:bg-blue-500 p-3 rounded-full shaow-lg cursor-pointer hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v4.5a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-4.5m-12-6.5l3-3m0 0l3 3m-3-3v12" />
                    </svg>
                </div>
            </label>
        </div>
        <div class="flex gap-4 mt-6 justify-between">
            <button id="resetButton" class="md:w-1/2 w-1/3 bg-red-500 dark:bg-red-600 text-white md:py-3 md:px-6 py-2 text-base rounded-lg shadow-lg font-semibold md:text-lg transition duration-300 hover:bg-red-600 dark:hover:bg-red-700" onclick="resetProfileImage()">
                Reset
            </button>
            <button id="profileSubmitButton" class="md:w-1/2 w-1/3 bg-green-500 dark:bg-green-600 text-white md:py-3 md:px-6 py-2 text-base rounded-lg shadow-lg font-semibold md:text-lg transition duration-300 hover:bg-green-600 dark:hover:bg-green-700 cursor-not-allowed opacity-50" disabled>
                Submit
            </button>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="fixed bg-blur inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50 transition-opacity bg-blur">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-2xl relative">
        <!-- Close Button -->
        <button id="closeModalBtn" onclick="closeEditUserInfoModal()" class="absolute top-4 right-4 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none" aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600 dark:text-indigo-400">Edit User Information</h2>
        <form id="editProfileForm" action="#" method="post">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- User Name Field -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Name:</label>
                    <input type="text" id="username" name="username" value="<?= $userData['name'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Enter user name" required minlength="3" maxlength="50">
                </div>

                <!-- Role Field -->
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role:</label>
                    <select id="role" name="role" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">None</option>
                        <option value="Student" <?= $userData['role'] === 'Student' ? 'selected' : '' ?>>Student</option>
                        <option value="Teacher" <?= $userData['role'] === 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                    </select>
                </div>

                <!-- Home Address Field -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Home Address (City):</label>
                    <select id="address" name="address" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">None</option>
                        <!-- Kayin State Cities -->
                        <optgroup label="Kayin State">
                            <option value="Hpa-an" <?= $userData['address'] === 'Hpa-an' ? 'selected' : '' ?>>Hpa-an</option>
                            <option value="Myawaddy" <?= $userData['address'] === 'Myawaddy' ? 'selected' : '' ?>>Myawaddy</option>
                            <option value="Kawkareik" <?= $userData['address'] === 'Kawkareik' ? 'selected' : '' ?>>Kawkareik</option>
                            <option value="Thandaung" <?= $userData['address'] === 'Thandaung' ? 'selected' : '' ?>>Thandaung</option>
                            <option value="Hlaingbwe" <?= $userData['address'] === 'Hlaingbwe' ? 'selected' : '' ?>>Hlaingbwe</option>
                            <option value="Hpapun" <?= $userData['address'] === 'Hpapun' ? 'selected' : '' ?>>Hpapun</option>
                            <option value="Kyain Seikgyi" <?= $userData['address'] === 'Kyain Seikgyi' ? 'selected' : '' ?>>Kyain Seikgyi</option>
                            <option value="Payathonzu" <?= $userData['address'] === 'Payathonzu' ? 'selected' : '' ?>>Payathonzu</option>
                            <option value="Shwegyin" <?= $userData['address'] === 'Shwegyin' ? 'selected' : '' ?>>Shwegyin</option>
                            <option value="Kyaikto" <?= $userData['address'] === 'Kyaikto' ? 'selected' : '' ?>>Kyaikto</option>
                            <option value="Thanbyuzayat" <?= $userData['address'] === 'Thanbyuzayat' ? 'selected' : '' ?>>Thanbyuzayat</option>
                        </optgroup>
                        <!-- Mon State Cities -->
                        <optgroup label="Mon State">
                            <option value="Mawlamyine" <?= $userData['address'] === 'Mawlamyine' ? 'selected' : '' ?>>Mawlamyine</option>
                            <option value="Thaton" <?= $userData['address'] === 'Thaton' ? 'selected' : '' ?>>Thaton</option>
                            <option value="Kyaikto" <?= $userData['address'] === 'Kyaikto' ? 'selected' : '' ?>>Kyaikto</option>
                            <option value="Kyaikmaraw" <?= $userData['address'] === 'Kyaikmaraw' ? 'selected' : '' ?>>Kyaikmaraw</option>
                            <option value="Chaungzon" <?= $userData['address'] === 'Chaungzon' ? 'selected' : '' ?>>Chaungzon</option>
                            <option value="Ye" <?= $userData['address'] === 'Ye' ? 'selected' : '' ?>>Ye</option>
                            <option value="Paung" <?= $userData['address'] === 'Paung' ? 'selected' : '' ?>>Paung</option>
                            <option value="Bilin" <?= $userData['address'] === 'Bilin' ? 'selected' : '' ?>>Bilin</option>
                            <option value="Mudon" <?= $userData['address'] === 'Mudon' ? 'selected' : '' ?>>Mudon</option>
                            <option value="Thanbyuzayat" <?= $userData['address'] === 'Thanbyuzayat' ? 'selected' : '' ?>>Thanbyuzayat</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Phone Number Field -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?= $userData['phoneNo'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Enter phone number">
                </div>

                <!-- Year Field -->
                <div class="mb-4">
                    <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year:</label>
                    <select id="year" name="year" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">None</option>
                        <option value="First" <?= $userData['year'] === 'first' ? 'selected' : '' ?>>First</option>
                        <option value="Second" <?= $userData['year'] === 'second' ? 'selected' : '' ?>>Second</option>
                        <option value="Third" <?= $userData['year'] === 'third' ? 'selected' : '' ?>>Third</option>
                        <option value="Fourth" <?= $userData['year'] === 'fourth' ? 'selected' : '' ?>>Fourth</option>
                        <option value="Fifth" <?= $userData['year'] === 'fifth' ? 'selected' : '' ?>>Fifth (Final)</option>
                    </select>
                </div>

                <!-- Roll Number Field -->
                <div class="mb-6">
                    <label for="rollno" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roll Number:</label>
                    <input type="text" id="rollno" name="rollno" value="<?= $userData['rollNo'] ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100" placeholder="Enter roll number">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeEditUserInfoModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Post Creation Form -->
<div id="postCreateForm" class="w-11/12 md:w-2/3 mx-auto md:p-6 p-2 my-10 bg-gray-100 shadow-lg rounded-lg dark:bg-gray-800" style="max-height:550px;">

    <form id="uploadPostForm" method="POST" enctype="multipart/form-data">
        <!-- Caption Textarea -->
        <div class="flex items-start w-full gap-x-1 md:gap-x-3 justify-between">
            <div class="  md:w-10 md:h-10 font-semibold rounded-full border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                <img class="w-6 h-6 md:w-full md:h-full object-cover rounded-full" src="<?= !empty($userData['profileImage']) ? '../uploads/profiles/' . $userData['profileImage'] : 'https://t3.ftcdn.net/jpg/10/58/16/08/360_F_1058160846_MxdSa2GeeVAF5A7Zt9X7Bp0dq0mlzeDe.jpg' ?>" alt="Profile Image">
            </div>
            <div class="w-11/12">
                <textarea name="caption" id="caption" placeholder="What's on your mind?" rows="3" class=" md:p-3 p-2 w-full md:text-md text-sm rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" required></textarea>
            </div>
        </div>

        <!-- Image Preview Container -->
        <div id="preview-container" class="grid gap-4 h-full"></div>

        <!-- File Upload and Actions -->
        <div class="md:mt-4 mt-2 flex items-center justify-between">
            <div class="flex items-center space-x-4">

                <input type="file" name="photos[]" id="photo-input" multiple
                    accept="image/*" style="display: none;">
                <input type="file" name="video" id="video-input"
                    accept="video/*" style="display: none;">
                <input type="file" name="documents[]" id="doc-input" multiple
                    accept=".pdf,.docx,.xlsx,.pptx,.doc,.xls,.ppt,.txt,.pdf" style="display: none;">

                <!-- Upload Photos Button -->
                <label for="photo-input" type="button" class="md:py-2.5  md:px-5 p-1 me-2 text-sm flex items-center font-medium text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:size-5 text-green-400">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 md:block hidden">Photos</span>
                </label>

                <!-- Upload Videos Button -->
                <label for="video-input" type="button" class="md:py-2.5 md:px-5 p-1 me-2 text-sm flex items-center font-medium text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 md:size-5 text-purple-400">
                        <path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625Zm1.5 0v1.5c0 .207.168.375.375.375h1.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-1.5A.375.375 0 0 0 3 5.625Zm16.125-.375a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h1.5A.375.375 0 0 0 21 7.125v-1.5a.375.375 0 0 0-.375-.375h-1.5ZM21 9.375A.375.375 0 0 0 20.625 9h-1.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h1.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-1.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h1.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-1.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h1.5a.375.375 0 0 0 .375-.375v-1.5ZM4.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-1.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h1.5ZM3.375 15h1.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-1.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h1.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 4.875 9h-1.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Zm4.125 0a.75.75 0 0 0 0 1.5h9a.75.75 0 0 0 0-1.5h-9Z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 md:block hidden">Videos</span>
                </label>

                <!-- Upload Documents Button -->
                <label for="doc-input" type="button" class="md:py-2.5 md:px-5 p-1 me-2 text-sm flex items-center font-medium text-gray-900 focus:outline-none bg-white rounded border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 md:size-5 text-yellow-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="ml-2 md:block hidden">Documents</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="button" id="uploadPostBtn" class="md:px-4 md:py-2 p-1.5 bg-blue-500 small md:text-base text-white rounded-md md:rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                Upload Post
            </button>
        </div>
    </form>

</div>

<!-- Post Display Section -->
<div class="w-11/12 md:w-2/3 mx-auto mb-96">
    <a href="#" id="scrollTo" class="hidden">Scroll To</a>

    <div id="postsContainer" class="flex flex-col space-y-10">

    </div>
</div>

<!-- Modal Background -->
<div id="editPostModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden bg-blur">
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-lg w-96 transition-all">
        <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-200">Edit Post Caption</h2>
        <textarea id="editPostContent" class="w-full p-2 border rounded-lg text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring focus:ring-blue-300 dark:focus:ring-blue-600"></textarea>
        <div class="flex justify-end mt-3">
            <button onclick="closeEditPostModal()" class="mr-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">Cancel</button>
            <button id="saveEditPost" onclick="saveEditedPost()" class="px-4 py-2 bg-blue-600 dark:bg-blue-500 text-white rounded hover:bg-blue-700 dark:hover:bg-blue-400">Save</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deletePostModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden bg-blur">
    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-lg w-96 transition-all">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Confirm Delete</h2>
        <p class="text-gray-700 dark:text-gray-300 my-3">Are you sure you want to delete this post?</p>
        <div class="flex justify-end mt-4">
            <button onclick="closeDeletePostModal()" class="mr-2 px-4 py-2 bg-gray-300 dark:bg-gray-700 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-600">Cancel</button>
            <button id="confirmDeletePost" class="px-4 py-2 bg-red-600 dark:bg-red-500 text-white rounded hover:bg-red-700 dark:hover:bg-red-400">Delete</button>
        </div>
    </div>
</div>



<!-- Gallery Modal -->
<div id="galleryModal" class="hidden fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50 bg-blur">
    <div class="relative w-full h-full flex items-center justify-center">
        <!-- Close Button -->
        <button type="button" onclick="closeGallery()" class="absolute top-4 right-4 text-white text-4xl transition-colors">
            &times;
        </button>

        <!-- Save Button -->
        <a id="saveImageButton" class="absolute bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition" download>
            Save Image
        </a>

        <!-- Previous Button -->
        <button type="button" onclick="prevImage()" class="absolute left-4 text-white text-2xl transition-colors">
            &#10094;
        </button>

        <!-- Gallery Image -->
        <img id="galleryImage" class="w-full h-full p-10 object-contain" src="" alt="Gallery Image" />

        <!-- Next Button -->
        <button type="button" onclick="nextImage()" class="absolute right-4 text-white text-2xl transition-colors">
            &#10095;
        </button>
    </div>
</div>