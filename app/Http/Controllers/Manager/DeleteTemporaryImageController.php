<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\TemporaryImage;
use Illuminate\Support\Facades\Storage;

class DeleteTemporaryImageController extends Controller
{
    public function __invoke($uniqueId)
    {
        $temporaryImage = TemporaryImage::where('folder', $uniqueId)->first();
        if ($temporaryImage) {
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return '';
    }
}
