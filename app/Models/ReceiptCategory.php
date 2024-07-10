<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $receipts_ref
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereReceiptsRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReceiptCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'receipts_ref',
    ];
}
