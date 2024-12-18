<?php

namespace Handyfit\Framework\Preacher;

use Closure;
use stdClass;
use Illuminate\Database\Eloquent\Model;
use Handyfit\Framework\Preacher\Trait\DefaultConst;

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
     * Eloquent 模型
     *
     * @var mixed
     */
    private mixed $model;

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
    public function __construct(Closure $msgActivity, int $code = self::RESP_CODE_SUCCEED, string $msg = '')
    {
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
     * @param  array  $rows
     *
     * @return static
     */
    public function setPaging(
        int $page,
        int $prePage,
        int $total,
        array $rows
    ): static {
        $this->data['paging'] = (object) [
            'page' => $page,
            'prePage' => $prePage,
            'total' => $total,
            'rows' => $rows,
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
     * @param  stdClass  $value
     *
     * @return static
     */
    public function setReceipt(stdClass $value): static
    {
        $this->data['receipt'] = $value;

        return $this;
    }

    /**
     * 合并回执信息
     *
     * @param  stdClass  $value
     *
     * @return PreacherResponse
     */
    public function mergeReceipt(stdClass $value): static
    {
        $this->data['receipt'] = array_merge(
            (array) $this->data['receipt'],
            (array) $value
        );

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
     * @param  array  $value
     *
     * @return static
     */
    public function setRows(array $value): static
    {
        $this->data['rows'] = $value;

        return $this;
    }

    /**
     * 合并行信息
     *
     * @param  array  $value
     *
     * @return PreacherResponse
     */
    public function mergeRows(array $value): static
    {
        $this->data['rows'] = array_merge(
            $this->data['rows'],
            $value
        );

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
        return $this->code === static::RESP_CODE_SUCCEED;
    }

    /**
     * 导出响应
     *
     * @return Export
     */
    public function export(): Export
    {
        return new Export(array_merge([
            static::DEFAULT_KEY_CODE => $this->getCode(),
            static::DEFAULT_KEY_MSG => $this->getMsg(),
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
     * @return static
     */
    public function setCode(int $code): static
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
     * @return static
     */
    public function setMsg(string $msg): static
    {
        $msgActivity = $this->msgActivity;
        $this->msg = $msgActivity($msg);

        return $this;
    }

    /**
     * 获取 Eloquent 模型
     *
     * @return mixed
     */
    public function getModel(): mixed
    {
        return $this->model;
    }

    /**
     * 设置 Eloquent 模型
     *
     * @param  Model  $model
     *
     * @return static
     */
    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

}