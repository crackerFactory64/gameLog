<div class="container">

    <div class="row">

        <div class="col-md-8">

            <h1>gameLogs From People You're Following</h1>

        </div>


    </div>

    <div class="row">

        <div class="col-md-7">

            <?php if ($_SESSION['id']) {

                displayLogs('friends');
            } else { ?>

                <p>Sign in to see your friends' gameLogs or create an account and start following people!</p>

            <?php }; ?>


        </div>

        <div class="col-md-5">

            <?php if ($_SESSION['id']) { ?>

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