<?php

namespace App\Livewire;

use App\Models\UploadedFile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CasesIndex extends Component
{
    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        // $cases = UploadedFile::where('case_number', 'like', $searchTerm)
        // ->groupBy('case_number, ')
        // ->orderBy('id', 'desc')->paginate();

        // $cases = UploadedFile::select(DB::raw('count(*) as cnt, case_number, category.name '))
        //     ->where('case_number', 'like', $searchTerm)
        //     ->with(['category'])
        //     ->groupBy('case_number, category.name')
        //     ->orderBy('id', 'desc')->paginate();

            $cases = UploadedFile::select(
                'case_number', 
                'case_categories.category_name', 
                'case_categories.code as category_code', 
                'unit_divisions.name as division_name',
                'units.name as unit_name', 
                DB::raw('COUNT(*) as uploaded_files'),  
                DB::raw('max(uploaded_files.created_at) as created_at'),  
            )
            ->where('case_number', 'like', $searchTerm)
            ->where('units.cts_subhead_id','=', env('DEFAULT_SUBHEAD_ID'))
            ->join('case_categories', 'case_categories.cts_case_category_id', '=', 'uploaded_files.cts_case_category_id')
            ->join('unit_divisions', 'unit_divisions.cts_unit_division_id', '=', 'case_categories.cts_unit_division_id')
            ->join('units', 'units.cts_unit_id', '=', 'unit_divisions.cts_unit_id')
            ->groupBy('case_number', 'case_categories.code','case_categories.category_name', 'unit_divisions.name', 'units.name')
            ->orderBy('uploaded_files.id', 'desc')->paginate();
            // ->get();

        return view('livewire.cases-index', compact('cases'));
    }
}
