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
              <div class="col s12 level-number white-text left-align offset-s1"><h5>Level 25</h5></div>
              <div class="level-content col s12">
                <div class="level-image-container">
                  <img class="level-image" src="asasas.jpg" usemap="#Map" />
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
                    <input type="hidden" value="30" name="presentId">
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
          <map name="Map" id="Map">
            <area alt="" title="" id="1" id="a1" shape="poly" coords="134,89,144,74,152,63,166,53,183,43,210,33,237,32,264,39,287,50,300,63,312,76,320,90,288,89,274,95,252,105,234,115,228,122,211,107,184,95,161,90" />
            <area alt="" title="" id="2" shape="poly" coords="323,92,327,109,331,127,330,147,324,167,319,182,316,187,336,201,349,211,358,223,372,243,379,260,379,267,393,248,400,230,407,220,410,194,406,169,396,140,376,114,351,100" />

            <area alt="" title="" id="3" shape="poly" coords="378,269,361,285,342,292,321,297,301,297,285,295,280,311,276,327,267,339,258,353,246,366,228,379,244,387,270,391,294,389,315,383,330,375,346,363,358,349,371,329,380,304,382,290" />
            <area alt="" title="" id="4" shape="poly" coords="227,379,208,367,195,353,184,335,175,312,172,292,148,298,123,294,100,284,84,274,75,269,75,291,78,314,86,336,101,355,122,373,146,385,172,391,201,390" />
            <area alt="" id="5" title="" shape="poly" coords="134,92,124,116,124,139,126,165,139,190,116,201,99,217,86,238,76,262,76,268,56,244,45,211,43,173,56,146,71,125,95,104,107,98" />
        </map>
        </div>
      </div>


    </div>

    <?php include_once('footer.php');?>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#1').on('click', function(e) {
        e.preventDefault();
        window.location.pathname = "25-1.jpg";
      });
      $('#2').on('click', function(e) {
        e.preventDefault();
        window.location.pathname = "25-2.jpg";
      });
      $('#3').on('click', function(e) {
        e.preventDefault();
        window.location.pathname = "25-3.jpg";
      });
      $('#4').on('click', function(e) {
        e.preventDefault();
        window.location.pathname = "25-4.jpg";
      });
      $('#5').on('click', function(e) {
        e.preventDefault();
        window.location.pathname = "25-5.jpg";
      });
    });
    </script>
    <?php
    echo "<!--".Users::getHintSource(25)."-->";
    ?>
  </body>
</html>

<html>
  