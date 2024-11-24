# Symfony validators

## Usage examples

### `NestedObject` and `NestedObjects` validators

```php
use N7\SymfonyValidatorsBundle\Validator\NestedObject;
use N7\SymfonyValidatorsBundle\Validator\NestedObjects;
use Symfony\Component\Validator\Constraints;

final class Book
{
    #[Constraints\NotBlank]
    #[Constraints\Type('integer')]
    private int $id;

    #[Constraints\NotBlank]
    #[Constraints\Type('string')]
    private string $title;
}

final class Reader
{
    #[Constraints\NotBlank]
    #[Constraints\Type('integer')]
    private int $id;

    #[Constraints\NotBlank]
    #[NestedObject(Book::class)]
    private Book $favoriteBook;

    /**
     * @var Book[]
     */
    #[Constraints\NotBlank]
    #[NestedObjects(Book::class)]
    private array $readedBooks;
}
```