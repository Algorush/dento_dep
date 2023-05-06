<?php

namespace Webmagic\Dashboard\Elements\Tables\Observers\Sorting;

interface SortingObserverContract
{
    /**
     * Check if sorting was activated
     *
     * @return bool
     */
    public function isSorted(): bool;

    /**
     * Check if sorting was not activated
     *
     * @return bool
     */
    public function isNotSorted(): bool;

    /**
     * @return bool
     */
    public function isSortDesc(): bool;

    /**
     * @return bool
     */
    public function isSortAsc(): bool;

    /**
     * Return sort direction (asc/desc/null)
     *
     * Return null if sorting is not activated
     *
     * @return string|null
     */
    public function getSortDirection(): ?string;

    /**
     * Return key name for sort
     *
     * @return string
     */
    public function getSortKey(): string;

    /**
     * Check if sorting set for given key
     *
     * @param string $key
     *
     * @return bool
     */
    public function isSortedBy(string $key): bool;
}