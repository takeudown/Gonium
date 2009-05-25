/**
 * Gnm_Table
 *
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

var Gnm_Table = {
    /**
    * Class name of highlightable tables
    * @var string
    */
    tableClassName: 'highlightable',

    /**
    * Class name to apply to pair rows
    * @var string
    */
    rowsNewClassName: 'highlight',

    /**
    * Highlight pair rows on a highlightable table
    * @return void
    */
    highlightPairRows: function() {

        var tablas = document.getElementsByTagName("table");

        for (var i=0; i<tablas.length; i++) {
            if( tablas[i].className == this.tableClassName) {
                for (var j=0; j<tablas[i].rows.length; j++) {
                    if (j%2 == 0) {
                        tablas[i].rows[j].className = this.rowsNewClassName;
                    }
                }
            }
        }
    }
};