<?php
class CtlAuxTool extends Controller
{
    private $srv = null;
    private $mediaCnf = null;

    public function __construct()
    {
        $this->mediaCnf = LibUtil::config('market_media');
    }

    //素材库
    public function toolList()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $mediaCnf = $this->mediaCnf;
        $this->out['medias'] = $mediaCnf;
        $this->out['__title__'] = '广告工具箱';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/toollist.tpl';
    }

    //定向
    public function toolAim()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $this->out['medias'] = $this->mediaCnf;
        $this->out['__title__'] = '广告工具箱';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/toolaim.tpl';
    }

    //文案库
    public function ToolText()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $this->out['medias'] = $this->mediaCnf;
        $this->out['__title__'] = '广告工具箱';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->out['__on_menu__'] = 'auxTool';
        $this->tpl = 'tool/tooltext.tpl';
    }

    /**-----------素材列表-------------*/

    //组图
    public function gPictureTool()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $media = $this->R('media','string','');
        $this->out['media'] = $media;
        $this->out['__title__'] = '新增广告素材';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/gpicture_tool.tpl';
    }

    //小图
    public function smPictureTool()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $media = $this->R('meida','string','');
        $this->out['media'] = $media;
        $this->out['__title__'] = '新增广告素材';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/smpicture_tool.tpl';
    }

    //横板视频
    public function hvideoTool()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $media = $this->R('media','string','');
        $this->out['media'] = $media;
        $this->out['__title__'] = '新增广告素材';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/hvideo_tool.tpl';
    }

    //竖版视频
    public function svideoTool()
    {
        SrvAuth::checkOpen('auxTool','toolList');
        $this->outType = 'smarty';
        $media = $this->R('media','string','');
        $this->out['media'] = $media;
        $this->out['__title__'] = '新增广告素材';
        $this->out['__on_menu__'] = 'auxTool';
        $this->out['__on_sub_menu__'] = 'toolList';
        $this->tpl = 'tool/svideo_tool.tpl';
    }

    //横板大图
    public function hPictureTool()
    {

    }

    //竖版大图
    public function sPictureTool()
    {

    }

}
?>