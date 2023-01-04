<?php
namespace App\Components;

class recursive
{
    private $data;
    protected $htmlSelect = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function CategoryRecursive($parent_id, $id = 0, $text = ''){
        foreach ($this->data as $value) {
            if ($value['parent_id'] == $id) {
                if(!empty($parent_id) && $parent_id == $value['id']){
                    $this->htmlSelect .="<option selected value='".$value['id']."'>". $text . $value['name'] . "</option..>";
                }else
                {
                    $this->htmlSelect .="<option value='".$value['id']."'>". $text . $value['name'] . "</option..>";
                }
                $this->CategoryRecursive($parent_id, $value['id'],$text.'--') ;
            }
        }
        return $this->htmlSelect;
    }

//    public function CategoryRecursive($id = 0, $text = ''){
//        foreach ($this->data as $value) {
//            if ($value['parent_id'] == $id) {
//                $this->htmlSelect .="<option value='".$value['id']."'>". $text . $value['name'] . "</option..>";
//                $this->CategoryRecursive($value['id'],$text.'--') ;
//            }
//        }
//        return $this->htmlSelect;
//    }
}
