<?php

class Lang{
	/**
	 * @var string 当前设置的语言
	 */
	public static $language = '';
	/**
	 * @var array 语言包
	 */
	private static $languageConfig = array();

	/**
	 * 指定当前语言，如果不指定则从cookie中读取，cookie没有则采用默认的语言
	 * @param string $language 当前语言
	 */
	public static function setLanguage($language = ''){
		self::$languageConfig = '';
		if(!$language){
			if(isset($_COOKIE['_lg_'])){
				$language = $_COOKIE['_lg_'];
			}
		}
		if(!$language){
			$language = self::getDefaultLanguage();
		}
		setcookie('_lg_', $language, 3600 * 24 * 365);
		self::$language = $language;
	}

	/**
	 * 获得默认语言
	 *
	 * @return string
	 */
	public static function getDefaultLanguage(){
		$defaultLanguage = 'zh_CN';
		if(defined('APP_LANG')){
			$defaultLanguage = APP_LANG;
		}
		return $defaultLanguage;
	}

	/**
	 * 获得语言配置
	 *
	 * @return array|mixed
	 */
	public static function getLanguageConfig(){
		if(!empty(self::$languageConfig)){//已经加载过
			return self::$languageConfig;
		}

		$appRoot = APP_ROOT;
		if(YX::$thisAppRoot){
			$appRoot = YX::$thisAppRoot;
		}

		$file = $appRoot . '/lang/' . self::$language . '.php';
		if(is_file($file)){
			self::$languageConfig = include $file;
			return self::$languageConfig;
		}
		//找不到尝试找默认的语言包
		$language = self::getDefaultLanguage();
		$file = $appRoot . '/lang/' . $language . '.json';
		if(is_file($file)){
			self::$languageConfig = json_decode(file_get_contents($file), true);
			return self::$languageConfig;
		}
		return array();
	}
}

/**
 * 返回设定语言的字符串
 * @param string $name 语言的代号
 * @return string
 */
function L($name){
	$languageConfig = Lang::getLanguageConfig();
	if(!empty($languageConfig[$name])){
		if(strpos($languageConfig[$name], '%s') !== false){
			$args = func_get_args();
			array_shift($args);
			if(empty($args)){
				$args = array('', '', '', '', '', '', '', '');
			}
			return vsprintf($languageConfig[$name], $args);
		}else{
			return $languageConfig[$name];
		}
	}else{
		return $name;
	}
}