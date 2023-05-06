<?php

namespace Webmagic\Dashboard\Elements\Tables\Observers\Sorting;

use Illuminate\Http\Request;

class SortingObserver implements SortingObserverContract
{
    /* @var string */
    protected $sortRequestKey = 'sort';

    /* @var string */
    protected $sortByRequestKey = 'sortBy';

    /* @var string */
    protected $sort;

    /* @var string */
    protected $sortBy;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->loadOptions($request);
    }

    /**
     * @param Request $request
     * @return void
     */
    protected function loadOptions(Request $request)
    {
        $validOptions = $request->validate([
            $this->sortRequestKey => ['nullable', 'string', 'in:asc,desc'],
            $this->sortByRequestKey => ['nullable', 'string'],
        ], $request->input());

        $this->sort = $validOptions[$this->sortRequestKey] ?? null;
        $this->sortBy = $validOptions[$this->sortByRequestKey] ?? '';
    }

    /**
     * @return bool
     */
    public function isSorted(): bool
    {
        return $this->sort && $this->sortBy;
    }

    /**
     * @return bool
     */
    public function isNotSorted(): bool
    {
        return !$this->isSorted();
    }

    /**
     * @return bool
     */
    public function isSortDesc(): bool
    {
        return $this->sort == 'desc';
    }

    /**
     * @return bool
     */
    public function isSortAsc(): bool
    {
        return $this->sort == 'asc';
    }

    /**
     * @return string|null
     */
    public function getSortDirection(): ?string
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getSortKey(): string
    {
        return $this->sortBy;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isSortedBy(string $key): bool
    {
        return $this->sortBy == $key;
    }
}