<?php

namespace Tests\Request;

use Illuminate\Http\Request;
use RequestHydrator\Request\IlluminateRequest;
use PHPUnit\Framework\TestCase;

class IlluminateRequestTest extends TestCase
{
    /**
     * @var IlluminateRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new IlluminateRequest(new Request);
    }

    public function testGetAllQueries()
    {
        $values = [
            'user_id' => 1,
            'username' => 'shindakioku',
        ];
        $this->request->setQueries($values);
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
        $this->request->setQueries($values);

        $this->assertSame(['user_id' => 1], $this->request->queries(['user_id'])->get());
        $this->assertSame(['username' => 'shindakioku'], $this->request->queries(['username'])->get());
    }

    public function testGetQueriesByKeys()
    {
        $values = [
            'user_id' => 1,
            'username' => 'shindakioku',
        ];
        $this->request->setQueries($values);

        $this->assertSame(
            ['username' => 'shindakioku', 'user_id' => 1],
            $this->request->queries(['user_id', 'username'])->get()
        );
    }
}