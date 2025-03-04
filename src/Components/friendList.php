<!-- Chat List -->
<div id="chatListContainer" class="md:w-96 w-full h-screen relative hidden md:block">
   <!-- Search box -->
   <div class="w-full absolute top-0 left-0 z-40 md:h-32 h-24 bg-slate-100 dark:bg-gray-700 md:p-5 p-3">
      <form id="search-form" class="w-full flex justify-between md:mb-0 mb-2">

         <!-- Sidebar Toggle Button -->
         <button type="button" onclick="openMobileSideBar()" class="inline-flex md:hidden mr-5 items-center p-2 text-gray-500 rounded-lg bg-gray-200 dark:text-gray-400 dark:bg-gray-800 transition-all focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-600">
            <svg class="size-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>

         <div class="relative w-full">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
               <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
               </svg>
            </div>
            <input name="searchText" type="search" id="default-search" class="searchBox block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search friends ... " required />
         </div>
      </form>
      <div class="flex justify-between items-center">
         <h3 id="mainTitle" class="md:py-5 py-2 md:text-xl text-base font-bold text-black dark:text-white">Chat Box</h3>
         <button type="button" id="createGroupBtn" class="text-blue-700 flex hidden items-center justify-center hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded md:rounded-lg md:text-sm text-xs px-3 md:py-1.5 py-1 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
            <span>Create</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="md:size-4 size-3">
               <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
         </button>
      </div>
   </div>

   <!-- Chat Items -->
   <div id="chatItems" class="md:pt-36 pt-28 px-3 pb-5 overflow-auto  h-screen scroll-none">
      <ul class="friendList flex flex-col gap-y-3 ">

         <!-- Repeat the above <li> for each chat item -->
      </ul>
   </div>

   <!-- group Items -->
   <div id="groupItems" class="md:pt-36 pt-28 px-3 pb-5 overflow-auto hidden h-screen scroll-none">
      <ul class="groupList flex flex-col gap-y-3 ">

         <!-- Repeat the above <li> for each chat item -->
      </ul>
   </div>

   <!-- Request Items -->
   <div id="requestItems" class="md:pt-36 pt-28 px-3 pb-5 overflow-auto hidden h-screen scroll-none">
      <ul id="requestList" class=" flex flex-col gap-y-3 ">

         <!-- Repeat the above <li> for each chat item -->
      </ul>
   </div>

   <!-- follow Items -->
   <div id="followItems" class="md:pt-36 pt-28 px-3 pb-5 overflow-auto hidden h-screen scroll-none">
      <ul id="followList" class=" flex flex-col gap-y-3 ">

         <!-- Repeat the above <li> for each chat item -->
      </ul>
   </div>

   <!-- Search Results -->
   <div id="searchItemsCon" class="md:pt-36 pt-28 hidden px-3 overflow-auto h-screen scroll-none">
      <ul id="searchItems" class="flex flex-col gap-y-3 mb-80">
         <!-- Search results will be dynamically inserted here -->
      </ul>
   </div>
</div>

<!-- Group Creation Modal -->
<div id="groupModal" class="fixed top-0 left-0 z-50 w-screen flex h-screen hidden justify-center items-center bg-black bg-opacity-50 bg-blur">
   <div class="bg-gray-800 text-gray-200 p-6 rounded-lg shadow-lg w-96">
      <div class="flex justify-center relative">
         <!-- Profile Upload -->
         <label for="groupProfileUpload" class="cursor-pointer">
            <div class="bg-blue-500  flex items-center rounded-full  justify-center">
               <img id="groupProfileImage" src="https://png.pngtree.com/png-vector/20241101/ourmid/pngtree-simple-camera-icon-with-line-png-image_14216604.png"
                  alt="group-icon" class="p-1 object-cover rounded-full w-16 h-16 ">
            </div>
         </label>
         <input type="file" id="groupProfileUpload" accept="image/*" class="hidden">
      </div>
      <h2 class="text-center text-lg mt-4">Group Profile</h2>
      <input id="groupNameInput" type="text"
         class="w-full mt-2 p-2 border-b bg-transparent focus:outline-none focus:border-blue-500"
         placeholder="Enter group name">
      <div class="flex justify-between mt-4">
         <button id="cancelBtn" class="text-blue-400 hover:text-blue-300">Cancel</button>
         <button id="nextBtn" class="text-blue-400 hover:text-blue-300">Next</button>
      </div>
   </div>
</div>