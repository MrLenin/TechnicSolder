<?php

class BaseController extends Controller {

	const SOLDER_STREAM = 'DEV';
	const SOLDER_VERSION = '0.3';

	public function __construct()
	{
		View::share(array('solderVersion' => self::getSolderVersion(), 'solderStream' => self::getSolderStream()));
	}

	public static function getSolderStream()
	{
		return self::SOLDER_STREAM;
	}

	public static function getSolderVersion()
	{
		return self::SOLDER_VERSION;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function getLogin()
	{
		return View::make('dashboard.login');
	}

	public function postLogin()
	{
		$email    = Input::get('email');
		$password = Input::get('password');
		$remember = Input::get('remember');

		$credentials = array(
			'email' => $email,
			'password' => $password
			);
		if ( Auth::attempt($credentials, !empty($remember) ? true : false)) {
			Auth::user()->last_ip = Request::getClientIp();
			Auth::user()->save();
			return Redirect::to('dashboard/');
		} else {
			return Redirect::to('login')->with('login_failed',"Invalid Username/Password");
		}
	}

}