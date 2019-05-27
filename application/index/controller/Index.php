<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Song;
use think\facade\Validate;
use think\facade\Request;
class Index extends Controller
{
    public function index()
    {
        $data = Song::select();
        if(!$data) {
            return error('很抱歉，好像没有歌曲了');
        }
        return success($data);
        // $this->view->assign('data', $data);
        // return $this->fetch();
    }
    public function add()
    {
        $params = Request::post();
        $validate = Validate::make([
            'song_name' => 'require|unique:song,song_name',
            'singer'    => 'require',
            'link'      => 'require'
        ]);
        if(!$validate->check($params)) {
            return error($validate->getError());
        }
        $result = Song::create($params);
        return success($result);
    }
    public function del()
    {
        $id = Request::get('id/d');
        if (empty($id)){
            return error('数据错误，请重试');
        }
        if(!Song::destroy($id)){
            return error('出现错误，请重试');
        }
        return success();
    }
}
