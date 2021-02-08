<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public static function saveFile($request)
    {

        $file               = new File;
        $file->name         = File::generateRandomName() . "." . $request->file('file')->extension();
        $file->real_name    = $request->file('file')->getClientOriginalName();
        $file->description         = $request->description;
        $file->user_id      = $request->user() ? $request->user()->id : 0;
        $path = \Storage::putFileAs(
            'files',
            $request->file('file'),
            $file->name
        );
        $file->path         = $path;
        $file->save();
        return response()->json([
            "f_id" => $file->id,
            "path" => $file->path,
            "description" => $file->description
        ]);
    }

    public static function generateRandomName()
    {
        return sha1(time() . random_int(1, 20000));
    }
}
