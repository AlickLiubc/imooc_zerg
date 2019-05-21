<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;

use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;

    private $msg;

    private $errorCode;
    // 需要返回客户端当前请求的URL路径

    public function render(Exception $e)
    {
        if ( $e instanceof BaseException ) {
            // 如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if ( config('app_debug') ) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误，不想告诉你';
                $this->errorCode = 999;
            }

            // 记录错误日志
            $this->recordErrorLog($e);
        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];

        return json($result, $this->code);
    }

    private function recordErrorLog(Exception $e)
    {
        Log::init([
            'type'  => 'File',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => ['error'],
        ]);

        Log::record($e->getMessage(), 'error');
    }
}