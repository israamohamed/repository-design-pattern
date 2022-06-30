<?php


namespace App\Traits\Images;


use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\Storage;
use Image;

trait HasAnImage
{
    public function image()
    {
        return $this->morphOne(ImageModel::class, 'imageable');
    }

    public function getImagePathAttribute()
    {
        $model = $this->find($this->id);
        return $model->image && asset('uploads/' . $model->image->path) ? asset('uploads/' . $model->image->path) : asset('images/default_user.png');
    }

    public function updateImage($folder_name)
    {
        if (request()->filled('new_image')) {

            //Delete the old image from the public images folder
            if($this->image)
            {
                Storage::delete($this->image->path);
                //Delete the old image from the images table
                $this->image()->delete();
            }

            $img = Image::make(request()->new_image)->resize(240,200);
           
            $position = strpos(request()->new_image, ';'); //data:image/jpeg;base64,/9j/4AAQSkZ

            $sub = substr(request()->new_image, 0, $position); //data:image/jpeg

            $ext = explode('/', $sub)[1]; //jpeg
            
            $name = time().".".$ext;

            $image_path = $folder_name. '/' . $name;
            $image_url = 'uploads/' . $image_path ;

            $img->save($image_url);
          
            //Create a new user's image in images table
            $this->image()->create(['path' => $image_path]);
        }

     
    }

    public function uploadImage($folder_name)
    {
        if (request()->filled('image')) {

            $img = Image::make(request()->image)->resize(240,200);
           
            $position = strpos(request()->image, ';'); //data:image/jpeg;base64,/9j/4AAQSkZ

            $sub = substr(request()->image, 0, $position); //data:image/jpeg

            $ext = explode('/', $sub)[1]; //jpeg
            
            $name = time().".".$ext;

            $image_path = $folder_name. '/' . $name;
            $image_url = 'uploads/' . $image_path ;

            $img->save($image_url);
          
            //Create a new user's image in images table
            $this->image()->create(['path' => $image_path]);
        }
    }

    public function deleteImage()
    {
        if($this->image)
        {
            //Delete image from the public images folder
            Storage::delete($this->image->path);
            //Delete image from images table
            $this->image()->delete();
        }

    }
}
