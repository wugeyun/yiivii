<?php
namespace app\index\controller;
use think\Controller;
use think\Validate;
use app\common\model\Member;
class Login extends Controller {
    public function index() {
        return view('');
    }
    /**
     * @param $email
     * @return mixed
     * 验证email
     */
    public function email($email) {
        $data['code'] = 500;
        $email = trim($email);
        if($email){
            //验证数据
            $result = Validate::make()
                ->rule(['email' => ValidateRule::email()])
                ->check(['email'=>$email]);
            if($result){
                $data['code'] = 200;
            }
            $user = Member::get(['email' => $email]);
            if(empty($user)){
                $user = Member::create(['email' => $email]);
            }
            //判断生成登录码
            for($i=1;$i<100;$i++){
                $salt = rand(1111,9999);
                $wait = time() - $user->lastget;
                if($wait > 300){
                    Member::where('email',$email)->update(['salt'=>$salt,'lastget'=>time()]);
                    $wait = 300;
                    $mail_content = '<p>登 录 码【'.$salt.'】</p>';
                    break;
                }else{
                    $wait = 300 - $wait;
                    $mail_content = '<p>登 录 码【'.$user->salt.'】</p>';
                }
            }
            //邮件发送登录码
            $mail_content .= '<p>有效时间【'.$wait.' 秒】</p>';
            $this_content = setEmailContent($mail_content,$title = '伊娃系统登陆码');
            sendMail($this_content,$email);
        }
        return json($data);
    }

    /**
     * @param $salt
     * @return mixed
     */
    public function dologin($salt) {
        $data['code'] = 500;
        if ($salt > 0){
            $time = time() - 300;
            $info = Member::where('salt',$salt)
            ->where('lastget','>',$time)
            ->find();
            if(!empty($info)){
                //写入cookie
                cookie('email',$info['email'],3600*24*90);
                //清空
                $info->salt = '';
                $info->lastlogin = time();
                $info->lastget = '';
                $info->save();
                $data['code'] = 200;
            }else{
                $data['code'] = 300;
            }
        }
        return json($data);
    }

    /**
     * 退出
     */
    public function loginout(){
        cookie('email',null);
        session(null);
        $this->redirect(url('/'));
    }
}
