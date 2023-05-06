<?php

namespace Webmagic\Dashboard\Elements\Graphics;

use Webmagic\Dashboard\Core\ComplexElement;
use Webmagic\Dashboard\Core\Content\Exceptions\NoOneFieldsWereDefined;


/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic graphicUniqClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addGraphicUniqClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic graphicChangeViewUniqClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addGraphicChangeViewUniqClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic graphicFormClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addGraphicFormClass($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic dataUrl($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addDataUrl($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic isChangeViewAvailable(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addIsChangeViewAvailable(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic type($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addType($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic isLegendDisplay(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addIsLegendDisplay(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic legendPosition($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addLegendPosition($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic pointRadius($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addPointRadius($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic lineTension($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addLineTension($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic showXAxes(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addShowXAxes(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic showYAxes(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\Graphics\Graphic addShowYAxes(bool $valueOrConfig)
 *
 ********************************************************************************************************************/

class Graphic extends ComplexElement
{
    protected $view = 'dashboard::elements.graphics.graphic';

    protected $available_fields = [
        'graphic_uniq_class',
        'graphic_change_view_uniq_class',
        'graphic_form_class',
        'data_url',
        'title' => [
            'type' => 'string',
            'default' => 'Empty graphic'
        ],
        'is_change_view_available' => [
            'type' => 'bool',
            'default' => false
        ],
        'type' => [
            'default' => 'line',
            'acceptable_values' => ['bar', 'line']
        ],
        'is_legend_display' => [
            'type' => 'bool',
            'default' => false
        ],
        'legend_position' => [
            'default' => 'bottom',
            'acceptable_values' => ['bottom','top']
        ],
        'point_radius' => [
            'default' => 0
        ],
        'line_tension' => [
            'default' => 0.3
        ],
        'show_x_axes' => [
            'type' => 'bool',
            'default' => false
        ],
        'show_y_axes' => [
            'type' => 'bool',
            'default' => false
        ],
        'labels' => [
            'type' => 'array',
            'default' => [],
        ],
        'data_set' => [
            'type' => 'array',
            'default' => [],
        ],
    ];

    protected $default_field = 'data_url';

    /** @var array  */
    protected $availableColors = [
        '#838B8B',
        '#7A8B8B',
        '#C1CDCD',
        '#668B8B',
        '#B4CDCD',
        '#2F4F4F',
        '#2F4F4F',
        '#5F9F9F',
        '#C0D9D9',
        '#528B8B',
        '#E0EEEE',
        '#96CDCD',
        '#388E8E',
        '#79CDCD',
        '#D1EEEE',
        '#8FD8D8',
        '#66CCCC',
        '#ADEAEA',
        '#70DBDB',
        '#AEEEEE',
        '#AFEEEE',
        '#8DEEEE',
        '#37FDFC',
        '#008080',
        '#008B8B',
        '#00CDCD',
        '#00EEEE',
        '#00FFFF',
        '#00FFFF',
        '#97FFFF',
        '#BBFFFF',
        '#E0FFFF',
        '#F0FFFF',
        '#00CED1',
        '#5F9EA0',
        '#00868B',
        '#00C5CD',
        '#00E5EE',
        '#00F5FF',
        '#67E6EC',
        '#4A777A',
        '#05EDFF',
        '#53868B',
        '#73B1B7',
        '#05E9FF',
        '#7AC5CD',
        '#8EE5EE',
        '#05B8CC',
        '#98F5FF',
        '#B0E0E6',
        '#C1F0F6',
        '#39B7CD',
        '#65909A',
        '#0EBFE9',
        '#C3E4ED',
        '#68838B',
        '#63D1F4',
        '#9AC0CD',
        '#50A6C2',
        '#ADD8E6',
        '#B2DFEE',
        '#00688B',
        '#009ACD',
        '#0099CC',
        '#00B2EE',
        '#00BFFF',
        '#BFEFFF',
        '#33A1C9',
        '#507786',
        '#87CEEB',
        '#38B0DE',
        '#0BB5FF',
        '#42C0FB',
        '#6996AD',
        '#539DC2',
        '#236B8E',
        '#3299CC',
        '#0198E1',
        '#33A1DE',
        '#607B8B',
        '#35586C',
        '#5D92B1',
        '#8DB6CD',
        '#325C74',
        '#A4D3EE',
        '#82CFFD',
        '#67C8FF',
        '#B0E2FF',
        '#87CEFA',
        '#6CA6CD',
        '#4A708B',
        '#9BC4E2',
        '#7EC0EE',
        '#87CEFF',
        '#517693',
        '#5D7B93',
        '#42647F',
        '#4682B4',
        '#4F94CD',
        '#5CACEE',
        '#63B8FF',
        '#525C65',
        '#36648B',
        '#62B1F6',
        '#74BBFB',
        '#F0F8FF',
        '#4E78A0',
        '#0D4F8B',
        '#708090',
        '#708090',
        '#778899',
        '#778899',
        '#6183A6',
        '#9FB6CD',
        '#7D9EC0',
        '#104E8B',
        '#1874CD',
        '#1C86EE',
        '#60AFFE',
        '#007FFF',
        '#1E90FF',
        '#6C7B8B',
        '#B7C3D0',
        '#739AC5',
        '#75A1D0',
        '#B9D3EE',
        '#499DF5',
        '#C6E2FF',
        '#3B6AA0',
        '#7AA9DD',
        '#0276FD',
        '#003F87',
        '#6E7B8B',
        '#506987',
        '#A2B5CD',
        '#4372AA',
        '#26466D',
        '#1D7CF2',
        '#687C97',
        '#344152',
        '#50729F',
        '#4973AB',
        '#B0C4DE',
        '#3063A5',
        '#BCD2EE',
        '#7EB6FF',
        '#CAE1FF',
        '#4D71A3',
        '#2B4F81',
        '#4981CE',
        '#88ACE0',
        '#5993E5',
        '#3A66A7',
        '#3579DC',
        '#5190ED',
        '#42526C',
        '#4D6FAC',
        '#2E5090',
        '#2C5197',
        '#6495ED',
        '#6D9BF1',
        '#5B90F6',
        '#1464F4',
        '#3A5894',
        '#7093DB',
        '#1B3F8B',
        '#5971AD',
        '#0147FA',
        '#3D59AB',
        '#27408B',
        '#3A5FCD',
        '#4169E1',
        '#436EEE',
        '#003EFF',
        '#4876FF',
        '#A9ACB6',
        '#22316C',
        '#162252',
        '#3B4990',
        '#283A90',
        '#6F7285',
        '#838EDE',
        '#E6E8FA',
        '#7D7F94',
        '#2E37FE',
        '#2F2F4F',
        '#42426F',
        '#8F8FBC',
        '#5959AB',
        '#7171C6',
        '#D9D9F3',
        '#23238E',
        '#3232CC',
        '#3232CD',
        '#191970',
        '#E6E6FA',
        '#000033',
        '#000080',
        '#00008B',
        '#00009C',
        '#0000CD',
        '#0000EE',
        '#0000FF',
        '#3333FF',
        '#4D4DFF',
        '#6666FF',
        '#AAAAFF',
        '#CCCCFF',
        '#F8F8FF',
        '#5B59BA',
        '#120A8F',
        '#302B54',
        '#483D8B',
        '#473C8B',
        '#3B3178',
        '#6A5ACD',
        '#6959CD',
        '#7A67EE',
        '#836FFF',
        '#8470FF',
        '#7B68EE',
        '#3300FF',
        '#5D478B',
        '#9F79EE',
        '#8968CD',
        '#9370DB',
        '#AB82FF',
        '#6600FF',
        '#380474',
    ];

    /**
     * Graphic constructor.
     *
     * @param null $content
     *
     * @throws NoOneFieldsWereDefined
     */
    public function __construct($content = null)
    {
        parent::__construct($content);

        if(empty($this->graphic_uniq_class)){
            $this->graphic_uniq_class = $this->prepareClass('js_graphic-');
        }

        if(empty($this->graphic_change_view_uniq_class)){
            $this->graphic_change_view_uniq_class = $this->prepareClass('js_graphic-change-');
        }
    }

    /**
     * Prepare uniq ID
     *
     * @return string
     */
    protected function prepareClass(string $prefix = ''): string
    {
        return $prefix.uniqid();
    }

    /**
     * @return self
     */
    public function labels(string ... $labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * @param string $label
     * @param array $points
     * @param string|null $backgroundColor
     * @param string|null $borderColor
     * @return self
     */
    public function addDataSet(string $label, array $points, string $backgroundColor = null, string $borderColor = null)
    {
        if (empty($this->data_set)) {
            $this->data_set = [];
        }

        $this->data_set[] = [
            'backgroundColor' => $backgroundColor ?? $this->getRandomColor(),
            'borderColor' => $borderColor ?? $this->getRandomColor(),
            'label' => $label,
            'data' =>  $points,
        ];

        return $this;
    }

    /**
     * @return string
     */
    protected function getRandomColor(): string
    {
        $randomKey = array_rand($this->availableColors);

        return $this->availableColors[$randomKey];
    }

    /**
     * @return string
     */
    public function jsonData(): string
    {
        $preparedData = [];
        $preparedData['labels'] = $this->labels;
        $preparedData['datasets'] = $this->data_set;

        return json_encode($preparedData);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function fillWithDummyData(string $title): self
    {
        $this
            ->title($title)
            ->labels('January', 'February', 'March', 'April', 'May', 'June', 'July')
            ->addDataSet('Digital Goods', [28, 48, 40, 19, 86, 27, 90], '#3c8dbc', '#3c8dbc')
            ->addDataSet('Electronics', [65, 59, 80, 81, 56, 55, 40], '#d2d6de', '#d2d6de');

        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->data_set = json_encode($this->data_set);
        $this->labels = json_encode($this->labels);

        return parent::render();
    }
}
