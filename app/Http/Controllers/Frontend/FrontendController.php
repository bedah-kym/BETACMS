<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Models\CaseCategory;
use App\Models\Subhead;
use App\Models\Unit;
use App\Models\UnitDivision;
use App\Models\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;
    public $default_subhead_id=0;
    public $data;

    public function __construct()
    {
        
        // Page Title
        $this->module_title = 'Uploaded Cases';

        // module name
        $this->module_name = 'cases';

        // directory path of the module
        $this->module_path = 'cases';

        // module icon
        $this->module_icon = 'fa-solid fa-file';

        // module model name, path
        $this->module_model = "App\Models\UploadFiles";
        $this->default_subhead_id=env('DEFAULT_SUBHEAD_ID');

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
        if (!Auth::check()) {
            return redirect('/login');
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        // $$module_name = $module_model::paginate();

        // Log::info("'$title' viewed by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view("ajira.cases.index",compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title'));
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function upload()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        // dd($this->data);
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        $query_data = Subhead::get();
      
        $lawcourts = []; 

        $years = [];

        // $year=date('Y');
        // for ($i=100;$i>0; $i-- ) {
        //     $y[] = [
        //         'id' => $i,
        //         'text' => $i,
        //     ];
        // }

        // $years= response()->json($y);

        return view(
            "ajira.cases.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'lawcourts', 'years')
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
        $query_data=[];
        if (empty($term)) {
            // return response()->json([]);
            $query_data = Subhead::where('cts_subhead_id','=', $this->default_subhead_id)->get();
        }
        else
        {
            $query_data = Subhead::where('cts_subhead_id','=', $this->default_subhead_id)->where('name', 'LIKE', "%$term%")->get();
        }

      
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
 
        $query_data=[];
        if (empty($term)) {
            // return response()->json([]);
            $query_data = Unit::where('cts_subhead_id', '=', $lawcourt )->get();
        }
        else
        {
            $query_data = Unit::where('name', 'LIKE', "%$term%")->where('cts_subhead_id', '=', $lawcourt )->get();
        }

   
 
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

       
        $query_data=[];
        if (empty($term)) {
            // return response()->json([]);
            $query_data = UnitDivision::where('cts_unit_id', '=', $unit_id )->get(); 
        }
        else
        {
            $query_data = UnitDivision::where('name', 'LIKE', "%$term%")->where('cts_unit_id', '=', $unit_id )->get(); 
        }

        $$module_name = [];

        // $table->string('name');
        // $table->integer('cts_unit_id'); 
        // $table->integer('cts_division_id');
        // $table->integer('cts_unit_division_id');

 

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

 

        
        $query_data=[];
        if (empty($term)) {
            // return response()->json([]);
            $query_data = CaseCategory::where('cts_unit_division_id', '=', $unit_division_id )->get();
        }
        else
        {
            $query_data = CaseCategory::where('category_name', 'LIKE', "%$term%")->orWhere('code', 'LIKE', "%$term%")->where('cts_unit_division_id', '=', $unit_division_id )->get();
        }


        // $table->string('case_type_name');
        // $table->string('code');
        // $table->string('category_name');
        // $table->integer('cts_case_type_id'); 
        // $table->integer('cts_case_category_id');

        // $table->integer('cts_unit_div_case_type_id'); 
        // $table->integer('cts_unit_division_id'); 

        

    
// dd($query_data);
        $$module_name = [];

        foreach ($query_data as $row) { 
            $$module_name[] = [
                'id' => $row['cts_case_category_id'],
                'text' => $row['code'].' '.$row['category_name'],
            ];
        }

        return response()->json($$module_name);
    }



    public function upload_files(Request $request)
    {
        // Validate the uploaded files (optional but recommended)
        $request->validate([
            'files.*' => 'required|file|mimes:,pdf', // Example validation rules
        ]);

        // Handle file upload
        if ($request->hasFile('files')) 
        {
            $files = $request->file('files');
            $law_court_id=$request->law_court;
            $unit_id=$request->unit;
            $unit_division_id=$request->unit_division;
            $code=$request->code;
            $case_index=$request->case_index;
            $year=$request->year;

            $uploadPath = 'public/uploads'; // Define the path where you want to store files

            $subhead=Subhead::where('cts_subhead_id','=',$law_court_id)->first();
            $unit=Unit::where('cts_unit_id','=',$unit_id)->first();
            $unit_division=UnitDivision::where('cts_unit_division_id','=',$unit_division_id)->first();
            $category=CaseCategory::where('cts_case_category_id','=',$code)->first();

            $case_number=$category->code.'-'.$case_index.'-'.$year;
            $path=$uploadPath.'/'.$subhead->name.'/'.$unit->name.'/'.$unit_division->name.'/'.$case_number;

            // Check if the directory doesn't exist, then create it
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }
            // dd(!Storage::exists($path));

            foreach ($files as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path3 = $file->storeAs($path,$fileNameToStore);

                $fileContents = file_get_contents($path3);

                $desktopPath = env('ONE_DRIVE_FOLDER') . $fileNameToStore;

                // Use file_put_contents to write the file to the specified path
                file_put_contents($desktopPath, $fileContents);

                // dd([
                //     'cts_case_category_id'   => $category->cts_case_category_id,
                //     'cts_unit_division_id'=> $unit_division->cts_unit_division_id,
                //     'size' => filesize($file),
                //     'case_number' => $case_number,
                //     'file_path' => $path3,
                //     'file_name' => $fileNameToStore,
                // ]);
            
                $ajira_unit_division_id = UploadedFile::create(
                    [
                        'cts_case_category_id'   => $category->cts_case_category_id,
                        'cts_unit_division_id'=> $unit_division->cts_unit_division_id,
                        'size' => filesize($file),
                        'case_number' => $case_number,
                        'file_path' => $path3,
                        'file_name' => $fileNameToStore
                    ],
                );
                // // Store each file in the storage folder (you can adjust the path as needed)
                // $path3 = $file->store($path);
                // echo $path3;
                // // You can also perform additional actions with the uploaded file like storing its path in the database
                // // For example: YourModel::create(['file_path' => $path]);
            }

            return response()->json(['success'=>true, 'message'=> 'Files uploaded successfully!']);
            // return redirect()->back()->with('success', 'Files uploaded successfully!');
        }
        $error = array(
            'validation_error' => array('screennshot3' => 'You did not Select a file to upload'),
            'error' => 'You did not Select a file to upload',
            "errorkeys" => [],
            "initialPreview" => [],
            "initialPreviewConfig" => [],
            "initialPreviewThumbTags" => [],
            "append" => true,
        );

        return response()->json($error);
    }
 /**
     * Privacy Policy Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_files(Request $request)
    {
        // dd($request->case_number);
        if (!Auth::check()) {
            return redirect('/login');
        }
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        // dd($this->data);
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';


        
        $case = UploadedFile::select(
            'case_number', 
            'case_categories.category_name', 
            'case_categories.code as category_code', 
            'unit_divisions.name as division_name',
            'units.name as unit_name'
        )
        ->where('case_number', '=', $request->case_number)
        ->where('units.cts_subhead_id','=', env('DEFAULT_SUBHEAD_ID'))
        ->join('case_categories', 'case_categories.cts_case_category_id', '=', 'uploaded_files.cts_case_category_id')
        ->join('unit_divisions', 'unit_divisions.cts_unit_division_id', '=', 'case_categories.cts_unit_division_id')
        ->join('units', 'units.cts_unit_id', '=', 'unit_divisions.cts_unit_id')
        ->groupBy('case_number', 'case_categories.code','case_categories.category_name', 'unit_divisions.name', 'units.name')
        ->orderBy('uploaded_files.id', 'desc')->first();


        $files = UploadedFile::where('case_number', '=', $request->case_number)
        ->where('units.cts_subhead_id','=', env('DEFAULT_SUBHEAD_ID'))
        ->join('case_categories', 'case_categories.cts_case_category_id', '=', 'uploaded_files.cts_case_category_id')
        ->join('unit_divisions', 'unit_divisions.cts_unit_division_id', '=', 'case_categories.cts_unit_division_id')
        ->join('units', 'units.cts_unit_id', '=', 'unit_divisions.cts_unit_id')
        ->orderBy('uploaded_files.id', 'desc')->get();
        // ->get();

        return view(
            "ajira.cases.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'case', 'files')
        );
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
