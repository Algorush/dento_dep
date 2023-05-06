<?php

namespace Webmagic\Dashboard\Core;

class DataExtractor
{
    /** @var  */
    protected $dataSource;

    /**
     * @param $dataSource
     */
    public function __construct($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @param string $key
     * @param string $default
     * @return array|mixed
     */
    public function get(string $key, $default = '')
    {
        if(is_array($this->dataSource) || $this->dataSource instanceof ArrayAccess){
            return data_get($this->dataSource, $key, $default);
        }

        return $this->dataSource;
    }
}