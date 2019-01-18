<?php
namespace app\index\controller;
use think\Controller;
use think\Validate;
use app\common\model\Member;
class Login extends Controller {
    /**
     * @return mixed
     */
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
            //验证邮箱
            $validate = Validate::make([
                'email' => 'email'
            ]);
            switch ($validate->check(['email'=>$email])){
                case true :
                    //开始查询数据库
                    $user = Member::get(['email' => $email]);
                    if($user == null){
                        $user = Member::create(['email' => $email,'lastget'=>time()]);
                    }
                    $salt = rand(1111,9999);
                    $wait = time() - $user->lastget;
                    switch ($wait){
                        case ($wait > 600):
                            $user->salt = $salt;
                            $user->lastget = time();
                            $user->save();
                            $wait = 600;
                            $mail_content = '<p>登 录 码【'.$salt.'】</p>';
                            break;
                        default:
                            $wait = 600 - $wait;
                            $mail_content = '<p>登 录 码【'.$user->salt.'】</p>';
                            break;
                    }
                    $data['code'] = 200;
                    //邮件发送登录码
                    $mail_content .= '<p>有效时间【'.$wait.' 秒】</p>';
                    $mail_content .= '<p>有效期至【'.date('Y-m-d H:i:s',time() + $wait).'】</p>';
                    $this_content = setEmailContent($mail_content);
                    sendMail($this_content,$email);
                    break;
                default:
                    $data['code'] = 500;
                    break;
            }
        }
        return json($data);
    }

    /**
     * @param $salt
     * @return mixed
     */
    public function dologin($salt) {
        $data['code'] = 500;
        $salt = intval($salt);
        if (is_int($salt + 0) && $salt > 0){
            $time = time() - 600;
            $info = Member::where('salt',$salt)
            ->where('lastget','>',$time)
            ->find();
            if($info != null){
                //写入cookie
                cookie('email',$info['email'],3600*24*90);
                cookie('uid',$info['id'],3600*24*90);
                session('status',1001);
                //清空
                $info->salt = '';
                $info->lastlogin = time();
                $info->lastget = '';
                $info->save();
                $data['code'] = 200;
            }else{
                $data['code'] = 500;
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
