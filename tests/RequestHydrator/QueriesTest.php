<?php

namespace Tests\RequestHydrator;

use RequestHydrator\Request\IlluminateRequest;
use RequestHydrator\RequestHydrator;
use RequestHydrator\Validator\IlluminateValidator;
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
        $loader = new ArrayLoader;
        $loader->addMessages(
            'ru', 'validation',
            ['required' => 'Поле обязательно.', 'email' => 'Некорректный email.']
        );

        $this->requestHydrator = new RequestHydrator(
            $this->request,
            new IlluminateValidator(new Translator($loader, 'ru')),
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

    public function testFailWithOneField()
    {
        $this->request->query->add(['email' => 'shindakioku@gmail.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired);

        $this->assertTrue($result->isLeft());
        $this->assertSame(['username' => ['Поле обязательно.']], $result->get()->errors());
    }

    public function testFailWithTwoFields()
    {
        $this->request->query->add(['email' => 'shindakioku.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired);

        $this->assertTrue($result->isLeft());
        $this->assertSame(
            ['username' => ['Поле обязательно.'], 'email' => ['Некорректный email.']],
            $result->get()->errors()
        );
    }
}