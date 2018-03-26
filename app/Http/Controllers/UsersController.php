<?php

namespace App\Http\Controllers;
use App\Task;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;
use Auth;
use Mail;
use Socialite;
use App\Users;
use App\Levels;
use App\Ticker;
use App\Answer;
use Input;
use Redirect;
use Hash;
use Session;
use resources\views;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
    public function feedback()
    {
        $userId = Auth::id();
        $getFeedback = Users::getFeedback($userId);
        return view('feedback')->with('getFeedback',$getFeedback);
    }
    public function postFeedback()
    {
        $feedback = Input::get('feedback');
        Users::updateFeedback($feedback);

    }
    public function check()
    {
        return view('feedback');
    }
    public function credits()
    {
        return view('credits');
    }
    public function college()
    {
        return view('college');
    }
    public function updateCollege()
    {
        $college = Input::get('college');
        $userId = Auth::id();
        $updateStatus = Users::updateCollege($college,$userId);
        if($updateStatus)
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            print_r("failed");
        }
    }
    public function dashboard()
    {
        //return "sdsds";

        return view('start');
    }
    public function leaderboard()
    {
        $lead = Users::leaderboard();
        //return $lead;
        return view('leaderboard')->with('lead',$lead);
    }
    public function home()
    {
    
        return view('index');
    }
	public function facebook_redirect()
	{
		return Socialite::driver('facebook')->redirect();
	}


	public function facebook()
	{
		$user = Socialite::driver('facebook')->user();

        
        $userId=Users::getUserId($user['id']);
            if($userId)
            {
                Auth::loginUsingId($userId);
                $firstname = Users::getFirstName($userId);
                Session::put('first_name',$firstname);
                $checkCollegeName = Users::getCollege($userId);
                if($checkCollegeName)
                {
                    $data = "Welcome ";
                    return Redirect::to('/dashboard')->with('message',$data." ".$firstname);
                    
                }
                else
                {
                    return Redirect::to('/college');
                }
                
            }
            else{
            $newUserData['first_name'] = $user['first_name'];
            $newUserData['last_name'] = $user['last_name'];
            $newUserData['email'] = $user['email'];
            $newUserData['uid'] = $user['id'];
            $newUserData['signup_type'] = 2;
            //$newUserData['profile_image'] = "https://graph.facebook.com/"+$result['id']+"/picture?width=250&height=250";
            Session::put('fb',$newUserData);
            return view('fbgoogle')->with('newUserData',$newUserData);

        }
		return;
	}

    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    public function google()
    {
        $user = Socialite::driver('google')->user();

        //echo $user->user['name']['familyName'];
        //return;
        $userId=Users::getUserId($user['id']);
            if($userId)
            {
                Auth::loginUsingId($userId);
                $firstname = Users::getFirstName($userId);
                Session::put('first_name',$firstname);
                $checkCollegeName = Users::getCollege(Auth::id());
                if($checkCollegeName)
                {
                    $data = "Welcome ";
                    return Redirect::to('/dashboard')->with('message',$data." ".$firstname);
                    
                }
                else
                {
                    return Redirect::to('/college');
                }
            }
            else{
            if($user->user['name']['givenName'])
            {
                $newUserData['first_name'] = $user->user['name']['givenName'];
            }
            else
            {
                $newUserData['first_name'] = "";
            }
            if($user->user['name']['familyName'])
            {
                $newUserData['last_name'] = $user->user['name']['familyName'];
            }
            else
            {
                $newUserData['last_name'] = "";
            }
            $newUserData['email'] = $user->email;
            $newUserData['uid'] = $user->id;
            $newUserData['signup_type'] = 1;
            //$newUserData['profile_image'] = "https://graph.facebook.com/"+$result['id']+"/picture?width=250&height=250";
            Session::put('fb',$newUserData);
            return view('fbgoogle')->with('newUserData',$newUserData);

        }
        return;
    }
	/*public function loginWithFacebook() {

    // get data from input
  

    // get fb service
    // 
    //return "utkarsh";
    $fb = OAuth::consumer( 'Facebook','http://www.obscuraconflu.com/fb/');

    // check if code is valid
   // $code = "";
    // if code is provided get user data and sign in
    // if not ask for permission first
   
        // get fb authorization
        $url = $fb->getAuthorizationUri();

        // return to facebook login url
         return Redirect::to( (string)$url );


}
public function loginDone()
{


    $code = Input::get( 'code' );
    $fb = OAuth::consumer( 'Facebook','http://www.obscuraconflu.com/fb/');


    // check if code is valid
    //$code = "";
    // if code is provided get user data and sign in
   

        // This was a callback request from facebook, get the token
        $token = $fb->requestAccessToken($code);

        // Send a request with it
        $result = json_decode( $fb->request( '/me' ), true );
        //$result1 = json_decode($fb->getUser());
        	$userId=Users::getUserId($result['id']);
        	if($userId)
        	{
        		Auth::loginUsingId($userId);
        		$firstname = Users::getFirstName($userId);
        		Session::put('first_name',$firstname);
        		$data = "Welcome ";
        		return Redirect::to('/dashboard')->with('message',$data." ".$firstname);
        	}
        	else{


        	$newUserData['first_name'] = $result['first_name'];
        	$newUserData['last_name'] = $result['last_name'];
        	$newUserData['email'] = $result['email'];
        	$newUserData['uid'] = $result['id'];
        	$newUserData['signup_type'] = 2;
        	//$newUserData['profile_image'] = "https://graph.facebook.com/"+$result['id']+"/picture?width=250&height=250";
        	Session::put('fb',$newUserData);
            return View::make('fbgoogle')->with('newUserData',$newUserData);

        }
        //$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
        //echo $message. "<br/>".$result['link']."<br>",$result['link']."<br>".$result['username'];

        //Var_dump
        //display whole array().
        //dd($result);

}
*/
public function googleAuth()
{
     // get data from input
    $code = Input::get( 'code' );

    // get google service
    $googleService = OAuth::consumer( 'Google' ,'http://www.obscuraconflu.com/google');


    $url = $googleService->getAuthorizationUri();

        // return to google login url
        return Redirect::to( (string)$url );
    // check if code is valid

    // if code is provided get user data and sign in
}

public function loginDoneGoogle()
{
    $code = Input::get( 'code' );
    $googleService = OAuth::consumer( 'Google' ,'http://www.obscuraconflu.com/google');


     $token = $googleService->requestAccessToken( $code );

        // Send a request with it
        $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );


        //Var_dump
        //display whole array().
        $userId=Users::getUserId($result['id']);
        	if($userId)
        	{
        		Auth::loginUsingId($userId);
        		$firstname = Users::getFirstName($userId);
        		Session::put('first_name',$firstname);
        		$data = "Welcome ";
        		return Redirect::to('/dashboard')->with('message',$data." ".$firstname);
        	}
        	else{


        	$newUserData['first_name'] = $result['given_name'];
        	$newUserData['last_name'] = $result['family_name'];
        	$newUserData['email'] = $result['email'];
        	$newUserData['uid'] = $result['id'];
        	$newUserData['signup_type'] = 3;
        	//$newUserData['profile_image'] = "https://graph.facebook.com/"+$result['id']+"/picture?width=250&height=250";
        	Session::put('fb',$newUserData);
            return View::make('fbgoogle')->with('newUserData',$newUserData);

        }
        
  

}


public function obscura()
{
	//echo $event;
	return Redirect::to('/test');
	//$data = Users::find(1);
	//return $data->email;

	$data['firstname'] = "Bharat";
	$data['lastname'] = "Maan";
	$data['email']  = "bharat6dx@gmail.com";
	$data['level'] = 10;
	$data['college'] = "NIT Kurukshetra";
	if(Users::create($data))
	{
		return "Success";
	}
	else
	{
		return "Failed";
	}
}
 public function signup()
 {
    if(Auth::check())
        {
            
            return Redirect::to("/dashboard")->with('message','You are all-ready logged in');
        }
 	return view('register');
 }

 public function postSignup()
 {

 	$validator=Validator::make($newUserData=Input::all(),Users::$rulesSignup);
 	if($validator->fails())
		{

			return Redirect::back()->withErrors($validator)->withInput(Input::except('password','email'));
		}
	else
	{
			
				$newUserData['password'] = Hash::make(Input::get('password'));
	  			Users::create($newUserData);
	  			return Redirect::to('/login')->with('message','Registered Successfully');
	}
 }
 public function postfbgoogle()
 {
 	$validator=Validator::make($newUserData=Input::all(),Users::$rulesfbgoole);
 	if($validator->fails())
		{

			return Redirect::to('/fbgoogle')->withErrors($validator)->withInput();
		}
	else
	{
				if(Session::has('fb'))
				{
					$tempData = Session::get('fb');
					$newUserData['uid'] = $tempData['uid'];
                    $newUserData['password'] = Hash::make(Input::get('password'));
					$newUserData['signup_type'] = $tempData['signup_type'];
					if(Users::create($newUserData))
					{
						Session::forget('fb');
						return Redirect::to('/login')->with('message','Registered succesfully');
					}
					else
					{
						return Redirect::to('/login')->with('message','Registration failed');
					}
					Session::forget('fb');
			}
	}
 }
 public function fbgoogle()
 {
 	return view('fbgoogle');
 }

 public function login()
 {
 	if(Auth::check())
		{
			
 	 		return Redirect::to("/dashboard")->with('message','You are all-ready logged in');
 		}
		return view('login');
 }

 public function postLogin()
{
	$remember=(Input::has('remember'))?true:false;
		$credentials=$this->getCerdentials();
		if(Auth::attempt($credentials,$remember))
			{
				Session::flash('success','Welcome user!');
				/*
				|$id is used to store the the unique 'user_id'
				|of the logged in user in session varible so thar
				|latter this can be used.
				|
				*/
				//$data=$this->users->get(Input::get('email'));
				$firstname = Users::getFirstName(Auth::id());
				Session::put('first_name',$firstname);
				$checkCollegeName = Users::getCollege(Auth::id());
                if($checkCollegeName)
                {
                    $data = "Welcome ";
                    return Redirect::to('/dashboard')->with('message',$data." ".$firstname);
                    
                }
                else
                {
                    return Redirect::to('/college');
                }
			}
			
		else
			{
				return Redirect::back()->with('message','Wrong email or password');
				//return Redirect::to('/login')->with('failed',Lang::get('login.invalid_login'));
			}

}

public function getCerdentials()
	{
		return [
			"email"=>Input::get('email'),
			"password"=>Input::get('password'),
		];
	}

public function logout()
	{
        if(Users::getUserCurrLevel(Auth::id()) == 6)
        {
            Users::updateLevel(6);
        }
		Auth::logout();
		Session::flush();
    	return Redirect::to("/login")->with('message','Successfully you are logged-out');
	}


 /*public function home()
 {
 	$userId = Auth::id();
 	//$userMaxLevel = Users::getLevel($userId);
 	//Session::put('userMaxLevel',$userMaxLevel);
 	return View::make('dashboard');
 	//return Redirect::to('/obscura');
 }*/
 public function start()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
 	$presentLevelName = Levels::getLevelName($userMaxLevel);
 	return Redirect::to($presentLevelName[0]->levelName);
 }

 public function checkAnswer()
 {	
 	$presentId = Input::get('presentId');
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
 	$userAnswer = Input::get('answer');
    $correctAnswer1 = Answer::getAnswer($presentId,'answer1');
    if($userAnswer == $correctAnswer1)
 	{
        print('Users Max Id - '.$userMaxLevel);
        print(' Level ID - '.$presentId);
        if($userMaxLevel <= $presentId - 1){
            Users::updateLevel($userMaxLevel);
            $userMaxLevel = Users::getUserCurrLevel(Auth::id());
        }
       // Session::put('presentLevel',$presentLevel);
        $nextLevelName = Levels::getLevelName($presentId + 1);
        return Redirect::to($nextLevelName[0]->levelName)->with('message', 'Next level');
 	}
 	else
 	{
 		return Redirect::back()->with('message','Wrong Answer!');
 	}
 }

 public function level0()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 0)
    {
        return view('level0');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }

 }

  public function level1()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 1)
    {
        return view('level1');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }
 }


  public function level2()
 {
	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 2)
    {
        return view('level2');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }
 }


  public function level3()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 3)
    {
        return view('level3');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }
 }


  public function level4()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    if($userMaxLevel == 4 && Input::get('key') == 50)
    {
        Users::updateLevel($userMaxLevel);
        $userMaxLevel = Users::getUserCurrLevel(Auth::id());
        $userMaxLevel = Users::getMaxLevel($userMaxLevel);
        Users::updateLevel($userMaxLevel);
        return view('level4');

    }
    $presentLevelId = Levels::getLevelName($userMaxLevel);
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 4)
    {
        return view('level4');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }	
 }
  public function level6()
 {
   $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 6)
    {
        return view('level6');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }
public function level6_1()
 {
   $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 7)
    {
        return view('level6_1');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }

  public function level5()
 {
	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 5)
    {
        return view('level5');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }   
 }


  

  public function level7()
 {
	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 8)
    {
        return view('level7');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }


  public function level8()
 {
	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 9)
    {
        return view('level8');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level8_lol123() { 
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_lol123');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }
 }

 public function level8_obsda() { 
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_obsda');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }
 }

 public function level8_delhi() {
     
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_delhi');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level8_sup1_() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_sup1_');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }

 public function level8_alpha() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_alpha');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }
 

 public function level8_roger() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_roger');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }

 public function level8_hahaha() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_hahaha');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }

 public function level8_stairs() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_stairs');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }

 public function level8_zozozo() {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 10)
    {
        return view('level8_zozozo');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    }  
 }
 
 
 
 
 public function level9()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $Id = Input::get('id');
    if($Id == Auth::id())
    {
        if($userMaxLevel == 10)
        {
        Users::updateLevel($userMaxLevel);
        $userMaxLevel = Users::getUserCurrLevel(Auth::id());
        $userMaxLevel = Users::getMaxLevel($userMaxLevel);
        Users::updateLevel($userMaxLevel);
        }
        
    }
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 11)
    {
        return view('level9');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level10()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 12)
    {
        return view('level10');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level11()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 13)
    {
        return view('level11');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level12()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 14)
    {
        return view('level12');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level13()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 15)
    {
        return view('level13');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level14()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 16)
    {
        return view('level14');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level15()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 17)
    {
        return view('level15');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level16()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 18)
    {
        return view('level16');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level17()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 19)
    {
        return view('level17');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level18()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    
    if(Input::get('key') == Auth::id())
    {
        if($userMaxLevel == 19)
        {
        Users::updateLevel($userMaxLevel);
        $userMaxLevel = Users::getUserCurrLevel(Auth::id());
        $userMaxLevel = Users::getMaxLevel($userMaxLevel);
        Users::updateLevel($userMaxLevel);
        }
        
    }
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 20)
    {
        return view('level18');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level19()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 21)
    {
        return view('level19');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level20()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 22)
    {
        return view('level20');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

 public function level21()
 {
 	$userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 23)
    {
        return view('level21');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level21_1()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 24)
    {
        return view('level21_1');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level22()
 {
    
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 25)
    {
        return view('level22');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level22_1()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 26)
    {
        return view('level22_1');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level23()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 27)
    {
        return view('level23');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level24()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 28)
    {
        return view('level24');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level24_1()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 29)
    {
        return view('level24_1');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level25()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 30)
    {
        return view('level25');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function level26()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 31)
    {
        return view('level26');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level27()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 32)
    {
        return view('level27');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level28()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 33)
    {
        return view('level28');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level29()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 34)
    {
        return view('level29');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
  public function level30()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 35)
    {
        return view('level30');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
 public function shiftone()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 36)
    {
        return view('shiftone');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }

public function congo()
 {
    $userMaxLevel = Users::getUserCurrLevel(Auth::id());
    $userMaxLevelName = Levels::getLevelName($userMaxLevel);
    if($userMaxLevel >= 37)
    {
        return view('congo');
    }
    else
    {
        return Redirect::to($userMaxLevelName[0]->levelName)->with('message','First Complete This Level!');
    } 
 }
}






/*class UsersController extends Controller
{
	public function facebook_redirect()
	{
		return Socialite::driver('facebook')->redirect();
	}


	public function facebook()
	{
		$user = Socialite::driver('facebook')->user();

		print_r($user);
		return;
	}
}
*/