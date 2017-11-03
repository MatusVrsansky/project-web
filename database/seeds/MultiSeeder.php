<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Input;
use App\Models\Zamestnanec;
use App\Models\Profile;
use App\Models\Publications;

// Work in Progress

//use App\Models\Projects;
//use App\Models\Activities;
//

class MultiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        //
            

            $arrayidzamestnanci = DB::select('select id from zamestnanci where id < 2416 or id > 2416', [1]);

            //
            //2416 NEFUNGUJE
            //

            foreach($arrayidzamestnanci as $idzam)          
            {           
                  

            $pdescription="";
            $pconsultation_hours="";
            $peducation="";

            $json = file_get_contents("https://ukfprofil.teacher.sk/get-teacher/".$idzam->id);
            //$json = File::get("public/json.txt");
            //$currentid = 1440;
            $data = json_decode($json, true);

            


            if(isset($data['profile']['description']))
            {   
                $pdescription=$data['profile']['description'];
            }

            if(isset($data['profile']['consultation_hours']))
            {   
                $pconsultation_hours=$data['profile']['consultation_hours'];
            }

            if(isset($data['profile']['education']))
            {   
                $peducation=$data['profile']['education'];
            }


            
            

            Profile::create(array('zamestnanec_id' => $idzam->id,
                    'description' => $pdescription,
                    'consultation_hours' => $pconsultation_hours,
                    'education' => $peducation));

         foreach($data['publications'] as $publikacia)
            {

            $pISBN="";
            $ptitle="";
            $psub_title="";
            $pall_authors="";
            $ptype="";
            $ppublisher="";
            $ppages="";
            $pyear="";
            $pcode="";


            if(isset($publikacia['ISBN']))
            {
              $pISBN=$publikacia['ISBN'];
            }
             if(isset($publikacia['title']))
            {
              $ptitle=$publikacia['title'];
            }
             if(isset($publikacia['sub_title']))
            {
              $psub_title=$publikacia['sub_title'];
            }
             if(isset($publikacia['all_authors']))
            {
              $pall_authors=$publikacia['all_authors'];
            }
             if(isset($publikacia['type']))
            {
              $ptype=$publikacia['type'];
            }
             if(isset($publikacia['publisher']))
            {
              $ppublisher=$publikacia['publisher'];
            }
             if(isset($publikacia['pages']))
            {
              $ppages=$publikacia['pages'];
            }
             if(isset($publikacia['year']))
            {
              $pyear=$publikacia['year'];
            }
             if(isset($publikacia['code']))
            {
              $pcode=$publikacia['code'];
            }                           
            




            Publications::create(array('zamestnanec_id' => $idzam->id,
                    'ISBN' => $pISBN,
                    'title' => $ptitle,
                    'sub_title' => $psub_title,
                    'all_authors' => $pall_authors,
                    'type' => $ptype,
                    'publisher' => $ppublisher,
                    'pages' => $ppages,
                    'year' => $pyear,
                    'code' => $pcode
                ));
            
              
            }           



    }
}

}

