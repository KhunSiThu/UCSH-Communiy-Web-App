<?php include("widgets/header.php"); ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex items-end justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">

        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search-users" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for groups">
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>

                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Members
                </th>
                <th scope="col" class="px-6 py-3">
                   CreatedAt
                </th>

                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>

            <?php
            $sql = "SELECT * FROM `group`";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                $count = mysqli_num_rows($res);
                if ($count == 0) {
                    echo "No Data";
                } else {
                    $sn = 1;
                    while ($row = mysqli_fetch_array($res)) {
                        $groupId = $row['groupId'];
                        $groupName = $row['groupName'];
                        $groupProfile = $row['groupProfile'];
                        $createdAt = $row['createdAt'];
            ?>


                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="../uploads/profiles/<?=$groupProfile ?>" alt="Group image">
                               
                                <div class="ps-3">
                                    <div class="text-base font-semibold"><?=$groupName?></div>

                                </div>
                            </th>
                            <td class="px-6 py-4">
                                React Developer
                            </td>
                            <td class="px-6 py-4">
                               <?=$createdAt?>
                            </td>

                            <td class="px-6 py-4">
                                <!-- Modal toggle -->
                                <a href="./delete-group.php?id=<?= $groupId ?>" type="button" data-modal-target="editUserModal" data-modal-show="editUserModal" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete group</a>
                            </td>
                        </tr>
            <?php
                    }
                }
            }

            ?>

        </tbody>
    </table>

</div>