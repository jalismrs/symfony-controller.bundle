# Symfony Bundle Controller

Adds Symfony controller abstract class

## Test

`phpunit` or `vendor/bin/phpunit`

coverage reports will be available in `var/coverage`

## Use

### returnFile
```php
use Jalismrs\Symfony\Common\ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SomeController extends ControllerAbstract
{
    public function someActionReturningFile(
        Request $request
    ): BinaryFileResponse
    {
        $file = 'some-file.ext';
    
       return $this->returnFile(
           $file,
       );
    }
}
```

### returnJson
```php
use Jalismrs\Symfony\Common\ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SomeController extends ControllerAbstract
{
    public function someActionReturningObject(
        Request $request
    ): JsonResponse
    {
        return $this->returnJson(
            $request,
            new ArrayObject(
                [
                    'property' => 'value',
                ]
            ),
        );
    }
    
    public function someActionReturningList(
        Request $request
    ): JsonResponse
    {
       return $this->returnJson(
           $request,
           [
               [
                   'property' => 'value',
               ]
           ],
           'listing',
       );
    }
}
```
