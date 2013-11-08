<?php

class ModpackController extends BaseController
{
	public function __construct()
	{
		parent::__construct();

		$modpack = "modpack:{Request::segment(3);}";
		$build = "build:{Request::segment(3)}";

		$this->beforeFilter('auth');
		$this->beforeFilter('perm:solder_modpacks');
		$this->beforeFilter('perm:solder_create', array('only' => array('create')));
		$this->beforeFilter($modpack, array('only' => array('view','create','delete','edit')));
		$this->beforeFilter($build, array('only' => array('build')));
	}

	public function index()
	{
		return View::make('modpack.index');
	}

	public function show($modpack_id = null)
	{
		if (empty($modpack_id))
			return Redirect::route('modpack.index');

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack))
			return Redirect::route('modpack.index');

		return View::make('modpack.view')->with('modpack', $modpack);
	}

	public function create()
	{
		return View::make('modpack.create');
	}

	public function store()
	{
		Validator::register('checkresources', function($attribute, $value, $parameters)
		{
			if (FileUtils::check_resource($value,"logo_180.png") &&
				FileUtils::check_resource($value,"icon.png") &&
				FileUtils::check_resource($value,"background.jpg"))
				return true;
			else
				return false;
		});

		$rules = array(
			'name' => 'required|unique:modpacks',
			'slug' => 'required|checkresources|unique:modpacks'
			);

		$messages = array(
			'name_required' => 'You must enter a modpack name.',
			'slug_required' => 'You must enter a modpack slug',
			'slug_checkresources' => 'Make sure all the resources required exist before submitting a pack!'
			);

		$validation = Validator::make(Input::all(), $rules, $messages);

		if ($validation->fails())
			return Redirect::back()->with_errors($validation->errors);

		$url = Config::get('solder.repo_location').Input::get('slug').'/resources/';
		try {
			$modpack = new Modpack();
			$modpack->name = Input::get('name');
			$modpack->slug = Str::slug(Input::get('slug'));
			$modpack->icon_md5 = UrlUtils::get_remote_md5($url.'icon.png');
			$modpack->logo_md5 = UrlUtils::get_remote_md5($url.'logo_180.png');
			$modpack->background_md5 = UrlUtils::get_remote_md5($url.'background.jpg');
			$modpack->save();
			return Redirect::route('modpack.show', $modpack->id);
		} catch (Exception $e) {
			Log::exception($e);
		}
	}

	/**
	 * Modpack Edit Interface
	 * @param  Integer $modpack_id Modpack ID
	 * @return View
	 */
	public function edit($modpack_id)
	{
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		return View::make('modpack.edit')->with(array('modpack' => $modpack));
	}

	public function update($modpack_id)
	{
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		Validator::register('checkresources', function($attribute, $value, $parameters)
		{
			if (FileUtils::check_resource($value,"logo_180.png") &&
				FileUtils::check_resource($value,"icon.png") &&
				FileUtils::check_resource($value,"background.jpg"))
				return true;
			else
				return false;
		});

		$rules = array(
			'name' => 'required|unique:modpacks,name,'.$modpack->id,
			'slug' => 'required|checkresources|unique:modpacks,slug,'.$modpack->id
			);

		$messages = array(
			'name_required' => 'You must enter a modpack name.',
			'slug_required' => 'You must enter a modpack slug',
			'slug_checkresources' => 'Make sure to move your resources to the new location! (Based on your slug name)'
			);

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->with_errors($validation->errors);

		$url = Config::get('solder.repo_location').Input::get('slug').'/resources/';
		$modpack->name = Input::get('name');
		$modpack->slug = Input::get('slug');
		$modpack->icon_md5 = UrlUtils::get_remote_md5($url.'icon.png');
		$modpack->logo_md5 = UrlUtils::get_remote_md5($url.'logo_180.png');
		$modpack->background_md5 = UrlUtils::get_remote_md5($url.'background.jpg');
		$modpack->hidden = Input::get('hidden') ? true : false;
		$modpack->save();

		return Redirect::route('modpack.show', $modpack->id)->with('success','Modpack edited');
	}

	public function delete($modpack_id)
	{
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		return View::make('modpack.delete')->with(array('modpack' => $modpack));
	}

	public function destroy($modpack_id)
	{
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack_id))
		{
			return Redirect::route('dashboard');
		}

		foreach ($modpack->builds as $build)
		{
			$build->modversions()->delete();
			$build->delete();
		}
		$modpack->delete();

		return Redirect::route('modpack.index')->with('deleted','Modpack Deleted');
	}
}