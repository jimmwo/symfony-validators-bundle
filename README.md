# Symfony validators

WIP

## Usage examples

### `NestedObject` and `NestedObjects` validators

```php
final class Book
{
    /**
     * @Constraints\NotBlank
     * @Constraints\Type(type="integer")
     */
    private int $id;

    /**
     * @Constraints\NotBlank
     * @Constraints\Type(type="string")
     */
    private string $title;
}

final class Reader
{
    /**
     * @Constraints\NotBlank
     * @Constraints\Type(type="integer")
     */
    private int $id;

    /**
     * @Constraints\NotBlank
     * @NestedObject(Book::class)
     */
    private Book $favoriteBook;

    /**
     * @Constraints\NotBlank
     * @NestedObjects(Book::class)
     *
     * @var Book[]
     */
    private array $readedBooks;
}
```