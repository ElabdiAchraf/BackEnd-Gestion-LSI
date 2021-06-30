<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;
    public $table = 'seances';


    protected $fillable = [
        'jour',
        'module_id',
        'class_id',
        'heure_debut',
        "reservetion",
        'heure_fin',
        'salle_id',
        'num',
        'description',
    ];

    const WEEK_DAYS = [
        '1' => 'lundi',
        '2' => 'mardi',
        '3' => 'mercredi',
        '4' => 'jeudi',
        '5' => 'vendredi',
        '6' => 'samedi',
        '7' => 'dimanche',
    ];

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->heure_fin)->diffInMinutes($this->heure_debut);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['heure_debut'] = $value ? Carbon::createFromFormat(
            config('panel.lesson_time_format'),
            $value
        )->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('panel.lesson_time_format')) : null;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['heure_fin'] = $value ? Carbon::createFromFormat(
            config('panel.lesson_time_format'),
            $value
        )->format('H:i:s') : null;
    }

    function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    public static function isTimeAvailable($jour, $startTime, $endTime, $salle, $module)
    {
        $lessons = self::where('jour', $jour)
            // ->when($seance, function ($query) use ($seance) {
            //     $query->where('id', '!=', $seance);
            // })
            ->where(function ($query) use ($salle, $module) {
                $query->where('salle_id', $salle)
                    ->orWhere('module_id', $module);
            })
            ->where([
                ['heure_debut', '<', $endTime],
                ['heure_fin', '>', $startTime],
            ])
            ->count();

        return !$lessons;
    }
    public static function isTimeAvailableUp($jour, $startTime, $endTime, $salle, $module, $seance)
    {
        $lessons = self::where('jour', $jour)
            ->when($seance, function ($query) use ($seance) {
                $query->where('id', '!=', $seance);
            })
            ->where(function ($query) use ($salle, $module) {
                $query->where('salle_id', $salle)
                    ->orWhere('module_id', $module);
            })
            ->where([
                ['heure_debut', '<', $endTime],
                ['heure_fin', '>', $startTime],
            ])
            ->count();

        return !$lessons;
    }

    // public function scopeCalendarByRoleOrClassId($query)
    // {
    //     return $query->when(!request()->input('class_id'), function ($query) {
    //         $query->when(auth()->user()->is_teacher, function ($query) {
    //             $query->where('teacher_id', auth()->user()->id);
    //         })
    //             ->when(auth()->user()->is_student, function ($query) {
    //                 $query->where('class_id', auth()->user()->class_id ?? '0');
    //             });
    //     })
    //         ->when(request()->input('class_id'), function ($query) {
    //             $query->where('class_id', request()->input('class_id'));
    //         });
    // }
}
