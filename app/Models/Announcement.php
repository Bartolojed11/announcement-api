<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get the acitve status
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function getActive($value)
    {
        $active = $value;
        $startDate = Carbon::parse($this->startDate);

        if ($this->endDate != '') {
            $endDate = Carbon::parse($this->endDate);
            if ($endDate->isPast() && $startDate->isPast()) $active = false;
        } else {
            $active = $startDate->isPast() ? false : true;
        }

        return $active;
    }

    /**
     * Scope a query to only include active announcements.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveAnnouncements($query)
    {
        $now =  Carbon::now()->timezone('Asia/Manila')->format('Y-m-d H:i:s');

        return $query->where(function ($q) use ($now) {
            $q->where('endDate', null)
                ->where('startDate', '<=', $now);
        })->orWhere(function ($q) use ($now) {
            $q->where('endDate', '>=', $now)
                ->where('startDate', '>=', $now);
        });
    }
}
