<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Discount
 *
 * @property int $id
 * @property string $name
 * @property double $discount_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_rate'
    ];
}
