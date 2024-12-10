<?php

namespace KanekiYuto\Handy\Cascade\Trait\Laravel;

use stdClass;
use Exception;
use ReflectionMethod;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;

trait Helper
{

    /**
     * 自动判断是否需要使用方法参数 [如果值不是默认的话]
     *
     * @param  string  $class
     * @param  string  $fn
     * @param  array   $params
     *
     * @return stdClass
     */
    protected function useParams(string $class, string $fn, array $params): stdClass
    {
        $validParams = [];

        try {
            $method = new ReflectionMethod($class, $fn);

            foreach ($method->getParameters() as $param) {
                $paramName = $param->getName();
                $key = '$' . $paramName;

                if (isset($params['@quote$' . $paramName])) {
                    $key = '@quote$' . $paramName;
                }

                // 如果有设置默认值并且与默认值相等则不会被载入
                if ($param->isOptional() && $params[$key] === $param->getDefaultValue()) {
                    continue;
                }

                $returnParamName = Str::of($key)->replace('$', '')->toString();
                $validParams[$returnParamName] = $params[$key];
            }
        } catch (Exception $e) {
            error($e->getMessage());
        }

        return (object) $validParams;
    }

}