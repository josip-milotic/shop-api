<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|ContractList[] $contractLists
 * @property Collection|Order[] $orders
 * @property PriceList $priceList
 *
 * @package App\Models
 */
class User extends Model
{
	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function contractLists(): HasMany
    {
		return $this->hasMany(ContractList::class);
	}

	public function orders(): HasMany
    {
		return $this->hasMany(Order::class);
	}

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }
}
