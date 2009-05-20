/**
 * Gonium_Link
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

var Gonium_Link = {
    /**
    * Rel value of external
    * @var string
    */
    rel: 'external',
    target: '_blank',

    /**
    * Set all links with 'rel="external"' value, to be opened on a new window/tab
	* All link with  tag
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