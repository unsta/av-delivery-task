<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
	use HasFactory;

	protected $fillable = ['title', 'latitude', 'longitude', 'orders_count'];

	public function drivers(): HasMany
	{
		return $this->hasMany(Driver::class, 'next_location');
	}
}
