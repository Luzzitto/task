<?php

require_once 'DB.php';

$todos = DB::query("SELECT * FROM todo");

if (isset($_POST["submit"])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $i = clean($_POST["item"]);
    $d = clean($_POST["description"]);

    if (!empty($i) && !empty($d)) {
        DB::query("INSERT INTO todo (`name`, `description`) VALUES (:n, :d)", array(":n"=>$i, ":d"=>$d));
        header("Location: ./");
    }
}

function clean($d) {
    return htmlentities(htmlspecialchars(strip_tags($d)));
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Homepage</title>
        <link rel="stylesheet" href="./assets/css/tailwind.css" />
        <script src="./assets/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="min-h-screen w-full bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-500 flex items-center justify-center">
            <div class="bg-white px-8 py-6 w-1/2 rounded-lg">
                <h1 class="text-lg font-medium text-center uppercase tracking-wider">todo</h1>
                <form method="POST" action="./" class="flex my-4 w-full justify-between">
                    <div class="flex flex-col w-full mr-2 gap-y-2">
                        <input type="text" name="item" id="item" class="shadow appearance-none border rounded py-2 px-3 w-full" placeholder="Add new item...">
                        <textarea name="description" id="description" class="shadow appearance-none border rounded py-2 px-3 w-full" placeholder="Description of new item"></textarea>
                    </div>
                    <button class="btn px-4 btn-primary border-2 rounded" id="add" name="submit" type="submit" value="add">Add</button>
                </form>
                <div>
                    <?php if (!empty($todos)): ?>
                    <?php foreach ($todos as $t): ?>
                        <div class="my-4 flex flex-col">
                            <div class="flex mb-4 justify-between">
                                <div>
                                    <p class="text-lg font-medium"><?php echo $t['name']; ?></p>
                                    <p class="text-gray-400"><?php echo $t['description']; ?></p>
                                </div>
                                <button class="btn btn-green border-2" data-id="<?php echo $t['id']; ?>">Done</button>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <?php else: ?>
                        <p class="text-center text-xl font-semibold">Nothing to show</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </body>
</html>
