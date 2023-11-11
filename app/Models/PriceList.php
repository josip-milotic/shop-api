<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class PriceList
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class PriceList extends Model
{
    use HasFactory;

	protected $fillable = [
		'name'
	];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('name', 'price', 'sku');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
