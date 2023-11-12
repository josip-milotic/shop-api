<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TaxCategory
 *
 * @property int $id
 * @property string $name
 * @property double $tax_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class TaxCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tax_rate'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
