<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property string $sku
 * @property bool $published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Category[] $categories
 * @property Collection|ContractList[] $contractLists
 * @property Collection|Order[] $orders
 * @property Collection|PriceList[] $priceLists
 *
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

	protected $casts = [
		'published' => 'bool'
	];

	protected $fillable = [
		'name',
		'price',
		'sku',
		'published'
	];

	public function categories(): BelongsToMany
    {
		return $this->belongsToMany(Category::class);
	}

	public function contractLists(): HasMany
    {
		return $this->hasMany(ContractList::class);
	}

	public function orders(): BelongsToMany
    {
		return $this->BelongsToMany(Order::class);
	}

	public function priceLists(): BelongsToMany
    {
		return $this->belongsToMany(PriceList::class);
	}
}
