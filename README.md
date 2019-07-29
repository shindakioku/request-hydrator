# Request-Hydrator

Describe yourself classes (DTO) with validation rules and custom messages and then just take your DTO with already validated properties!
Easy for use, easy for change default request & validator object to your favorite!

------------
To first, just describe your request dto
```php
<?php

namespace App\Requests\Users;

use RequestHydator\App\Dto\DtoHydrator;

class CreateUser extends DtoHydrator
{
    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'email' => 'required|email'
        ];
    }
}
```

Then use one of three `queries`, `headers`, `body`.

```php
<?php

use RequestHydrator\App\RequestHydrator;

namespace App\Http\Controllers;

class UsersController 
{
    private RequestHydrator $requestHydrator;

    public function __construct(RequestHydrator $requestHydrator)
    {
        $this->requestHydrator = $requestHydrator;
    }
    
    public function create()
    {
        return $this->requestHydrator->queries(new CreateUser)
                ->left(fn($validationErrors) => ...)
                ->right(fn(CreateUser $user) => $this->register->execute($user));
    }
}
```

`Request` and `Validator` by default is interfaces. You can use adapters from `illuminate`. They're ready for using.
Or you can create your simple `request` & `validator`.
For example:

```php
<?php

use RequestHydrator\App\Request\Request;
use \PhpSlang\Option\Option;

class MyGreatRequest implements Request
{
    public function queries(array $keys = []): Option
    {
        return Option::of($_GET);
    }

    public function headers(array $keys = []): Option
    {
        return Option::of(\getallheaders());
    }
    
    public function body(array $keys = []): Option
    {
        return Option::of($_POST);
    }
}
```