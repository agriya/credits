<?php namespace Agriya\Credits;

class UserAccountBalance extends \Eloquent
{
    protected $table = "user_account_balance";
    public $timestamps = false;
    protected $primarykey = 'id';
    protected $table_fields = array("id", "user_id", "currency", "amount");
}