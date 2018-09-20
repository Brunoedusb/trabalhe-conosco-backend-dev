<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * DB table name
     *
     * @var string
     */
    protected $table;

    /**
     * CSV filename
     *
     * @var string
     */
    protected $filename;

    public function __construct()
    {

        $this->table = 'picpayUsers';
        $this->filename = app_path() . '/users.csv';

    }

    public function run()
    {
        $this->split_file();
        // DB::table($this->table)->delete();
        // $seedData = $this->seedFromCSV($this->filename);
        // DB::table($this->table)->insert($seedData);
    }

    /**
     * Collect data from a given CSV file and return as array
     *
     * @param $filename
     * @return array|bool
     */
    private function seedFromCSV($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }
        $count = 0;
        $header = [
            0 => "id",
            1 => "name",
            2 => "username"
        ];
        $data = array();
        try
        {
            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle)) !== FALSE) {
                    $count++;
                    if (!$header) {
                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                }
                dd($count);
                fclose($handle);
            }

            return $data;
        }catch (Exception $e){
            return $data;
        }
    }

    private function split_file(){
        $i=0;
        $j=1;
        $buffer='';
            
        while (!feof ($handle = fopen($this->filename, 'r'))) {
            $buffer .= fgetcsv($handle);
            $i++;
            if ($i >= $lines) {
                $fname = app_path()."/users/".$j.".csv";
                $fhandle = fopen($fname, "w") or die($php_errormsg);
    
                if (!$fhandle) {
                    echo "Cannot open file ($fname)";
                    //exit;
                }
    
                if (!fwrite($fhandle, $buffer)) {
                    echo "Cannot write to file ($fname)";
                    //exit;
                }
                fclose($fhandle);
                $j++;
                $buffer='';
                $i=0;
                //$line+=10; // add 10 to $lines after each iteration. Modify this line as required
            }
        }
        fclose ($handle);
    }

}