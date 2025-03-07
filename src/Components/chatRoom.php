<!-- Chat Room -->
<div id="chatRoomCon" class="h-screen hidden w-full relative bg-white dark:bg-gray-900">

    <!-- Hero Section -->
    <section id="chatRoomHeader" class="md:p-4 p-2 bg-slate-100 dark:bg-gray-800 w-full md:h-20 h-16 absolute right-0 top-0 z-40 flex items-center justify-between">

    </section>

    <!-- Chat Messages -->
    <section id="messageShowCon" class="w-full md:w-3/4 mx-auto px-3 h-full overflow-auto scroll-none py-24 bg-white dark:bg-gray-900  pb-40">

        <!-- Repeat the above chat bubbles as needed -->
    </section>

    <!-- Input Section -->
    <section class="md:p-4 p-2 bg-slate-100 dark:bg-gray-800 rounded-t-md w-full h-20 absolute bottom-0 z-20 right-0 flex justify-center items-center gap-x-1 md:gap-x-5">

        <div id="sendFiles" class="w-48 text-slate-800 dark:text-slate-100 text-sm rounded-md flex hidden flex-col absolute bottom-20 mb-1 left-5 md:left-32 bg-slate-100 dark:bg-slate-800 p-3">
            <!-- Video Attachment Button -->
            <label for="sendVideo" class="p-2 mb-2 flex items-center bg-slate-200 dark:bg-gray-700 rounded-md hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm14.024-.983a1.125 1.125 0 0 1 0 1.966l-5.603 3.113A1.125 1.125 0 0 1 9 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113Z" clip-rule="evenodd" />
                </svg>
                <span class="ml-2">Video</span>
            </label>
            <input id="sendVideo" class="hidden" multiple type="file" name="videos[]" accept="video/*">

            <!-- Image Attachment Button -->
            <label for="sendImage" class="p-2 mb-2  flex items-center bg-slate-200 dark:bg-gray-700 rounded-md hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                </svg>
                <span class="ml-2">Photos</span>
            </label>
            <input id="sendImage" class="hidden" type="file" name="images[]" multiple accept="image/*">

            <!-- File Attachment Button (Documents) -->
            <label for="sendFile" class="p-2 flex items-center bg-slate-200 dark:bg-gray-700 rounded-md hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                    <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                <span class="ml-2">Documents</span>
            </label>
            <input id="sendFile" class="hidden" type="file" name="documents[]" multiple accept=".pdf,.docx,.xlsx,.pptx,.doc,.xls,.ppt,.txt,.pdf">

        </div>

        <button id="sendFilesBtn" class="p-2 bg-slate-200 dark:bg-gray-700 rounded hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
            📂
        </button>
        <!-- Message Input -->
        <div class="md:w-2/3 w-full">
            <input id="sendMessage" type="text" class="w-full p-2 rounded md:text-base text-sm bg-white text-black dark:bg-gray-700 dark:text-white dark:border-gray-600 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 transition-colors duration-200" placeholder="Type a message...">
        </div>

        <!-- Send Button -->
        <button id="sendBtn" class="p-2 bg-slate-200 dark:bg-gray-700 rounded hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-800 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
            <svg aria-hidden="true" class="inline hidden w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
        </button>

        <button id="loadingBtn" class="p-2 hidden bg-slate-200 dark:bg-gray-700 rounded hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
            <svg aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
        </button>

        <!-- Group Send Button -->
        <button id="groupSendBtn" class="p-2 bg-slate-200 dark:bg-gray-700 rounded hover:bg-slate-300 dark:hover:bg-gray-600 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-800 dark:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
            </svg>
        </button>
    </section>


    <div id="messDropdown" class="z-10 w-full h-screen flex  hidden justify-center items-center absolute top-0 divide-y divide-gray-100 dark:divide-gray-600 bg-black/50 bg-blur">
        <ul class="py-2 w-36 text-sm bg-slate-100 dark:bg-slate-500 text-gray-700 dark:text-gray-200  rounded-lg shadow-sm ">
            <li id="deleteMessageBtn" class="px-4 py-2 mx-2 rounded-lg flex justify-between  text-white hover:bg-gray-200 dark:hover:bg-gray-600 dark:hover:text-red-500">
                <span class="text-base font-bold">Delete</span>
                <span><i class="fa-solid fa-trash  text-sm"></i></span>
            </li>

        </ul>
    </div>


    <!-- Modal -->

    <!-- Custom Alert Box -->
    <div id="customAlertBox" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 bg-blur">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center">
            <div id="alertMessage" class="text-blue-600 dark:text-blue-400 mb-4">Upload group profile!</div>
            <button id="closeAlertBtn" class="bg-blue-500 dark:bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-600 dark:hover:bg-blue-500">
                OK
            </button>
        </div>
    </div>


    <!-- Delete Group Modal -->
    <div id="deleteGroupModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex hidden justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-blur">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Close button -->
                <button id="closeDeleteModalButton" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal content -->
                <div class="p-4 md:p-5 text-center">
                    <!-- Warning icon -->
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <!-- Modal title -->
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to Delete this group?</h3>
                    <!-- Confirmation buttons -->
                    <button id="sureDelete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button id="cancelDelete" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Group Modal -->
    <div id="leaveGroupModal" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex hidden justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-blur">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Close button -->
                <button id="closeLeaveModalButton" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal content -->
                <div class="p-4 md:p-5 text-center">
                    <!-- Warning icon -->
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <!-- Modal title -->
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to leave this group?</h3>
                    <!-- Confirmation buttons -->
                    <button id="sureLeave" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button id="cancelLeave" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Group Modal -->
    <div id="editGroupModal" class="fixed top-0 left-0 z-50 w-screen flex h-screen hidden justify-center items-center bg-black bg-opacity-50 bg-blur">

    </div>

</div>

<div id="noSelect" class="h-screen   w-full overflow-auto relative bg-white text-gray-900 dark:bg-gray-900 dark:text-white scroll-none">

    <?php require_once "../Components/posts.php"; ?>
    <ul id="filterPosts" class="flex md:hidden  fixed bottom-0 py-2 filterPosts w-full bg-slate-100/90 dark:bg-slate-950/90 rounded-t-2xl border-t-4 border-blue-400 items-center justify-evenly">
        <li>
            <button id="2filterBtnpost" class="posts w-10 h-10  shadow-lg text-xl rounded-full bg-slate-300 dark:bg-gray-800 focus:outline-none  hover:text-blue-600  transition-all">
                <i class="fa-solid fa-image pointer-events-none"></i>
            </button>
        </li>
        <li>
            <button id="2filterBtnvideo" class="videos w-10 h-10 shadow-lg text-xl rounded-full bg-slate-300 dark:bg-gray-800  focus:outline-none  hover:text-blue-600  transition-all">
                <i class="fa-solid fa-circle-play pointer-events-none"></i>
            </button>
        </li>


        <li>
            <button id="2filterBtnall" class="all w-12 h-12 shadow-lg text-xl rounded-full border-2 border-gray-800 dark:border-gray-100 bg-slate-200 dark:bg-gray-900 focus:outline-none  hover:text-blue-600  transition-all">
                <i class="fa-solid fa-house pointer-events-none"></i>
            </button>
        </li>

        <li>
            <button id="2filterBtndoc" class="docs w-10 h-10 shadow-lg text-xl rounded-full bg-slate-300 dark:bg-gray-800 focus:outline-none  hover:text-blue-600  transition-all">
                <i class="fa-solid fa-file-contract pointer-events-none"></i>
            </button>
        </li>

        <li>
            <button id="userProfileBtn" class="userProfileBtn w-10 h-10 shadow-lg text-xl rounded-full bg-slate-300 dark:bg-gray-800 focus:outline-none  hover:text-blue-600  transition-all">
                <i class="fa-solid fa-user pointer-events-none"></i>
            </button>
        </li>
    </ul>

</div>