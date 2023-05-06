<?php

namespace Webmagic\Dashboard\Api\Http;

use Illuminate\Http\Request;
use Webmagic\Dashboard\Core\Content\Exceptions\FieldUnavailable;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;
use Webmagic\Dashboard\Dashboard\Components\ColumnFormGenerator;

/**
 * Class TablePageController
 * @package Webmagic\Dashboard\Api\Http
 */
class TablePageController
{
    /**
     * @param Request $request
     * @param ColumnFormGenerator $columnFormGenerator
     * @return ColumnFormGenerator
     * @throws FieldUnavailable
     * @throws NoOneFieldsWereDefined
     */
    public function getColumnList(
        Request             $request,
        ColumnFormGenerator $columnFormGenerator
    ): ColumnFormGenerator
    {
        $validated = $request->validate([
            'table_fields' => ['required', 'string'],
            'table_url' => ['required', 'url'],
            'table_identifier' => ['required', 'string'],
        ], [
            'table_identifier.required' => 'Table ID is required',
            'table_url.required' => 'The URL of the current table is required',
            'table_url.url' => 'TThe URL of the current table is invalid',
            'table_fields.required' => 'Table fields is required'
        ]);

        return $columnFormGenerator->prepare($validated);
    }
}