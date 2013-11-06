<?php

class ModVersionController extends BaseController {

	public function __construct()
	{
		//		parent::__construct();
		$this->beforeFilter('auth');
		$this->beforeFilter('perm:solder_mods');
		$this->beforeFilter('perm:mods_manage', array('only' => array('view','versions')));
		$this->beforeFilter('perm:mods_create', array('only' => array('create')));
		$this->beforeFilter('perm:mods_delete', array('only' => array('delete')));
	}

	public function store()
	{
		$mod_id = Input::get('mod-id');
		$version = Input::get('add-version');
		if (empty($mod_id) || empty($version))
			return Response::json(array(
					'status' => 'error',
					'reason' => 'Missing Post Data'
			));

		$mod = Mod::find($mod_id);
		if (empty($mod))
			return Response::json(array(
					'status' => 'error',
					'reason' => 'Could not pull mod from database'
			));

		$ver = new ModVersion();
		$ver->mod_id = $mod->id;
		$ver->version = $version;
		if ($md5 = $this->modMD5($mod,$version))
		{
			$ver->md5 = $md5;
			$ver->save();
			return Response::json(array(
					'status' => 'success',
					'version' => $ver->version,
					'md5' => $ver->md5,
			));
		} else {
			return Response::json(array(
					'status' => 'error',
					'reason' => 'Could not get MD5. URL Incorrect?'
			));
		}
	}

	public function destroy($ver_id = null)
	{
		if (empty($ver_id))
			return Redirect::to('mod');

		$ver = ModVersion::find($ver_id);
		if (empty($ver))
			return Redirect::to('mod');

		$old_id = $ver->id;
		$ver->delete();
		return Response::json(array('version_id' => $old_id));
	}

	public function update($ver_id = null)
	{
		if (empty($ver_id))
			return Redirect::to('mod');

		$ver = ModVersion::find($ver_id);
		if (empty($ver))
			return Redirect::to('mod');

		if ($md5 = $this->modMD5($ver->mod,$ver->version))
		{
			$ver->md5 = $md5;
			$ver->save();
			return Response::json(array(
					'version_id' => $ver->id,
					'md5' => $md5,
			));
		}

		return Response::error('500');
	}

	private function modMD5($mod, $version)
	{
		$location = Config::get('solder.repo_location').'mods/'.$mod->name.'/'.$mod->name.'-'.$version.'.zip';

		if (file_exists($location))
			return md5_file($location);
		else
			return $this->remoteModMD5($mod, $version);
	}

	private function remoteModMD5($mod, $version, $attempts = 0)
	{
		$url = Config::get('solder.repo_location').'mods/'.$mod->name.'/'.$mod->name.'-'.$version.'.zip';
		if ($attempts >= 3)
		{
			Log::write("ERROR", "Exceeded maximum number of attempts for remote MD5 on mod ". $mod->name ." version ".$version." located at ". $url);
			return "";
		}

		$hash = UrlUtils::get_remote_md5($url);
		if (!empty($hash))
			return $hash;
		else {
			Log::write("ERROR", "Attempted to remote MD5 mod " . $mod->name . " version " . $version . " located at " . $url ." but curl response did not return 200!");
			return $this->remote_mod_md5($mod, $version, $attempts + 1);
		}
	}
}