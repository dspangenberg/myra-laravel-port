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
 * @property string $type
 * @property int $is_private
 * @property int $outturn_account_id
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereOutturnAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptCategory whereType($value)
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
