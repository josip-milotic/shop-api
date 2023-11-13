<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\DB;

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
 * @property TaxCategory|null $taxCategory
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
        'published',
        'tax_category_id'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function taxCategory(): BelongsTo
    {
        return $this->belongsTo(TaxCategory::class);
    }

    public function contractLists(): HasMany
    {
        return $this->hasMany(ContractList::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->BelongsToMany(Order::class);
    }

    public function priceLists(): HasManyThrough
    {
        return $this->hasManyThrough(
            PriceList::class,
            PriceListProduct::class,
            'product_id',
            'id',
        );
    }

    /**
     * Scope a query to get products for user that take into account price and contract lists.
     */
    public function scopeForUser(Builder $query, User $user): void
    {
        $query->select(
            'products.id',
            'products.name',
            'products.sku',
            'products.tax_category_id',
            'products.created_at',
            DB::raw('COALESCE(contract_lists.price, price_list_product.price, products.price) as price'),
        )
            ->leftJoin('price_list_product', function ($join) use ($user) {
                $join->on('products.id', '=', 'price_list_product.product_id')
                    ->where(function ($query) use ($user) {
                        $query->where('price_list_product.price_list_id', $user->price_list_id)
                            ->orWhereNull('price_list_product.price_list_id');
                    });
            })
            ->leftJoin('contract_lists', function ($join) use ($user) {
                $join->on('products.id', '=', 'contract_lists.product_id')
                    ->where(function ($query) use ($user) {
                        $query->where('contract_lists.user_id', $user->id)
                            ->orWhereNull('contract_lists.user_id');
                    });
            })
            ->where('products.published', true);
    }
}
