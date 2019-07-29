<?php

namespace Tests\RequestHydrator;

use App\Request\IlluminateRequest;
use App\RequestHydrator;
use App\Validator\IlluminateValidator;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use PHPUnit\Framework\TestCase;
use Tests\RequestHydrator\Classes\TwoFieldsWithOneRequired;

class QueriesTest extends TestCase
{
    private IlluminateRequest $request;
    private RequestHydrator $requestHydrator;

    public function setUp(): void
    {
        $this->request = new IlluminateRequest;

        $this->requestHydrator = new RequestHydrator(
            $this->request,
            new IlluminateValidator(new Translator(new ArrayLoader(), 'ru')),
        );
    }

    public function testSuccessWithOneField()
    {
        $this->request->query->add(['username' => 'shindakioku']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired)->get();

        $this->assertTrue($result->username === 'shindakioku');
    }

    public function testSuccessWithTwoFields()
    {
        $this->request->query->add(['username' => 'shindakioku', 'email' => 'shindakioku@gmail.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired)->get();

        $this->assertTrue($result->username === 'shindakioku');
        $this->assertTrue($result->email === 'shindakioku@gmail.com');
    }
}