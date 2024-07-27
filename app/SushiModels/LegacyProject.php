<?php

namespace App\SushiModels;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

/**
 * 
 *
 * @property int $id
 * @property int|null $customer_id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $mite_id
 * @property int|null $account_id
 * @property string|null $invoice_name
 * @property int|null $is_archived
 * @property string|null $project_category_id
 * @property string|null $description
 * @property int|null $parent_id
 * @property string|null $price_per_hour
 * @method static Builder|LegacyProject newModelQuery()
 * @method static Builder|LegacyProject newQuery()
 * @method static Builder|LegacyProject query()
 * @method static Builder|LegacyProject whereAccountId($value)
 * @method static Builder|LegacyProject whereCreatedAt($value)
 * @method static Builder|LegacyProject whereCustomerId($value)
 * @method static Builder|LegacyProject whereDescription($value)
 * @method static Builder|LegacyProject whereId($value)
 * @method static Builder|LegacyProject whereInvoiceName($value)
 * @method static Builder|LegacyProject whereIsArchived($value)
 * @method static Builder|LegacyProject whereMiteId($value)
 * @method static Builder|LegacyProject whereName($value)
 * @method static Builder|LegacyProject whereParentId($value)
 * @method static Builder|LegacyProject wherePricePerHour($value)
 * @method static Builder|LegacyProject whereProjectCategoryId($value)
 * @method static Builder|LegacyProject whereUpdatedAt($value)
 * @method static Builder|LegacyProject whereUserId($value)
 * @mixin Eloquent
 */
class LegacyProject extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $json = Storage::disk('private')->json('legacy_projects.json');

        return collect($json)->toArray();
    }
}
