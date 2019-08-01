<?php

namespace RequestHydrator\Request;

use PhpSlang\Option\Option;
use function Functional\curry;
use function Functional\filter;
use function Functional\pick;
use function Functional\reduce_right;

class IlluminateRequest implements Request
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }

    public function queries(array $keys = []): Option
    {
        $queries = $this->request->query->all();
        if (count($keys)) {
            return $this->getWithKeys($keys, $queries);
        }

        return Option::of($queries);
    }

    public function headers(array $keys = []): Option
    {
        $headers = $this->request->headers->all();
        if (count($keys)) {
            return $this->getWithKeys($keys, $headers);
        }

        return Option::of($headers);
    }

    public function body(array $keys = []): Option
    {
        $body = $this->request->post();
        if (count($keys)) {
            return $this->getWithKeys($keys, $body);
        }

        return Option::of($body);
    }

    public function setQueries(array $values): Request
    {
        $this->request->query->add($values);

        return $this;
    }

    public function setHeaders(array $values): Request
    {
        $this->request->headers->add($values);

        return $this;
    }

    private function getWithKeys(array $keys, array $values): Option
    {
        $pickValues = curry(function (array $values, $key) {
            return pick($values, $key);
        })($values);

        return Option::of(
            filter(reduce_right($keys, function ($key, $_, $__, $acc) use ($pickValues) {
                $acc[$key] = $pickValues($key);

                return $acc;
            }, []), function ($_, $value) {
                return $value !== null;
            })
        );
    }
}