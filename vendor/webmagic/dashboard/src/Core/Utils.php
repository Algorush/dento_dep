<?php


namespace Webmagic\Dashboard\Core;


class Utils
{
    /**
     * Appends given parameters to URL
     *
     * @param string $url
     * @param array  $params
     *
     * @return string
     */
    static public function appendsParamsToURL(string $url, array $params): string
    {
        // Need to generate query first, because some of params can has no values
        $query = http_build_query($params);
        if ($query == '') {
            return $url;
        }

        // Add to existing params if needed
        if (strpos($url, '?') !== false) {
            return "$url&$query";
        }

        return "$url?$query";
    }

    /**
     * Appends all parameters from request to URL
     *
     * @param string $url
     * @param array  $excludedKeys
     *
     * @return string
     */
    static public function appendsAllRequestToURL(string $url, array $excludedKeys = []): string
    {
        return self::appendsParamsToURL($url, request()->except($excludedKeys));
    }

    /**
     * Generate table id key for storage
     *
     * @param array $tableFields
     * @param string $url
     * @return string
     */
    static public function generateTableIdKey(array $tableFields, string $url): string
    {
        $tableId = implode('', $tableFields);
        return 'user:' . (auth()->id() ?? session()->getId()) . ':table_id:' . $tableId . ':url:' . strtok($url, '?');
    }
}
