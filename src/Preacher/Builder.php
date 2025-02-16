<?php

namespace Handyfit\Framework\Preacher;

use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * Preacher Builder
 *
 * @author KanekiYuto
 */
class Builder
{

    /**
     * 消息钩子
     *
     * @var Closure
     */
    private static Closure $msgHook;

    /**
     * 使用消息生命周期
     *
     * @param Closure $closure
     */
    public static function useMsgHook(Closure $closure): void
    {
        static::$msgHook = $closure;
    }

    /**
     * 返回基础的响应信息
     *
     * @return PreacherResponse
     */
    public static function base(): PreacherResponse
    {
        return new PreacherResponse(self::getMsgActivity());
    }

    /**
     * 等同于 [setMsg()]
     *
     * @param string $msg
     *
     * @return PreacherResponse
     */
    public static function msg(string $msg): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setMsg($msg);
    }

    /**
     * 等同于 [setCode()]
     *
     * @param int $code
     *
     * @return PreacherResponse
     */
    public static function code(int $code): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setCode($code);
    }

    /**
     * 同时设置 [msg] 和 [code]
     *
     * @param int    $code
     * @param string $msg
     *
     * @return PreacherResponse
     */
    public static function msgCode(int $code, string $msg): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setCode($code)
            ->setMsg($msg);
    }

    /**
     * 等同于 [setPaging]
     *
     * @param int   $page
     * @param int   $prePage
     * @param int   $total
     * @param array $data
     *
     * @return PreacherResponse
     */
    public static function paging(int $page, int $prePage, int $total, array $data): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setPaging($page, $prePage, $total, $data);
    }

    /**
     * 等同于 [setReceipt]
     *
     * @param object $data
     *
     * @return PreacherResponse
     */
    public static function receipt(object $data): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setReceipt($data);
    }

    /**
     * 等同于 [setRows]
     *
     * @param array $data
     *
     * @return PreacherResponse
     */
    public static function rows(array $data): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setRows($data);
    }

    /**
     * 验证并返回预设
     *
     * @param bool             $allow
     * @param PreacherResponse $pass
     * @param PreacherResponse $noPass
     * @param callable|null    $handle
     *
     * @return PreacherResponse
     */
    public static function allow(bool $allow, mixed $pass, mixed $noPass, callable $handle = null): mixed
    {
        if (!empty($handle)) {
            call_user_func($handle);
        }

        return $allow ? $pass : $noPass;
    }

    /**
     * 设置 Eloquent 模型
     *
     * @param Model $model
     *
     * @return PreacherResponse
     */
    public static function model(Model $model): PreacherResponse
    {
        return (new PreacherResponse(self::getMsgActivity()))
            ->setModel($model);
    }

    /**
     * 获取消息的生命周期
     *
     * @return Closure
     */
    private static function getMsgActivity(): Closure
    {
        if (!isset(self::$msgHook)) {
            return function (string $message) {
                return $message;
            };
        }

        return self::$msgHook;
    }

}
