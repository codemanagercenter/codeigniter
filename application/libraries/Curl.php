<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Curl Class
 *
 * @author JakeWang
 * @copyright Wang_run_sheng@sina.com
 */
class Curl
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    //Curl提交
    public function go($url, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        // 需要通过POST方式发送的数据
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            )
        );
        curl_setopt($curl, CURLOPT_TIMEOUT, 180);

        // 运行cURL，请求API, 并解开Json，格式数组
        $res = json_decode(curl_exec($curl), true);
        $curl_errno = curl_errno($curl);
        curl_close($curl);
        if ($curl_errno > 0) {
            header('HTTP/1.1 408 Request Time-out');
            $this->CI->load->vars("message_e", "网络错误，请稍后再试");
            $this->CI->load->view("error_404");
            $this->CI->output->_display();
            die();
        } else {
            return $res;
        }
    }

    public function doGet($url)
    {
        //初始化
        $ch = curl_init();

        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        $output_array = json_decode($output, true);
        $curl_errno = curl_errno($ch);
        curl_close($ch);

        if ($curl_errno > 0) {
            header('HTTP/1.1 408 Request Time-out');
            $this->CI->load->vars("message_e", "网络错误，请稍后再试");
            $this->CI->load->view("errors/html/error_405");
            $this->CI->output->_display();
            die();
        } else {
            return $output_array;
        }
    }

    /*
     * curl 文件上传
     */
    public function upload_file_to_java($furl, $url)
    {
        $data = array(
            'importfile' => new CURLFile(realpath($furl))
        );
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_USERPWD, 'joe:secret');//设置登录名密码
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return_data = curl_exec($ch);
        $output_array = json_decode($return_data, true);
        curl_close($ch);
        return $output_array;
    }
}

/* End of file Curl.php */
/* Location: ./application/libraries/Curl.php */
