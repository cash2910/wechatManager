<?php 
namespace backend\widgets;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
class SideNav extends \yii\bootstrap\Widget
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
    */
    public $encodeLabels = true;
    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive
     */
    public $activeUrl;
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        if (!isset($this->options['class'])) {
            Html::addCssClass($this->options, 'list-group');
        }
    }
    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems();
        BootstrapAsset::register($this->getView());
    }
    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            $items[] = $this->renderItem($item, count($this->items) !== 1);
        }
        return Html::tag('div', implode("\n", $items), $this->options);
    }
    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @param boolean $collapsed whether to collapse item if not active
     * @throws \yii\base\InvalidConfigException
     * @return string the rendering result.
     * @throws InvalidConfigException if label is not defined
     */
    public function renderItem($item, $collapsed = true)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encode = isset($item['encodeLabel']) ? $item['encodeLabel'] : $this->encodeLabels;
        $label = $encode ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = Url::to(ArrayHelper::getValue($item, 'url', '#'));
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        Html::addCssClass($linkOptions, 'list-group-item');
        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = ($url == $this->activeUrl);
        }
        if ($items !== null) {
            Html::addCssClass($linkOptions, 'has-children');
            $linkOptions['data-toggle'] = 'collapse';
            $linkOptions['data-parent'] = '#' . $this->id;
            $id = $this->id . '-' . static::$counter++;
            $linkOptions['data-target'] = '#' . $id;
            $url = '#';
            $label .= '<b class="caret"></b>';
            if (is_array($items)) {
                if ($active === false) {
                    foreach ($items as $subItem) {
                        if (isset($subItem['active']) && $subItem['active']) {
                            $active = true;
                        }
                    }
                }
                $items = static::widget([
                    'id' => $id,
                    'items' => $items,
                    'encodeLabels' => $this->encodeLabels,
                    'view' => $this->getView(),
                    'options' => [
                        'class' => "submenu panel-collapse collapse" . ($active || !$collapsed ? ' in' : '') . ($active ? ' active-parent' : '')
                        //'class' => "submenu panel-collapse " . ($active || !$collapsed ? ' in' : '') . ($active ? ' active-parent' : '')
                    ]
                ]);
            }
        }
        if ($active) {
            Html::addCssClass($linkOptions, 'active');
        }
        return Html::a($label, $url, $linkOptions) . $items;
    }
}
?>