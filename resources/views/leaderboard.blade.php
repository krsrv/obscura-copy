<html>
  <?php
    include_once('header.php');
    use App\Users;
  ?>

  <body id="home">

  <?php include_once('nav_after_login.php'); ?>


   






<div class="container-fluid body leaderboard-container">
      <div class="parallax-container  valign-wrapper">
        <div class="section">
          <div class="container">
            <div class="row center">
              <div class="col s11 level-number white-text center-align"><h5 >Leaderboard</h5></div>
              <div class="level-content col s12">
                <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-3 col-xs-12" style="background:#000; opacity: 0.6; color:#E7E3E3; font-size:20px">
            <table class="leaderboard">
              <tr>
                <th >Rank</th>
                <th >Name</th> 
                <th >College</th>
                <th >Level</th>
              </tr>
              <?php $i=0;?>
            @foreach($lead as $user)
            <tr>
              <td class="col s1">{{$i++}}</td>
              <td class="col s3">{{$user->first_name}}{{" "}}{{$user->last_name}}</td>
              <td class="col s7">{{$user->college}}</td>
              <td class="col s1">{{$user->level}}</td>
            </tr>
            @endforeach

            </table>

            </div>
            </div>
              </div> 

              
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

  </body>
</html>

