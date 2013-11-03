<?php

class UserPermission extends Eloquent
{
	public $timestamps = true;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_permissions';

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function setModpacks($modpack_array)
	{
		if (is_array($modpack_array))
		{
			$this->setAttribute('modpacks', implode(',',$modpack_array));
		} else {
			$this->setAttribute('modpacks', null);
		}

	}

	public function getModpacks()
	{
		return explode(',', $this->getAttribute('modpacks'));
	}
}