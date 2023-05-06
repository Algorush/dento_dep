# Sorting in tables

You can use the **SortingObserver** class to make it easier to handle sorting data.  
The class only has a dependency on *Illuminate\Http\Request* so you can use it in dependency injection.    

The class has methods like this:
* isSorted
* isNotSorted
* isSortDesc
* isSortAsc
* getSortDirection
* getSortKey
* isSortedBy

### Example  
In **Controller**:

```php
/**
* @param UserTablePageGenerator $tablePageGenerator
* @param SortingObserver $sortingObserver
* @param UserRepository $repository
* @return mixed
*/
public function index(
    UserTablePageGenerator $tablePageGenerator,
    SortingObserver $sortingObserver,
    UserRepository $repository
) {
    $items = $repository->getFiltered($sortingObserver);
    
    return $tablePageGenerator->prepareTable($items, $sortingObserver);
}
```
In **UserRepository**:
```php
/**
* @param SortingObserver $sortingObserver
* @param $perPage
* @return mixed
*/
public function getFiltered(SortingObserver $sortingObserver, $perPage = 20)
{
    $query = $this->query();

    if ($sortingObserver->isSorted()) {
        $query = $this->sort($sortingObserver, $query);
    }

    return $this->realGetMany($query, $perPage);
}

 /**
* @param SortingObserver $sortingObserver
* @param $query
* @return mixed
*/ 
protected function sort(SortingObserver $sortingObserver, $query) 
{
    if ($sortingObserver->isSortedBy('address')) {
        return $query->select('users.*')
            ->leftJoin('addresses_user', 'users.id', '=', 'addresses_user.user_id')
            ->orderByRaw('addresses_user.street asc, users.name asc');
    }
    
    return $query->orderBy($sortingObserver->getSortKey(), $sortingObserver->getSortDirection());
}
```
In **UserTablePageGenerator** can be used like this:
```php
$tablePageGenerator = (new TablePageGenerator())
    ->addTitleWithSorting('Id', 'id', $sortingObserver->isSortedBy('id') ? $sortingObserver->getSortDirection(): '')
    ->addTitleWithSorting('Name', 'name', $sortingObserver->isSortedBy('name') ? $sortingObserver->getSortDirection(): '')
    ->addTitleWithSorting('Address', 'address', $sortingObserver->isSortedBy('address') ? $sortingObserver->getSortDirection(): '')
    ->items($data);
```

As an alternative way you can get manual sorting param manually from *Illuminate\Http\Request* or request() helper

```php
$request = app(\Illuminate\Http\Request::class);
$request->get('sort');
$request->get('sortBy');
```  



