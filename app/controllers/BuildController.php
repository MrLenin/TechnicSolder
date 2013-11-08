<?php

class BuildController extends BaseController
{
	const MINECRAFT_API = 'http://www.technicpack.net/api/minecraft';

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

	public function delete($build_id = null)
	{
		if (empty($build_id))
			return Redirect::route('modpack.index');

		$build = Build::find($build_id);
		if (empty($build))
			return Redirect::route('modpack.index');

		return View::make('modpack.build.delete')->with('build', $build);
	}

	public function destroy($mod_id = null, $build_id = null)
	{
		if (empty($build_id))
			return Redirect::route('modpack.index');

		$build = Build::find($build_id);
		if (empty($build))
			return Redirect::route('modpack.index');

		$switchrec = 0;
		$switchlat = 0;
		$modpack = $build->modpack;
		if ($build->version == $modpack->recommended)
			$switchrec = 1;
		if ($build->version == $modpack->latest)
			$switchlat = 1;
		$build->modversions()->detach();
		$build->delete();
		if ($switchrec)
		{
			$recbuild = Build::where('modpack_id','=',$modpack->id)
			->orderBy('id','desc')->first();
			$modpack->recommended = $recbuild->version;
		}

		if ($switchlat)
		{
			$latbuild = Build::where('modpack_id','=',$modpack->id)
			->orderBy('id','desc')->first();
			$modpack->latest = $latbuild->version;
		}
		$modpack->save();

		return Redirect::route('modpack.show', $build->modpack->id)->with('deleted','Build deleted.');
	}

	public function edit($modpack_id = null, $build_id = null)
	{
		if (empty($build_id))
			return Redirect::route('modpack.index');

		$build = Build::find($build_id);
		if (empty($build))
			return Redirect::route('modpack.index');

		return View::make('modpack.build.view')->with('build', $build);
	}

	public function create($modpack_id)
	{
		if (empty($modpack_id))
			return Redirect::route('modpack.index');

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack))
			return Redirect::route('modpack.index');

		$minecraft = $this->getMinecraft();

		return View::make('modpack.build.create')
		->with(array(
				'modpack' => $modpack,
				'minecraft' => $minecraft
		));
	}

	public function store($modpack_id)
	{
		if (empty($modpack_id))
			return Redirect::route('modpack.index');

		$modpack = Modpack::find($modpack_id);
		if (empty($modpack))
			return Redirect::route('modpack.index');

		$rules = array(
				"version" => "required",
		);

		$messages = array('version_required' => "You must enter in the build number.");

		$validation = Validator::make(Input::all(), $rules, $messages);
		if ($validation->fails())
			return Redirect::back()->with_errors($validation->errors);

		$clone = Input::get('clone');
		$build = new Build();
		$build->modpack_id = $modpack->id;
		$build->version = Input::get('version');

		$minecraft = explode(':', Input::get('minecraft'));

		$build->minecraft = $minecraft[0];
		$build->minecraft_md5 = $minecraft[1];
		$build->save();
		if (!empty($clone))
		{
			$clone_build = Build::find($clone);
			$version_ids = array();
			foreach ($clone_build->modversions as $cver)
			{
				if (!empty($cver))
					array_push($version_ids, $cver->id);
			}
			$build->modversions()->sync($version_ids);
		}

		return Redirect::route('modpack.show', $modpack_id);
	}

	/**
	 * AJAX Methods for Modpack Manager
	 **/
	public function modify($action = null)
	{
		if (empty($action))
			return Response::error('500');

		switch ($action)
		{
			case "version":
				$affected = DB::table('build_mod_version')
				->where('id','=', Input::get('pivot_id'))
				->update(array('modversion_id' => Input::get('version')));
				return Response::json(array('success' => 'Rows Affected: '.$affected));
				break;
			case "delete":
				$affected = DB::table('build_mod_version')
				->where('id','=', Input::get('pivot_id'))
				->delete();
				return Response::json(array('success' => 'Rows Affected: '.$affected));
				break;
			case "add":
				$build = Build::find(Input::get('build'));
				$mod = Mod::where('name','=',Input::get('mod-name'))->first();
				$ver = ModVersion::where('mod_id','=', $mod->id)
				->where('version','=', Input::get('mod-version'))
				->first();
				$build->modversions()->attach($ver->id);
				return Response::json(array(
						'pretty_name' => $mod->pretty_name,
						'version' => $ver->version,
				));
				break;
			case "recommended":
				$modpack = Modpack::find(Input::get('modpack'));
				$new_version = Input::get('recommended');
				$modpack->recommended = $new_version;
				$modpack->save();

				return Response::json(array(
						"success" => "Updated ".$modpack->name."'s recommended  build to ".$new_version,
						"version" => $new_version
				));
				break;
			case "latest":
				$modpack = Modpack::find(Input::get('modpack'));
				$new_version = Input::get('latest');
				$modpack->latest = $new_version;
				$modpack->save();

				return Response::json(array(
						"success" => "Updated ".$modpack->name."'s latest  build to ".$new_version,
						"version" => $new_version
				));
				break;
			case "published":
				$build = Build::find(Input::get('build'));
				$published = Input::get('published');

				$build->is_published = ($published ? true : false);
				$build->save();

				return Response::json(array(
						"success" => "Updated build ".$build->version."'s published status.",
				));
		}
	}

	public function getMinecraft()
	{
		if (Config::has('solder.minecraft_api'))
		{
			$url = Config::get('solder.minecraft_api');
		} else {
			$url = self::MINECRAFT_API;
		}

		$response = UrlUtils::get_url_contents($url);

		return json_decode($response);
	}
}