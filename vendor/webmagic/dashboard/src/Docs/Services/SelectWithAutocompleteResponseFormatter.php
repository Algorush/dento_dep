<?php

namespace Webmagic\Dashboard\Docs\Services;

class SelectWithAutocompleteResponseFormatter
{
    /** @var array */
    protected $rawResult = [];

    /**
     * @param int $id
     * @param string $title
     * @return $this
     */
    public function addResultRow(int $id, string $title): SelectWithAutocompleteResponseFormatter
    {
        $this->rawResult[] = [
            'id' => $id,
            'name' => $title,
        ];

        return $this;
    }

    /**
     * @return array[]
     */
    public function get(): array
    {
        return [
            'results' => $this->rawResult,
        ];
    }
}