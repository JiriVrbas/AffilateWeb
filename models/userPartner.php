<?php

class userPartner
{
    public $partner_id;
    public $user_id;
    public $link_to_affilate;
    public $active;

    public function __construct($partner_id,$user_id,$link_to_affilate,$active) {
        $this->partner_id = $partner_id;
        $this->user_id = $user_id;
        $this->link_to_affilate = $link_to_affilate;
        $this->active = $active;
    }
}