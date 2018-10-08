<?php
/**
 * interface HistogramInterface
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{
    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie();



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin();



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax();
}
