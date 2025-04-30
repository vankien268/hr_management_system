<?php

namespace App\Observers;

use App\Models\product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Image;
use Illuminate\Validation\ValidationException;

class productObserver
{
    public function created(product $product): void
    {
        //
    }

    public function creating(Product $product)
    {
        $imageNew = $product->image_link;
        try {
            $this->saveImage($imageNew);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                $e->getMessage()
            ]);
        }

    }

    public function updating(Product $product)
    {
        $imageNew = $product->image_link;
        try {
            $this->saveImage($imageNew);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                $e->getMessage()
            ]);
        }
    }

    /**
     */
    public function updated(product $product): void
    {
        //
    }

    /**
     */
     public function deleting(product $product)
     {

     }

    public function deleted(product $product): void
    {
        //
    }

    /**
     */
    public function restored(product $product): void
    {
        //
    }

    /**
     */
    public function forceDeleted(product $product): void
    {
        //
    }

    public function saveImage($imageNew)
    {
        $fileName = Str::afterLast($imageNew, '/');
        #storage
        $pathStorage = Storage::disk('public')->url('/');
        $pathImage = $pathStorage . 'product_images/' . $fileName;
        #get with - height
        $getimagesizeStorage = $imageNew == null ? null : getimagesize(URL::to('/') . Storage::url($imageNew));
        $ratioStandard = 600 / 400;
        if ($imageNew != null) {
            $width = $getimagesizeStorage[0];
            $height = $getimagesizeStorage[1];
            $ratioImage = $width / $height;
            #compare
            if ($width > 600 && $height > 400) {
                $resize_image = Image::make($pathImage);
                if ($ratioStandard > $ratioImage) {
                    $resize_image->resize(null, 400, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($ratioStandard < $ratioImage) {
                    $resize_image->resize(600, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else {
                    $resize_image->resize(600, 400);
                }
                $resize_image->save(storage_path("app/public/product_images/" . $fileName));
            } elseif ($width > 600 && $height < 400) {
                $resize_image = Image::make($pathImage);
                $resize_image->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path("app/public/product_images/" . $fileName));
            } elseif ($width < 600 && $height > 400) {
                $resize_image = Image::make($pathImage);
                $resize_image->resize(null, 400, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $resize_image->save(storage_path("app/public/product_images/" . $fileName));
            } else {

            }
        } else {
        }
    }
}
