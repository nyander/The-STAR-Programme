<?php

namespace App\Http\Controllers;

use App\Models\File;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
  function __construct(){
      $this->middleware('permission:file-management-control', ['only' => ['create', 'store', 'show']]);
  }
  public function create()
  {
    return view('files.create'); 
  }

  public function store(Request $request)
  {
  
    $request->validate([
      'file' => 'required|mimes:pdf,docx|max:2048',
      'type' => 'required'
    ]);

    DB::transaction(function() use ($request) {
      // Check if file with same type exists
      $files = File::where('type', $request->type)->get();

      
      if ($files->count() > 0) {
        foreach($files as $fileItem){
          $path = public_path('storage/uploads/' . $fileItem->name);
          if (File::exists($path)){
            unlink($path);
          }
          $fileItem->delete();
        }
      }
    });
    

    // Upload new file
    $mimeType = $request->file->getMimeType();
    $fileName = time().'_'.$request->file->getClientOriginalName();
    $path = $request->file('file')->storeAs('uploads', $fileName, 'public');

    // Create file model
    $file = new File;
    $file->name = $fileName;
    $file->path = '/storage/' . $path; 
    $file->mime_type = $mimeType;
    $file->type = $request->type;

    $file->save();

    return redirect()
            ->route('files.show', $file->id)
            ->with('success', 'File uploaded successfully.');

  }

  public function show($id)
  {
    $file = File::findOrFail($id);
    return view('files.show', compact('file'));
  }

}