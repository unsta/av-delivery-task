<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'latitude', 'longitude', 'capacity', 'next_location'];

	public function nextRestaurant(): BelongsTo
	{
		return $this->belongsTo(Restaurant::class, 'next_location');
	}
}
