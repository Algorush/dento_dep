> Choose columns

The functional is implemented using the `\Webmagic\Dashboard\Components\TableGenerator` class

This functionality allows the user to select the columns he needs from the table.
The `addChooseColumns` method takes one optional url parameter to the table that will need to be rendered with the
selected columns. If the url is not specified, then the "GET" request will be sent to the url of the page. The selected
columns are stored in the cache for an unlimited period of time, for this table.
At least one column must be selected, otherwise the changes will not be applied.
For each table on the page, you can set your own selected columns.

> **WARNING**: The selected columns are linked to the URL of the table and its fields, and if the same table is located
> elsewhere, the selected columns will always be repeated

- **addChooseColumns(string $tableUrl = null)** - method called on the table with the parameter url of the table itself.

### How to use

#### Method №1

```php
(new \Webmagic\Dashboard\Components\TableGenerator())
    ->items(['id' => 1, 'name' => 'Name', 'address' => 'Address'])
    ->tableTitles(['ID', 'Name', 'Address'])
    ->showOnly(['id', 'name', 'address'])
    ->addChooseColumns();
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\TablePresentationController::chooseColumnsDocs`