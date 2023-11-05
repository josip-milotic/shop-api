<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ContractList
 *
 * @property int $id
 * @property string $price
 * @property string $sku
 * @property int $user_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class ContractList extends Model
{
	protected $fillable = [
		'price',
		'sku',
		'user_id',
		'product_id'
	];

	public function product(): BelongsTo
    {
		return $this->belongsTo(Product::class);
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}
