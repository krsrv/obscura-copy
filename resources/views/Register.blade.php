<html>
  <?php
    include_once('header.php');
  ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <body id="home">

   <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
              <a href="/" class="brand-logo"><img src="images/logo.jpg" class="logo-image">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obscura</a>
              <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
              <ul class="right hide-on-med-and-down">
                  
            <li><a class="waves-effect waves-light" href="/signup">Signup</a></li>
            <li><a class="waves-effect waves-light" href="/login">Login</a></li>

              </ul>

              <ul class="side-nav" id="mobile-demo">
            <li><a href="#home">Home</a></li>
                  <li><a href="#about">About</a></li>
                  <li><a href="#rules">Rules</a></li>

              </ul>
            </div>
        </nav>
    </div>


    <div class="container-fluid body">
      <div class="full valign-wrapper">
        <div class="section">
          <div class="container">
            <div class="row center">

                <div class="row">
                  <div class="row col s12"><p class="message"></p></div>
                  <div class="login-block signup-block">
                    <div class="row"><p id="message"></p></div>
                    <div class="row">
                      <div class="logmod__alter">
                      <div class="logmod__alter-container">

                          <a href="/fb_login" class="connect facebook">
                          <div class="connect__icon">
                            <i class="fa fa-facebook"></i>
                          </div>
                          <div class="connect__context">
                            <span>Signup with <strong>Facebook</strong></span>
                          </div>
                          </a>

                          <a href="/google_login" class="connect googleplus">
                          <div class="connect__icon">
                            <i class="fa fa-google-plus"></i>
                          </div>
                          <div class="connect__context">
                            <span>Signup with <strong>Google+</strong></span>
                          </div>
                          </a>
                        </div>
                      </div>
                    </div>

                    <h1>OR</h1>
                                @if($errors->has())
            @foreach($errors->all() as $error)
              <p>{{ $error }}<br>
            @endforeach
          @endif
                    <form method="post" action="/postSignup">
                    <div class="col m6 s12">
                      <input type="text" placeholder="First Name" id="firstname" name="first_name" value="{{Input::old('first_name')}}"  required/>
                    </div>
                    <div class="col s12 m6">
                      <input type="text" placeholder="Last Name" id="lastname" name="last_name" value="{{Input::old('last_name')}}" required/>

                    </div>

                    <div class="col m6 s12">
                      <input type="text" placeholder="Email" id="username" name="email" value="{{Input::old('email')}}"  required />
                    </div>
                    <div class="col s12 m6">
                      <input type="text"  placeholder="Phone" id="phone" name="mobno" value="{{Input::old('mobno')}}" required/>
                    </div>
                    <div class="col m6 s12">
                      <input type="password"  placeholder="Password" id="password" name="password" required/>
                    </div>
                    <div class="col m6 s12">
                    <input type="password" placeholder="Confirm Password" id="confirm-password" name="password_confirmation" required/>
                  </div>
                  <div class="col m12 s12">
                    <input type="text" placeholder="College Name" id="confirm-password" name="college" value="{{Input::old('college')}}" required/>
                  </div>
                    <div class="row">
                      <div class="col m6 s12 captcha">
                          {!! app('captcha')->display(); !!}               
                     </div>

                        <button type="submit" class="col m5 s12 signup-btn">Signup</button>
                      </div>
                  </div>
                  <div class="row"></div>
                </div>
                </form>
                <div class="row">
                  <!-- Captcha here, it will resize automatically-->
                </div>

                <div class="row"></div>
            </div>
          </div>
        </div>
        <div class="parallax">
          <img src="images/banner.jpg" style="display: block; transform: translate3d(-50%, 316px, 0px);"></img>
        </div>
      </div>





    </div>

    <?php include_once('footer.php');?>

  </body>
</html>
