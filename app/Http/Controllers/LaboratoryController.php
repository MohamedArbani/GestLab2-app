<?php

namespace App\Http\Controllers;
use App\Models\Laboratory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{
    public function index(Request $request)
    {

    $laboratories = Laboratory::select(['id', 'name','address','phone'])
    ->when($request->long && $request->lat, function ($query) use ($request) {
        $query->addSelect(DB::raw("ST_Distance_Sphere(
                POINT('$request->long', '$request->lat'), POINT(longitude, latitude)
            ) as distance"))
            ->orderBy('distance');
    })
    ->when($request->labName, function ($query, $labName) {
        $query->where('laboratories.name', 'like', "%{$labName}%");
    })
    ->take(10)
    ->get();

return response()->json([
    'laboratories' => $laboratories,
]);

    
}
}


/*

$query = Laboratory::query();

        if ($request->has('labName')) {
            $query->where('name', 'like', '%' . $request->labName . '%');
        }

        if ($request->has('lat') && $request->has('long')) {
            $lat = $request->lat;
            $long = $request->long;

            // Simple distance calculation for demonstration purposes
            $query->selectRaw("
                *, ( 6371000 * acos( cos( radians(?) ) *
                cos( radians( latitude ) )
                * cos( radians( longitude ) - radians(?)
                ) + sin( radians(?) ) *
                sin( radians( latitude ) ) )
                ) AS distance", [$lat, $long, $lat])
                ->orderBy('distance');
        }

        $laboratories = $query->get();

        return response()->json(['laboratories' => $laboratories]);
*/