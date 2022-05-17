<?php
namespace App\Traits;

trait OpenHours
{
    public function getOpenHours()
    {
        $basicHours = config('malom.basicHours');
        $days = collect([ 0 => 'Vasárnap', 1 =>'Hétfő', 2 => 'Kedd', 3 => 'Szerda', 4 => 'Csütörtök', 5 => 'Péntek', 6 => 'Szombat']);
        $hours = $this->hours;
        // $hours = $this->hours->only(['day_of_week', 'open_time', 'close_time']);
        
        $days->map(function ($day, $key) use ($hours, $basicHours) {
            if (!$hours->contains('day_of_week', $day)) {
                $hours->push([
                    'day_of_week' => $day,
                    'open_time' => $basicHours[$key]['open_time'],
                    'close_time' => $basicHours[$key]['close_time'],
                ]);
            }
        });

        return $hours;
    }
}
