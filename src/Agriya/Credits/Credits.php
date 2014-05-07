<?php namespace Agriya\Credits;

class AmountNotFoundException extends \Exception {}
class UserNotFoundException extends \Exception {}
class InvalidAmountException extends \Exception {}

class Credits extends \BaseController {

	public static function greeting() {
		return "What up dawg credits package";
	}

	public static function add($user_id, $amount = null, $currency = 'USD') {
		if($user_id == '') {
			throw new UserNotFoundException('User not given');
		}
		else if($amount == '') {
			throw new AmountNotFoundException('Amount not given');
		}
		if($amount != '') {
			if (!preg_match("/^[0-9]+(\\.[0-9]{1,2})?$/", $amount))
			{
				throw new InvalidAmountException('Invalid Amount Format');
			}
		}
		$currency_cnt = UserAccountBalance::whereRaw('user_id = ? AND currency = ?', array($user_id, $currency))->count();
		if($currency_cnt > 0) {
			UserAccountBalance::whereRaw('user_id = ? AND currency = ?', array($user_id, $currency))->increment('amount', $amount);
		}
		else {
			$data_arr['user_id'] = $user_id;
			$data_arr['currency'] = $currency;
			$data_arr['amount'] = $amount;
			$credit_id = UserAccountBalance::insertGetId($data_arr);
		}
		return true;
	}

	public static function totalCredits($user_id, $currency = 'USD') {
		if($user_id == '') {
			throw new UserNotFoundException('User not given');
		}
		$total = UserAccountBalance::whereRaw('user_id = ? AND currency = ?', array($user_id, $currency))->sum('amount');
		return $total;
	}

	public static function refund($user_id, $amount = null, $currency = 'USD') {
		if($user_id == '') {
			throw new UserNotFoundException('User not given');
		}
		else if($amount == '') {
			throw new AmountNotFoundException('Amount not given');
		}
		UserAccountBalance::whereRaw('user_id = ? AND currency = ?', array($user_id, $currency))->decrement('amount', $amount);
		return true;
	}
}