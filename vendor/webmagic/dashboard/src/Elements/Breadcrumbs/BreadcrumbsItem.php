<?php


namespace Webmagic\Dashboard\Elements\Breadcrumbs;


class BreadcrumbsItem
{
    /** @var string */
    private $link;

    /** @var string */
    private $icon;

    /** @var string */
    private $text;

    /**
     * BreadcrumbsItem constructor.
     *
     * @param string      $link
     * @param string      $text
     * @param string|null $icon
     */
    public function __construct(string $link, string $text, string $icon = '')
    {
        $this->link = $link;
        $this->icon = $icon;
        $this->text = $text;
    }

    /**
     * Check if Icon set
     *
     * @return bool
     */
    public function hasIcon(): bool
    {
        return $this->icon != '';
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return BreadcrumbsItem
     */
    public function setLink(string $link): BreadcrumbsItem
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return BreadcrumbsItem
     */
    public function setIcon(string $icon): BreadcrumbsItem
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return __($this->text);
    }

    /**
     * @param string $text
     *
     * @return BreadcrumbsItem
     */
    public function setText(string $text): BreadcrumbsItem
    {
        $this->text = $text;
        return $this;
    }
}