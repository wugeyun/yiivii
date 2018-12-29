<?php
namespace app\index\controller;
use think\Controller;
class Login extends Controller {
    public function index() {
        return view('');
    }
    //验证email
    public function email() {
        $data['code'] = 200;
        $email = trim(input('email'));
        if($email){
            cookie('loginemail',$email,3600*24*90);
            $data['code'] = 500;
            /*
            $isEmail = $model::get(['email'=>$email]);
            if($isEmail){
                //判断生成登录码
                for($i=1;$i<100;$i++){
                    $salt = rand(1111,9999);
                    $wait = time() - $isEmail['lastget'];
                    if($wait > 300){
                        $info = $model->save(['salt'=>$salt,'lastget'=>time(),'ip'=>Request::instance()->ip()],['email'=>$email]);
                        $wait = 300;
                        $mail_content = '<p>登 录 码【'.$salt.'】</p>';
                        break;
                    }else{
                        $wait = 300 - $wait;
                        $mail_content = '<p>登 录 码【'.$isEmail['salt'].'】</p>';
                    }
                }
                //邮件发送登录码
                $mail_content .= '<p>有效时间【'.$wait.' 秒】</p>';
                $mail_content .= '<p>登录地址 <a href="'.url('/').'">'.url('/').'</a></p>';
                $this_content = setEmailContent($title = '伊娃系统通知', '', $mail_content);
                sendMail($email, '【'.$isEmail['title'].'】的登录码', $this_content, 1);
                //返回json到页面
                $data['code'] = 500;
                $data['str'] .= '<form action="'.url('login/doLogin').'" method="post" class="form-singin">';
                $data['str'] .= '<div class="input-group input-group-lg lead">';
                $data['str'] .= '<input type="text" name="password" class="form-control" placeholder="输入登录码" required autofocus>';
                $data['str'] .= '<span class="input-group-btn">';
                $data['str'] .= '<button class="btn btn-success" type="submit">确定 <span class="glyphicon glyphicon-ok"></span></button>';
                $data['str'] .= '</span>';
                $data['str'] .= '</div>';
                $data['str'] .= '</form>';
                $data['str'] .= '<hr>';
                $data['str'] .= '<div class="alert alert-warning fade in" role="alert">';
                $data['str'] .= '<button type="button" class="close" data-dismiss="alert">';
                $data['str'] .= '<span aria-hidden="true">&times;</span>';
                $data['str'] .= '<span class="sr-only">Close</span>';
                $data['str'] .= '</button>';
                $data['str'] .= '<span class="glyphicon glyphicon-envelope"></span> 请打开邮件接收登录码<br>有效期 <b id="wait">'.$wait.'</b> 秒</div>';
                $data['str'] .= '<script>';
                $data['str'] .= '(function(){';
                $data['str'] .= 'var wait = document.getElementById("wait");';
                $data['str'] .= 'var interval = setInterval(function(){';
                $data['str'] .= 'var time = --wait.innerHTML;';
                $data['str'] .= 'if(time <= 0) {';
                $data['str'] .= 'clearInterval(interval);';
                $data['str'] .= '};';
                $data['str'] .= '}, 1000);';
                $data['str'] .= '})();';
                $data['str'] .= '</script>';
            }
        */
        }
        return json($data);
    }
    public function dologin() {
        $data['code'] = 200;
        return json($data);
        //return view('');
    }
}
