<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 随机boostrap状态
 * @return mixed
 */
function get_color(){
    $data = ['default','primary','success','info','warning','danger'];
    $key = array_rand($data,1);
    return $data[$key];
}
/**
 * 邮件内容构造器
 * $to 发送给谁
 * $title 正文标题
 * $from 正文底部来源
 * $base_content 正文内容
 */
function setEmailContent($base_content = '邮件正文内容...',$title = '伊娃交易登陆码'){
    $content = '<table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f7f9fa;padding-top:20px;padding-bottom:30px;">';
    $content .= '<tr>';
    $content .= '<td align="center" style="background-color: #F7F9FA" width="100%">';
    $content .= '<table border="0" width="552" cellspacing="0" cellpadding="0" style="width:552px;border-radius:4px;border:1px solid #dedede;margin:0 auto;background-color:#ffffff">';
    $content .= '<tr>';
    $content .= '<td style="padding:25px" align="left">';
    $content .= '<p style="text-align:center;font-size:1.6em;font-weight:400;">'.$title.'</p>';
    $content .= '<hr />';
    $content .= $base_content;
    $content .= '<hr />';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '<tr>';
    $content .= '<td style="padding:25px 25px 35px 25px;background-color:#f7f7f7;">';
    $content .= '<p>来源【<a href="https://www.yiivii.com">www.yiivii.com</a>】';
    $content .= '<p style="text-align:right;">发送时间【'.date('Y-m-d H:i:s').'】</p>';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '</table>';
    $content .= '</td>';
    $content .= '</tr>';
    $content .= '</table>';
    return $content;
}
/**
 * 发送邮件
 * $to 发送给谁
 * $title 邮件标题
 * $content 邮件内容
 */
function sendMail($content = '',$to = 'hswddan@qq.com',$title = '伊娃系统通知'){
    //邮件设置
    $mail = new \PHPMailer\PHPMailer\PHPMailer;
    try {
        // 服务器设置
        //$mail->SMTPDebug = 2;     // 开启Debug
        $mail->isSMTP();        // 使用SMTP
        $mail->SMTPAuth = true;     // 开启SMTP验证
        $mail->SMTPSecure = 'ssl';      // 开启TLS 可选
        $mail->Host = 'smtp.exmail.qq.com';     // 服务器地址 smtp.exmail.qq.com
        $mail->Username = config('email.Username');     // SMTP 用户名
        $mail->Password = config('email.Password');     // SMTP 密码
        $mail->Port = 465;      // 端口
        $mail->setFrom('system@yiivii.com', '伊娃系统通知');      // 来自
        $mail->addReplyTo('system@yiivii.com', '收件人');      // 回复地址
        $mail->addAddress($to);
        //$mail->addAddress($to);       // 可以只传邮箱地址
        //$mail->ConfirmReadingTo = 'hswddan@qq.com';       //回执
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // 附件
        //$mail->addAttachment('/var/tmp/file.tar.gz');     // 添加附件
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // 可以设定名字
        // 内容
        $mail->isHTML(true);        // 设置邮件格式为HTML
        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->AltBody = '收件人(https://www.yiivii.com)';     //邮件正文不支持HTML的备用显示
        $mail->send();
    } catch (Exception $e) {

    }
}