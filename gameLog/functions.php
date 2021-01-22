<?php

session_start();

$link = mysqli_connect("shareddb-y.hosting.stackcp.net", "gameLog-3135393d40", "Bjr{=df!)_ab", "gameLog-3135393d40");

if (mysqli_connect_errno()) {

    print_r(mysqli_connect_error());
    exit();
}


if ($_GET['function'] == "logout") {

    session_unset();
}

function starMaker($stars)
{

    $starRating = "";

    if (is_numeric($stars)) {

        $initialStars = $stars;

        while ($stars > 0) {

            $starRating .= "&starf;";
            $stars--;
        }

        if ($stars < 5) {

            while ($initialStars + 1 < 6) {

                $starRating .= "&#9734";
                $initialStars++;
            }
        }

        return $starRating;
    } else {

        return $starRating;
    }
}

function checkedOrNot($yesNo)
{

    if ($yesNo == "Yes") {

        return "checked";
    } else {

        return "";
    }
}

function displayLogs($type)
{


    global $link;

    if ($type == "public") {

        $whereClause = " ";
    } else if ($type == "myProfile") {

        $whereClause = " WHERE `userid` ='" . mysqli_real_escape_string($link, $_SESSION['id']) . "' ";
    } else if ($type == "profile") {

        $whereClause = " WHERE `userid` ='" . mysqli_real_escape_string($link, $_GET['userid']) . "' ";
    } else if ($type == "friends") {

        $query = "SELECT * FROM followers WHERE `follower` = " . mysqli_real_escape_string($link, $_SESSION['id']);

        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {

            $whereClause = "";

            while ($row = mysqli_fetch_assoc($result)) {

                if ($whereClause == "") $whereClause = " WHERE ";
                else $whereClause .= " OR ";
                $whereClause .= " userid = '" . $row['isFollowing'] . "'";
            }
        }
    } else {

        echo "log type error";
    }

    $query = "SELECT * FROM games" . $whereClause . "ORDER BY `id` DESC LIMIT 10";

    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 0) {

        echo "There are no gameLogs to display.";
    } else {


        while ($row = mysqli_fetch_assoc($result)) {

            $userQuery = "SELECT `email` FROM users WHERE `id` = '" . mysqli_real_escape_string($link, $row['userid']) . "' LIMIT 1";

            $userResult = mysqli_query($link, $userQuery);

            $userRow = mysqli_fetch_assoc($userResult);

            echo "<div class='gameLog'>" .

                "<p><span class='titleText'>" . $row['title'] . "</span> 
                        <span class='platformText'>" . $row['platform'] . "</span>
                        <span class='userEmail'><a href='http://www.leemander.com/content/gameLog/?page=profile&userid=" . $row['userid'] . "&email=" . $userRow['email'] . "'>" . $userRow['email'] . "</a></span></p>" .
                "<p class='commentsText'>\"" . $row['comments'] . "\"</p>" .
                "<p class='ratingText'>" . starMaker($row['rating']) . "</p>" .
                "<form class='completedText'><label for='completedCheck'>Completed:</label><input type='checkbox' class='completedCheck' name='completedCheck' " . checkedOrNot($row['completed']) . " disabled></form>" .

                "</div>";
        }
    }
}

function getHiScores()
{

    global $link;

    $query = "SELECT `title`, `rating`, `userid` FROM games WHERE `rating` >= 4 ORDER BY `id` DESC LIMIT 10";

    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {

        $userQuery = "SELECT `email` FROM users WHERE `id` = '" . mysqli_real_escape_string($link, $row['userid']) . "' LIMIT 1";

        $userResult = mysqli_query($link, $userQuery);

        $userRow = mysqli_fetch_assoc($userResult);

        echo "<p><a href='http://www.leemander.com/content/gameLog/?page=profile&userid=" . $row['userid'] . "&email=" . $userRow['email'] . "'>" . $userRow['email'] . "</a> rated <span class='hiScoreTitle'>" . $row['title'] . "</span><span class='hiScoreRating'>" . starMaker($row['rating']) . "</span></p>";
    }
}
