<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Project;

class Automate extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'duration_info',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getDurationInfoAttribute()
    {
        $durationMilliseconds = $this->duration;

        $durationSeconds = $durationMilliseconds / 1000;

        $hours = floor($durationSeconds / 3600);
        $minutes = floor(($durationSeconds % 3600) / 60);
        $seconds = floor($durationSeconds % 60);
        $milliseconds = $durationMilliseconds % 1000;

        $value_text = '';

        if ($hours > 0) {
            $value_text .= $hours . 'h ';
        }

        if ($minutes > 0) {
            $value_text .= $minutes . 'min ';
        }

        if ($seconds > 0 || ($hours === 0 && $minutes === 0)) {
            $value_text .= $seconds . 's';
        }

        if ($durationSeconds < 1) {
            if ($durationMilliseconds > 0) {
                $value_text = $durationMilliseconds . 'ms';
            } else {
                $value_text = '0s'; 
            }
        } else if ($milliseconds > 0) {
            $value_text .= ' ' . $milliseconds . 'ms';
        }

        return [
            'value' => $durationMilliseconds,
            'value_text' => trim($value_text),
        ];
    }

}
