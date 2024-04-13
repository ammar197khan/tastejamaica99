<?php
	class Auth extends Database {
		private $imsg;
		private $table_name="employee";

		function __construct() {
			parent::__construct();
			$this->imsg=load_class('InfoMessages');
		}
		/**
		*	authentication: admin is login or not (if admin is not login redirect to login page)
		*	$redirect is used to redirect the person on the page which he wants to open after login
		*	by default $redirect is set to true
		*	$this_url: is used to check that at which page user have to redirect
		*	exit() is used to exit the page request (stop loading that page)
		*/
		function authenticate_old($this_url='', $authen=false,$redirect=true){
			if($authen){
				if($this_url=='' && $_SERVER['REQUEST_URI']!=''){
					$this_url=basename($_SERVER['SCRIPT_FILENAME']).'?'.$_SERVER['QUERY_STRING'];
				}
				//|| $_COOKIE['uid']<1
				if($_SESSION['uid']<1){
					if($redirect){
						header("location:".BASE_URL."login.php?redirect_url=".urlencode($this_url));
						exit();
					}
				}
			}
			$id=$this->get_id();
			if($id>0){
				$user_row=$this->get_row_by_id($id);
				return $user_row;
			}else{
				return header("location:".BASE_URL);
			}
		}
		function authenticate($redirect=true){
			// die('dsfy');
			//$this->get_cookie_id()<1
			if($this->get_session_id()<1 ){
				$redirect_path=basename($_SERVER['SCRIPT_FILENAME']);
				if ($_SERVER['QUERY_STRING']!='') {
					$redirect_path.='?'.$_SERVER['QUERY_STRING'];
				}
				if($redirect) {
					header("location:".ADMIN_URL."login.php?redirect_url=".urlencode($redirect_path));
					exit();
				}
			}
			if ($this->get_session_id()>0) {
				return $this->get_session_id();
			} else {
				return $this->get_cookie_id();
			}
		}
		/*function::make_login*/
		function make_login($post){
			$arr=array($post['email'],$post['cell'], $post['password']);
			//print_r($arr); die();
			$query="SELECT * from ".$this->table_name." where (email=? or cell=?) and password=?";
			$result=parent::fetch_array_by_query($query, $arr);
			if ($result['locked']=='yes') {
				$this->imsg->setMessage('Your Account is Locked! Please Contact Website Administrator to Unlock your Account!','error');
				redirect_header(BASE_URL.'login.php');
			} else {
				if ($result['id']!='') {
					$this->create_session($result['id']);
					if($post['remeber_me']==true){
						$cookie_name = "uid";
						$cookie_value = $result['id'];
						setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
					}else{
						setcookie('uid','',1);
					}
					//print_r($_COOKIE); die();
					//print_r($result); die();
					//return true;
					redirect_header(BASE_URL."user-dashbaord/");
					exit();
				} else {
					$this->imsg->setMessage('Wrong email or password. Try Again!','error');
					//return false;
					//redirect_header(BASE_URL);
				}
			}
		}
		/**
		*	create a session with name 'uid' (put id of the admin into 'uid'
		*/
		function create_session($userid,$type='session',$fullname=""){
			if($type=='session'){
				$_SESSION['uid']=$userid;
				$_SESSION['fullname']=$fullname;
			}else{
				$expiry_time=time()*30*24*60*60;
				setcookie('uid', $userid, $expiry_time);
			}
		}
		/**
		*	get value from the set session named 'uid'
		*/
		function get_id(){
			if (isset($_SESSION['uid']) && $_SESSION['uid']>0) {
				return $_SESSION['uid'];
			} 
			/*else if (isset($_COOKIE['uid']) && $_COOKIE['uid']>0) {
				return $_COOKIE['uid'];
			} else {
				return 0;
			}*/
		}
		/**
		*	destroy or unset the session named 'uid'
		*/
		function logout(){
			unset($_SESSION['uid']);
			//header("location:".BASE_URL."login.php");
			header("location:".BASE_URL);
			exit();
		}
		function get_row_by_detail($username='', $email='') {
			$query="SELECT * from ".$this->table_name." where username=? or email=?";
			$arr=array($username, $email);
			$result=parent::fetch_array_by_query($query, $arr);
			return $result;
		}
		function get_row_by_id($id) {
			$result=parent::get_row($id, $this->table_name);
			return $result;
		}		
		/**
		*	function:recovery_email
		*/
	
		/**
		*	function:change_pass
		*/
		function change_pass($post) {
			$arr=array('forgotPassword'=>'', 'password'=>$post['password']);
			$result=parent::update($post['id'], $arr, $this->table_name);
			if ($result) {
				$this->imsg->setMessage('Password Changed Successfully!');
				redirect_header(BASE_URL.'login.php');
			} else {
				$this->imsg->setMessage("Problem Occurred While Changing Password. Try Again!","error");
			}
		}
	}

	function get_session_id(){
		if (isset($_SESSION['a_ch'])) {
			return intval($_SESSION['a_ch']);
		} else {
			return 0;
		}
	}
	function get_cookie_id() {
		if (isset($_COOKIE['a_ch'])) {
			return intval($_COOKIE['a_ch']);
		} else {
			return 0;
		}
	}
?>