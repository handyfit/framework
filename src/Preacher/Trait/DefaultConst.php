<?php

namespace KanekiYuto\Handy\Preacher\Trait;

/**
 * 默认常量
 *
 * @author KanekiYuto
 */
trait DefaultConst
{

	/**
	 * 成功状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_SUCCEED = 200;

	/**
	 * 警告状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_WARN = 400;

	/**
	 * 失败状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_FAIL = 500;

	/**
	 * 鉴权状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_AUTH = 401;

	/**
	 * 访问被拒绝响应码
	 *
	 * @var int
	 */
	const RESP_CODE_ACCESS_DENIED = 403;

	/**
	 * 未找到状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_NOT_FOUND = 404;

	/**
	 * 方法不允许状态响应码
	 *
	 * @var int
	 */
	const RESP_CODE_METHOD_NOT_ALLOWED = 405;

	/**
	 * 默认状态码键名称
	 *
	 * @var string
	 */
	const DEFAULT_KEY_CODE = 'code';

	/**
	 * 默认消息键名称
	 *
	 * @var string
	 */
	const DEFAULT_KEY_MSG = 'msg';

	/**
	 * 默认的 [json] 选项
	 *
	 * @var int
	 */
	const DEFAULT_JSON_OPTIONS = JSON_PARTIAL_OUTPUT_ON_ERROR;

	/**
	 * 默认的 [HTTP] 状态码
	 *
	 * @var int
	 */
	const DEFAULT_HTTP_STATUS = 200;

}