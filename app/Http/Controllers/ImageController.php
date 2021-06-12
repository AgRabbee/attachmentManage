<?php

namespace App\Http\Controllers;

use App\User;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use mysql_xdevapi\Exception;

class ImageController extends Controller
{
    public function convertToBase64(Request $request){
        $file = Input::file('file');
        $data = [
//            'blobTxt' => file_get_contents($file),
            'base64Txt' => base64_encode(file_get_contents($file)),
        ];
        #dd($data);
        return Response()->json($data);
    }

    public function convertToRawImg(Request $request){
        $base64_data = $request['base64Txt'];
        $blob_data = base64_decode($base64_data);

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $blob_data, FILEINFO_MIME_TYPE);
        $split = explode( '/', $mime_type );
        $type = $split[1];

        $fileName = time().'.'.$type;

        file_put_contents('images/'.$fileName,$blob_data);
        $data = [
            'imgSrc' => 'images/'.$fileName,
        ];

        return Response()->json($data);
    }

    public function generateUrlForImg(Request $request){
        $file = Input::file('file');

        $destinationPath = public_path('/images/');
        $image = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $image);

        $exp_time = time() + 15;

        $data = [
            'file' => $destinationPath.$image,
            'exp' =>$exp_time,
        ];
        $data = Crypt::encryptString(json_encode($data));

        $imgUrl = url('image_url?data='.urlencode($data));
        $data = [
            'imgUrl' => $imgUrl,
        ];

        return Response()->json($data);
    }

    public function imgFromURL(Request $request){
        $data = $request['data'];
        $decryptData = Crypt::decryptString($data);
        $data = json_decode($decryptData);
        if($data->exp < time()){
            echo 'Image time expired';
            exit;
        }else{
            $finfo = getimagesize($data->file);
            $mime = $finfo['mime'];
            header("Content-Type:$mime");
            echo file_get_contents($data->file);
            exit;
        }
    }


    public function exclToDB(Request $request){
        try {
            $file = Input::file('file');
            $data= Excel::load($file, function($reader) {})->get()->toArray();
            foreach ($data as $value) {
                $data=new User();
                $data->name=$value['name'];
                $data->email=$value['email'];
                $data->save();
            }
            $res_data = ['responseCode' => 1,'msg'=>'Data store successfully.'];
            return Response()->json($res_data);
        }catch (Exception $e){
            $res_data = ['responseCode' => -1,'msg'=>'Something went wrong.'];
            return Response()->json($res_data);
        }

    }
}
