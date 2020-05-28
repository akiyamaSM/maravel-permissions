<?php


namespace Inani\Maravel;

trait IsMarvel
{
    /**
     * The marvel related to
     *
     * @return Marvel
     */
    public function marvel()
    {
        return $this->belongsTo(Marvel::class);
    }

    /**
     * The scanner
     *
     * @return mixed
     */
    public function cerebro()
    {
        /** @var Cerebro $conan */
        $conan = resolve(Cerebro::class);

        return $conan->scan($this);
    }
}
