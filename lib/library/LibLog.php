<?php

class LibLog
{

    public static function write($type, $data)
    {
        $dir = LOG_PATH . $type . '/';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                Debug::log('创建日志目录失败' . $dir);
                return false;
            };
        }
        $file = date('YmdHi') . '.log';
        $content = json_encode($data) . "\n";
        return LibUtil::file_append_contents($dir . $file, $content);
    }

    public static function statLog($type, $data)
    {
        $dir = "/data2/stat_log/{$type}/";
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $file = $dir . date('YmdHi') . '.log';
    }

}