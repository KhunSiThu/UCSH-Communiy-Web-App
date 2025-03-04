sendImageInput.addEventListener("change",() => {
    sendDocumentInput.value = "";
    sendVideoInput.value = "";
    sendFiles.classList.toggle("hidden");
});

sendVideoInput.addEventListener("change",() => {
    sendDocumentInput.value = "";
    sendImageInput.value = "";
    sendFiles.classList.toggle("hidden");
})

sendDocumentInput.addEventListener("change",() => {
    sendVideoInput.value = "";
    sendImageInput.value = "";
    sendFiles.classList.toggle("hidden");
})

searchPostsBtn.addEventListener("click",()=> {
    const searchValue = searchPostsText.value;
    sessionStorage.removeItem("profile");
    sessionStorage.removeItem("filterType");
    sessionStorage.removeItem('friendProfile');
    sessionStorage.setItem("searchPost",searchValue);
})

// Event Listeners
filterPosts.forEach((btn) => {
    btn.addEventListener("click", (e) => {

        if(e.target.classList.contains('all'))
        {
            sessionStorage.setItem("filterType",'all');
        } else if(e.target.classList.contains('posts')) {
            sessionStorage.setItem("filterType",'post');
        } else if(e.target.classList.contains('videos')) {
            sessionStorage.setItem("filterType",'video');
        } else if(e.target.classList.contains('docs')) {
            sessionStorage.setItem("filterType",'doc');
        } else if(e.target.classList.contains('userProfileBtn')) {
            handleUserProfileClick();
            return
        }
    
        sessionStorage.removeItem('profile');
        sessionStorage.removeItem('searchPost');
        sessionStorage.removeItem('friendProfile');
    
        location.reload()
    });
    
})
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

photoInput.addEventListener('change', handlePhotoInputChange);
videoInput.addEventListener("change", handleVideoInputChange);
documentInput.addEventListener("change", handleDocumentInputChange);
chatBoxBtn.addEventListener("click", handleChatBoxBtnClick);
groupBtn.addEventListener("click", handleGroupBtnClick);


userProfileBtn.forEach((btn) => {
    btn.addEventListener('click', () => {
        handleUserProfileClick();
    })
})

searchBox.addEventListener("keyup", handleSearchBoxKeyup);
searchItems.addEventListener("click", handleSearchItemsClick);
searchForm.addEventListener("submit", handleSearchFormSubmit);
createGroupBtn.addEventListener("click", handleCreateGroupBtnClick);
cancelBtn.addEventListener("click", handleCancelBtnClick);
nextBtn.addEventListener("click", handleNextBtnClick);
memberName.addEventListener("keyup", handleMemberNameKeyup);
forMemberList.addEventListener("click", handleForMemberListClick);
closeAddMember.addEventListener("click", handleCloseAddMemberClick);
groupProfileUpload.addEventListener("change", handleGroupProfileUploadChange);
groupList.addEventListener("click", handleGroupListClick);
groupSendBtn.addEventListener("click", handleGroupSendBtnClick);
sendFilesBtn.addEventListener("click", handleSendFilesBtnClick);
sendBtn.addEventListener("click", handleSendBtnClick);
friendList.addEventListener("click", handleFriendListClick);
uploadPostBtn.addEventListener('click', handleUploadPostBtnClick);

// Functions
function handlePhotoInputChange() {
    videoInput.value = "";
    documentInput.value = "";

    sessionStorage.setItem("type","post");
    previewContainer.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'preview-item relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="preview-image">
                <button type="button" class='text-red-500 absolute top-1 right-1' onclick="this.parentElement.remove()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function handleVideoInputChange() {
    photoInput.value = "";
    documentInput.value = "";
    
    sessionStorage.setItem("type","video");
    previewContainer.innerHTML = '';
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'preview-item relative w-full h-full';
            div.innerHTML = `
                <video class="preview-video w-2/3 mx-auto" controls>
                    <source src="${e.target.result}" type="${file.type}">
                    Your browser does not support the video tag.
                </video>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function handleDocumentInputChange() {
    videoInput.value = "";
    videoInput.value = "";
    
    sessionStorage.setItem("type","doc");
    previewContainer.innerHTML = ''; 
    const fileIconMap = {
        'doc': 'https://cdn-icons-png.flaticon.com/512/300/300213.png',
        'docx': 'https://cdn-icons-png.flaticon.com/512/300/300213.png',
        'xls': 'https://cdn-icons-png.flaticon.com/256/3699/3699883.png',
        'xlsx': 'https://cdn-icons-png.flaticon.com/256/3699/3699883.png',
        'ppt': 'https://cdn-icons-png.flaticon.com/256/888/888874.png',
        'pptx': 'https://cdn-icons-png.flaticon.com/256/888/888874.png',
        'txt': 'https://cdn-icons-png.flaticon.com/512/10260/10260761.png',
        'pdf': 'https://cdn-icons-png.flaticon.com/512/4726/4726010.png'
    };

    Array.from(this.files).forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        const fileIcon = fileIconMap[ext] || 'https://cdn-icons-png.flaticon.com/512/6811/6811255.png';

        const div = document.createElement('div');
        div.className = "flex items-center justify-between p-1 md:gap-2 gap-1 md:p-3 bg-gray-50 dark:bg-gray-700 rounded-lg shadow";

        div.innerHTML = `
            
                <img class="w-5" src="${fileIcon}" alt="">
                <span class="text-blue-600 dark:text-blue-400 md:font-medium so-small break-words whitespace-pre-line">${file.name}</span>
        `;

        previewContainer.appendChild(div);
    });

    
}


function handleNewFeedBtnClick() {
    chatListContainer.classList.add("hidden");
    chatRoomCon.classList.add("hidden");
    userProfileShowCon.classList.add("hidden");
    document.querySelector("#noSelect").classList.remove("hidden");
    document.querySelector("#noSelect").classList.remove("md:hidden");
    getAllPosts(false)
}

function handleChatBoxBtnClick() {
    chatListContainer.classList.remove("hidden");

    chatItems.classList.remove("hidden");
    searchItemsCon.classList.add("hidden");
    groupItems.classList.add("hidden");
    mainTitle.textContent = "Chat Box";
    searchBox.value = "";

    document.querySelector("#noSelect").classList.add("hidden");
    document.querySelector("#createGroupBtn").classList.add("hidden");

    closeMobileSideBar();
}

function handleGroupBtnClick() {
    chatListContainer.classList.remove("hidden");

    chatItems.classList.add("hidden");
    searchItemsCon.classList.add("hidden");
    groupItems.classList.remove("hidden");
    mainTitle.textContent = "Your Group";
    searchBox.value = "";

    document.querySelector("#noSelect").classList.add("hidden");
    document.querySelector("#createGroupBtn").classList.remove("hidden");

    closeMobileSideBar();
}

async function handleUserProfileClick() {
    sessionStorage.setItem("profile",true);
    sessionStorage.removeItem("filterType");
    sessionStorage.removeItem('searchPost');
    sessionStorage.removeItem('friendProfile');
    location.reload();
}


function handleSearchBoxKeyup() {
    const searchText = searchBox.value.trim();

    if (searchText) {
        chatItems.classList.add("hidden");
        requestItems.classList.add("hidden");
        followItems.classList.add("hidden");
        searchItemsCon.classList.remove("hidden");
        groupItems.classList.add("hidden");
        mainTitle.textContent = "Search Friends";

        if (intervalId) {
            clearInterval(intervalId);
        }

        intervalId = setInterval(() => {
            searchFriend(searchText);
        }, 1000);
    } else {
        chatItems.classList.remove("hidden");
        searchItemsCon.classList.add("hidden");
        mainTitle.textContent = "Chat Box";

        if (intervalId) {
            clearInterval(intervalId);
        }
    }
}

function handleSearchItemsClick(e) {
    if (e.target.matches(".requestBtn")) {
        const id = e.target.getAttribute("id");
        requestTest('../Controller/requestFri.php', id, e.target);
    }

    if (e.target.matches(".confirmBtn")) {
        const id = e.target.getAttribute("id");
        confirmTest('../Controller/comfirmFri.php', id, e.target);
    }
}

function handleSearchFormSubmit(e) {
    e.preventDefault();
}

function handleCreateGroupBtnClick() {
    groupModal.classList.remove("hidden");
}

function handleCancelBtnClick() {
    groupModal.classList.add("hidden");
    groupNameInput.value = "";
    groupProfileImage.src = "https://png.pngtree.com/png-vector/20241101/ourmid/pngtree-simple-camera-icon-with-line-png-image_14216604.png";
}

function handleNextBtnClick() {
    const groupName = groupNameInput.value.trim();
    if (groupProfileUpload.value === "") {
        showCustomAlert("<div class=' p-2 rounded'>Upload group profile!</div>");
        return;
    }
    if (groupName === "") {
        groupNameInput.focus();
    } else {
        const file = groupProfileUpload.files[0];
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
        formData.append("groupProfileImage", file);
        formData.append("groupName", groupName);

        fetch("../Controller/createGroup.php", {
            method: 'POST',
            body: formData,
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    groupModal.classList.add("hidden");
                    groupNameInput.value = "";
                    groupProfileImage.src = "https://png.pngtree.com/png-vector/20241101/ourmid/pngtree-simple-camera-icon-with-line-png-image_14216604.png";
                    addMemberModal.classList.remove("hidden");

                    getFriendByName("");
                }
            })
            .catch((error) => {
                console.error("Error creating group:", error);
            });
    }
}

function handleMemberNameKeyup() {
    getFriendByName(memberName.value);
}

async function handleForMemberListClick(e) {
    if (e.target.matches(".addMemberBtn")) {
        const parentLi = e.target.closest('li');
        const addId = e.target.getAttribute("id");

        try {
            const response = await fetch("../Controller/addGroupMember.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ addId }),
            });

            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }

            const data = await response.json();
            console.log("Member added successfully:", data);

            parentLi.classList.add("hidden");
        } catch (error) {
            console.error("Error adding member:", error);
        }
    }
}

function handleCloseAddMemberClick() {
    addMemberModal.classList.add("hidden");
}

function handleGroupProfileUploadChange(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            groupProfileImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        alert("Upload group profile!");
    }
}

async function handleGroupListClick(e) {
    if (e.target.matches(".groupItem")) {
        const id = e.target.getAttribute("id");
        await groupChat(id);
    }
}

async function handleGroupSendBtnClick() {
    loadingBtn.classList.remove("hidden");
    groupSendBtn.classList.add("hidden");
    await groupSendMessage();
    loadingBtn.classList.add("hidden");
    groupSendBtn.classList.remove("hidden");
}

function handleSendFilesBtnClick() {
    sendFiles.classList.toggle("hidden");
}

async function handleSendBtnClick() {
    loadingBtn.classList.remove("hidden");
    sendBtn.classList.add("hidden");
    await sendMessage();
    loadingBtn.classList.add("hidden");
    sendBtn.classList.remove("hidden");
   
}

async function handleFriendListClick(e) {
    if (e.target.matches(".chatItem")) {
        const id = e.target.getAttribute("id");
        await chatFriend(id);
    }
}

function handleUploadPostBtnClick() {
    uploadPost();
}

// Utility Functions
function showCustomAlert(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'custom-alert';
    alertDiv.innerHTML = message;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

function clearPreview() {
    previewContainer.innerHTML = '';
    photoInput.value = '';
}

document.querySelector('body').addEventListener("click", (e) => {
    if (e.target.classList.contains("bg-blur")) {
        e.target.classList.add("hidden");
    }
});

