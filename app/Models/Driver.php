<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property int $capacity
 * @property int|null $next_location
 *
 * @property-read Restaurant|null $nextRestaurant
 * @property Restaurant|null $closestRestaurant
 * @property float|null $distanceToAssigned
 * @property float|null $distanceToClosest
 */
class Driver extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'latitude', 'longitude', 'capacity', 'next_location'];

	public function nextRestaurant(): BelongsTo
	{
		return $this->belongsTo(Restaurant::class, 'next_location');
	}
}
