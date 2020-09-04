<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NeoAsteroidController extends Controller
{
    public function getNeoDate(Request $request)
    {
        $neo_by_date = [];
        $temp = [];
        $asteroids = [];
        $asteroid_data_by_date =[];


        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $url = "https://api.nasa.gov/neo/rest/v1/feed?start_date=$start_date&end_date=$end_date&api_key=Oz1JxpM5e8beyAD8PlKIUh93WRhIUXMWXHIfb5Mr ";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        $asteroid_data = json_decode($result, true);

        response()->json($asteroid_data);

        foreach($asteroid_data['near_earth_objects'] as $index => $value)
        {
             $neo_by_date[$index] = $value;
            foreach($neo_by_date[$index] as $data_by_date)
            {
                // single neo data by date
                 $asteroids[$index] = $data_by_date;
            }
        }

        // asteroids data
        foreach($asteroids as $neo_data)
        {
            $temp[] = $neo_data;
            foreach($neo_data['estimated_diameter'] as $est_dia_index => $value
            )
            {
              if($est_dia_index == 'kilometers')
              {
                    $estimated_diameter_km[$index] = $value;
              }
            }


         // neo close approach data_by_data
            foreach($neo_data['close_approach_data'] as $NEOcad)
                {
                    foreach($NEOcad['relative_velocity'] as $velocity_index => $value)
                    {
                        if($velocity_index == 'kilometers_per_hour')
                            {
                                 $velocity_km[$index] = $value;
                            }
                    }
                    foreach($NEOcad['miss_distance'] as $miss_distance_index => $value)
                    {
                        if($miss_distance_index == 'kilometers')
                        {
                            $miss_distance[$index] = $value;
                        }
                    }
                }
        }

        //get start and end date from array $neo_by_date
        $neo_array_by_date = array_keys($neo_by_date);

        // count the data to find fastest asteroids near earth
        foreach($neo_array_by_date as $key => $value)
        {
             $asteroids_countBy_date[$value] = count($neo_by_date[$value]);
        }

        // sort velocity by kilometer
         arsort($velocity_km);

         $fastest_asteroid = Arr::first($velocity_km);
        $fastest_asteroid_key = array_key_first($velocity_km);
        $fastest_asteroid_id = $asteroids[$fastest_asteroid_key]['id'];

    //    sort miss_distance
         asort($miss_distance);
         $NeoClosest = Arr::first($miss_distance);
        $NeoClosest_key = array_key_first($miss_distance);
        $NeoClosest_id = $asteroids[$NeoClosest_key]['id'];


    $asteroids_count = array_keys($asteroids_countBy_date);
    $asteroids_count_values = array_values($asteroids_countBy_date);

    // return response()->json(['NeoClosest'=> $NeoClosest]);
    return response()->json(['fastest_asteroid' => $fastest_asteroid, 'fastest_asteroid_id' => $fastest_asteroid_id, 'NeoClosest' => $NeoClosest, 'NeoClosest_id' => $NeoClosest_id, 'asteroids_count' => $asteroids_count, 'asteroids_count_values' => $asteroids_count_values ]);
}
}
