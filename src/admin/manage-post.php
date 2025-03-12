<?php include("widgets/header.php"); ?>



<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="postListContainer" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">User</th>
                <th scope="col" class="px-6 py-3">Post</th>
                <th scope="col" class="px-6 py-3">Details</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT posts.*, user.name, user.profileImage 
                    FROM posts 
                    JOIN user ON posts.user_id = user.userId 
                    ORDER BY posts.createdAt DESC";

            $res = mysqli_query($conn, $sql);

            if ($res) {
                $count = mysqli_num_rows($res);

                if ($count == 0) {
                    echo "<tr><td colspan='4' class='px-6 py-4 text-center'>No Data</td></tr>";
                } else {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['post_id'];
                        $user_id = $row['user_id'];
                        $createdAt = $row['createdAt'];
                        $photos_json = $row['photos'];
                        $name = $row['name'];
                        $profileImage = $row['profileImage'];
            ?>
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="../uploads/profiles/<?= htmlspecialchars($profileImage) ?>" alt="Profile image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold"><?= htmlspecialchars($name) ?></div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div class="h-auto max-w-xs"><?= htmlspecialchars($createdAt) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="getPost(<?= $id ?>)" class="postDetail font-medium text-blue-600 dark:text-blue-500 hover:underline">Details</button>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="openDeleteModal(<?= $id ?>, <?= $user_id ?>)" class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</button>
                            </td>
                        </tr>
            <?php
                    }
                }
            } else {
                echo "<tr><td colspan='4' class='px-6 py-4 text-center'>Error fetching data</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Post Display Section -->
<div id="postsContainerMain" class="w-screen h-screen flex justify-center items-center absolute top-0 left-0 z-50 hidden bg-black/90">
    <div id="postsContainer" class="flex flex-col max-h-['500px'] overflow-auto space-y-10 w-11/12 md:w-2/3 mx-auto"></div>
</div>


<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-11/12 md:w-1/3">
        <h2 class="text-lg font-semibold mb-4">Delete Post</h2>
        <form id="deleteForm" action="./delete-post.php" method="POST">
            <input type="hidden" id="postId" name="postId">
            <input type="hidden" id="userId" name="userId"> <!-- Add this line -->
            <div class="mb-4">
                <label for="deleteReason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason for Deletion</label>
                <select id="deleteReason" name="deleteReason" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300">
                    <option value="spam">Spam</option>
                    <option value="inappropriate">Inappropriate Content</option>
                    <option value="duplicate">Duplicate Post</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

</body>


<script>
    // Function to create a post element
    function createPostElement(post) {
        const postElement = document.createElement('a');
        postElement.id = `Post${post.post_id}`;
        postElement.className = 'bg-gray-100 dark:bg-gray-800 md:p-4 p-3 rounded-lg shadow-md hover:shadow-lg transition-shadow';

        const display = "block";

        // Build post content
        postElement.innerHTML = `
        ${createUserInfo(post, display)}
        ${createCaption(post.caption)}
        ${createMediaContent(post)}
    `;

        return postElement;
    }

    // Function to create user info section
    function createUserInfo(post, display) {
        return `
        <div class="flex justify-between items-center relative">
            <div onclick="openProfile(${post.user_id})" class="flex cursor-pointer items-center md:space-x-2 space-x-1">
                <img src="../uploads/profiles/${post.profileImage}" alt="${post.name}'s profile picture" class="md:w-8 md:h-8 w-6 h-6 object-cover rounded-full" />
                <div>
                    <p class="font-semibold text-sm md:text-base text-gray-900 dark:text-gray-100">${post.name}</p>
                    <p class="so-small md:text-xs text-gray-500 dark:text-gray-400">
                        ${new Date(post.createdAt).toLocaleString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        })}
                    </p>
                </div>
            </div>

        </div>
    `;
    }


    // Function to create the caption section
    function createCaption(caption) {
        return `
        <p class="md:my-5 my-2 md:text-base text-sm text-gray-800 dark:text-gray-200 break-words text-justify">
            ${caption}
        </p>
    `;
    }

    // Function to create media content (images, videos, files)
    function createMediaContent(post) {
        if (post.images.length > 0) {
            return createImageGallery(post.images);
        } else if (post.videos.length > 0) {
            return createVideoElement(post.videos[0]);
        } else if (post.files.length > 0) {
            return createFileElements(post.files);
        }
        return '';
    }

    // Function to create file elements
    function createFileElements(files) {
        const fileIcons = {
            'doc': 'https://cdn-icons-png.flaticon.com/512/300/300213.png',
            'docx': 'https://cdn-icons-png.flaticon.com/512/300/300213.png',
            'xls': 'https://cdn-icons-png.flaticon.com/256/3699/3699883.png',
            'xlsx': 'https://cdn-icons-png.flaticon.com/256/3699/3699883.png',
            'ppt': 'https://cdn-icons-png.flaticon.com/256/888/888874.png',
            'pptx': 'https://cdn-icons-png.flaticon.com/256/888/888874.png',
            'txt': 'https://cdn-icons-png.flaticon.com/512/10260/10260761.png',
            'pdf': 'https://cdn-icons-png.flaticon.com/512/4726/4726010.png'
        };

        return `
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 h-full w-full">
            ${files.map(file => {
                const ext = file.split('.').pop().toLowerCase();
                const filePath = `../posts/documents/${file}`;
                const fileIcon = fileIcons[ext] || 'https://cdn-icons-png.flaticon.com/512/6811/6811255.png';

                return `
                    <div class="flex items-center relative flex-col justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg shadow">
                        <div class="flex items-center gap-2 flex-col">
                            <img class="md:w-16 w-8" src="${fileIcon}" alt="${file} file icon" />
                            <a href="${filePath}" target="_blank" class="text-blue-600 dark:text-blue-400 so-small md:text-xs hover:underline break-words whitespace-pre-line">${file}</a>
                        </div>
                        <a href="${filePath}" download class="items-center text-sm flex absolute top-2 right-2 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-transform transform hover:scale-105 active:scale-95" aria-label="Download ${file}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                    </div>
                `;
            }).join('')}
        </div>
    `;
    }

    // Function to create a video element
    function createVideoElement(video) {
        return `
        <div class="grid grid-cols-1 gap-1 mt-3 relative">
            <a href="javascript:void(0);" data-videos='${JSON.stringify([video])}' data-index='0' class="gallery-trigger relative">
                <video controls class="w-full object-cover rounded-lg">
                    <source src="../posts/videos/${video}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </a>
        </div>
    `;
    }

    // Function to create an image gallery (Show all images with improved layout)
    function createImageGallery(images) {
        return `
        <div class="grid grid-cols-${Math.min(images.length, 3)} gap-2 mt-3 relative max-h-[700px] overflow-y-auto">
            ${images.map((photo, index) => 
                `<a href="javascript:void(0);" data-images='${JSON.stringify(images)}' data-index='${index}' class="gallery-trigger relative block">
                    <img src="../posts/images/${photo}" alt="Post image ${index + 1}" class="w-full object-cover rounded-lg ${images.length === 1 ? 'md:h-[600px] h-[220px]' : 'md:h-80 h-40'}" />
                </a>`
            ).join('')}
        </div>
    `;
    }


    const postsContainerMain = document.querySelector('#postsContainerMain');

    // Fetch and display posts
    async function getPost(id) {

        const postContainer = document.querySelector('#postsContainer');

        postContainer.innerHTML = '<p>Loading...</p>'; // Add a loading message

        try {
            const response = await fetch(`./getPost.php?id=${id}`);
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const posts = await response.json();
            postContainer.innerHTML = ''; // Clear the loading message

            posts.forEach(post => {
                postsContainerMain.classList.remove("hidden");
                const postElement = createPostElement(post);
                postContainer.appendChild(postElement);
            });
        } catch (error) {
            console.error('Error fetching posts:', error);
            postContainer.innerHTML = '<p>Failed to load posts. Please try again later.</p>';
        }
    }

    postsContainerMain.addEventListener("click", () => {
        postsContainerMain.classList.add("hidden");
    })

    // Delete Post

    // Function to open the delete modal
    function openDeleteModal(postId, userId) {
        document.getElementById('postId').value = postId;
        document.getElementById('userId').value = userId; // Add a hidden input for userId
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Function to close the delete modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Event listener for form submission
    document.getElementById('deleteForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Post deleted successfully');
                    closeDeleteModal();
                    // Optionally, refresh the post list or remove the deleted post from the DOM
                    location.reload();
                } else {
                    alert('Failed to delete post: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the post');
            });
    });
</script>

</html>