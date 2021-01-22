<div class="container">

    <div class="row">

        <?php if ($_GET['userid']) { ?>

            <h1><?php echo $_GET['email']; ?>'s gameLogs</h1>

        <?php } else { ?>

            <div class="col-md-8">

                <h1>Your gameLogs</h1>

            </div>

        <?php }; ?>
    </div>


    <div class="row">

        <div class="col-md-7">

            <?php if ($_GET['userid']) {

                displayLogs('profile');
            } else if ($_SESSION['id']) {

                displayLogs('myProfile');
            } else { ?>

                <p>Sign in to see all of the games you have logged. Or create an account and get logging!</p>

            <?php }; ?>
        </div>

        <div class="col-md-5">

            <?php if ($_SESSION['id']) {

                if ($_GET['email'] and $_GET['email'] != $_SESSION['email']) { ?>

                    <button class="btn btn-light" id="followButton"><?php

                                                                    $query = "SELECT * FROM followers WHERE `follower` = '" . mysqli_real_escape_string($link, $_SESSION['id']) . "' AND `isFollowing` = '" . mysqli_real_escape_string($link, $_GET['userid']) . "'";

                                                                    if (mysqli_num_rows(mysqli_query($link, $query)) == 0) { ?>

                            Follow<br><span class="plusSymbol">+<br></span>

                        <?php } else { ?>

                            Unfollow<br><span class="plusSymbol">-<br></span>

                        <?php } ?>

                        <?php echo $_GET['email']; ?></button>

                <?php }; ?>

                <button class="btn btn-light" data-toggle="modal" data-target="#addModal" id="addButton">Add new<br><span class="plusSymbol">+<br></span>gameLog</button>

                <hr>

            <?php }; ?>

            <div id="hiScores">

                <h2>Recent High Ratings</h2>

                <?php getHiScores(); ?>

            </div>

        </div>

    </div>




</div>