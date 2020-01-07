<?php

class CtlUpload extends Controller
{
    private $srv;
    private $ext = array(
        'img' => array('.gif', '.jpg', '.jpeg', '.bmp', '.png', '.psd', '.ico'),
        'file' => array('.rar', '.zip', '.doc', '.xls', '.docx', '.xlsx', '.pdf', '.txt'),
        'video' => array('.avi', '.wma', '.rmvb', '.rm', '.flash', '.mp4', '.mid', '.3gp', '.flv', '.mov'),
        'material' => array('.gif', '.jpg', '.jpeg', '.bmp', '.png', '.psd', '.ico', '.avi', '.wma', '.rmvb', '.rm', '.flash', '.mp4', '.mid', '.3gp', '.flv', '.mov')
    );

    public function __construct()
    {
        $this->srv = new SrvUpload();
    }

    /**
     * 上传到CDN
     */
    public function upload()
    {
        $this->outType = 'json';
        $file_name = $this->R('file_name'); //上传文件标识
        $limit_size = $this->R('limit_size', 'int', 0); //限制上传文件大小，单位：KB

        $total = $this->post('chunks', 'int', 0); //WebUploader，分割上传文件总数，0不分割
        $now = $this->post('chunk', 'int', 0); //WebUploader，当前上传分割数
        $nowSize = $this->post('chunkSize'); //WebUploader，当前分片大小，单位：字节
        $size = $this->post('size', 'int', 0); //WebUploader，上传文件大小，单位：字节
        $guid = $this->post('guid'); //WebUploader，页面唯一GUID
        $name = $this->post('name'); //WebUploader，文件名
        $fileMd5 = $this->post('fileMd5'); //WebUploader，上传文件MD5

        $this->srv->setRootPath(CDN_UPLOAD_DIR);
        $this->srv->setRootUrl(CDN_UPLOAD_URL);
        $this->srv->setUploadName($file_name);
        $this->srv->setLimitSize($limit_size);
        $this->srv->setExt(array('.jpg', '.png', '.jpeg', '.psd'));

        $this->out = $this->srv->upload($fileMd5, $total, $now, $size, $nowSize, $guid, $name);
    }

    /**
     * 上传到后台
     */
    public function uploadAdmin()
    {
        $this->outType = 'json';
        $file_name = $this->R('file_name'); //上传文件标识
        $limit_size = $this->R('limit_size', 'int', 0); //限制上传文件大小，单位：KB

        $total = $this->post('chunks', 'int', 0); //WebUploader，分割上传文件总数，0不分割
        $now = $this->post('chunk', 'int', 0); //WebUploader，当前上传分割数
        $nowSize = $this->post('chunkSize'); //WebUploader，当前分片大小，单位：字节
        $size = $this->post('size', 'int', 0); //WebUploader，上传文件大小，单位：字节
        $guid = $this->post('guid'); //WebUploader，页面唯一GUID
        $name = $this->post('name'); //WebUploader，文件名
        $fileMd5 = $this->post('fileMd5'); //WebUploader，上传文件MD5

        $this->srv->setRootPath(PIC_UPLOAD_DIR);
        $this->srv->setUploadName($file_name);
        $this->srv->setLimitSize($limit_size);
        $this->srv->setExt(array('.jpg', '.png', '.jpeg', '.psd', '.zip', '.txt'));

        $this->out = $this->srv->upload($fileMd5, $total, $now, $size, $nowSize, $guid, $name);
    }

    /**
     * 上传到临时文件
     */
    public function uploadTmp()
    {
        $this->outType = 'json';
        $file_name = $this->R('file_name'); //上传文件标识
        $limit_size = $this->R('limit_size', 'int', 0); //限制上传文件大小，单位：KB

        $total = $this->post('chunks', 'int', 0); //WebUploader，分割上传文件总数，0不分割
        $now = $this->post('chunk', 'int', 0); //WebUploader，当前上传分割数
        $nowSize = $this->post('chunkSize'); //WebUploader，当前分片大小，单位：字节
        $size = $this->post('size', 'int', 0); //WebUploader，上传文件大小，单位：字节
        $guid = $this->post('guid'); //WebUploader，页面唯一GUID
        $name = $this->post('name'); //WebUploader，文件名
        $fileMd5 = $this->post('fileMd5'); //WebUploader，上传文件MD5
        $this->srv->setRootPath(RUNTIME_DIR . '/tmp');
        $this->srv->setUploadName($file_name);
        $this->srv->setLimitSize($limit_size);
        $this->srv->setExt(array('.jpg', '.png', '.jpeg', '.rar', '.zip', '.txt', '.doc', '.docx', '.xls', '.xlsx'));

        $this->out = $this->srv->upload($fileMd5, $total, $now, $size, $nowSize, $guid, $name);
    }


    public function uploadTool()
    {
        $this->outType = 'json';
        $name = $this->post('name','string','');
        $limit_size = $this->post('limit_size', 'int', 0);
        $this->srv->setRootPath(RUNTIME_DIR . "/tmp");
        $this->srv->setUploadName($name);
        $this->srv->setLimitSize($limit_size);
        $this->srv->setExt($this->ext['video']);

        $res = $this->srv->toolUpload($name);
        if($res['state'] == true){
            $this->out = array(
                'code'=>0,
                'msg'=>'上传成功',
                'data'=>$res['data']
            );
        }else{
            $this->out = array(
                'code'=>400,
                'msg'=>$res['msg'],
                'data'=>[]
            );
        }
    }
}