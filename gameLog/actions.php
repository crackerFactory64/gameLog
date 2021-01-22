<?php

include("functions.php");

if ($_GET["action"] == "signIn") {

    $error = "<p><strong>Uh-oh! Please fix the following and try again: </strong><br></p>";

    if ($_POST['email'] == "") {

        $error .= "<p>Please enter an email address.</p>";
    } else if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false) {

        $error .= "<p>Please enter a valid email address.</p>";
    }

    if ($_POST['password'] == "") {

        $error .= "<p>Please enter a password.</p>";
    }

    if ($error != "<p><strong>Uh-oh! Please fix the following and try again: </strong><br></p>") {

        echo $error;
        exit();
    }

    if ($_POST['signIn'] == "0") {

        $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) > 0) {

            $error .= "<p>An account with that email address already exists.</p>";
            echo $error;
        } else {

            $query = "INSERT INTO users (`email`, `password`) VALUES ('" . mysqli_real_escape_string($link, $_POST['email']) . "', '" . mysqli_real_escape_string($link, $_POST['password']) . "')";

            if (mysqli_query($link, $query)) {

                $_SESSION['id'] = mysqli_insert_id($link);

                $query = "UPDATE users SET password = '" . md5(md5(mysqli_insert_id($link)) . $_POST['password']) . "' WHERE id =" . $_SESSION['id'] . " LIMIT 1";
                mysqli_query($link, $query);
                $_SESSION['email'] = $_POST['email'];
                echo "1";
            } else {

                echo "Error";
            }
        }
    } else if ($_POST['signIn'] == "1") {

        $query = "SELECT * FROM users WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";
        $result = mysqli_query($link, $query);
        if (mysqli_num_rows($result) == 0) {

            $error .= "<p>No account with that email address exists.</p>";
        } else {

            $row = mysqli_fetch_assoc($result);

            if (md5(md5($row['id']) . $_POST['password']) != $row['password']) {

                $error .= "<p>Password incorrect.</p>";
            }
        }

        if ($error != "<p><strong>Uh-oh! Please fix the following and try again: </strong><br></p>") {

            echo $error;
        } else {

            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            echo "1";
        }
    }
};

if ($_GET['action'] == 'addNew') {

    $error = "<p><strong>Uh-oh! Please fix the following and try again: </strong><br></p>";

    $warning = "<p><strong>You have empty optional fields in your gameLog: </strong><br></p>";

    if ($_POST['title'] == "") {

        $error .= "<p>Please enter a game title.</p>";
    }

    if ($_POST['platform'] == "") {

        $error .= "<p>Please enter a platform.</p>";
    }

    if ($_POST['rating'] == "No rating") {

        $warning .= "<p>Rating</p>";
    }

    if ($_POST['comments'] == "") {

        $warning .= "<p>Comments</p>";
    } else if (strlen($_POST['comments']) > 500) {

        $error .= "<p>Comments can not exceed 500 characters.</p>";
    }

    if ($error != "<p><strong>Uh-oh! Please fix the following and try again: </strong><br></p>") {

        echo $error;
        exit();
    } else if ($warning != "<p><strong>You have empty optional fields in your gameLog: </strong><br></p>") {

        echo $warning . "<p><strong>Feel free to leave them empty or fill them in now. Click the save changes button again to continue. </strong></p>";

        if ($_SESSION['warned'] == "1") {

            $query = "INSERT INTO games (`userid`, `title`, `platform`, `rating`, `comments`, `completed`) VALUES ('" . $_SESSION['id'] . "', '" . mysqli_real_escape_string($link, $_POST['title']) . "', '" . mysqli_real_escape_string($link, $_POST['platform']) . "', '" . $_POST['rating'] . "', '" . mysqli_real_escape_string($link, $_POST['comments']) . "', '" . $_POST['completed'] . "')";

            if (mysqli_query($link, $query)) {

                unset($_SESSION['warned']);
                echo "1";
            } else {

                unset($_SESSION['warned']);
                echo "2";
            }
        }

        $_SESSION['warned'] = "1";
    } else {

        $query = "INSERT INTO games (`userid`, `title`, `platform`, `rating`, `comments`, `completed`) VALUES ('" . $_SESSION['id'] . "', '" . mysqli_real_escape_string($link, $_POST['title']) . "', '" . mysqli_real_escape_string($link, $_POST['platform']) . "', '" . $_POST['rating'] . "', '" . mysqli_real_escape_string($link, $_POST['comments']) . "', '" . $_POST['completed'] . "')";

        if (mysqli_query($link, $query)) {

            echo "1";
        } else {

            echo "2";
        }
    }
};

if ($_GET['action'] == "follow") {

    $query = "SELECT * FROM followers WHERE `follower` = '" . mysqli_real_escape_string($link, $_SESSION['id']) . "' AND `isFollowing` = '" . mysqli_real_escape_string($link, $_POST['id']) . "'";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 0) {

        $query = "INSERT INTO followers (`follower`, `isFollowing`) VALUES ('" . mysqli_real_escape_string($link, $_SESSION['id']) . "', '" . mysqli_real_escape_string($link, $_POST['id']) . "')";

        if (mysqli_query($link, $query)) {

            echo "1";
        } else {

            echo "2";
        }
    } else {

        $query = "DELETE FROM followers WHERE `follower` = '" . mysqli_real_escape_string($link, $_SESSION['id']) . "' AND `isFollowing` = '" . mysqli_real_escape_string($link, $_POST['id']) . "'";

        if (mysqli_query($link, $query)) {

            echo "3";
        } else {

            echo "2";
        }
    }
};
