<?php

namespace Tests\Request;

use App\Request\IlluminateRequest;
use PHPUnit\Framework\TestCase;

class IlluminateRequestTest extends TestCase
{
    private IlluminateRequest $request;

    public function setUp(): void
    {
        $this->request = new IlluminateRequest();
    }

    public function testGetAllQueries()
    {
        $values = [
            'user_id' => 1,
            'username' => 'shindakioku',
        ];
        $this->request->query->add($values);
        $result = $this->request->queries();

        $this->assertTrue($result->isNotEmpty());
        $this->assertSame($values, $result->get());
    }

    public function testGetQueriesByKey()
    {
        $values = [
            'user_id' => 1,
            'username' => 'shindakioku',
        ];
        $this->request->query->add($values);

        $this->assertSame(['user_id' => 1], $this->request->queries(['user_id'])->get());
        $this->assertSame(['username' => 'shindakioku'], $this->request->queries(['username'])->get());
    }

    public function testGetQueriesByKeys()
    {
        $values = [
            'user_id' => 1,
            'username' => 'shindakioku',
        ];
        $this->request->query->add($values);

        $this->assertSame(
            ['username' => 'shindakioku', 'user_id' => 1],
            $this->request->queries(['user_id', 'username'])->get()
        );
    }
}