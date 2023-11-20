<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseCategory extends Model
{
    use HasFactory;



    /**
     * Get the user that owns the UploadedFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit_division(): BelongsTo
    {
        return $this->belongsTo(UnitDivision::class, 'cts_unit_division_id', 'cts_unit_division_id');
    }

}
