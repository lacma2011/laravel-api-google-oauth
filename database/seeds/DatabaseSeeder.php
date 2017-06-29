<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = $this->getArtistFile('artists.json');
        $fh = fopen($file_path, "r") or die("Unable to open file: " . $file_path);
        $json = fread($fh,filesize($file_path));
        fclose($fh);
        $arr = json_decode($json);
        foreach ($arr->artists as $record) {
            DB::connection('mysql')->table('artist')->insert([
                'artist_id' => $record->artist_id,
                'name' => $record->artist_name,
                'handle' => $record->artist_handle,
            ]);
        }
    }
    
    /**
     * Get path to artist file if it exists.
     * 
     * @param type $file
     * @return null|string
     */
    private function getArtistFile($file) {
        // oauth2 creds
        $path = base_path() . '/' . $file;
        if (file_exists($path)) {
            return $path;
        }
        return false;
    }
}
