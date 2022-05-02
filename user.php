<?php
session_start();

require 'classes/DB.php';
include 'classes/globals.php';
include 'classes/Input.php';

if (!isset($_GET["action"]) || empty($_GET["action"])) {
    header("Location: ./user.php?action=register");
}

if (isset($_SESSION["ID"]) && !empty($_SESSION["ID"])) {
    header("Location: ./");
}

if (isset($_GET["action"]) && !empty($_GET["action"])) {
    $action = Input::sanitize($_GET["action"]);
    $error = "";

    if ("register" === $action && isset($_POST["register"])) {
        $username = Input::sanitize($_POST["username"]);
        $password = Input::sanitize($_POST["password"]);

        if (empty($username) || empty($password)) {
            $error = "Fill in missing information!";
        }

        if (strlen($username) < 6 || strlen($username) >= 32) {
            $error = "Username must be between 6 and 32 characters!";
        }

        if (DB::query("SELECT username FROM users WHERE username=:u", array(":u" => $username))) {
            $error = "Username already exists!";
        }

        if (strlen($password) < 6 || strlen($password) >= 32) {
            $error = "Password must be between 6 and 32 characters!";
        }

        if (empty($error)) {
            try {
                DB::query("INSERT INTO users (username, `password`, created_at) VALUES (:u, :p, NOW())", array(":u" => $username, ":p" => password_hash($password, PASSWORD_BCRYPT)));
                $userID = DB::query("SELECT id FROM users WHERE username=:u", array(":u" => $username))[0]["id"];
                $_SESSION["ID"] = $userID;
                $_SESSION["username"] = $username;
            } catch (PDOException $e) {
                $error = "Something went wrong! Please try again later";
            }
            header("Location: ./");
        }
    }

    if ("login" === $action && isset($_POST["login"])) {
        $username = Input::sanitize($_POST["username"]);
        $password = Input::sanitize($_POST["password"]);

        if (empty($username) || empty($password)) {
            $error = "Fill in missing information!";
        }

        if (empty($error)) {
            if (password_verify($password, DB::query("SELECT `password` FROM users WHERE username=:u", array(":u"=>$username))[0]["password"])) {
                $userID = DB::query("SELECT id FROM users WHERE username=:u", array(":u"=>$username))[0]["id"];

                $_SESSION["ID"] = $userID;
                $_SESSION["username"] = $username;
                header("Location: ./");
            }
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo $_GLOBALS["APP_ROOT"]; ?>assets/css/tailwind.css">
    <title><?php echo ucfirst($action); ?> User - Task</title>
</head>

<body>
    <div class="h-screen bg-gradient-to-br from-blue-500 to-blue-800 flex items-center justify-center">
        <div class="bg-white w-1/2 p-4 rounded">
            <h1 class="head"><?php echo ucfirst($action); ?> User</h1>
            <hr class="my-2">
            <?php if (Input::doesExist($error)): ?>
                <div class="bg-red-200 border border-red-500 text-red-500 rounded px-4 py-2 my-2">
                    <?php echo $error; ?>
                </div>
            <?php endif ?>
            <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" autofocus <?php if(Input::doesExist($error)){if(Input::doesExist($username)){echo'value="'.$username.'"';}} ?>>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" <?php if(Input::doesExist($error)){if(Input::doesExist($password)){echo'value="'.$password.'"';}} ?>>
                </div>
                <?php if ("register" === $action) : ?>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                    <a href="./user.php?action=login" class="btn btn-dark-outline">Login</a>
                <?php endif ?>
                <?php if ("login" === $action) : ?>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                    <a href="./user.php?action=register" class="btn btn-dark-outline">Register</a>
                <?php endif ?>
            </form>
        </div>
    </div>

    <script src="<?php echo $_GLOBALS["APP_ROOT"]; ?>assets/js/fix.js"></script>
</body>

</html>