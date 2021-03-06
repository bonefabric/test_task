<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'user_ref',
		'sum',
	];

	protected $hidden = [
		'user_ref'
	];

	/**
	 * @return HasOne
	 */
	public function user(): HasOne
	{
		return $this->hasOne(User::class, 'user_ref');
	}
}
