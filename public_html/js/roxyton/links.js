/**
 * Rox_Link
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: links.js 153 2009-05-10 21:20:21Z gnzsquall $
 */

var Rox_Link = {
    /**
    * Rel value of external
    * @var string
    */
    rel: 'external',
    target: '_blank',

    /**
    * Highlight pair rows on a highlightable table
    * @return void
    */
    setExternal: function() {

        var anchors = document.getElementsByTagName("a");

        for (var i=0; i < anchors.length; i++) {
            var anchor = anchors[i];

            if (anchors[i].getAttribute("href") &&
                anchors[i].getAttribute("rel") == "external")

                anchor.target = this.target;
        }
    }
};