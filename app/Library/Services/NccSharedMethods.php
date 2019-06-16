<?php
namespace App\Library\Services;
use App\Cve;
use App\Library\Services\Contracts\NccServiceInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class NccSharedMethods implements NccServiceInterface {

    /**
     * @return string
     */
    public function import_csv_file(){
        ini_set('memory_limit', -1);
        $data       = $this->csv_to_array();
        if(!is_null($data)){
            $collection = collect($data);
            $chunks     = $collection->chunk(50);
            $chunks     = $chunks->toArray();
            if(is_array($chunks) && count($chunks) > 0){
                foreach($chunks as $v){
                    Cve::insert($this->format_data($v));
                }
                return "Success";
            }
            return "The CSV file is not valid";
        }
        return "CSV file doesn't exist";
    }


    /**
     * @return |null
     */
    protected function csv_to_array(){
        $path       = $this->get_file_path();
        if(!is_null($path)){
            $data       = Excel::load($path, function($reader) {})->get()->toArray();
            return $data;
        }
        return null;
    }

    /**
     * @param $values
     * @return array
     */
    protected function format_data($values){
        $data = [];
        if(is_array($values) && count($values) > 0):
            foreach($values as $val):
                unset($val[0]);
                $data[] = $val;
            endforeach;
            return $data;
        endif;
        return $data;
    }

    /**
     * @return |null
     */
    protected function get_file_path(){
        $path = Storage::disk('local')->url('app/csv/cve.csv');
        if(File::exists($path)) {
            return $path;
        }
        return null;
    }
}
