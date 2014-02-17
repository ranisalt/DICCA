<?php
	function limpa_str($str) {
		$sujo = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
		$limpo = array("&agrave;", "&aacute;", "&acirc;", "&atilde;", "&ccedil;", "&eacute;", "&ecirc;", "&iacute;", "&oacute;", "&ocirc;", "&otilde;", "&uacute;", "&uuml;", "&Agrave;", "&Aacute;", "&Acirc;", "&Atilde;", "&Ccedil;", "&Eacute;", "&Ecirc;", "&Iacute;", "&Oacute;", "&Ocirc;", "&Otilde;", "&Uacute;", "&Uuml;");
		return str_replace($sujo, $limpo, $str);
	}
	
	function desafio_compara($str1, $str2) {
		$sujo = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
		$limpo = array("a", "a", "a", "a", "c", "e", "e", "i", "o", "o", "o", "u", "u", "A", "A", "A", "A", "C", "E", "E", "I", "O", "O", "O", "U", "U");
		return strtolower(str_replace($sujo, $limpo, $str1)) == strtolower(str_replace($sujo, $limpo, $str2));
	}
?>