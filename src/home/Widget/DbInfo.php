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
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Widget */
require_once 'Gonium/Widget.php';

/**
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Widget_DbInfo extends Gonium_Widget
{

    public function execute()
    {
    	$this->_output = '';

        $config = Zend_Registry::get('GoniumCore_Config');
        $db = Zend_Registry::get('GoniumCore_db');
        $profiler = $db->getProfiler();
        
        if($profiler->getEnabled())
        {
            $totalTime    = $profiler->getTotalElapsedSecs();
            $queryCount   = $profiler->getTotalNumQueries();
            $longestTime  = 0;
            $longestQuery = null;
        
            $queries = $profiler->getQueryProfiles();
            $queries = $queries ? $queries : array();
            
            foreach ( $queries as $query) {
                if ($query->getElapsedSecs() > $longestTime) {
                    $longestTime  = $query->getElapsedSecs();
                    $longestQuery = $query->getQuery();
                }
            }
        
            $this->_view->assign('db_queryCount', $queryCount );
            $this->_view->assign('db_totalTime', round($totalTime, 5));
        
            if( (bool) $config->show->dbInfo )
            {
                $this->_view->assign('db_QueriesPerSecond',
                   ($totalTime != 0) ? round($queryCount/$totalTime, 5) : false
                );
        
                $this->_view->assign('db_AverageQueryLength',
	               ($queryCount != 0) ? round($totalTime/$queryCount, 5) : false
	            );
        
                $this->_view->assign('db_longestQuery', $longestQuery);
                $this->_view->assign('db_longestTime', round($longestTime, 5));
        
            } else {
                $this->_view->assign('db_QueriesPerSecond', false);
                $this->_view->assign('db_AverageQueryLength', false);
                $this->_view->assign('db_longestQuery', false);
                $this->_view->assign('db_longestTime', false);
            }

            $this->setContent( $this->_view->render('DbInfo.phtml') );
        }
    }
}
