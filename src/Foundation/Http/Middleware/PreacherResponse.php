<?php

namespace KanekiYuto\Handy\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteAction;
use KanekiYuto\Handy\Preacher\Export;
use Symfony\Component\HttpFoundation\Response;
use Laravel\SerializableClosure\SerializableClosure;
use KanekiYuto\Handy\Preacher\PreacherResponse as PResponse;

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
	 * @param  Request  $request
	 * @param  Closure  $next
	 *
	 * @return Response
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$route = $request->route();
		$action = $route->getAction();

		// 无论是控制器处理的请求还是闭包处理的请求，他们最终都应该被以闭包的方式返回
		$handle = function (mixed $callable, Route $route) {
			if ($callable instanceof PResponse) {
				$route->uses(function () use ($callable) {
					return $callable->export()->json();
				});
			}

			if ($callable instanceof Export) {
				$route->uses(function () use ($callable) {
					return $callable->json();
				});
			}

			return false;
		};

		if ($this->isControllerAction($action)) {
			return $this->runController($request, $next, $handle);
		}

		return $this->runCallable($request, $next, $handle);
	}

	/**
	 * 判定是哪种方式的 [action]
	 *
	 * @param  array  $action
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
	 * @param  array  $action
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
	 * @param  Request  $request
	 * @param  Closure  $next
	 * @param  Closure  $handle
	 *
	 * @return Response
	 */
	protected function runController(Request $request, Closure $next, Closure $handle): Response
	{
		$route = $request->route();

		$callable = $route->controllerDispatcher()
			->dispatch($route, $route->getController(), $route->getActionMethod());

		$handleResult = $handle($callable, $route);

		if ($handleResult !== false) {
			return $handleResult;
		}

		return $next($request);
	}

	/**
	 * 运行闭包方式的路由处理
	 *
	 * @param  Request  $request
	 * @param  Closure  $next
	 * @param  Closure  $handle
	 *
	 * @return Response
	 */
	protected function runCallable(Request $request, Closure $next, Closure $handle): Response
	{
		$route = $request->route();
		$action = $route->getAction();

		if ($this->isSerializedClosure($action)) {
			$callable = unserialize($action['uses']);

			if ($callable instanceof SerializableClosure) {
				$callable = $callable->getClosure();
			}

			$callable = $callable();

			$handleResult = $handle($callable, $route);

			if ($handleResult !== false) {
				return $handleResult;
			}
		}

		return $next($request);
	}

}
