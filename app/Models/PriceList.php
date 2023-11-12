<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(
            Product::class,
            PriceListProduct::class,
            'price_list_id',
            'id',
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
