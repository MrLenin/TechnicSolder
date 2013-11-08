<?php

class ModController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->beforeFilter('auth');
		$this->beforeFilter('perm:solder_mods');
		$this->beforeFilter('perm:mods_manage', array('only' => array('view','versions')));
		$this->beforeFilter('perm:mods_create', array('only' => array('create')));
		$this->beforeFilter('perm:mods_delete', array('only' => array('delete')));
	}

	public function index()
	{
		$search = Input::get('search');
		if (!empty($search))
		{
			$mods = DB::table('mods')
					->where('name','LIKE','%'.$search.'%')
					->or_where('pretty_name', 'LIKE', '%'.$search.'%')
					->paginate(20);
		} else {
			$mods = DB::table('mods')->paginate(20);
		}
		return View::make('mod.list')->with(array('mods' => $mods,'search' => $search));
	}

	public function edit($mod_id = null)
	{
		if (empty($mod_id))
			return Redirect::route('mod');

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Redirect::route('mod');

		return View::make('mod.edit')->with(array('mod' => $mod));
	}

	public function create()
	{
		return View::make('mod.create');
	}

	public function store()
	{
		$rules = array(
			'name' => 'required|unique:mods',
			'pretty_name' => 'required'
			);
		$messages = array(
			'name_required' => 'You must fill in a mod slug name.',
			'name_unique' => 'The slug you entered is already taken',
			'pretty_name_required' => 'You must enter in a mod name'
			);

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->with_errors($validation->errors);

		try {
			$mod = new Mod;
			$mod->name = Str::slug(Input::get('name'));
			$mod->pretty_name = Input::get('pretty_name');
			$mod->author = Input::get('author');
			$mod->description = Input::get('description');
			$mod->link = Input::get('link');
			$mod->save();
			return Redirect::route('mod.show', $mod->id);
		} catch (Exception $e) {
			Log::exception($e);
		}
	}

	public function delete($mod_id = null)
	{
		if (empty($mod_id))
			return Redirect::route('mod');

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Redirect::route('mod');

		return View::make('mod.delete')->with(array('mod' => $mod));
	}

	public function update($mod_id = null)
	{
		if (empty($mod_id))
			return Redirect::route('mod');

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Redirect::route('mod');

		$rules = array(
			'pretty_name' => 'required',
			'name' => 'required|unique:mods,name,'.$mod->id,
			);

		$messages = array(
			'pretty_name_required' => 'You must enter in a Mod Name',
			'name_required' => 'You must enter a Mod Slug',
			'name_unique' => 'The slug you entered is already in use by another mod',
			);

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->with_errors($validation->errors);

		try {
			$mod->pretty_name = Input::get('pretty_name');
			$mod->name = Input::get('name');
			$mod->author = Input::get('author');
			$mod->description = Input::get('description');
			$mod->link = Input::get('link');
			$mod->save();

			return Redirect::back()->with('success','Mod successfully edited.');
		} catch (Exception $e) {
			Log::exception($e);
		}
	}

	public function destroy($mod_id = null)
	{
		if (empty($mod_id))
			return Redirect::route('mod');

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Redirect::route('mod');

		foreach ($mod->versions as $ver)
		{
			$ver->builds()->delete();
			$ver->delete();
		}
		$mod->delete();

		return Redirect::route('mod')->with('deleted','Mod deleted!');
	}

	public function show($mod_id = null)
	{
		if (empty($mod_id))
			return Redirect::route('mod');

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Redirect::route('mod');

		return View::make('mod.versions')->with(array('mod' => $mod));
	}
}