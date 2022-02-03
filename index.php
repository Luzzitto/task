<?php
date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/tailwind.css">
</head>

<body>
    <div class="flex items-center justify-center bg-slate-900 min-h-screen w-full">
        <div class="bg-white px-2 rounded-lg md:w-1/2 lg:w-1/4 flex flex-col">
            <div class="w-full p-4">
                <h1 class="font-semibold text-xl">Title</h1>
                <p class="text-slate-500">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit, commodi quaerat autem mollitia minus voluptatum libero sunt cum placeat molestiae corporis, earum quidem beatae id unde maxime nobis hic ab!</p>
                <div class="flex items-baseline space-x-4 py-2 text-xs">
                    <p class="bg-green-500 text-white py-1 px-2 rounded">Shady Class</p>
                    <p><?php echo date('F d, Y  h:i a'); ?></p>
                </div>
            </div>
            <hr>
            <div class="w-full p-4">
                <h1 class="font-semibold text-xl">Title</h1>
                <p class="text-slate-500">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reprehenderit, commodi quaerat autem mollitia minus voluptatum libero sunt cum placeat molestiae corporis, earum quidem beatae id unde maxime nobis hic ab!</p>
                <div class="flex items-baseline space-x-4 py-2 text-xs">
                    <p class="bg-green-500 text-white py-1 px-2 rounded">Shady Class</p>
                    <p><?php echo date('F d, Y  h:i a'); ?></p>
                </div>
            </div>
        </div>
</body>

</html>