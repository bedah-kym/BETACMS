<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FrontendController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;
    public $data;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Uploaded Cases';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fa-solid fa-file';

        // module model name, path
        $this->module_model = "App\Models\User";

        $path = storage_path() . "/app/data.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $this->data = json_decode(file_get_contents($path), true);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('frontend.index');
    // }
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $$module_name = $module_model::paginate();

        Log::info("'$title' viewed by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "ajira.cases.index",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title')
        );
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function upload()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $lawcourts = $this->data;

        // dd($this->data);
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        return view(
            "ajira.cases.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'lawcourts')
        );
    }


    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name; 
        $module_action = 'List';

        $page_heading = label_case($module_title);

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        // $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('email', 'LIKE', "%$term%")->limit(10)->get();
        $query_data=$this->data;
        $filteredArray = Arr::where($query_data, function ($value, $key) use($term) {
            // return $value['subhead_name'] == $term;
            return str_contains(Str::lower($value['subhead_name']), Str::lower($term));
        });

        $$module_name = [];

        foreach ($filteredArray as $row) {
            $$module_name[] = [
                'id' => $row['subhead_id'],
                'text' => $row['subhead_name'],
            ];
        }

        return response()->json($$module_name);
    }




    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list_unit(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name; 
        $module_action = 'List';

        $page_heading = label_case($module_title);

        $term = trim($request->q);
        $lawcourt = trim($request->lawcourt);

        if (empty($term)) {
            return response()->json([]);
        }

        // $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('email', 'LIKE', "%$term%")->limit(10)->get();
        $query_data=$this->data;

        $units = Arr::where($query_data, function ($value, $key) use($lawcourt) {
             return $value['subhead_id'] == $lawcourt;
        });

        // $collection = collect($units)->filter(function ($item) use ($term) {
        //     // dd($item['units']);
        //     $exist=false;
        //     foreach($item['units'] as $unit)
        //     {
        //         if(stripos($unit['unit_name'], $term))
        //         {
        //             $exist= true;
        //             break; 
        //         }
        //     }
        //     return $exist;
        // });

        // dd($collection );
        $filteredArray = Arr::where($units, function ($value, $key) use($lawcourt, $term) {
            $exist=false;
            foreach($value['units'] as $unit)
            {
                if(str_contains(Str::lower($unit['unit_name']), Str::lower($term)))
                {
                    $exist= true;
                    break; 
                }
            }
            return $exist;
            // return str_contains(Str::lower($value['units']['unit_name']), Str::lower($term));
        });

        $$module_name = [];

        dd($filteredArray[0]);
        foreach ($filteredArray[0]['units'] as $row) {
            $$module_name[] = [
                'id' => $row['unit_id'],
                'text' => $row['unit_name'],
            ];
        }

        return response()->json($$module_name);
    }



    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list_unit_division(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name; 
        $module_action = 'List';

        $page_heading = label_case($module_title);

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        // $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('email', 'LIKE', "%$term%")->limit(10)->get();
        $query_data=$this->data;
        $filteredArray = Arr::where($query_data, function ($value, $key) use($term) {
            // return $value['subhead_name'] == $term;
            return str_contains(Str::lower($value['subhead_name']), Str::lower($term));
        });

        $$module_name = [];

        foreach ($filteredArray as $row) {
            $$module_name[] = [
                'id' => $row['subhead_id'],
                'text' => $row['subhead_name'],
            ];
        }

        return response()->json($$module_name);
    }




    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list_code(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name; 
        $module_action = 'List';

        $page_heading = label_case($module_title);

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        // $query_data = $module_model::where('name', 'LIKE', "%$term%")->orWhere('email', 'LIKE', "%$term%")->limit(10)->get();
        $query_data=$this->data;
        $filteredArray = Arr::where($query_data, function ($value, $key) use($term) {
            // return $value['subhead_name'] == $term;
            return str_contains(Str::lower($value['subhead_name']), Str::lower($term));
        });

        $$module_name = [];

        foreach ($filteredArray as $row) {
            $$module_name[] = [
                'id' => $row['subhead_id'],
                'text' => $row['subhead_name'],
            ];
        }

        return response()->json($$module_name);
    }
    /**
     * Privacy Policy Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('frontend.privacy');
    }

    /**
     * Terms & Conditions Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        return view('frontend.terms');
    }
}
