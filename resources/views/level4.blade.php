<html>
  <?php
    include_once('header.php');
    use App\Users;
  ?>

  <body id="home">

    <?php include_once('nav_after_login.php'); ?>



    <div class="container-fluid body">
      <div class="parallax-container level-4-container valign-wrapper">
        <div class="section">
          <div class="container">
            <div class="row center">
              <div class="col s12 level-number white-text left-align offset-s1"><h5>Level 4</h5></div>
              <div class="level-content col s12">
                <div class="level-image-container">
                  <script>
                    var word = new Array(); //words stored in array
                    word[0] = "fox";
                    word[2] = "ox";
                    word[4] = "bear";
                    word[6] = "bird";
                    word[9] = "mouse";
                    word[8] = "wolf";
                    word[7] = "toad";
                    word[5] = "whale";
                    word[3] = "bee";
                    word[1] = "tiger";
                    function show() {
                      var i = Math.floor((Math.random()*10));
                      document.getElementById('display').innerHTML = word[i];
                    }
                  </script>
                  <p class="white-text" id="display"></p>
                  <input type="button" class="btn btn-default green" onclick="show()" value="Generate!" />
                  
                </div>
              </div> 

              <form method="post" action="/checkAnswer">
              @if(Session::has('message'))
                <div class="row answer-message " >
                  <div class="left-align col s10 offset-s2 white-text">
                      {{Session::get('message')}}
                  </div>
                </div>
                @endif
                <div class="row">

                  <div class="col s6 offset-s2 input-field">
                    <input type="text" class="validate answer-box" id="answer" placeholder="Answer" name="answer">
                    <input type="hidden" value="5" name="presentId">
                  </div>
                  <div class="col s3">
                    <input type="submit" class="btn level-submit" value="Submit" />
                  </div>
                </div>
              </form>
            </div>

          </div>
           
        </div>
        <div class="parallax">
          <img src="images/banner.jpg" style="display: block; transform: translate3d(-50%, 316px, 0px);"></img>
        </div>
      </div>


    </div>

    <?php include_once('footer.php');?>
    <script src="js/index.js"></script>
    <?php
    echo "<!--".Users::getHintSource(4)."-->";
    ?>
  </body>
</html>

