<?php


namespace Webmagic\Dashboard\Docs\Http;

use Faker\Generator;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Webmagic\Dashboard\Components\TableGenerator;
use Webmagic\Dashboard\Components\TablePageGenerator;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Core\Utils;
use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Elements\Tables\Observers\Sorting\SortingObserver;
use Webmagic\Dashboard\Elements\Tables\Table;
use Webmagic\Dashboard\Elements\WrapperDiv;
use Webmagic\Dashboard\Pages\BasePage;
use Webmagic\Dashboard\Elements\Titles\H4Title;
use Webmagic\Dashboard\Services\DashboardSettingsManager;

class TablePresentationController
{
    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function manualSortingDocs(): Dashboard
    {
        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/tables/manual-sorting.md');

        $tablePageGenerator = (new TablePageGenerator())
            ->tableTitles(['ID', 'Name', 'Address'])
            ->showOnly('id', 'name', 'address')
            // Add items
            ->items($this->prepareFakeData())
            // Manual sorting activation
            ->manualSorting(
                url()->current(),
                function ($item) {
                    return $item['id'];
                },
                'GET'
            );

        $dashboard->page()
            ->setPageTitle('Manual sorting in tables')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($tablePageGenerator->getTable());

        return $dashboard;
    }

    /**
     * Prepare fake data
     *
     * @return array
     */
    protected function prepareFakeData()
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'id'      => $faker->numberBetween(0, 100),
                'name'    => $faker->name,
                'address' => $faker->address,
            ];
        }

        return $data;
    }

    /**
     * Prepare fake data for paginator
     *
     * @return array
     */
    protected function prepareFakeDataForPaginator($countElements = 10, $page = 0, $totalElements = 0)
    {
        if ($countElements > $totalElements) {
            $countElements = $totalElements;
        }

        $firstItemNum = $page * $countElements - $countElements;

        if ($countElements * $page > $totalElements) {
            $countElements = $countElements * $page - (($countElements * ($page - 1)) + ($countElements * $page - $totalElements));
        }

        /** @var Generator $faker */
        $faker = app(Generator::class);
        $data = [];
        for ($i = 0; $i < $countElements; $i++) {
            $data[] = [
                '#'       => $firstItemNum + $i + 1,
                'id'      => $faker->numberBetween(0, 100),
                'name'    => $faker->name,
                'address' => $faker->address,
            ];
        }

        return $data;
    }

    /**
     * @param null $addressLike
     * @return array|Collection
     */
    private function filteredData($addressLike = null)
    {
        $preparedData = $this->getPreparedDataForPagination();

        if ($addressLike) {
            $preparedData = $this->findInData($addressLike, $preparedData);
        }

        return is_array($preparedData) ? $preparedData : $preparedData->toArray();
    }

    /**
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws BindingResolutionException
     */
    public function pagination(): Dashboard
    {
        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/tables/pagination.md');

        $dashboard->page()
            ->setPageTitle('Pagination')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example (Base using)')->content($this->paginationBaseUsing(true)->render())
            ->parent()->addElement()->tab()->title('Example (Base using with dropdown)')->content($this->paginationBaseUsingWithDropdown(true)->render())
            ->parent()->addElement()->tab()->title('Example (Custom per page values)')->content($this->paginationWithCustomPerPage(true)->render())
            ->parent()->addElement()->tab()->title('Example (Two tables and filters)')->content($this->paginationWithTwoTablesAndFilters(true)->render())
            ->parent()->addElement()->tab()->title('Example (Simple pagination)')->content($this->paginationWithTwoTablesAndFilters(true, 'simplePagination')->render())
        ;

        return $dashboard;
    }

    /**
     * @param bool $getTable
     * @return TablePageGenerator|Table
     * @throws NoOneFieldsWereDefined
     */
    public function paginationBaseUsing(bool $getTable = false)
    {
        $perPage = (new DashboardSettingsManager())->getPaginationStep();

        $total = 500;
        $page = request()->input('page', 1);
        $data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
        $paginator = new LengthAwarePaginator($data, $total, $perPage);

        $tableGenerator = (new TablePageGenerator())
            ->title('Base using pagination')
            ->tableTitles('#', 'ID', 'Name', 'Address')
            ->items($data)
            ->withPagination($paginator, route('dashboard.docs.presentation.tables.paginationBaseUsing'));

        if (request()->ajax() || $getTable) {
            return $tableGenerator->getTable();
        }

        return $tableGenerator;
    }

    /**
     * @param bool $getTable
     * @return TablePageGenerator|Table
     * @throws NoOneFieldsWereDefined
     */
    public function paginationBaseUsingWithDropdown(bool $getTable = false)
    {
        $perPage = (new DashboardSettingsManager())->getPaginationStep();

        $total = 500;
        $page = request()->input('page', 1);
        $data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
        $paginator = new LengthAwarePaginator($data, $total, $perPage);

        $tableGenerator = (new TablePageGenerator())
            ->title('Base using pagination with dropdown')
            ->tableTitles('#', 'ID', 'Name', 'Address')
            ->items($data)
            ->withPagination(
                $paginator,
                route('dashboard.docs.presentation.tables.paginationBaseUsingWithDropdown'),
                true
            );

        if (request()->ajax() || $getTable) {
            return $tableGenerator->getTable();
        }

        return $tableGenerator;
    }

    /**
     * @param bool $getTable
     * @return TablePageGenerator|Table
     * @throws NoOneFieldsWereDefined
     */
    public function paginationWithCustomPerPage(bool $getTable = false)
    {
        $perPage = (new DashboardSettingsManager())->getPaginationStep(null, 'per_page', 30);

        $total = 500;
        $page = request()->input('page', 1);
        $data = $this->prepareFakeDataForPaginator($perPage, $page, $total);
        $paginator = new LengthAwarePaginator($data, $total, $perPage);

        $tableGenerator = (new TablePageGenerator())
            ->title('Pagination with custom per page dropdown')
            ->tableTitles('#', 'ID', 'Name', 'Address')
            ->items($data)
            ->withPagination(
                $paginator,
                route('dashboard.docs.presentation.tables.paginationWithCustomPerPage'),
                true,
                [30, 40, 50, 60]
            );

        if (request()->ajax() || $getTable) {
            return $tableGenerator->getTable();
        }

        return $tableGenerator;
    }


    /**
     * @param bool $getTables
     * @param string $paginationType
     * @return WrapperDiv|BasePage
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function paginationWithTwoTablesAndFilters(bool $getTables = false, $paginationType = 'pagination')
    {
        $firstTable = $this->paginationFirstTableAndFilter(new DashboardSettingsManager(), $getTables, $paginationType);
        $secondTable = $this->paginationSecondTableAndFilter(new DashboardSettingsManager(), $getTables, $paginationType);

        $dashboard = (new Dashboard())
            ->title('Pages')
            ->contentHeader('<h3>Two tables and filters</h3>');

        if ($getTables) {
            $dashboard = new WrapperDiv();
        }

        $dashboard->addContent('<h4>First table</h4>');
        $dashboard->addContent($getTables ? $firstTable->render() : $firstTable->getBox());
        $dashboard->addContent('<br>');
        $dashboard->addContent('<h4>Second table</h4>');
        $dashboard->addContent($getTables ? $secondTable->render() : $secondTable->getBox());

        return $dashboard;
    }

    /**
     * @param $perPageItems
     * @param $pageNum
     * @param $address
     * @return array
     */
    private function dataPerPage($perPageItems, $pageNum, $address)
    {
        $filteredData = $this->filteredData($address);
        $firstItemNum = $pageNum * $perPageItems - $perPageItems;

        $data = [];
        for ($i = $firstItemNum, $len = $i + $perPageItems; $i < $len; $i++) {
            if(!isset($filteredData[$i])) {
                continue;
            }

            $data[] = array_prepend($filteredData[$i], $i + 1, '#');
        }

        return $data;
    }

    /**
     * @param DashboardSettingsManager $dashboardSettingsManager
     * @param bool $getTable
     * @param null $paginationType
     * @return TablePageGenerator|Table
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function paginationFirstTableAndFilter(
        DashboardSettingsManager $dashboardSettingsManager,
        bool $getTable = false,
        $paginationType = null
    ) {
        $paginationStepParam = 'per_page_first_table';
        $perPageItems = $dashboardSettingsManager->getPaginationStep('firstPage', $paginationStepParam, 3);

        $address = request()->input('address');
        $pageNum = request()->input('page', 1);
        $filteredDataCount = count($this->filteredData($address));
        $dataPerPage = $this->dataPerPage($perPageItems, $pageNum, $address);
        $paginator = new LengthAwarePaginator($dataPerPage, $filteredDataCount, $perPageItems, $pageNum);

        $tableGenerator = (new TablePageGenerator())
            ->tableTitles('#', 'ID', 'Name', 'Address')
            ->items($dataPerPage);

        $tableRoute = route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter');

        $paginationType = $paginationType ?? request('pagination_type');

        $filterRoute = route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter');

        if ($paginationType == 'pagination') {
            if (!request()->has('pagination_type')) {
                $tableRoute = Utils::appendsParamsToURL($tableRoute, ['pagination_type' => 'pagination']);
            }
            $tableGenerator->withPagination(
                $paginator,
                $tableRoute,
                true,
                [1, 2, 3, 4],
                $paginationStepParam
            );

            $filterRoute = route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter', ['pagination_type' => 'pagination']);
        } else if ($paginationType == 'simplePagination') {
            if (!request()->has('pagination_type')) {
                $tableRoute = Utils::appendsParamsToURL($tableRoute, ['pagination_type' => 'simplePagination']);
            }
            $tableGenerator->withSimplePagination($paginator, $tableRoute);
            $filterRoute = route('dashboard.docs.presentation.tables.paginationFirstTableAndFilter', ['pagination_type' => 'simplePagination']);
        }

        $tableGenerator
            ->addFiltering()
            ->action($filterRoute)
            ->textInput('address', $address, 'Address', false, ['placeholder' => '%like%'])
            ->submitButton('Search');

        if (request()->ajax() || $getTable) {
            return $tableGenerator->getTable();
        }

        return $tableGenerator;
    }

    /**
     * @param DashboardSettingsManager $dashboardSettingsManager
     * @param bool $getTable
     * @param string $paginationType
     * @return TablePageGenerator|Table
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function paginationSecondTableAndFilter(
        DashboardSettingsManager $dashboardSettingsManager,
        bool $getTable = false,
        $paginationType = null
    ) {
        $paginationStepParam = 'per_page_second_table';
        $perPageItems = $dashboardSettingsManager->getPaginationStep('secondPage', $paginationStepParam, 1);

        $address = request()->input('address');
        $pageNum = request()->input('page', 1);
        $filteredDataCount = count($this->filteredData($address));
        $dataPerPage = $this->dataPerPage($perPageItems, $pageNum, $address);
        $paginator = new LengthAwarePaginator($dataPerPage, $filteredDataCount, $perPageItems, $pageNum);

        $tableGenerator = (new TablePageGenerator())
            ->tableTitles('#', 'ID', 'Name', 'Address')
            ->items($dataPerPage);

        $tableRoute = route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter');

        $paginationType = $paginationType ?? request('pagination_type');

        $filterRoute = route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter');

        if ($paginationType == 'pagination') {
            if (!request()->has('pagination_type')) {
                $tableRoute = Utils::appendsParamsToURL($tableRoute, ['pagination_type' => 'pagination']);
            }
            $tableGenerator->withPagination(
                $paginator,
                $tableRoute,
                true,
                [1, 2, 3, 4],
                $paginationStepParam
            );

            $filterRoute = route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter', ['pagination_type' => 'pagination']);
        } else if ($paginationType == 'simplePagination') {
            if (!request()->has('pagination_type')) {
                $tableRoute = Utils::appendsParamsToURL($tableRoute, ['pagination_type' => 'simplePagination']);
            }
            $tableGenerator->withSimplePagination($paginator, $tableRoute);
            $filterRoute = route('dashboard.docs.presentation.tables.paginationSecondTableAndFilter', ['pagination_type' => 'simplePagination']);
        }

        $tableGenerator
            ->addFiltering()
            ->action($filterRoute)
            ->textInput('address', $address, 'Address', false, ['placeholder' => '%like%'])
            ->submitButton('Search');

        if (request()->ajax() || $getTable) {
            return $tableGenerator->getTable();
        }

        return $tableGenerator;
    }

    /**
     * @return Collection
     */
    private function getPreparedDataForPagination(): Collection
    {
        return collect([
            ['id' => '21321', 'name' => 'Prof. Antonina Schultz V', 'address' => '189 Mann Courts Suite 434 Joanyport, KS 58233'],
            ['id' => '321323', 'name' => 'Krystel Dooley', 'address' => '8041 Hillary Centers Suite 426 Smithburgh, WY 36129-9160'],
            ['id' => '546456', 'name' => 'Mr. Terry Rohan IV', 'address' => '75247 McGlynn Ramp Apt. 465 Domenicafurt, AL 36588-9145'],
            ['id' => '54', 'name' => 'Lily Miller', 'address' => '1197 Schiller Common Apt. 687 South Lea, OH 32543-9551'],
            ['id' => '22', 'name' => 'Gerson Stiedemann Sr.', 'address' => '4880 Weber Causeway West Kaelyn, NC 33083-6268  '],
            ['id' => '74', 'name' => 'Karson Ullrich III', 'address' => '90084 Jaycee Islands West Pink, KY 03718'],
            ['id' => '720', 'name' => 'Andres Bernier', 'address' => '252 Zoila Run Apt. 754 West Neilside, NV 71129'],
            ['id' => '4982', 'name' => 'Ethan Thompson MD', 'address' => '973 Shyann Light Helgamouth, OR 14265-2237'],
            ['id' => '4358', 'name' => 'Jalen Walter', 'address' => '165 Considine Squares Suite 372 North Boyd, OR 24878'],
            ['id' => '222', 'name' => 'Kylee Cummings PhD', 'address' => '13094 Edna Union South Mercedes, CT 99386'],
            ['id' => '797', 'name' => 'Katelyn McDermott', 'address' => '884 Bradtke Neck Apt. 780 Port Estelleside, NE 24315'],
            ['id' => '3845', 'name' => 'Karli Jacobson', 'address' => '3138 Willms Orchard Prohaskachester, RI 79145'],
            ['id' => '95564', 'name' => 'Ofelia Schuppe', 'address' => '902 Renner Villages Torpfurt, MI 22370'],
            ['id' => '12447', 'name' => 'Catharine Beatty', 'address' => '1793 Elizabeth Glens Lake Jacinthe, ND 73538'],
            ['id' => '57566', 'name' => 'Ernesto Smitham III', 'address' => '75389 Yundt Skyway Apt. 626 North Elmer, TN 88321'],

        ]);
    }

    /**
     * @param $search
     * @param array $data
     * @return array
     */
    private function findInData(string $search, Collection $data): array
    {
        $data = $data->filter(function ($item) use ($search) {
            if(strpos($item['address'], $search) !== false) {
                return $item;
            }
        });

        return array_values($data->toArray());
    }

    /**
     * @param SortingObserver $sortingObserver
     * @return Dashboard|Table
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function sortingDocs(SortingObserver $sortingObserver)
    {
        $data = $this->prepareFakeData();
        $data = $this->sortFakeData($data, $sortingObserver);

        $tablePageGenerator = (new TablePageGenerator())
            ->addTitleWithSorting('Id', 'id', $sortingObserver->isSortedBy('id') ? $sortingObserver->getSortDirection() : '')
            ->addTitleWithSorting('Name', 'name', $sortingObserver->isSortedBy('name') ? $sortingObserver->getSortDirection() : '')
            ->addTitleWithSorting('Address', 'address', $sortingObserver->isSortedBy('address') ? $sortingObserver->getSortDirection() : '')
            ->items($data);

        if (request()->ajax()) {
            return $tablePageGenerator->getTable();
        }

        $dashboard = new Dashboard();
        $docs = view()->file(__DIR__ . '/../../../docs/tables/sorting.md');

        $dashboard->page()
            ->setPageTitle('Sorting in tables')
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($tablePageGenerator->getTable());

        return $dashboard;
    }

    /**
     * @param $data
     * @param SortingObserver $sortingObserver
     * @return mixed
     */
    protected function sortFakeData($data, SortingObserver $sortingObserver)
    {
        if ($sortingObserver->isNotSorted()) {
            return $data;
        }

        $names = array();
        $sortBy = $sortingObserver->getSortKey();
        foreach ($data as $key => $val) {
            $names[$key] = $val[$sortBy];
        }
        array_multisort($names, $sortingObserver->isSortAsc() ? SORT_ASC : SORT_DESC, $data);

        return $data;
    }

    /**
     * @return Dashboard|Table
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function chooseColumnsDocs()
    {
        $docs = view()->file(__DIR__ . '/../../../docs/tables/choose-columns.md');

        $table = (new TableGenerator())
            ->items($this->prepareFakeData())
            ->tableTitles(['ID', 'Name', 'Address'])
            ->showOnly(['id', 'name', 'address'])
            ->addChooseColumns();

        if (request()->ajax()) {
            return $table->getTable();
        }

        $examples = new WrapperDiv([
            new H4Title('by TableGenerator'),
            $table
        ]);

        return $this->dashboardPresentation($docs, $examples, 'Choose columns');
    }

    /**
     * @param View $docs
     * @param $example
     * @param string $title
     * @return Dashboard
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    protected function dashboardPresentation(View $docs, $example, string $title): Dashboard
    {
        $dashboard = new Dashboard();
        $dashboard->page()
            ->setPageTitle($title)
            ->addElement()->tabs()->addElement()->tab()->title('Description')->content($docs)->active()
            ->parent()->addElement()->tab()->title('Example')->content($example);

        return $dashboard;
    }
}
