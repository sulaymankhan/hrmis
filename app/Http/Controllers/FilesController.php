<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use App\Http\Requests\RelatedFileRequest;

class FilesController extends Controller
{
    public function uploadFile(Request $r)
    {
        $validatedData = $r->validate([
            'file' => 'mimes:jpeg,png,pdf,csv,docx,doc,xlsx',
        ]);
        return File::saveFile($r);
    }

    public function viewFile(Request $r)
    {
        $file = File::where('path', $r->input('path'))->first();
        if (!$file) {
            abort(404);
        }
        $path = \Storage::path($file->path);
        return response()->download($path, 'file', [], 'inline');
    }

    public function assignFileTo(RelatedFileRequest $r)
    {
        $relatedFile = new \App\RelatedFile;
        $relatedFile->f_id = $r->input('f_id');
        $relatedFile->emp_id = $r->input('emp_id');
        $relatedFile->save();
        return $relatedFile;
    }
}
