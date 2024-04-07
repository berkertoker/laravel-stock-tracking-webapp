<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
   public function __invoke($id)
    {

        $productImage = ProductImage::findOrFail($id);

        if ($productImage) {
            $folderName = strtok($productImage->url, '/');
            Storage::deleteDirectory('public/images/' . $folderName);
            $productImage->delete();
        }

        return '';
    }
}
