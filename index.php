<?php
session_start();

require 'classes/DB.php';

if (!isset($_SESSION["ID"])) {
    header("Location: ./user.php?action=login");
}

$userTasks = DB::query("SELECT * FROM tasks WHERE userid=:u", array(":u"=>$_SESSION["ID"]));

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <title><?php echo $_SESSION["username"]; ?> task</title>
</head>

<body>
    <div class="h-screen bg-gradient-to-br from-blue-500 to-blue-800 flex items-center justify-center">
        <div class="bg-white w-1/2 p-4 rounded">
            <?php if (count($userTasks) > 0): ?>
                <?php foreach ($userTasks as $task): ?>
                    <div class="card">
                        <h1><?php echo $task["title"]; ?></h1>
                        <p><?php echo $task["description"]; ?></p>
                        <div class="mt-2">
                            <button class="btn btn-primary" onclick='action(<?php echo $task["id"]; ?>, "delete")'>Done</button>
                            <button class="btn btn-dark-outline" onclick='action(<?php echo $task["id"]; ?>, "edit")'>Edit</button>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
            <div class="card">
                <h1>You have no task</h1>
                <p>To add a task press "a"</p>
                <div class="mt-2">
                    <a class="btn btn-primary" href="./task.php?action=add">Add Task</a>
                </div>
            </div>
            <?php endif ?>
        </div>
    </div>

    <script>
        window.addEventListener("keydown", function (e) {
            if (e.key == "a") {
                window.location.href = "./task.php?action=add";
            }
        });
        function action(id, action) {
            window.location.href = "./task.php?action=" + action + "&id="+id;
        }
    </script>

</body>

</html>