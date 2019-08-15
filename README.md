# Request-Hydrator

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

--------------------


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
