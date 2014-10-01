<?php

namespace WL\AppBundle\Lib\View\Data\Entity\Filter;


class PropertyRange extends FilterAbstract
{
    /**
     * @var float
     */
    protected $min;
    /**
     * @var float
     */
    protected $max;

    /**
     * @param float $max
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param float $min
     */
    public function setMin($min)
    {
        $this->min = $min;
    }

    /**
     * @return float
     */
    public function getMin()
    {
        return $this->min;
    }

} 