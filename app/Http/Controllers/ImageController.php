<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public static function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,svg|max:2048',
            ]);

            $file = $request->image;
            if($file){
                $fileName = ImageController::getFileName($file);
                $googleDriveStorage = Storage::disk('google');
                $googleDriveStorage->put($fileName, file_get_contents($file->getRealPath()));
                $url = Storage::disk('google')->url($fileName);
                return $url;
            }
            return null;
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public static function getFileName($file)
    {
        $uuid = Str::uuid()->toString();
        $fileName = $file->getClientOriginalName();
        $fileName = $uuid . "-" . $fileName;
        return $fileName;
    }
}
