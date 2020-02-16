
# Parentheses
  library created with to check open parentheses to mathematical expression
## Usage
  create instance object 'parentheses'
  transfer to string to method isValid, to response you get message to string passed validation or not

```php
use App\Brackets;

$data = '
    ()()())()
    ()()()()
    )))()()(
    ()()()
';
echo (new Brackets())->isValid($data);;
```


## errors
`DataIsEmpty` - empty attribute data

`InvalidArgumentException` - the transmitted string has the wrong format
