<?php

class affilatepartner
{
    public $partner_id;
    public $link;
    public $name;
    public $image_link;

    public function __construct($partner_id,$link,$name,$image_link) {
        $this->partner_id = $partner_id;
        $this->link = $link;
        $this->name = $name;
        $this->image_link = $image_link;
    }
}