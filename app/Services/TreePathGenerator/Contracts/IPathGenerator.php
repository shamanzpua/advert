<?php
namespace App\Services\TreePathGenerator\Contracts;

use App\Services\TreePathGenerator\Exceptions\BadParamException;

/**
 * Interface IPathGenerator
 * @package App\Services\Contracts
 *
 */
interface IPathGenerator
{
    /**
     * @param $data
     * @return mixed
     * @throws BadParamException
     */
    public function generate($data);
}