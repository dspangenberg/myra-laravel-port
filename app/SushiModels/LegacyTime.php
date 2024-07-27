<?php

namespace App\SushiModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

/**
 * 
 *
 * @property int $id
 * @property string|null $mite_id
 * @property int|null $invoice_id
 * @property int|null $project_id
 * @property string|null $date
 * @property string|null $begin
 * @property string|null $end
 * @property int|null $service_id
 * @property int|null $user_id
 * @property int|null $minutes
 * @property string|null $note
 * @property string|null $created_at
 * @property string|null $updated_ad
 * @property int|null $is_locked
 * @property string|null $task
 * @property string|null $subproject_id
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereBegin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereMiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereSubprojectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereUpdatedAd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegacyTime whereUserId($value)
 * @mixin \Eloquent
 */
class LegacyTime extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $json = Storage::disk('private')->json('legacy_times.json');

        return collect($json)->toArray();
    }
}
