<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Category|null $parent
 * @property Collection|Category[] $children
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'description',
		'parent_id'
	];

	public function parent(): BelongsTo
    {
		return $this->belongsTo(Category::class, 'parent_id');
	}

	public function children(): HasMany
    {
		return $this->hasMany(Category::class, 'parent_id');
	}

	public function products(): BelongsToMany
    {
		return $this->belongsToMany(Product::class);
	}
}
