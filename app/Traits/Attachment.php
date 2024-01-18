<?php

namespace App\Traits;


use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait Attachment
{

    static public function uploadFile(array $files, string $Storage ,string $type ,string $attachable_id ,string $attachable_type)
    {
        try {
            foreach ($files as $file){
                $path = $file->store($Storage);
                $name = $file->getClientOriginalName();
                DB::table("attachments")->insertGetId([
                    "type" => $type,
                    "name" =>$name,
                    "path" => $path,
                    "attachable_id" => $attachable_id,
                    "attachable_type" => $attachable_type,
                    "created_at" => Carbon::now(),
                ]);

            }

        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with("error",$e->getMessage());
        }
    }


    static public function updateFile(array $files ,string $Storage ,string $type ,string $attachable_id ,string $attachable_type){
        try {

            $file = DB::table("attachments")
            ->where("attachable_id" , $attachable_id)
            ->where("attachable_type" , $attachable_type)
            ->select("id" , "path")
            ->get();

            $ids = $file->pluck("id");
            $paths = $file->pluck("path");

            self::deleteFile($ids , $paths);

            foreach ($files as $file) {
                $path = $file->store($Storage);
                $name = $file->getClientOriginalName();
                DB::table("attachments")
                ->whereId('id',$ids)
                ->updateOrInsert([
                    "type" => $type,
                    "name" =>$name,
                    "path" => $path,
                    "attachable_id" => $attachable_id,
                    "attachable_type" => $attachable_type,
                    "updated_at" => Carbon::now(),
                ]);
            }



        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with("error",$e->getMessage());
        }
    }


    static public function deleteFile($ids ,  $paths ){
        try {


            foreach ($paths as $path) {
                if ($path !== null && Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
            DB::table("attachments")->whereIn("id" , $ids)->delete();


        }
        catch (Exception $e) {
            DB::rollBack();
            return back()->with("error",$e->getMessage());
        }
    }






}

?>
