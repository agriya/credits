<?php namespace Agriya\Credits;

class WithdrawalRequest extends \Eloquent
{
    protected $table = "withdrawal_request";
    public $timestamps = false;
    protected $primarykey = 'withdraw_id';
    protected $table_fields = array("withdraw_id", "user_id", "currency", "amount", "added_date", "status");
}