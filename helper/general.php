<?php

use Illuminate\Support\Facades\Storage;
use App\Models\Lookup;
use Carbon\Carbon;








/**
*  This function formats a date to 'Y-m-d' format. Returns NULL if the date is null.
* @author Salah Derbas
*/
if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return (!is_null($date)) ? Carbon::parse($date)->format('Y-m-d') : NULL ;
    }
}

/**
*  This function retrieves the ID of a lookup record by key.
* @author Salah Derbas
*/
if (!function_exists('getIDLookups')) {
    function getIDLookups($key)
    {
        return Lookup::where(['key' => $key ])->pluck('id')->first();
    }
}

/**
* Checks if the function 'handleFileUpload' already exists before defining it.
* This function handles the uploading of files, allowing optional deletion of old files if updating.
* @author Salah Derbas
*/
if (!function_exists('handleFileUpload')) {
    function handleFileUpload($file, $type, $directory, $oldPath = null)
    {
        $path = 'public/' . $directory;
        if($type === 'update' && $oldPath)  {
            if (Storage::exists($oldPath))
                Storage::delete($oldPath);
        }
        $newPath = $file->store($path);
        return env('APP_URL').'/storage/'.$newPath;

    }
}
