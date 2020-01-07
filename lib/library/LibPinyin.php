<?php

class LibPinyin
{
    private static $pinyins = array();           // 拼音的缓冲数组

    /**
     * 返回汉字拼音
     * @param string $str （输入的汉字）
     * @param int $ishead （是否采用缩写的模式，0则否，1则是）
     * @param int $isclose （是否删除拼音数组，0则删除，1则保留）
     * @return string $restr       （返回汉字拼音）
     */

    private static function spGetPinyin($str, $ishead = 0, $isclose = 1)
    {
        $restr = "";
        $str = trim($str);
        $_slen = strlen($str);
        if ($_slen < 2)
            return $str;
        if (count(self::$pinyins) == 0) {
            $_fp = fopen(LIB . "/library/pinyin/pinyin.db", "r");
            while (!feof($_fp)) {
                $line = trim(fgets($_fp));
                self::$pinyins[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
            }
            fclose($_fp);
        }
        for ($i = 0; $i < $_slen; $i++) {
            if (ord($str[$i]) > 0x80) {
                $_c = $str[$i] . $str[$i + 1];
                $i++;
                if (isset(self::$pinyins[$_c])) {
                    if ($ishead == 0)
                        $restr .= self::$pinyins[$_c];
                    else
                        $restr .= self::$pinyins[$_c][0];
                } else
                    $restr .= "-";
            } else if (eregi("[a-z0-9]", $str[$i])) {
                $restr .= $str[$i];
            } else {
                $restr .= "-";
            }
        }
        if ($isclose == 0) {
            self::$pinyins = [];
            //unset(self::$pinyins);
        }
        return $restr;
    }

    /**
     *调用私有方法spGetPinyin获得返回的汉字拼音，并且自己也返回拼音；
     * @param string $str （输入的汉字）
     * @param int $is_head （是否采用缩写的模式，0则否，1则是）
     * @param string $encoding （输入的编码方式）
     * @param int $is_close （是否删除拼音数组，0则删除，1则保留）
     * @return string $res                 （返回汉字拼音）
     */
    public static function get($str, $is_head = 1, $encoding = 'utf-8', $is_close = 1)
    {
        return self::spGetPinyin(iconv($encoding, 'GB2312', $str), $is_head, $is_close);
    }
}