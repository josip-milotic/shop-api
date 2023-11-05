<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $total_price
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $fillable = [
		'user_id',
		'total_price',
		'first_name',
		'last_name',
		'email',
		'address',
		'city',
		'country'
	];

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
