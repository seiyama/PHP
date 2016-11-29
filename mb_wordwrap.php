<?php

/**
*
指定した文字列を指定した幅に改行された文字列を返す。
*
* @param string $str
* @param number $width
* @param string $break
* @return string
*/

function mb_wordwrap($str , $width = 76, $break = "\n")
{
	$wordwrap_lines = array();
	
	// 入力された文字列を「\n」で分割する
	$lines = explode($break, $str);
	foreach($lines as $line) {
		
		// 文字列後方の空白を取り除く
		$line = rtrim($line);
		
		// 空文字でない文字だけを一文字ずつ分割する（UTF-8）
		$str_chars = preg_split('//u', $line, -1, PREG_SPLIT_NO_EMPTY);
		
		$length_count = 0;
		$field_cnt = 0;
		$wraps = array();
		$wraps[$field_cnt] = '';
		
		foreach($str_chars as $char)
		{
			// 半角か判別
			$is_half_char = true;
			if(strlen($char) != 1) {
				$is_half_char = false;
			}
			
			// 文字の追加ができるか。
			if(
				( $is_half_char && $length_count + 1 > $width) || 
				(!$is_half_char && $length_count + 2 > $width)
			){
				$length_count = 0;
				$field_cnt++;
				$wraps[$field_cnt] = '';
				
			}
			
			if($is_half_char){
				// 半角なら1byte
				$length_count += 1;
				
			} else {
				// 全角なら2byte
				$length_count += 2;
			}
			
			// 文字の追加
			$wraps[$field_cnt] .= $char;
			
		}
		
		$wordwrap_lines = array_merge($wordwrap_lines, $wraps);
	}
	
	return implode($break, $wordwrap_lines);
}


?>