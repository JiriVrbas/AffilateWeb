<?php
class user
{
    public $user_id;
    public $login;
    public $email;
    public $link;
    public $first_name;
    public $last_name;
    public $superior_id;
    public $account_id;
    public $balance;

    public function __construct($user_id,$login,$email,$link,$first_name=null,$last_name=null,$superior_id,$account_id=null,$balance) {
        $this->user_id = $user_id;
        $this->login = $login;
        $this->email = $email;
        $this->link = $link;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->superior_id = $superior_id;
        $this->account_id = $account_id;
        $this->balance = $balance;
    }
}