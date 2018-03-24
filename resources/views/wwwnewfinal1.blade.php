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
                  <img class="level-image" src="/levelx/wwwnewfinal1.jpg" usemap="#Map6" />
                </div>
              </div> 

               <form method="post" action="/checkAnswer"> 
                @if(Session::has('message'))
                <div class="answer-message " >
                  <div class="left-align col s10 offset-s2 white-text">
                      {{Session::get('message')}}
                  </div>
                </div>
                @endif
                <div class="row">

                  <div class="col s6 offset-s2 input-field">
                  <input type="hidden" value="22" name="presentId">
                    <input type="text" class="validate answer-box" id="answer" placeholder="Answer" name="anxswer">
                    
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
          <map name="Map6" id="Map6">
              <area alt="" title="" href="#" shape="poly" coords="282,175,275,189,283,200,291,200,301,190,299,179,292,172" />
              <area alt="" title="" href="#" shape="poly" coords="14,269,44,258,57,247,54,234,36,232,21,232,7,237,0,244,3,257,7,267" />
              <area alt="" title="" href="#" shape="poly" coords="497,103,499,117,511,120,519,114,515,104,504,101" />
              <area alt="" title="" href="#" shape="poly" coords="615,196,626,199,635,192,628,186,618,185,608,183,601,182,595,184,601,191,598,197,592,201,588,208,586,211,583,217,581,224,589,226,597,225,599,215,603,220,612,225,614,213,610,205" />
              <area alt="" title="" href="#" shape="poly" coords="72,63,66,95,83,104,92,75,92,67" />
              <area alt="" title="" href="#" shape="poly" coords="286,97,283,112,294,117,306,109,307,100,299,93" />
              <area alt="" title="" href="#" shape="poly" coords="470,254,464,203,456,198,456,179,457,171,471,171,476,185,471,195,471,207,473,225,473,238,472,249,474,255" />
              <area alt="" title="" href="#" shape="poly" coords="228,182,227,194,231,199,231,207,241,211,243,198,249,192,247,179,234,177" />
              <area alt="" title="" href="#" shape="poly" coords="129,292,128,300,137,308,148,309,154,301,154,291,139,288" />
            
          </map>
        </div>
      </div>


    </div>

    <?php include_once('footer.php');?>
    <script src="js/index.js"></script>
    <script>
    
    $(document).ready(function() {
      alert('room');
    });
    </script>
  </body>
</html>

