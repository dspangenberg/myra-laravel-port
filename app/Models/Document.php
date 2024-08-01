<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $org_file
 * @property string|null $doc_file_name
 * @property string|null $preview
 * @property \Illuminate\Support\Carbon $issued_on
 * @property int $contact_id
 * @property string $fulltext
 * @property int|null $subject
 * @property int $size
 * @property string|null $received_on
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $number_of_pages
 * @property int $is_confirmed
 * @property int $is_marked
 * @property string|null $sender
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFulltext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIsConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIsMarked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereIssuedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereNumberOfPages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereOrgFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereReceivedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 *
 * @property int $document_folder_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocumentFolderId($value)
 *
 * @mixin \Eloquent
 */
class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'org_file',
        'doc_file_name',
        'issued_on',
        'contact_id',
        'fulltext',
        'subject',
        'size',
        'received_on',
        'number_of_pages',
        'is_confirmed',
        'is_marked',
        'sender',
        'document_folder_id',
        'year',
    ];

    public function contact(): HasOne
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id');
    }

    public function folder(): HasOne
    {
        return $this->hasOne(DocumentFolder::class, 'id', 'document_folder_id');
    }

    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
            'received_on' => 'date',
            'is_confirmed' => 'boolean',
            'is_marked' => 'boolean',
        ];
    }
}
