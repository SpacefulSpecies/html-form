Html Form
=========

## Install

```bash
composer require species/html-form
```


## Contract

### Node

#### Node
    getName(): string
    getShortName(): string
    getParent(): ?ParentNode

    setParent(?ParentNode $parent): void
    clone(): Node

#### LeafNode
    + Node

#### ParentNode
    + Node, NodeCollection

#### NodeCollection
    +IteratorAggregate<Node>
    +ArrayAccess<Node>
    +Countable<Node>


### Value

#### StringValue
    getValue(): string
    getDefaultValue(): string

    getError(): ?string;

    submit(string $value, array $context  = []): mixed
    reset(?string $newDefaultValue = null): void

#### ArrayValue
    getValues(): array
    getDefaultValues(): array

    getError(): ?string;
    getErrors(): array

    submit(array $values, array $context  = []): mixed
    reset(?array $newDefaultValues = null): void


### Form

#### Form
    + ArrayValue
    +submit(array $values, array $context  = []): bool

    fields: FieldSet

#### FieldSet
    + ParentNode, ArrayValue

#### FieldList
    + ParentNode, ArrayValue

    getPrototype(): (cloned) Node



### Fields

#### InputField
    + LeafNode, StringValue

    TYPES: [
       'text', 'search', 'hidden', 'password',
       'email', 'tel', 'url', 'number', 'range', 'color',
       'date', 'time', 'datetime-local', 'week', 'month',
    ]
    getType(): string

#### TextareaField
    + LeafNode, StringValue

#### CheckboxField
    + LeafNode, StringValue

    isChecked(): bool

#### RadioFields
    + ParentNode, StringValue

    getOptions(): string[]

#### RadioField
    + LeafNode, StringValue

    isChecked(): bool

#### SelectField
    + LeafNode, StringValue

    getOptions(): string[]

#### SelectMultipleField
    + LeafNode, ArrayValue

    getOptions(): string[]

#### SubmitField
    + LeafNode, StringValue

    isClicked(): bool


### TODO

#### UploadField
    + LeafNode, StringValue

#### UploadMultipleField
    + LeafNode, ArrayValue

