<?php
ini_set('memory_limit', '128M');

class SrvUpload
{
    private $root_path = '', $root_url = '', $ext = [], $limit_size = 20480, $upload_name = 'file';

    /**
     * 设置目标绝地路径
     * @param string $dir
     * @return bool
     */
    public function setRootPath($dir = '')
    {
        if (!$dir) {
            return false;
        }

        if (substr($dir, -1, 1) != '/' && substr($dir, -1, 1) != '\\') {
            $dir .= '/';
        }

        $this->root_path = $dir;
    }

    /**
     * 设置目标访问URL
     * @param string $url
     */
    public function setRootUrl($url = '')
    {
        $this->root_url = $url;
    }

    /**
     * 设置可上传文件后缀
     * @param array $ext
     * @return bool
     */
    public function setExt($ext = [])
    {
        if (!is_array($ext)) {
            return false;
        }

        $this->ext = $ext;
    }

    /**
     * 设置上传文件限制大小
     * @param int $limit_size
     * @return bool
     */
    public function setLimitSize($limit_size = 0)
    {
        if ((int)$limit_size <= 0) {
            return false;
        }

        $this->limit_size = $limit_size;
    }

    /**
     * 设置上传标识
     * @param string $name
     * @return bool
     */
    public function setUploadName($name = 'file')
    {
        if (!$name) {
            return false;
        }

        $this->upload_name = $name;
    }

    /**
     * 上传
     * @param string $fileMd5
     * @param int $total
     * @param int $now
     * @param int $size
     * @param int $nowSize
     * @param string $guid
     * @param string $name
     * @return array
     */
    public function upload($fileMd5 = '', $total = 0, $now = 0, $size = 0, $nowSize = 0, $guid = '', $name = '')
    {
        $total = intval($total); //WebUploader，分块上传文件总数，0不分割
        $now = intval($now); //WebUploader，当前上传分割数
        $nowSize = intval($nowSize); //WebUploader，当前分片大小，单位：字节
        $size = intval($size); //WebUploader，上传文件大小，单位：字节
        $name = trim($name); //WebUploader，文件名
        $guid = trim($guid); //页面唯一GUID
        $fileMd5 = trim($fileMd5); //上传文件唯一MD5

        if (!$this->root_path || empty($this->ext) || !$fileMd5) {
            return array('state' => false, 'msg' => '缺少参数');
        }

        $old_file_name = $name;
        if (!$name) {
            $old_file_name = $_FILES[$this->upload_name]['name'];
        }

        $old_file_ext = LibFile::getExt($old_file_name);
        $root_path = $this->root_path;
        $file = '';

        if ($total > 1) {
            $root_path = RUNTIME_DIR . '/tmp/upload/' . $fileMd5 . '/';
            $file = $now . $old_file_ext . '.tmp';

            //第一次上传时删除之前上传的文件
            if ($now == 0 && is_dir($root_path)) {
                LibUtil::delDir($root_path);
            }
        }

        $end = false;
        $data = LibFile::upload($this->upload_name, $root_path, $this->root_url, $this->limit_size, $this->ext, $file);
        if ($data['state']) {
            //分片上传
            if ($total > 1) {
                if ($nowSize != filesize($data['file'])) {
                    return array('state' => false, 'msg' => '上传文件不完整，请重新上传[1]');
                }

                //分片上传结束，合并分片
                if ($total == ($now + 1)) {
                    $new_file = $this->root_path . date('ym') . '/' . date('dHis') . mt_rand(1000, 9999) . '_' . substr($fileMd5, 4, 10) . $old_file_ext;
                    if (!is_dir(dirname($new_file))) {
                        mkdir(dirname($new_file), 0775, true);
                    }

                    $files = LibUtil::getDirFile($root_path);
                    if (count($files) != $total) {
                        return array('state' => false, 'msg' => '上传文件不完整，请重新上传[2]');
                    }

                    //自然排序法排序
                    natsort($files);
                    $_size = 0;
                    foreach ($files as $_file) {
                        $stream = file_get_contents($_file);
                        file_put_contents($new_file, $stream, FILE_APPEND);
                        unlink($_file);
                        $_size += strlen($stream);
                    }
                    LibUtil::delDir($root_path);

                    if ($size > 0 && $size != $_size) {
                        return array('state' => false, 'msg' => '上传文件不完整，请重新上传[3]');
                    }

                    $data['url'] = str_replace($this->root_path, '', $new_file);
                    $data['file'] = $new_file;
                    $data['size'] = bcdiv($_size, 1024, 0);
                    $end = true;
                }
            } else {
                if ($size > 0 && $size != filesize($data['file'])) {
                    return array('state' => false, 'msg' => '上传文件不完整，请重新上传');
                }
                $end = true;
            }

            if ($end) {
                $data['name'] = substr($old_file_name, 0, strrpos($old_file_name, '.'));

                unset($data['file']);
                return $data;
            } else {
                return array('state' => true, 'msg' => '上传成功');
            }
        }

        return array('state' => false, 'msg' => $data['msg']);
    }

    public function toolUpload($name = '')
    {
        if (!$this->root_path || empty($this->ext)) {
            return array('state' => false, 'msg' => '缺少参数');
        }
        $old_file_name = $name;
        if (!$name) {
            $old_file_name = $_FILES[$this->upload_name]['name'];
        }
        $root_path = $this->root_path;
        $file = '';
        $end = false;
        $data = LibFile::upload($this->upload_name, $root_path, $this->root_url, $this->limit_size, $this->ext, $file);
        if ($data['state']) {
            //上传成功
            //调用接口

        }
        return array('state' => false, 'msg' => $data['msg']);
    }
}