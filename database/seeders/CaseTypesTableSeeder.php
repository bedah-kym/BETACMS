<?php

namespace Database\Seeders;

use App\Models\CaseType;
use App\Models\Subhead;
use App\Models\Unit;
use App\Models\UnitDivision;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class UserRoleTableSeeder.
 */
class CaseTypesTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */


     function guzzle($url, $d):string
     {
         $option = array(
             'body' => json_encode($d),
             'headers' => array('Authorization' => ' Bearer 0b84a512b6ea40d9aa71027fd3dd46d898e2ae5c')
         );
        
  
         $client = new \GuzzleHttp\Client();
         try
         {
             $response = $client->request('GET', $url, $option);
          
             return $response->getBody();
         } catch (\GuzzleHttp\Exception\BadResponseException $e)
         { 
             $response = $e->getResponse();
             $responseBodyAsString = $response->getBody()->getContents();
             return $responseBodyAsString;
         }
     }


     public function get_LawCourts_units_division_case_types($unit_division_id, $ajira_unit_division_id)
     {
         $res=$this->guzzle("http://172.17.0.1/cts/Oauth2/ajira/get_unit_division_case_types/".$unit_division_id, []); 
         $unit_division_case_types=json_decode($res);
         foreach($unit_division_case_types as $unit_division_case_type)
         {

            // dd($unit_division_case_type);
            // $table->string('case_type_name');
            // $table->string('code');
            // $table->string('category_name');
            // $table->integer('cts_case_type_id'); 
            // $table->integer('cts_case_category_id'); 

            // +"unit_div_case_type_id": 464
            // +"unit_division_id": 52
            // +"case_type_id": 1
            // +"case_type_name": "Petition"
            // +"case_type_deleted": false
            // +"category_id": 1
            // +"code": "SCPT"
            // +"category_name": "Supreme Court Petition"
            // +"case_category_deleted": false
            // +"division_id": 3
            // +"division_name": "Supreme Court "
            // +"unit_id": 242
            // +"unit_name": "Supreme Court"
            // +"subhead_id": 1
            // +"subhead_name": "Supreme Court Building"

            

            $ajira_unit_division_id = CaseType::updateOrCreate(
                [
                   'cts_case_category_id'   => $unit_division_case_type->category_id,
                   'cts_case_type_id'   => $unit_division_case_type->case_type_id
                ],
                [

                    'cts_case_category_id'   => $unit_division_case_type->category_id,
                    'cts_case_type_id'   => $unit_division_case_type->case_type_id,

                    'case_type_name' => trim($unit_division_case_type->case_type_name),
                    'code' => trim($unit_division_case_type->code),
                    'category_name' => trim($unit_division_case_type->category_name),
                ],
            );

         }
         // dd($response);
     }
     
    public function get_LawCourts_units_division($unit_id, $ajira_unit_id, $ajira_subhead_id)
    {
        $res=$this->guzzle("http://172.17.0.1/cts/Oauth2/ajira/get_unit_division_list/".$unit_id, []); 
        $unit_divisions=json_decode($res);
        foreach($unit_divisions as $unit_division)
        {
            // dd($unit_division);
            // $table->string('name');
            // $table->integer('cts_unit_id'); 
            // $table->integer('cts_division_id');
            // $table->integer('cts_unit_division_id');

 
            $ajira_unit_division_id = UnitDivision::updateOrCreate(
                [
                   'cts_unit_division_id'   => $unit_division->unit_division_id,
                ],
                [
                    'cts_unit_division_id' => $unit_division->unit_division_id,
                    'name' => $unit_division->division_name,
                    'cts_unit_id' => $unit_division->unit_id,
                    'cts_division_id' => $unit_division->division_id
                ],
            );
            $res=$this->get_LawCourts_units_division_case_types($unit_division->unit_division_id, $ajira_unit_division_id);
        }
        // dd($response);
    }


     public function get_LawCourts_units($subhead_id, $ajira_subhead_id)
    {

        $res=$this->guzzle("http://172.17.0.1/cts/Oauth2/ajira/get_lawcourt_unit/".$subhead_id, []); 
        $units=json_decode($res);
        foreach($units as $unit)
        { 
            $ajira_unit_id = Unit::updateOrCreate(
                [
                   'cts_unit_id'   => $unit->unit_id,
                ],
                [
                    'cts_unit_id' => $unit->unit_id,
                    'name' => $unit->unit_name,
                    'cts_subhead_id' => $unit->subhead_id
                ],
            );
            $res=$this->get_LawCourts_units_division($unit->unit_id, $ajira_unit_id, $ajira_subhead_id);
        }
        // dd($response);
    }
     public function get_LawCourts()
    {

        $res=$this->guzzle("http://172.17.0.1/cts/Oauth2/ajira/get_law_courts", []); 
        // echo $res;
        $subheads=json_decode($res);
        foreach($subheads as $subhead)
        {
            // echo $subhead['subhead_id'].' === ';
            // var_dump($subhead);
            $subhead_id = Subhead::updateOrCreate(
                [
                   'cts_subhead_id'   => $subhead->subhead_id,
                ],
                [
                    'cts_subhead_id' => $subhead->subhead_id,
                    'name' => $subhead->subhead_name
                ],
            );

             $res=$this->get_LawCourts_units($subhead->subhead_id, $subhead_id);
        }
        // dd($response);
    }
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->get_LawCourts();
        Schema::enableForeignKeyConstraints();
    }
}
