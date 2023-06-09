<?php


namespace Webmagic\Dashboard\Components\Core;


use Webmagic\Dashboard\Dashboard;
use Webmagic\Dashboard\Pages\BasePage;
use Webmagic\Dashboard\Pages\BasePageTopSidebar;

trait UsePage
{
    /** @var BasePage */
    protected $page;

    /**
     * Return page
     *
     * @return BasePage|BasePageTopSidebar
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param BasePage|null $page
     */
    protected function setPage(BasePage $page = null)
    {
        $this->page = is_null($page) ? app(Dashboard::class)->page() : $page;
    }

    /**
     * Set page title
     *
     * @param string $title
     *
     * @param string $subTitle
     *
     * @return $this
     */
    public function title(string $title, string $subTitle = '')
    {
        $this->getPage()->setPageTitle($title, $subTitle);

        return $this;
    }

}
