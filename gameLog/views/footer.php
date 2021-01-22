        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        <!-- Sign In Modal -->
        <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="signInModalLabel">Sign In</h5>

              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="emailInput" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="passwordInput">
                  </div>
                  <div class="alert alert-warning error" id="signInError">
                  </div>
                  <input type="hidden" id="signInActive" value="1">
                </form>
              </div>
              <div class="modal-footer">
                <a id="inUpToggle" href="#">
                  <p><br>Need an account? Sign up</p>
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="signInClose">Close</button>
                <button id="signInButton" type="button" class="btn btn-success">Sign In</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Add gameLog Modal -->

        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add new gameLog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <input type="hidden" id="warned" value="0">
                  <div class="form-row" style="margin-bottom: 10px;">
                    <div class="col">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="title">
                    </div>
                    <div class="col">
                      <label for="platform">Platform</label>
                      <input type="text" class="form-control" id="platform" placeholder="Nintendo Switch, PC, etc.">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="rating">Star Rating</label>
                    <select class="form-control" name="rating" id="rating">
                      <option value="No rating">No rating</option>
                      <option value="1">&starf;</option>
                      <option value="2">&starf;&starf;</option>
                      <option value="3">&starf;&starf;&starf;</option>
                      <option value="4">&starf;&starf;&starf;&starf;</option>
                      <option value="5">&starf;&starf;&starf;&starf;&starf;</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="comments">Comments</label>
                    <textarea class="form-control" id="comments" rows="3"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="completed">Mark completed?</label>
                    <select class="form-control" name="completed" id="completed">
                      <option>Yes</option>
                      <option>No</option>
                    </select>
                  </div>

                  <div class="alert alert-warning error" id="newLogError">

                  </div>


                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveLogButton">Save changes</button>
              </div>
            </div>
          </div>
        </div>



        <script>
          $(document).ready(function() {

            $(".btn").click(function(event) {

              // Removes focus of the button.

              $(this).blur();

            });
          });

          $("#inUpToggle").click(function() {

            if ($("#signInActive").val() == "1") {

              $("#signInModalLabel").html("Sign Up");
              $("#signInButton").html("Sign Up");
              $("#exampleModalLabel").html("Sign Up");
              $(this).html("Already have an account? Sign in");
              $("#signInActive").val("0");

            } else {

              $("#signInModalLabel").html("Sign In");
              $("#signInButton").html("Sign In");
              $("#exampleModalLabel").html("Sign In");
              $(this).html("Need an account? Sign up");
              $("#signInActive").val("1");

            }

          });

          $("#signInButton").click(function() {

            $.ajax({

              type: "POST",
              url: "actions.php?action=signIn",
              data: "email=" + $("#emailInput").val() + "&password=" + $("#passwordInput").val() + "&signIn=" + $("#signInActive").val(),
              success: function(result) {

                if (result == "1") {

                  setTimeout(function() {

                    window.location.replace("http://www.leemander.com/content/gameLog/index.php");


                  }, 1000);

                } else {

                  $("#signInError").html("<br>" + result).show();
                }

              }


            })

          });

          $("#addButton").click(function() {

            $("#title").val('');
            $("#platform").val('');
            $("#rating").val('No rating');
            $("#comments").val('');
            $("#completed").val('');
            $("#newLogError").hide();
            <?php unset($_SESSION['warned']); ?>

          });

          $("#saveLogButton").click(function() {

            $.ajax({

              type: "POST",
              url: "actions.php?action=addNew",
              data: "title=" + $("#title").val() + "&platform=" + $("#platform").val() + "&rating=" + $("#rating").val() + "&comments=" + $("#comments").val() + "&completed=" + $("#completed").val() + "&warned=" + $("#warned").val(),
              success: function(result) {


                if (result.includes("1")) {

                  setTimeout(function() {

                    window.location.replace("http://www.leemander.com/content/gameLog/");
                    window.location.reload();

                  }, 1000);

                } else {

                  $("#newLogError").html("<br>" + result).show();

                }
              }

            })

          });

          $("#followButton").click(function() {

            $.ajax({

              type: "POST",
              url: "actions.php?action=follow",
              data: "id=" + "<?php echo $_GET['userid'] ?>",
              success: function(result) {

                var id = "<?php echo $_GET['email'] ?>";

                if (result == "1") {

                  $("#followButton").html('Unfollow<br><span class="plusSymbol">-<br></span>' + id);

                } else if (result == "2") {

                  alert("error");

                } else {

                  $("#followButton").html('Follow<br><span class="plusSymbol">+<br></span>' + id);
                }
              }


            })

          });
        </script>

        </body>



        </html>