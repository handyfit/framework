<?php

namespace KanekiYuto\Handy\Preacher;

use Closure;
use KanekiYuto\Handy\Preacher\Trait\DefaultConst;

/**
 * Preacher
 *
 * @author KanekiYuto
 */
class PreacherResponse
{

	use DefaultConst;

	/**
	 * 状态码
	 *
	 * @var int
	 */
	private int $code;

	/**
	 * 响应消息
	 *
	 * @var string
	 */
	private string $msg;

	/**
	 * 响应数据
	 *
	 * @var array
	 */
	private array $data;

	/**
	 * 消息的生命周期
	 *
	 * @var Closure
	 */
	private Closure $msgActivity;

	/**
	 * 构造一个 [Preacher] 实例
	 *
	 * @param  Closure  $msgActivity
	 * @param  int      $code
	 * @param  string   $msg
	 *
	 * @return void
	 */
	public function __construct(
		Closure $msgActivity,
		int $code = self::RESP_CODE_SUCCEED,
		string $msg = ''
	) {
		$this->msgActivity = $msgActivity;
		$this->code = $code;
		$this->msg = $msg;
		$this->data = [];
	}

	/**
	 * 设置分页信息
	 *
	 * @param  int    $page
	 * @param  int    $prePage
	 * @param  int    $total
	 * @param  array  $data
	 *
	 * @return self
	 */
	public function setPaging(
		int $page,
		int $prePage,
		int $total,
		array $data
	): self {
		$this->data['paging'] = (object) [
			'page' => $page,
			'prePage' => $prePage,
			'total' => $total,
			'rows' => $data,
		];

		return $this;
	}

	/**
	 * 获取分页信息
	 *
	 * @return object
	 */
	public function getPaging(): object
	{
		return $this->data['paging'];
	}

	/**
	 * 设置回执信息
	 *
	 * @param  object  $data
	 *
	 * @return self
	 */
	public function setReceipt(object $data): self
	{
		$this->data['receipt'] = $data;

		return $this;
	}

	/**
	 * 返回回执信息
	 *
	 * @return object
	 */
	public function getReceipt(): object
	{
		return $this->data['receipt'];
	}

	/**
	 * 设置行数据
	 *
	 * @param  array  $data
	 *
	 * @return self
	 */
	public function setRows(array $data): self
	{
		$this->data['rows'] = $data;

		return $this;
	}

	/**
	 * 获取行数据
	 *
	 * @return array
	 */
	public function getRows(): array
	{
		return $this->data['rows'];
	}

	/**
	 * 判断是否成功
	 *
	 * @return bool
	 */
	public function isSucceed(): bool
	{
		return $this->code === self::RESP_CODE_SUCCEED;
	}

	/**
	 * 导出响应
	 *
	 * @return Export
	 */
	public function export(): Export
	{
		return new Export(array_merge([
			self::DEFAULT_KEY_CODE => $this->getCode(),
			self::DEFAULT_KEY_MSG => $this->getMsg(),
		], $this->data));
	}

	/**
	 * 获取响应状态码
	 *
	 * @return int
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * 设置响应状态码
	 *
	 * @param  int  $code
	 *
	 * @return self
	 */
	public function setCode(int $code): self
	{
		$this->code = $code;

		return $this;
	}

	/**
	 * 获取响应消息
	 *
	 * @return string
	 */
	public function getMsg(): string
	{
		return $this->msg;
	}

	/**
	 * 设置响应消息
	 *
	 * @param  string  $msg
	 *
	 * @return self
	 */
	public function setMsg(string $msg): self
	{
		$msgActivity = $this->msgActivity;
		$this->msg = $msgActivity($msg);

		return $this;
	}

}