<?php

namespace Webmagic\Dashboard\Services;


class DashboardSettingsManager
{
    /**
     * @param string $lang
     */
    public function setLocale(string $lang)
    {
        session(['lang' => $lang]);
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return session('lang', config('webmagic.dashboard.dashboard.header_navigation_options.default_locale'));
    }
    /**
     * @param int|null $step
     * @param string|null $identifier
     * @param string $paginationStepParam
     * @param int $defaultStep
     */
    public function savePaginationStep(
        int $step = null,
        string $identifier = null,
        string $paginationStepParam = 'per_page',
        int $defaultStep = 25
    ) {
        $identifier = $this->getIdentifier($identifier);
        $step = $step ?? $this->getActualStep($identifier, $paginationStepParam, $defaultStep);

        session([$identifier => $step]);
    }

    /**
     * Get actual step value based on priorities
     *
     * @param $identifier
     * @param $paginationStepParam
     * @param $defaultStep
     *
     * @return int|mixed|null
     */
    protected function getActualStep($identifier, $paginationStepParam, $defaultStep)
    {
       if($step = $this->getStepFromRequest($paginationStepParam)){
           return $step;
       }

        if($step = $this->getPaginationStepFromSession($identifier)){
            return $step;
        }

        return $defaultStep;
    }

    /**
     * @param string|null $identifier
     * @param string|null $paginationStepParam
     * @param int         $defaultStep
     *
     * @return int
     */
    public function getPaginationStep(
        string $identifier = null,
        string $paginationStepParam = 'per_page',
        int $defaultStep = 25
    ): int
    {
        $identifier = $this->getIdentifier($identifier);
        $step = $this->getActualStep($identifier, $paginationStepParam, $defaultStep);

        $this->savePaginationStep($step, $identifier, $paginationStepParam);

        return $step;
    }

    /**
     * @param string|null $identifier
     * @return string
     */
    private function getIdentifier(string $identifier = null): string
    {
        return $identifier ?? url()->current();
    }

    /**
     * @param string $paginationStepParam
     *
     * @return int
     */
    private function getStepFromRequest(string $paginationStepParam): ?int
    {
        return request()->input($paginationStepParam);
    }

    /**
     * @param $identifier
     * @return mixed
     */
    private function getPaginationStepFromSession($identifier)
    {
        return session($identifier);
    }
}