<?php

namespace Webmagic\Dashboard\Elements\ProgressBar;

use Webmagic\Dashboard\Core\ComplexElement;


/*********************************************************************************************************************
 * Generated meta methods
 *********************************************************************************************************************
 *
 * @method \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar title($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar progress($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar striped(bool $valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar thickness($valueOrConfig)
 * @method \Webmagic\Dashboard\Elements\ProgressBar\ProgressBar color($valueOrConfig)
 *
 ********************************************************************************************************************/

class ProgressBar extends ComplexElement
{
    /** @var  string Component view name */
    protected $view = 'dashboard::elements.progressbar.progressbar';

    /** @var  array Sections available in page */
    protected $available_fields = [
        'title' => [
            'type' => 'string',
            'default' => '',
        ],
        'progress' => [
            'default' => 0,
        ],
        'striped' => [
            'type' => 'bool',
            'default' => false,
        ],
        'thickness' => [
            'type' => 'string',
            'default' => '',
        ],
        'color' => [
            'type' => 'string',
            'default' => 'primary',
        ]
    ];

    /** @var  string Default section for current component */
    protected $default_field = 'progress';

    /**
     * @return self
     */
    public function setThicknessNormal(): self
    {
        $this->thickness = '';

        return $this;
    }

    /**
     * @return self
     */
    public function setThicknessSmall(): self
    {
        $this->thickness = 'progress-sm';

        return $this;
    }

    /**
     * @return self
     */
    public function setThicknessMini(): self
    {
        $this->thickness = 'progress-xs';

        return $this;
    }

    /**
     * @return self
     */
    public function setThicknessMicro(): self
    {
        $this->thickness = 'progress-xxs';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorPrimary(): self
    {
        $this->color = 'bg-primary';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorSecondary(): self
    {
        $this->color = 'bg-secondary';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorSuccess(): self
    {
        $this->color = 'bg-success';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorDanger(): self
    {
        $this->color = 'bg-danger';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorWarning(): self
    {
        $this->color = 'bg-warning';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorInfo(): self
    {
        $this->color = 'bg-info';

        return $this;
    }

    /**
     * @return self
     */
    public function setColorDark(): self
    {
        $this->color = 'bg-dark';

        return $this;
    }
}