<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\Category;
use App\Model\SubCategory;
use App\Model\State;
use App\Model\City;
use App\Model\Series;
class SerchController extends Controller
{
    //
     public function getCountry(Request $request)
    {

        $search = $request->get('search');
        $id = $request->get('id');

        $data = Country::when($id, function ($query, $id) {
            $query->where('id', $id);
        })
        ->where('name', 'like', '%' . $search . '%')
        ->get();

        return response()->json($data->toArray());

    }

    
    public function getState(Request $request)
    {

        $search = $request->get('search');
        $id = $request->get('id');

        $data = State::when($id, function ($query, $id) {
            $query->where('country_id', $id);
        })
        ->where('name', 'like', '%' . $search . '%')
        ->get();
        
        return response()->json($data->toArray());
    }

    
    public function getCity(Request $request)
    {

        $search = $request->get('search');
        $id = $request->get('id');

        $data = City::when($id, function ($query, $id) {
            $query->where('state_id', $id);
        })
        ->where('name', 'like', '%' . $search . '%')
        ->get();   
        return response()->json($data->toArray());

    }
    
    public function getCategory(Request $request)
    {

        $search = $request->get('search');
        $id = $request->get('id');

        $data = Category::when($id, function ($query, $id) {
            $query->where('id', $id);
        })
        ->where('name', 'like', '%' . $search . '%')
        ->get();
       
        return response()->json($data->toArray());

    }
    

    public function getSeries(Request $request)
    {

        $search = $request->get('search');
        $id = $request->get('id');

        $data = Series::when($id, function ($query, $id) {
            $query->where('id', $id);
        })
        ->where('series_name', 'like', '%' . $search . '%')
        ->get();
       
        return response()->json($data->toArray());

    }
}
