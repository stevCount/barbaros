<?php

namespace App\Http\Controllers;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class GoogleDriveController extends Controller
{
    private $drive;
    public function __construct(Google_Client $client)
    {
        $this->middleware(function ($request, $next) use ($client) {
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    public function getFolders()
    {
    	$this->ListFolders('root');
    }

    public function ListFolders($id){
        $query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";

        $optParams = [
            'fields' => 'files(id,name)',
            'q' => $query
        ];

        $results = $this->drive->files->ListFiles($optParams);
        $list = $results->getFiles();

         if(count($list) == 0){
            print Redirect::to('/api/v');
         } else {
            print view('drive.index', compact('list'));
         }

    }

    public function isEmpty(){
      return view('drive.empty');
    }


    public function uploadFiles(Request $request)
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();

        try{
            //instanciamos el servicio
            $service = new Google_Service_Drive($client);
            
            //ruta al archivo
            $file_path = 'word_ejemplo.docx';
            
            //instacia de archivo
            $file = new Google_Service_Drive_DriveFile();
            $file->setName("word_ejemplo.docx");
            
            //obtenemos el mime type
            $finfo = finfo_open(FILEINFO_MIME_TYPE); 
            $mime_type=finfo_file($finfo, $file_path);
            
            //id de la carpeta donde hemos dado el permiso a la cuenta de servicio 
            $file->setParents(array("1N97EZnFq1irAilAMYss5MwWghSFO5K4F"));
            $file->setDescription('archivo subido desde php');
            $file->setMimeType($mime_type);
            
            $result = $service->files->create(
              $file,
              array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type,
                'uploadType' => 'media',
              )
            );
            
            echo '<a href="https://drive.google.com/open?id='.$result->id.'" target="_blank">'.$result->name.'</a>';
            
            }catch(Google_Service_Exception $gs){
             
              $m=json_decode($gs->getMessage());
              echo $m->error->message;
            
            }catch(Exception $e){
                echo $e->getMessage();
              
            }
    }
    public function uploadFilesView()
    {
    	return view('drive.upload');
    }

}
 