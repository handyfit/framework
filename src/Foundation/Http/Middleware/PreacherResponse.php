<?php

namespace Handyfit\Framework\Foundation\Http\Middleware;

use Closure;
use Handyfit\Framework\Preacher\Export;
use Handyfit\Framework\Preacher\PreacherResponse as PResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteAction;
use Laravel\SerializableClosure\SerializableClosure;
use Symfony\Component\HttpFoundation\Response;

/**
 * 响应处理中间件
 *
 * @author kanekiYuto
 */
class PreacherResponse
{

    /**
     * 处理传入的请求
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $action = $route->getAction();

        if ($this->isControllerAction($action)) {
            return $this->runController($request, $next);
        }

        return $this->runCallable($request, $next);
    }

    /**
     * 判定是哪种方式的 [action]
     *
     * @param array $action
     *
     * @return bool
     */
    protected function isControllerAction(array $action): bool
    {
        return is_string($action['uses']) && !$this->isSerializedClosure($action);
    }

    /**
     * 判断 [action] 是否包含序列化闭包
     *
     * @param array $action
     *
     * @return bool
     */
    protected function isSerializedClosure(array $action): bool
    {
        return RouteAction::containsSerializedClosure($action);
    }

    /**
     * 运行控制器方式的路由处理
     *
     * @param Request $request
     * @param Closure $next
     * @param Closure $handle
     *
     * @return Response
     */
    protected function runController(Request $request, Closure $next): Response
    {
        $route = $request->route();

        $callable = $route->controllerDispatcher()->dispatch(
            $route,
            $route->getController(),
            $route->getActionMethod()
        );

        $convertResult = $this->convert($callable);

        if ($convertResult !== false) {
            return $convertResult;
        }

        return $next($request);
    }

    /**
     * 转换返回的数据
     *
     * @param mixed $callable
     *
     * @return JsonResponse|false
     */
    protected function convert(mixed $callable): JsonResponse|false
    {
        if ($callable instanceof PResponse) {
            return $callable->export()->json();
        }

        if ($callable instanceof Export) {
            return $callable->json();
        }

        return false;
    }

    /**
     * 运行闭包方式的路由处理
     *
     * @param Request $request
     * @param Closure $next
     * @param Closure $handle
     *
     * @return Response
     */
    protected function runCallable(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $action = $route->getAction();

        if ($this->isSerializedClosure($action)) {
            $callable = unserialize($action['uses']);

            if ($callable instanceof SerializableClosure) {
                $callable = $callable->getClosure();
            }

            $convertResult = $this->convert($callable());

            if ($convertResult !== false) {
                return $convertResult;
            }
        }

        return $next($request);
    }

}
