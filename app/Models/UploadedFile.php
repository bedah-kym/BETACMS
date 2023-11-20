<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;

class UploadedFile extends Model
{
    use HasFactory;

    protected $fillable=[
        'file_name',
        'file_path',
        'case_number',
        'cts_case_category_id',
        'cts_unit_division_id',
        'size'
    ];

    /**
     * Get the user that owns the UploadedFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CaseCategory::class, 'cts_case_category_id', 'cts_case_category_id');
    }

}
