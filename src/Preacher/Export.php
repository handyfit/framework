<?php

namespace KanekiYuto\Handy\Preacher;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * Export Preacher
 *
 * @author KanekiYuto
 */
readonly class Export
{

	/**
	 * 构造导出实例
	 *
	 * @param  array  $data
	 */
	public function __construct(private array $data = [])
	{
		// Do it...
	}

	/**
	 * 以 [json] 形式导出
	 *
	 * @param  int    $status
	 * @param  array  $headers
	 * @param  int    $options
	 *
	 * @return JsonResponse
	 */
	public function json(
		int $status = PreacherResponse::DEFAULT_HTTP_STATUS,
		array $headers = [],
		int $options = PreacherResponse::DEFAULT_JSON_OPTIONS
	): JsonResponse {
		return Response::json(self::array(), $status, $headers, $options);
	}

	/**
	 * 以 [array] 形式导出
	 *
	 * @return array
	 */
	public function array(): array
	{
		return $this->data;
	}

	/**
	 * 以 [jsonp] 形式导出
	 *
	 * @param  string|null  $callback
	 * @param  int          $status
	 * @param  array        $headers
	 * @param  int          $options
	 *
	 * @return JsonResponse
	 */
	public function jsonp(
		string|null $callback = null,
		int $status = PreacherResponse::DEFAULT_HTTP_STATUS,
		array $headers = [],
		int $options = PreacherResponse::DEFAULT_JSON_OPTIONS
	): JsonResponse {
		return Response::jsonp(
			$callback,
			self::array(),
			$status,
			$headers,
			$options
		);
	}

}