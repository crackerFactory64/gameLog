<?php

include("functions.php");

include("views/header.php");

if ($_GET["page"] == "friends") {

    include("views/friends.php");
} else if ($_GET["page"] == "profile") {

    include("views/profile.php");
} else {

    include("views/home.php");
}

include("views/footer.php");
