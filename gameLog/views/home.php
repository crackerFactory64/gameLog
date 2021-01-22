<div class="container">

    <div class="row">

        <div class="col-md-8">

            <h1>Recent gameLogs</h1>

        </div>


    </div>

    <div class="row">

        <div class="col-md-7">

            <?php displayLogs('public'); ?>

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