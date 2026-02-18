<?php
class Currency {
	private $currencies = array();
	public function __construct() {
		$this->CI =& get_instance();
		$query = $this->CI->db->query("SELECT * FROM currency")->result_array();
		foreach ($query as $result) {
			$this->currencies[$result['code']] = array(
				'currency_id'   => $result['currency_id'],
				'title'         => $result['title'],
				'symbol_left'   => $result['symbol_left'],
				'symbol_right'  => $result['symbol_right'],
				'decimal_place' => $result['decimal_place'],
				'value'         => $result['value']
			);
		}
	}
	public function format($number, $format = true, $currency, $_decimal_point = false) {
		$symbol_left = $this->currencies[$currency]['symbol_left'];
		$symbol_right = $this->currencies[$currency]['symbol_right'];
		$decimal_place = $this->currencies[$currency]['decimal_place'];

		if($_decimal_point !== false){
			$decimal_place = $_decimal_point;
		}

		$value = '';
		if(!$value)
			$value = $this->currencies[$currency]['value'];

		$amount = $value ? (float) $number * $value : (float) $number;
		$amount = number_format($amount, (int)$decimal_place);
		
		if (!$format) {
			return $amount;
		}
		$string = '';
		if ($symbol_left) {
			$string .= $symbol_left;
		}
		$string .= $amount;
		 
		if ($symbol_right) {
			$string .= $symbol_right;
		}
		return $string;
	}
	public function convert($value, $from, $to) {
		if (isset($this->currencies[$from])) {
			$from = $this->currencies[$from]['value'];
		} else {
			$from = 1;
		}
		if (isset($this->currencies[$to])) {
			$to = $this->currencies[$to]['value'];
		} else {
			$to = 1;
		}
		return $value * ($to / $from);
	}
	
	public function getId($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['currency_id'];
		} else {
			return 0;
		}
	}
	public function getSymbolLeft($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_left'];
		} else {
			return '';
		}
	}
	public function getSymbolRight($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_right'];
		} else {
			return '';
		}
	}
	public function getSymbol() {
		$currency = $_SESSION['userCurrency'];

		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['symbol_left'] ? $this->currencies[$currency]['symbol_left'] : $this->currencies[$currency]['symbol_right'];
		} else {
			return '';
		}
	}
	public function getDecimalPlace($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['decimal_place'];
		} else {
			return 0;
		}
	}
	public function getValue($currency) {
		if (isset($this->currencies[$currency])) {
			return $this->currencies[$currency]['value'];
		} else {
			return 0;
		}
	}
	public function has($currency) {
		return isset($this->currencies[$currency]);
	}
}

function c_format($amount = 0,$format = true, $decimal_place = false){
	$CI =& get_instance();
	$currency = $_SESSION['userCurrency'];
	
	if(!$currency){
		$default_currency = $CI->db->query("SELECT * FROM currency WHERE is_default=1")->row_array();
        if($default_currency){
            $currency = $_SESSION['userCurrency'] = $default_currency['code'];
        }
	}

	return $CI->currency->format($amount, $format, $currency, $decimal_place, false);
}


function c_format_nosym ($amount = 0){
	return !empty($amount) ? $amount : 0;
}