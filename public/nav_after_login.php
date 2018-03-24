<?php
use App\Users;
$maxLevel = Users::getUserMaxLevel(Auth::id());
?>

<div class="navbar-fixed">
		    <nav>
		      	<div class="nav-wrapper">
		        	<a href="/" class="brand-logo"><img src="/images/logo.jpg" class="logo-image">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obscura</a>
		        	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		        	<ul class="right hide-on-med-and-down">
		          		<li><a class="waves-effect waves-light" href="/dashboard">Home</a></li>
						<li><a class="waves-effect waves-light" href="https://www.facebook.com/obscuranitkkr" target="_blank">Forum</a></li>
						<li><a class="waves-effect waves-light" href="/leaderboard">Leaderboard</a></li>
						<li><a class="dropdown-button" href="#!" data-activates="levels">Levels<i class="material-icons right">arrow_drop_down</i></a></li>

						<li><a class="dropdown-button" href="#!" data-activates="logout"><?php echo Users::getFirstName(Auth::id()); ?><i class="material-icons right">arrow_drop_down</i></a></li>




		        	</ul>

		        	 <ul id='logout' class='dropdown-content'>
					  	<li><a href="/logout">Logout</a></li>
					</ul>

					<ul id='levels' class='dropdown-content'>
					<?php
						$i = 0;
						for($i = 0;$i <=$maxLevel; $i++)
						{
							if($i == 31)
							{
								echo "<li><a href='/shiftone'>Level"."$i"."</a></li>";
							}
							else if($i==32)
							{
								echo "<li><a href='/congo'>Level"."$i"."</a></li>";
							}
							else
							 echo "<li><a href='/level".$i."''>Level"."$i"."</a></li>";
						}
					?>
					  	
					</ul>
		        	<ul class="side-nav" id="mobile-demo">
						<li><a href="/">Home</a></li>
						<li><a href="https://www.facebook.com/obscuranitkkr" target="_blank">Forum</a></li>
						<li><a href="/leaderboard">Leaderboard</a></li>
						<li><a href="/logout">Logout</a></li>

			      	</ul>
		      	</div>
		    </nav>
		</div>
