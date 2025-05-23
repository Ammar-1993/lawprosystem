<?php

namespace App\Traits;

use Storage;

trait DatatablTrait
{

    public function image($dir, $image, $width = '20%')
    {

        $exist = $dir . '/' . $image;

        if (is_null($image) || !Storage::disk('public')->exists($exist)) {
            $img_url =  asset('storage/default/picture.png');
        }

        if (!is_null($image) && Storage::disk('public')->exists($exist)) {
            $img_url =  asset('storage/' . $exist);
        }

        return '
            <div class="text-center">
                <img src="' . $img_url . '" style="width:' . $width . '" alt="">
            </div>
        ';
    }

    public function action($data)
    {
        return view('component.action')->with($data)->render();
    }

    public function status($isYes, $id, $url, $item = NULL)
    {


        if (($isYes == 'yes' || $isYes == 'YES' || $isYes == 'Yes') && $isYes !== NULL) {



            $isYes = '<label class="switch"><input type="checkbox"  class="change-status" checked=""  id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '"  value="' . $id . '"><div class="slider round"></div></label>';
            // $isYes = '<div class="material-switch">
            //     <input id="status_'.$id.'" name="status_'.$id.'" data-url="'.$url.'" type="checkbox" class="change-status"  value="'.$id.'"  checked />
            //     <label for="status_'.$id.'" class="badge-success"></label>
            // </div>';

        } else {


            $isYes = '<label class="switch"><input type="checkbox"  class="change-status" id="status_' . $id . '" name="status_' . $id . '" data-url="' . $url . '"  value="' . $id . '"><div class="slider round"></div></label>';
            // $isYes = '<div class="material-switch">
            //     <input id="status_'.$id.'" name="status_'.$id.'" class="change-status" data-url="'.$url.'" type="checkbox"  value="'.$id.'"   />
            //     <label for="status_'.$id.'" class="badge-success"></label>
            // </div>' ;

        }

        return $isYes;
    }

    public function checkbox($id)
    {
        return '<label class="ckbx" for="variants_id_' . $id . '" value="' . $id . '">
                    <input type="checkbox" class="custome-checkbox is_check" name="ids[]" id="variants_id_' . $id . '" value="' . $id . '">
                    <span class="checkmark"></span>
                </label>';
    }

    public function text($item, $class = NULL)
    {
        return  '<p class="' . $class . '">' . $item . '</p>';
    }
}
