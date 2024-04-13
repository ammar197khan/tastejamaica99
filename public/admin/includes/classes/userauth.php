<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
class UserAuth extends Database
{

    private $table_name = "user_profile";

    private $imsg;

    /**

     *	constructor used to start the session

     */

    function __construct()
    {

        parent::__construct();

        $this->imsg = load_class('InfoMessages');
    }

    /**

     *	function to check login valid or not.

     *	$username: username/email

     *	$password: password

     *	$type: by default session (but we can set cookie)

     */

    function check_login($username, $password, $type = "session")
    {

        $query = "select * from " . $this->table_name . " where (username=? or email=?) and password=? and locked='no'";

        $arr = array($username, $username, $password);

        $result = parent::fetch_array_by_query($query, $arr);
        // print_r($result);
        // die();


        //echo $username;die();

        if ($result['email'] != '') {
            if (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != '') {
                $redirect_url = BASE_URL . $_REQUEST['redirect_url'];
            } else {
                $redirect_url = BASE_URL . "profile.php";
            }
            if ($type == "session") {
                $this->create_session($result['id'], $result['name']);
                redirect_header($redirect_url);
            } else {

                $this->create_cookie($result['id']);

                redirect_header($redirect_url);
            }
        } else {

            return false;
        }
    }

    /**

     *	function to change password

     *	parameter: $post (array)

     */

    function change_password($post)
    {

        $arr = array("password" => md5($post['newpassword']));

        $arr['hint'] = $post['newpassword'];

        $password = md5($post['oldpassword']);

        $arr2 = array($post['id'], $password);

        $query = "select * from " . $this->table_name . " where id=? and password=?";

        $result = parent::fetch_array_by_query($query, $arr2);

        $f = BASE_URL . "change-user-pass.php";

        if ($result) {

            $r = parent::update($post['id'], $arr, $this->table_name);

            if ($r) {

                $this->imsg->setMessage("Password Updated Successfully!");

                redirect_header($f);
            } else {

                $this->imsg->setMessage("There's a Problem While Update Your Password!", "error");

                redirect_header($f);
            }
        } else {

            $this->imsg->setMessage("Please Enter Valid Old Password to Change Your Password!", "error");

            redirect_header($f);
        }
    }

    /**

     *	authentication: admin is login or not (if admin is not login redirect to login page)

     *	$redirect is used to redirect the person on the page which he wants to open after login

     *	by default $redirect is set to true

     *	exit() is used to exit the page request (stop loading that page)

     */

    function authenticate($redirect = true)
    {

        //$this->get_cookie_id()<1

        if ($this->get_user_session_id() < 1) {

            $redirect_path = basename($_SERVER['SCRIPT_FILENAME']);

            if ($_SERVER['QUERY_STRING'] != '') {

                $redirect_path .= '?' . $_SERVER['QUERY_STRING'];
            }

            if ($redirect) {

                header("location:" . BASE_URL . "login.php?redirect_url=" . urlencode($redirect_path));

                exit();
            }
        }

        if ($this->get_user_session_id() > 0) {

            return $this->get_user_session_id();
        } else {

            return $this->get_user_cookie_id();
        }
    }

    /**

     *	create a session with name 'a_ch' (put id of the admin into 'a_ch'

     */

    function create_session($id, $name)
    {

        $_SESSION['USER_ID'] = $id;

        $_SESSION['USER_NAME'] = $name;
    }

    /**

     *	create a cookie with name 'a_ch' (put id of the admin into 'a_ch'

     *	$cookietime: set time to 30 days for login

     */

    function create_cookie($id)
    {

        $cookietime = time() + (24 * 60 * 60 * 30);

        setcookie('USER_ID', $id, $cookietime);
    }

    /**

     *	destroy or unset the session/cookie named 'a_ch'

     */

    function logout()
    {

        if ($_SESSION['USER_ID'] > 0) {

            unset($_SESSION['USER_ID']);
        } else {

            setcookie('USER_ID', $_COOKIE['USER_ID'], (time() - 1));
        }

        header("location:" . BASE_URL . "login.php");

        exit();
    }

    /**

     *	get value from the set session named 'a_ch'

     */

    function get_user_session_id()
    {

        if (isset($_SESSION['USER_ID'])) {

            return intval($_SESSION['USER_ID']);
        } else {

            return 0;
        }
    }

    function get_user_cookie_id()
    {

        if (isset($_COOKIE['USER_ID'])) {

            return intval($_COOKIE['USER_ID']);
        } else {

            return 0;
        }
    }

    function auth_row($db)
    {
        $auth_id = $this->get_user_session_id();
        $auth_row = $db->fetch_array_by_query("SELECT * from " . $this->table_name . " where id=" . $auth_id);
        return $auth_row;
    }
}
