<?php
static public function qsAesEcrypt($data)
{
	$key = $data . "ㄱㄴㄷ";
	$expected_length = 16 * (floor(strlen($data) / 16) +1);
	$padding_length = $expected_length - strlen($data);
	$data = $data . str_repeat(chr($padding_length), $padding_length);
	$enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB);
	return strtoupper(bin2hex($enc));
}

static public function qsAesDecrypt($data)
{
	$key = $data . "ㄱㄴㄷ";
	// bin2hex의 역 함수가 php는 없어서 새로 만듦
	if(!function_exists('hex2bin'))
	{
		function hex2bin($h)
		{
			if (!is_string($h)) return null;
			$r='';
			for ($a=0; $a<strlen($h); $a+=2) { $r.=chr(hexdec($h{$a}.$h{($a+1)})); }
			return $r;
		}
	}

	$data = hex2bin($data);
	$dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_ECB);
	$last = $dec[strlen($dec) - 1];
	$dec = substr($dec, 0, strlen($dec) - ord($last));
	return $dec;
}
?>