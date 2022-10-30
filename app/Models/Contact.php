<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    public function seller(): HasOne
    {
        return $this->hasOne(
            related: Seller::class,
            foreignKey: 'id',
            localKey: 'seller_id',
        );
    }

    public function sales(): HasMany
    {
        return $this->hasMany(
            related: Sale::class,
            foreignKey: 'contact_id',
            localKey: 'id'
        );
    }
}
