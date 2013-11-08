<?php

class DashboardController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->beforeFilter('auth');
	}

	public function getIndex()
	{
		return View::make('dashboard.index');
	}

}