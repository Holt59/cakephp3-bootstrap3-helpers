<?php
/**
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE file
 * Redistributions of files must retain the above copyright notice.
 * You may obtain a copy of the License at
 *
 *     https://opensource.org/licenses/mit-license.php
 *
 *
 * @copyright Copyright (c) Mikaël Capelle (https://typename.fr)
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Bootstrap\View\Helper;

use Cake\View\Helper\FlashHelper;

/**
 * FlashHelper class to render flash messages.
 *
 * After setting messages in your controllers with FlashComponent, you can use
 * this class to output your flash messages in your views.
 */
class BootstrapFlashHelper extends FlashHelper {

    /**
     * Available bootstrap templates for alert.
     *
     * @var array
     */
    protected $_bootstrapTemplates = ['info', 'error', 'success', 'warning'];

    /**
     * {@inheritDoc}
     */
    public function render($key = 'flash', array $options = []) {
        if (!$this->request->session()->check("Flash.$key")) {
            return;
        }

        $flash = $this->request->session()->read("Flash.$key");
        if (!is_array($flash)) {
            throw new \UnexpectedValueException(sprintf(
                'Value for flash setting key "%s" must be an array.',
                $key
            ));
        }
        foreach ($flash as &$message) {
            if (in_array(basename($message['element']), $this->_bootstrapTemplates)) {
                $message['element'] = 'Bootstrap.'.$message['element'];
            }
        }
        $this->request->session()->write("Flash.$key", $flash);

        return parent::render($key, $options);
    }

}

?>
