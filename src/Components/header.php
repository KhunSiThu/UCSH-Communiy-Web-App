<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">


    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            },

        }
    </script>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="../CSS/output.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="../CSS/newfeed2.css">
    <link rel="stylesheet" href="../CSS/poststyle.css">
</head>


<style>
    html {
        scroll-behavior: smooth;
    }

    .scroll-none {
        scrollbar-width: none;
    }

    .scroll-bar-w {
        scrollbar-width: 2px;
    }

    .top {
        z-index: 100;
    }

    .bg-blur {
        backdrop-filter: blur(3px);
        background-color: rgba(0, 0, 0, 0.806);
        z-index: 200;
    }

    .bg-blur0 {
        backdrop-filter: blur(3px);
        background-color: rgba(0, 0, 0, 0.806);
        z-index: 200;
    }

    /* Dark Mode Switch Background Color */
    .dark .bg-gray-300 {
        background-color: #2563eb !important;
        /* Blue Background for Dark Mode */
    }

    /* Move switch to right when dark mode is active */
    .dark .switch {
        transform: translateX(18px);
        /* Move switch right */
    }

    /* Dark mode switch button colors */
    .dark .peer-checked~div {
        background-color: #2563eb !important;
        /* Dark Mode ON - Blue */
    }

    .so-small {
        font-size: 8px;
    }

    .small {
        font-size: 10px;
    }

    .z-high {
        z-index: 300;
    }

</style>

<body>

    <div id="spinner" class ="hidden fixed z-high top-0 left-0 w-screen h-screen flex justify-center items-center bg-blur0 ">

        <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>

    </div>