<?php

namespace App\Request;

use \Illuminate\Http\Request as IRequest;
use PhpSlang\Option\Option;
use function Functional\curry;
use function Functional\filter;
use function Functional\pick;
use function Functional\reduce_right;

class IlluminateRequest extends IRequest implements Request
{
    public function queries(array $keys = []): Option
    {
        $queries = $this->query->all();
        if (count($keys)) {
            return $this->getWithKeys($keys, $queries);
        }

        return Option::of($queries);
    }

    public function headers(array $keys = []): Option
    {
        $headers = $this->headers->all();
        if (count($keys)) {
            return $this->getWithKeys($keys, $headers);
        }

        return Option::of($headers);
    }

    public function body(array $keys = []): Option
    {
        $body = $this->post();
        if (count($keys)) {
            return $this->getWithKeys($keys, $body);
        }

        return Option::of($body);
    }

    private function getWithKeys(array $keys, array $values): Option
    {
        $pickValues = curry(fn (array $values, $key) => pick($values, $key))($values);

        return Option::of(
            filter(reduce_right($keys, function ($key, $_, $__, $acc) use ($pickValues) {
                $acc[$key] = $pickValues($key);

                return $acc;
            }, []), fn ($_, $value) => $value !== null)
        );
    }
}