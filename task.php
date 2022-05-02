<?php
session_start();

require 'classes/DB.php';
include 'classes/globals.php';
include 'classes/Input.php';

if (!isset($_SESSION["ID"])) {
    header("Location: ./user.php?action=login");
}


if (isset($_GET["action"]) && !empty($_GET["action"])) {
    $action = Input::sanitize($_GET["action"]);
    $title = "";
    $description = "";
    $error = "";

    if (isset($_GET["id"])) {
        $taskID = Input::sanitize($_GET["id"]);
        $taskInformation = DB::query("SELECT title, `description`, userid FROM tasks WHERE id=:i", array(":i" => $taskID));
        if (0 == count($taskInformation)) {
            header("Location: ./");
        }

        if ("delete" === $action) {
            DB::query("DELETE FROM tasks WHERE id=:i", array(":i" => $taskID));
            header("Location: ./");
        }

        $taskUID = $taskInformation[0]["userid"];
        $title = $taskInformation[0]["title"];
        $description = $taskInformation[0]["description"];

        if ($_SESSION["ID"] != $taskUID) {
            header("Location: ./");
        }

        if (isset($_POST["title"]) && isset($_POST["description"])) {
            $title = Input::sanitize($_POST["title"]);
            $description = Input::sanitize($_POST["description"]);

            if (empty($title) || empty($description)) {
                $error = "Fill in missing information!";
            }
        }

        if ("edit" === $action && isset($_POST["edit"])) {
            if (empty($error)) {
                try {
                    DB::query("UPDATE tasks SET title=:t, `description`=:d WHERE id=:i", array(":t" => $title, ":d" => $description, ":i" => $taskID));
                    header("Location: ./");
                } catch (PDOException $e) {
                    $error = "Something went wrong!";
                }
            }
        }
    }

    if ("add" === $action && isset($_POST["add"])) {
        $title = Input::sanitize($_POST["title"]);
        $description = Input::sanitize($_POST["description"]);

        if (empty($title) || empty($description)) {
            $error = "Fill in missing information!";
        }

        if (empty($error)) {
            $query = "INSERT INTO tasks (title, `description`, userid, created_at) VALUES (:t, :d, :i, NOW())";
            $params = array(":t" => $title, ":d" => $description, ":i" => $_SESSION["ID"]);
            DB::query($query, $params);
            header("Location: ./");
        }
    }
} else {
    header("Location: ./");
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $_GLOBALS["APP_ROOT"]; ?>assets/css/tailwind.css">
    <title><?php echo ucfirst($action); ?> Task</title>
</head>

<body>

    <div class="h-screen bg-gradient-to-br from-blue-500 to-blue-800 flex items-center justify-center">
        <div class="bg-white w-1/2 p-4 rounded">
            <h1 class="head"><?php echo ucfirst($action); ?> Task</h1>
            <hr class="my-2">
            <?php if (Input::doesExist($error)) : ?>
                <div class="bg-red-200 border border-red-500 text-red-500 rounded px-4 py-2 my-2">
                    <?php echo $error; ?>
                </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" autofocus <?php if (Input::doesExist($title)) {
                                                                                                                            echo 'value="' . $title . '"';
                                                                                                                        } ?>>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter task description"><?php if (Input::doesExist($description)) {
                                                                                                                                            echo $description;
                                                                                                                                        } ?></textarea>
                </div>
                <button type="submit" name="<?php echo $action ?>" class="btn btn-primary"><?php echo ucfirst($action); ?> Task</button>
                <a href="./" class="btn btn-dark-outline">Go Back</a>
            </form>
        </div>
    </div>

    <script src="<?php echo $_GLOBALS["APP_ROOT"]; ?>assets/js/fix.js"></script>

</body>

</html>