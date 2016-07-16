<?php

namespace App;

use App\ProblemType;
use App\Request as Petition;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SimpleSearchableTables;
use Illuminate\Database\Eloquent\Builder;


class RequestType extends Model {

	use SimpleSearchableTables;

	protected $fillable = ['name', 'color'];

	protected $searchable=['name'];
	
	public function requests() {
		return $this->hasMany(Petition::class);
	}
	public function problemTypes() {
		return $this->hasMany(ProblemType::class);
	}

}
