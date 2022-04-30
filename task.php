<?php
session_start();

require 'classes/DB.php';
include 'classes/Input.php';

if (!isset($_SESSION["ID"])) {
    header("Location: ./user.php?action=login");
}

if (isset($_GET["action"]) && !empty($_GET["action"])) {
    $action = Input::sanitize($_GET["action"]);
    $error = "";

    if ("add" === $action && isset($_POST['add'])) {
        $title = Input::sanitize($_POST["title"]);
        $description = Input::sanitize($_POST["description"]);

        if (empty($title) || empty($description)) {
            $error = "Fill in missing information!";
        }

        if (empty($error)) {
            try {
                DB::query("INSERT INTO tasks (title, `description`, userid, created_at) VALUES (:t, :d, :u, NOW())", array(":t"=>$title, ":d"=>$description, ":u"=>$_SESSION["ID"]));
                header("Location: ./");
            } catch (PDOException $e) {
                $error = "Something went wrong!";
            }
        }

    }

    if ("edit" === $action && isset($_GET["id"])) {
        if (isset($_POST["edit"])) {
            // Code: 
        }
    }

    if ("delete" === $action && Input::doesExist($_GET["id"])) {
        $taskID = Input::sanitize($_GET["id"]);
        $userID = DB::query("SELECT userid FROM tasks WHERE id=:i", array(":i"=>$_SESSION["ID"]))[0]["userid"];
        
        if (!$taskID) {
            header("Location: ./");
        }

        if ($_SESSION["ID"] == $userID) {
            DB::query("DELETE FROM tasks WHERE id=:i", array(":i"=>$taskID));
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
    <link rel="stylesheet" href="./assets/css/tailwind.css">
    <title><?php echo ucfirst($action); ?> Task</title>
</head>

<body>
    <div class="h-screen bg-gradient-to-br from-blue-500 to-blue-800 flex items-center justify-center">
        <div class="bg-white w-1/2 p-4 rounded">
            <h1 class="head"><?php echo ucfirst($action); ?> Task</h1>
            <hr class="my-2">
            <?php if (Input::doesExist($error)): ?>
                <div class="bg-red-200 border border-red-500 text-red-500 rounded px-4 py-2 my-2">
                    <?php echo $error; ?>
                </div>
            <?php endif ?>
            <?php if ("add" === $action): ?>
                <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" autofocus <?php if(Input::doesExist($error)){if(Input::doesExist($title)){echo'value="'.$title.'"';}} ?>>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter task description"><?php if(Input::doesExist($error)){if(Input::doesExist($description)){echo'value="'.$description.'"';}} ?></textarea>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Add Task</button>
                    <a href="./" class="btn btn-dark-outline">Go Back</a>
                </form>
            <?php endif ?>
        </div>
    </div>

    <script src="./assets/js/fix.js"></script>

</body>

</html>