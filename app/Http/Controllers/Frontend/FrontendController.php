<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\CaseType;
use App\Models\Subhead;
use App\Models\Unit;
use App\Models\UnitDivision;
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

        // Log::info("'$title' viewed by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

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

        $query_data = Subhead::where('name', 'LIKE', "%$term%")->get();
      
        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id' => $row['cts_subhead_id'],
                'text' => $row['name'],
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

   
        $query_data = Unit::where('name', 'LIKE', "%$term%")->where('cts_subhead_id', '=', $lawcourt )->get();
 
        $$module_name = [];

        foreach ($query_data as $row) { 
            $$module_name[] = [
                'id' => $row['cts_unit_id'],
                'text' => $row['name'],
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
        $unit_id = trim($request->unit);
        $lawcourt = trim($request->lawcourt);

        if (empty($term)) {
            return response()->json([]);
        }
        $$module_name = [];

        // $table->string('name');
        // $table->integer('cts_unit_id'); 
        // $table->integer('cts_division_id');
        // $table->integer('cts_unit_division_id');

        $query_data = UnitDivision::where('name', 'LIKE', "%$term%")->where('cts_unit_id', '=', $unit_id )->get(); 
 

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id' => $row['cts_unit_division_id'],
                'text' => $row['name'],
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
        $unit_division_id = trim($request->unit_division);
        $unit_id = trim($request->unit);

 

        if (empty($term)) {
            return response()->json([]);
        }


        // $table->string('case_type_name');
        // $table->string('code');
        // $table->string('category_name');
        // $table->integer('cts_case_type_id'); 
        // $table->integer('cts_case_category_id');

        // $table->integer('cts_unit_div_case_type_id'); 
        // $table->integer('cts_unit_division_id'); 

        

        $query_data = CaseType::where('category_name', 'LIKE', "%$term%")->orWhere('case_type_name', 'LIKE', "%$term%")->orWhere('code', 'LIKE', "%$term%")->where('cts_unit_division_id', '=', $unit_division_id )->get();
    

        $$module_name = [];

        foreach ($query_data as $row) { 
            $$module_name[] = [
                'id' => $row['cts_case_category_id'],
                'text' => $row['category_name'],
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
