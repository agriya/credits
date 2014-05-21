<?php namespace Agriya\Credits;

class AmountNotFoundException extends \Exception {}
class UserNotFoundException extends \Exception {}
class InvalidAmountException extends \Exception {}
class WithdrawalRequestNotFoundException extends \Exception {}

class Credits extends \BaseController {

	public static function greeting() {
		return "What up dawg credits package";
	}

	public static function credit($user_id, $amount = null, $currency = 'USD') {
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
			UserAccountBalance::insertGetId($data_arr);
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

	public static function debit($user_id, $amount = null, $currency = 'USD') {
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
		UserAccountBalance::whereRaw('user_id = ? AND currency = ?', array($user_id, $currency))->decrement('amount', $amount);
		return true;
	}

	public static function withdraw($user_id, $amount = null, $currency = 'USD') {
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
		$data_arr['user_id'] = $user_id;
		$data_arr['currency'] = $currency;
		$data_arr['amount'] = $amount;
		$data_arr['added_date'] = \DB::raw('NOW()');
		$data_arr['status'] = 'Pending';
		WithdrawalRequest::insertGetId($data_arr);
		return true;
	}

	public static function withdrawDetails() {
		$withdraw_details = self::getWithdrawDetails();
		if(count($withdraw_details) > 0) {
			return $withdraw_details;
		}
		throw new WithdrawalRequestNotFoundException;
	}

	public static function getWithdrawDetails()
	{
		$withdraw_arr = array();
		$withdraw = WithdrawalRequest::Select('withdraw_id', 'user_id', 'currency', 'amount', 'added_date', 'status')
									->orderBy('added_date', 'ASC')->get();
		if(count($withdraw) > 0) {
			foreach($withdraw as $key => $values) {
				$withdraw_arr[$key]['id'] = $values->withdraw_id;
				$withdraw_arr[$key]['user_id'] = $values->user_id;
				$withdraw_arr[$key]['currency'] = $values->currency;
				$withdraw_arr[$key]['amount'] = $values->amount;
				$withdraw_arr[$key]['added_date'] = $values->added_date;
				$withdraw_arr[$key]['status'] = $values->status;
			}
		}
		return $withdraw_arr;
	}
}