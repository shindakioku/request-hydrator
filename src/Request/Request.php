<?php

namespace RequestHydrator\Request;

use \PhpSlang\Option\Option;

interface Request
{
    public function queries(array $keys = []): Option;

    public function headers(array $keys = []): Option;

    public function body(array $keys = []): Option;
}