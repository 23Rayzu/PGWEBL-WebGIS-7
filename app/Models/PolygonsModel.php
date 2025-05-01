<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolygonsModel extends Model
{
    protected $table = 'polygons';

    protected $guarded = ['id'];

    public function geojson_polygons()
    {
        $polygons = $this->select(columns: DB::raw('id, st_asgeojson(geom) as geom, name, description, image,
        created_at, updated_at'))
        ->get();

                $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom, true),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'luas_hektar' => $p->luas_hektar,
                    'image' => $p->image,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ],
            ];

            array_push($geojson['features'], $feature);
        }

        return $geojson;
    }
}
