<?php

namespace App\Http\Controllers\Designs;

use App\Http\Controllers\Controller;
use App\Jobs\UploadImage;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function upload(Request $request)
    {
        //validate the request
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,gif,bmp,png', 'file', 'max:2048'],
        ]);

        //get the image from the request

        $image = $request->file('image');
        $image_path = $image->getPathname();

        //get the original filename and replace any spaces with _

        $filename = time() . "_" . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        //move the image to the temporary location (tmp)
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        //create database record for the design
        $design = $this->users->applyDesign($filename, 'site.upload_disk');
        /*$design = auth()->user()->designs()->create([
            'image' => $filename,
            'disk' => config('site.upload_disk'),
        ]);*/

        //dispatch a job to handle the image manipulation
        $this->dispatch(new UploadImage($design));

        return response()->json($design, 200);

    }
}
