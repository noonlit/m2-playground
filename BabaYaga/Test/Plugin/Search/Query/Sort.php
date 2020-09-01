<?php

declare(strict_types=1);

namespace BabaYaga\Test\Plugin\Search\Query;

class Sort
{
    /**
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterGetSort($subject, $result)
    {
        $result[] = ['entity_id' => ['order' => 'desc']];

        return $result;
    }
}
