<html>
  <?php
    include_once('header.php');
    use App\Users;
  ?>
  <body id="home">

  <?php include_once('nav_after_login.php'); ?>


    <div class="container-fluid body">
      <div class="parallax-container levels-container valign-wrapper">
        <div class="section">
          <div class="container">
            <div class="row center">
              <div class="col s12 level-number white-text left-align offset-s1"><h5>Level 22</h5></div>
              <div class="level-content col s12">
                <div class="level-image-container">
                  <img class="level-image" src="/levelx/prophecy.jpg" usemap="#Map1" />
                </div>
              </div> 
              @if(Session::has('message'))
                <div class="answer-message " >
                  <div class="left-align col s10 offset-s2 white-text">
                      {{Session::get('message')}}
                  </div>
                </div>
                @endif
               <form method="post" action="/checkAnswer"> 
                
                <div class="row">

                  <div class="col s6 offset-s2 input-field">
                  <input type="hidden" value="22" name="presentId">
                    <input type="text" class="validate answer-box" id="answer" placeholder="Answer" name="answemr">
                    
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
        <map name="Map1" id="Map1">
            <area alt="" title="" shape="poly" coords="282,175,275,189,283,200,291,200,301,190,299,179,292,172" />
            
        </map>
      </div>


    </div>

    <?php include_once('footer.php');?>
     <?php
    echo "<!--".Users::getHintSource(22)."-->";
    ?>
  </body>
</html>

