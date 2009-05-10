<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 *  Copyright (C) 2008 Gonzalo Diaz Cruz
 *
 * LICENSE
 *
 * Gonium is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category    Gonium
 * @package     Rox_Translate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Date.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Rox_Translate_Abstract */
require_once 'Rox/Translate/Abstract.php';

/**
 * Translatable
 *
 * @category    Gonium
 * @package     Rox_Translate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Date.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Rox_Translate_Date extends Rox_Translate_Abstract
{
    // Day Keys
    const DAY_MONDAY = 'monday';
    const DAY_THUESDAY = 'tuesday';
    const DAY_WEDNESDAY = 'wednesday';
    const DAY_THURSDAY = 'thursday';
    const DAY_FRIDAY = 'friday';
    const DAY_SATURDAY = 'saturday';
    const DAY_SUNDAY = 'sunday';

    // Month keys
    const MONTH_JANUARY = 'january';
    const MONTH_FEBRUARY = 'february';
    const MONTH_MARCH = 'march';
    const MONTH_APRIL = 'april';
    const MONTH_MAY = 'may';
    const MONTH_JUNE = 'june';
    const MONTH_JULY = 'july';
    const MONTH_AUGUST = 'august';
    const MONTH_SEPTEMBER = 'september';
    const MONTH_OCTOBER = 'october';
    const MONTH_NOVEMBER = 'november';
    const MONTH_DECEMBER = 'december';

    /**
    * Get translated day names
    * in a numerical Array.
    *
    * @return array
    */
    public function getDays() {
        return array(
            $this->_lang->translate('date_day_monday'),
            $this->_lang->translate('date_day_tuesday'),
            $this->_lang->translate('date_day_wednesday'),
            $this->_lang->translate('date_day_thursday'),
            $this->_lang->translate('date_day_friday'),
            $this->_lang->translate('date_day_saturday'),
            $this->_lang->translate('date_day_sunday')
        );
    }

    /**
    * Get translated day names
    * in an assotive array. Day_Key -> Name
    *
    * @return array
    */
    public function getDaysAndKeys() {
        return array(
            self::DAY_MONDAY => $this->_lang->translate('date_day_monday'),
            self::DAY_THUESDAY => $this->_lang->translate('date_day_tuesday'),
            self::DAY_WEDNESDAY => $this->_lang->translate('date_day_wednesday'),
            self::DAY_THURSDAY => $this->_lang->translate('date_day_thursday'),
            self::DAY_FRIDAY => $this->_lang->translate('date_day_friday'),
            self::DAY_SATURDAY => $this->_lang->translate('date_day_saturday'),
            self::DAY_SUNDAY => $this->_lang->translate('date_day_sunday')
        );
    }

    /**
    * Get translated day names
    * in a numerical Array.
    *
    * @return array
    */
    public function getShortDays() {
        return array(
            $this->_lang->translate('date_day_short_sunday'),
            $this->_lang->translate('date_day_short_monday'),
            $this->_lang->translate('date_day_short_tuesday'),
            $this->_lang->translate('date_day_short_wednesday'),
            $this->_lang->translate('date_day_short_thursday'),
            $this->_lang->translate('date_day_short_friday'),
            $this->_lang->translate('date_day_short_saturday')
        );
    }

    /**
    * Get translated day names
    * in a numerical Array.
    *
    * @return array
    */
    public function getMinDays() {
        return array(
            $this->_lang->translate('date_day_min_sunday'),
            $this->_lang->translate('date_day_min_monday'),
            $this->_lang->translate('date_day_min_tuesday'),
            $this->_lang->translate('date_day_min_wednesday'),
            $this->_lang->translate('date_day_min_thursday'),
            $this->_lang->translate('date_day_min_friday'),
            $this->_lang->translate('date_day_min_saturday')
        );
    }

    /**
    * Get translated month names
    *
    * @return array
    */
    public function getMonths() {
        return array(
            $this->_lang->translate('date_month_january'),
            $this->_lang->translate('date_month_february'),
            $this->_lang->translate('date_month_march'),
            $this->_lang->translate('date_month_april'),
            $this->_lang->translate('date_month_may'),
            $this->_lang->translate('date_month_june'),
            $this->_lang->translate('date_month_july'),
            $this->_lang->translate('date_month_august'),
            $this->_lang->translate('date_month_september'),
            $this->_lang->translate('date_month_october'),
            $this->_lang->translate('date_month_november'),
            $this->_lang->translate('date_month_december')
        );
    }

    /**
    * Get translated month names
    *
    * @return array
    */
    public function getShortMonths() {
        return array(
            $this->_lang->translate('date_month_short_january'),
            $this->_lang->translate('date_month_short_february'),
            $this->_lang->translate('date_month_short_march'),
            $this->_lang->translate('date_month_short_april'),
            $this->_lang->translate('date_month_short_may'),
            $this->_lang->translate('date_month_short_june'),
            $this->_lang->translate('date_month_short_july'),
            $this->_lang->translate('date_month_short_august'),
            $this->_lang->translate('date_month_short_september'),
            $this->_lang->translate('date_month_short_october'),
            $this->_lang->translate('date_month_short_november'),
            $this->_lang->translate('date_month_short_december')
        );
    }

    /**
    * Get translated month names
    * in an assotive array. Month_Key -> Name
    *
    * @return array
    */
    public function getMonthsAndKeys() {
        return array(
            self::MONTH_JANUARY => $this->_lang->translate('date_month_january'),
            self::MONTH_FEBRUARY => $this->_lang->translate('date_month_february'),
            self::MONTH_MARCH => $this->_lang->translate('date_month_march'),
            self::MONTH_APRIL => $this->_lang->translate('date_month_april'),
            self::MONTH_MAY => $this->_lang->translate('date_month_may'),
            self::MONTH_JUNE => $this->_lang->translate('date_month_june'),
            self::MONTH_JULY => $this->_lang->translate('date_month_july'),
            self::MONTH_AUGUST => $this->_lang->translate('date_month_august'),
            self::MONTH_SEPTEMBER => $this->_lang->translate('date_month_september'),
            self::MONTH_OCTOBER => $this->_lang->translate('date_month_october'),
            self::MONTH_NOVEMBER => $this->_lang->translate('date_month_november'),
            self::MONTH_DECEMBER => $this->_lang->translate('date_month_december')
        );
    }

    public function getUnits()
    {
        return array(
            $this->_lang->translate('date_unit_second'),
            $this->_lang->translate('date_unit_minute'),
            $this->_lang->translate('date_unit_hour'),
            $this->_lang->translate('date_unit_day'),
            $this->_lang->translate('date_unit_week'),
            $this->_lang->translate('date_unit_month'),
            $this->_lang->translate('date_unit_year'),
            $this->_lang->translate('date_unit_decade'),
            $this->_lang->translate('date_unit_century'),
            $this->_lang->translate('date_unit_millenium')
        );
    }

    /**
    * Spring Â· Summer Â· Autumn Â· Winter
    */
    public function getSessions()
    {
        return array(
            $this->_lang->translate('date_session_spring'),
            $this->_lang->translate('date_session_summer'),
            $this->_lang->translate('date_session_autumn'),
            $this->_lang->translate('date_session_winter')
        );
    }
}
