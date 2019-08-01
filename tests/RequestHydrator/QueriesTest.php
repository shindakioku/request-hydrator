<?php

namespace Tests\RequestHydrator;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use RequestHydrator\Request\IlluminateRequest;
use RequestHydrator\RequestHydrator;
use RequestHydrator\Validator\IlluminateValidator;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use PHPUnit\Framework\TestCase;
use Tests\RequestHydrator\Classes\TwoFieldsWithOneRequired;

class QueriesTest extends TestCase
{
    /**
     * @var IlluminateRequest
     */
    private $request;

    /**
     * @var RequestHydrator
     */
    private $requestHydrator;

    public function setUp(): void
    {
        $this->request = new IlluminateRequest(new Request);
        $loader = new ArrayLoader;
        $loader->addMessages(
            'ru', 'validation',
            ['required' => 'Поле обязательно.', 'email' => 'Некорректный email.']
        );

        $this->requestHydrator = new RequestHydrator(
            new IlluminateValidator(new Factory(new Translator($loader, 'ru'))),
            $this->request,
        );
    }

    public function testSuccessWithOneField()
    {
        $this->request->setQueries(['username' => 'shindakioku']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired, $this->request)->get();

        $this->assertTrue($result->username === 'shindakioku');
    }

    public function testSuccessWithTwoFields()
    {
        $this->request->setQueries(['username' => 'shindakioku', 'email' => 'shindakioku@gmail.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired, $this->request)->get();

        $this->assertTrue($result->username === 'shindakioku');
        $this->assertTrue($result->email === 'shindakioku@gmail.com');
    }

    public function testFailWithOneField()
    {
        $this->request->setQueries(['email' => 'shindakioku@gmail.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired, $this->request);

        $this->assertTrue($result->isLeft());
        $this->assertSame(['username' => ['Поле обязательно.']], $result->get()->errors());
    }

    public function testFailWithTwoFields()
    {
        $this->request->setQueries(['email' => 'shindakioku.com']);
        $result = $this->requestHydrator->queries(new TwoFieldsWithOneRequired, $this->request);

        $this->assertTrue($result->isLeft());
        $this->assertSame(
            ['username' => ['Поле обязательно.'], 'email' => ['Некорректный email.']],
            $result->get()->errors()
        );
    }
}