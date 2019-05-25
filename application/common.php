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
function get_color()
{
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
function setEmailContent($base_content = '邮件正文内容...',$title = '伊娃交易登陆码')
{
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
function sendMail($content = '',$to = 'hswddan@qq.com',$title = '伊娃系统通知')
{
    //邮件设置
    $mail = new \PHPMailer\PHPMailer\PHPMailer;
    try {
        // 服务器设置
        //Server settings
        //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.exmail.qq.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = config('email.Username');                     // SMTP username
        $mail->Password   = config('email.Password');                               // SMTP password
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('system@yiivii.com', '伊娃系统通知');
        //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress($to);               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        // Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "=?UTF-8?B?".base64_encode($title)."?=";
        $mail->CharSet = "UTF-8";
        $mail->Body    = $content;
        $mail->AltBody = '收件人(https://www.yiivii.com)';

        $status = $mail->send();
        if ($status) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}
/**
 * 提交curl请求
 * api
 */
function callapi($url,$post = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($post)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl,CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36');
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}