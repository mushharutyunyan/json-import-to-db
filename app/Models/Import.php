<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Import
 * @package App\Models
 * @property int $import_id
 * @property string $status
 * @property string $type
 * @property string $file_url
 * @property integer $rows_qty_per_request
 * @property integer $failed_index
 * @property string $file_pointer
 * @property integer $done_pct
 */
class Import extends Model
{
    use HasFactory;
    protected $primaryKey = 'import_id';
    protected $fillable = [
        'status',
        'type',
        'file_url',
        'rows_qty_per_request',
        'failed_index',
        'file_pointer',
        'done_pct'
    ];
}
