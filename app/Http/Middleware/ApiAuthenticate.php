<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;

class ApiAuthenticate
{
     /**
     * Path for login with http basic authorization api.
     * @var string
     */
    protected $httpAuthLogin = 'api/v1/login';

    /**
     * Path for logout and clear authorization cache.
     * @var string
     */
    protected $httpAuthLogout = 'api/v1/logout';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {  
        try{ 
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

           if (trim($_SERVER['PHP_AUTH_USER']) != '' && trim($_SERVER['PHP_AUTH_PW']) != '') {

               // login authorization code
               if (\Request::path() == $this->httpAuthLogin) {                
                   // validate user is authorized or not.
                   return $this->doLogin($request,false);

               } elseif (\Request::path() == $this->httpAuthLogout) {

                   // logout user & clear authorization cache.
                   return $this->doLogout();
               } else {
                   // if normal request validate user is authorized or not
                   if ($this->doLogin($request,true) === false) {
                       return $this->apiResponse(false, 401, $this->lang('auth.failed_login'));
                   }
                   else{
                   }
               }
           } else {
               return $this->apiResponse(false, 401, $this->lang('auth.auth_required'));
           }
        } else {
           return $this->apiResponse(false, 401, $this->lang('auth.auth_required'));
        }
        return $next($request);
        } catch (\Exception $exception) {
            return $this->apiResponse(false, 500, $this->lang('messages.server_error'));
        }
    }

    /**
     * Method is used for login authorization.
     *
     * @param bool $request
     *
     * @return Json|Response
     */


    protected function doLogin(Request $_request,$request = false)
    {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        try {

            $credentials = [
                'email' => $username,
                'password' => $password,
                'status' => 1
            ];

            if (\Auth::once(['email' => $username, 'password' => $password, 'status' => 1]) ||
                \Auth::once($credentials)
                ) {
                $user = $this->updateLastLogin();
                // for notifications
                
                //dd($user);
            } else {
                //$this->loginAttemptsFailed($username);
                if ($request == true) {
                    return false;
                } else {
                    return $this->apiResponse(false, 401, $this->lang('Access Denied by Admin'));
                }
            }

            if (\Request::path() == $this->httpAuthLogin) {
                if ($user->deleted_at != null) {
                    return $this->apiResponse(false, 400, 'Access Denied by Admin');
                }else{
                    return $this->apiResponse(true, 200, '', [], $user);
                }
            }

        } catch (\Exception $e) {
            return $this->apiResponse(false, 500, $this->lang('messages.server_error').$e->getMessage());
        }
    }

  

    /**
     * Method is used for logout and clear authorization cache.
     *
     * @return  Response|Json
     */
    protected function doLogout()
    {
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            try {
                // unset the http auth values.
                $_SERVER['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_PW'] = '';
                unset($_SERVER['PHP_AUTH_USER']);
                unset($_SERVER['PHP_AUTH_PW']);
                return $this->apiResponse(true, 200, $this->lang('auth.logout'));

            } catch (\Exception $e) {
                return $this->apiResponse(false, 500, $this->lang('messages.server_error'));
            }
        }
    }

    /**
     * Method is used for update last login time.
     *
     * @return  Response
     */
    protected function updateLastLogin()
    {
        //(new User)->updateLastLogin();
        return \Auth::user();
        $id = \Auth::user()->id;
        $email = \Auth::user()->email;
        
        return [
            'id'        => $id,
            'email'     => $email
         ];
    }

    /**
     * Method is used for update last login time.
     *
     * @param string $username
     *
     * @return Response
     */
    protected function loginAttemptsFailed($username)
    {
        if($username != "") {
            (new User)->updateFailedAttempts($username);
        }
    }

    //Serach Key
    protected function multiKeyExists(array $arr, $key) {
        
        // is in base array?
        if (array_key_exists($key, $arr)) {
            return true;
        }

        // check arrays contained in this array
        foreach ($arr as $element) {
            if (is_array($element)) {
                if ($this->multiKeyExists($element, $key)) {
                    return true;
                }
            }
            
        }

        return false;
    }

    function apiResponse($status, $statusCode, $message, $errors = [], $data = [])
    {
        $response = ['success' => $status, 'status' => $statusCode];
        
        if ($message != "") {
            $response['message']['success'] = $message;
        }

        if (!empty($errors)) {
            $response['message']['errors'] = $errors;
        }

        if (!empty($data)) {
            $response['message']['data'] = $data;
        }
        return response()->json($response);
    }

    function errorMessages($errors = [])
    {
        $error = [];
        foreach($errors->toArray() as $key => $value) {
            foreach($value as $messages) {
                $error[$key] = $messages;
            }
        }
        return $error;
    }

    function lang($path = null, $string = null)
    {
        $lang = $path;
        if (trim($path) != '' && trim($string) == '') {
            $lang = \Lang::get($path);
        } elseif (trim($path) != '' && trim($string) != '') {
            $lang = \Lang::get($path, ['attribute' => $string]);
        }
        return $lang;
    }
}
