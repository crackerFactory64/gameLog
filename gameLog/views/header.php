<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

  <link rel="stylesheet" href="https://www.leemander.com/content/gameLog/style.css" type="text/css">

  <title>gameLog</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand" href="http://www.leemander.com/content/gameLog/">gameLog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="http://www.leemander.com/content/gameLog/">Recent<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://www.leemander.com/content/gameLog/?page=friends">Following</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://www.leemander.com/content/gameLog/?page=profile">Your Profile</a>
        </li>
      </ul>
    </div>


    <?php if ($_SESSION['id']) { ?>

      <p id="loggedInEmail">Welcome, <?php echo  $_SESSION['email']  ?></p>
      <a class="btn btn-light" href="http://www.leemander.com/content/gameLog/?function=logout">Sign Out</a>

    <?php } else { ?>

      <button type="button" class="btn btn-light" data-toggle="modal" id="signInHeaderButton" data-target="#signInModal">Sign In</button>

    <?php } ?>
  </nav>