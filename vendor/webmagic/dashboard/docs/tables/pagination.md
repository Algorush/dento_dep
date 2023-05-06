# Pagination

Provides the ability to display part of the data in table and not all at once

## withPagination function

Pros:
- User can go to any page of the list
- User is shown the total number of rows in the list

Cons:
- Speed (compared to the following methods)

To do this, you need to use the `withPagination()` function when generating the data table

```php
...
$tablePageGenerator = (new TablePageGenerator())
    ->items($data)
    ->withPagination(...)
;
...
```

The function takes 6 parameters, 4 of which are optional:
```php
AbstractPaginator $paginator,
string $action,
bool $stepsChange = false,
array $availableSteps = [25, 50, 100, 200],
string $paginationStepParam = 'per_page',
string $stepUpdateAction = null
```

``$paginator`` - an object that wraps elements selected from DB that should be displayed on single page  
``$action`` - the link for request will be sent when paginate content  
``$stepsChange`` - shows or hides the dropdown list with possible values of the number for display elements on one page  
``$availableSteps`` - an array of values to be displayed in the dropdown list of the number of items possible to display on one page  
``$paginationStepParam`` - name of dropdown  
``$stepUpdateAction`` - the link for request will be sent when user change items per page

## withSimplePagination function

Pros:
- Speed. Works faster than withPagination. due to the fact that it does not display to the user

Cons:
- It is not known how many lines are in the list
- No option to go to any page, only next or previous

Use also as withPagination but this function has only 2 parameters:
AbstractPaginator ``$paginator`` - an object that wraps elements selected from DB that should be displayed on single page  
string ``$action`` - the link for request will be sent when paginate content

## Examples  

*Common for all examples:*  
Use dependence injection ``DashboardSettingsManager $dashboardSettingsManager``.  
Function ``getPaginationStep`` use for get and write to session pagination step

***[Base using](/dashboard/tech/tables/pagination/base-using)***

*Code:*  
```php
$perPage = $dashboardSettingsManager->getPaginationStep();

$total = 500;
$page = request()->input('page', 1);
$data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
$paginator = new LengthAwarePaginator($data, $total, $perPage);

$tableGenerator = (new TablePageGenerator())
    ->title('Base using pagination')
    ->tableTitles('#', 'ID', 'Name','Address')
    ->items($data)
    ->withPagination($paginator, request()->url());

if (request()->ajax()) {
    return $tableGenerator->getTable();
}

        return $tableGenerator;
```

*Description:*  
First argument in function `withPagination` is object of interface ``AbstractPaginator`` contains elements for displaying on current page.  
Second argument it's link for switch next/previous page.  
In real task you most likely will have Repository class with paginate function and second argument of it have count elements per page.  
And for pagination without dropdown you don't need to use ``DashboardSettingsManager``.  

---

***[Base using with dropdown](/dashboard/tech/tables/pagination/base-using-with-dropdown)***

*Code:*  
```php
$perPage = $dashboardSettingsManager->getPaginationStep();

$total = 500;
$page = request()->input('page', 1);
$data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
$paginator = new LengthAwarePaginator($data, $total, $perPage);

$tableGenerator = (new TablePageGenerator())
    ->title('Base using pagination with dropdown')
    ->tableTitles('#', 'ID', 'Name','Address')
    ->items($data)
    ->withPagination($paginator, request()->url(), true);

if (request()->ajax()) {
    return $tableGenerator->getTable();
}

return $tableGenerator;
```

*Description:*  
It's almost the same code as example above.  
Different in presence third argument in ``withPagination`` function.  
It means show dropdown menu with default values per page(25, 50, 100, 200).  

---

[Custom per page values](/dashboard/tech/tables/pagination/with-custom-per-page)

*Code:*  
```php
$perPage = $dashboardSettingsManager->getPaginationStep(null, 'per_page', 30);

$total = 500;
$page = request()->input('page', 1);
$data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
$paginator = new LengthAwarePaginator($data, $total, $perPage);

$tableGenerator = (new TablePageGenerator())
    ->title('Pagination with custom per page dropdown')
    ->tableTitles('#', 'ID', 'Name','Address')
    ->items($data)
    ->withPagination($paginator, request()->url(), true, [30, 40, 50, 60]);

if (request()->ajax()) {
    return $tableGenerator->getTable();
}

return $tableGenerator;
```

*Description:*  
It code have a bit more changes compare with example above.  
In this example we have fourth argument in ``withPagination`` function with value [30, 40, 50, 60].  
Also we differently call function getPaginationStep.  
``$perPage = $dashboardSettingsManager->getPaginationStep(null, 'per_page', 30);``  
first argument is ``null`` because we want to use identifier by default (current page without parameters).  
second is name of dropdown list for change items per page.  
third is count elements by default when first time visit page.  

If you will work with one page and change elements per page, you maybe will see additional item in dropdown element.    
It contains in session so that don't forget clear cookie if you want to simulate first visit page.  

---

[Two tables at single page with filters](/dashboard/tech/tables/pagination/with-two-tables)


Code:
```php
// main page
public function paginationWithTwoTablesAndFilters()
{
    $firstTable = $this->paginationFirstTableAndFilter(new DashboardSettingsManager());
    $secondTable = $this->paginationSecondTableAndFilter(new DashboardSettingsManager());

    $dashboard = (new Dashboard())
        ->title('Pages')
        ->contentHeader('<h3>Two tables and filters</h3>');

    $dashboard->addContent('<h4>First table</h4>');
    $dashboard->addContent($firstTable->getBox());
    $dashboard->addContent('<br>');
    $dashboard->addContent('<h4>Second table</h4>');
    $dashboard->addContent($secondTable->getBox());

    return $dashboard;
}

// first table
public function paginationFirstTableAndFilter(DashboardSettingsManager $dashboardSettingsManager)
{
    $paginationStepParam = 'per_page_first_table';
    $perPageItems = $dashboardSettingsManager->getPaginationStep('firstPage', $paginationStepParam, 3);

    $address = request()->input('address');
    $pageNum = request()->input('page', 1);
    $filteredDataCount = count($this->filteredData($address));
    $dataPerPage = $this->dataPerPage($perPageItems, $pageNum, $address);
    $paginator = new LengthAwarePaginator($dataPerPage, $filteredDataCount, $perPageItems, $pageNum);

    $tableGenerator = (new TablePageGenerator())
        ->tableTitles('#', 'ID', 'Name','Address')
        ->items($dataPerPage)
        ->withPagination(
            $paginator,
            route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter'),
            true,
            [1, 2, 3, 4],
            $paginationStepParam
        )
    ;

    $tableGenerator
        ->addFiltering()
        ->action(route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter'))
        ->textInput('address', $address, 'Address', false, ['placeholder' => '%like%'])
        ->submitButton('Search')
    ;

    if (request()->ajax()) {
        return $tableGenerator->getTable();
    }

    return $tableGenerator;
}

// second table
public function paginationSecondTableAndFilter(DashboardSettingsManager $dashboardSettingsManager)
{
    $paginationStepParam = 'per_page_second_table';
    $perPageItems = $dashboardSettingsManager->getPaginationStep('secondPage', $paginationStepParam, 1);

    $address = request()->input('address');
    $pageNum = request()->input('page', 1);
    $filteredDataCount = count($this->filteredData($address));
    $dataPerPage = $this->dataPerPage($perPageItems, $pageNum, $address);
    $paginator = new LengthAwarePaginator($dataPerPage, $filteredDataCount, $perPageItems, $pageNum);

    $tableGenerator = (new TablePageGenerator())
        ->tableTitles('#', 'ID', 'Name','Address')
        ->items($dataPerPage)
        ->withPagination(
            $paginator,
            route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter'),
            true,
            [1, 2, 3, 4],
            $paginationStepParam
        )
    ;

    $tableGenerator
        ->addFiltering()
        ->action(route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter'))
        ->textInput('address', $address, 'Address', false, ['placeholder' => '%like%'])
        ->submitButton('Search')
    ;

    if (request()->ajax()) {
        return $tableGenerator->getTable();
    }

    return $tableGenerator;
}
```
*Description:*  
In this example displayed two tables with personal pagination and filtering.  
What you should pay attention to  
* step parameter for changing items count per page (``$paginationStepParam``)
* explicitly given identifier for storing in session count per page (call ``getPaginationStep`` function)
* route for paginate item is NOT same like current url
* route for filtering  
