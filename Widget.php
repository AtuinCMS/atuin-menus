<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-widgets
 * @subpackage yii2-widget-sidenav
 * @version 1.0.0
 */

namespace atuin\menus;

use cyneek\yii2\menu\models\MenuItems;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Widget extends \yii\widgets\Menu
{

    /**
     * @var string the template used to render the body of a menu which has another items as sons.
     * In this template, the token `{label}` will be replaced with the label of the menu item.
     * This property will be overridden by the `template` option set in individual menu items via [[items]].
     */
    public $parentTemplate = '<a href="#">{label} <i class="fa fa-angle-left pull-right"></i> </a>';

    /**
     * @var string prefix for the icon in [[items]]. This string will be prepended
     * before the icon name to get the icon CSS class. This defaults to `glyphicon glyphicon-`
     * for usage with glyphicons available with Bootstrap.
     */
    public $iconPrefix = 'pull-right glyphicon glyphicon-';


    public $headerTemplate = '<ul class="sidebar-menu"><li class="header">{header}</li></ul>';

    /**
     * @var array string/boolean the menu heading. This is not HTML encoded
     * When set to false or null, no heading container will be displayed.
     */
    public $header = FALSE;


    public function run()
    {
        ob_start();
        parent::run();
        $body = ob_get_contents();
        ob_end_clean();

        // Adds the header
        if ($this->header)
        {
            $encodeHeader = ArrayHelper::getValue($this->options, 'encodeHeader', FALSE);

            $header = strtr($this->headerTemplate, [
                '{header}' => (($encodeHeader) ? Html::encode($this->header) : $this->header),
            ]);

            $body = $header . $body;
        }

        echo Html::tag('div', $body, ['class' => 'sidebar']);
    }

    public function init()
    {
        $this->items = $this->item_list();
        parent::init();
    }

    /**
     * Gets a list of ordered menu items from the MenuItems model and
     * makes an array of items compatible with the SideNav widget
     *
     * @return array
     */
    protected function item_list()
    {
        $menuItemsObj = new MenuItems();

        $items = $menuItemsObj->get_active_menu_items();

        $ordered_list = [];

        foreach ($items as $item)
        {
            $ordered_list[] = $this->recursive_make_list($item);
        }

        return $ordered_list;

    }

    /**
     * Does the heavy lifting of making the ordered list of SideNav items
     * calling recursively each children node to traverse all the nodes
     *
     * @param $item
     * @return mixed
     */
    protected function recursive_make_list($item)
    {
        $new_item['label'] = $item['data']['label'];

        if ($item['data']['icon'] != '')
        {
            $new_item['icon'] = $item['data']['icon'];
        }

        if ($item['data']['url'] != '')
        {
            $new_item['url'] = $item['data']['url'];
        }

        if ($item['data']['options'] != '')
        {
            $new_item['options'] = json_decode($item['data']['options'], TRUE);
        } else
        {
            $new_item['options'] = [];
        }

        if (!empty($item['children']))
        {
            foreach ($item['children'] as $child)
            {
                $new_item['items'][] = $this->recursive_make_list($child);
            }

            if (!array_key_exists('class', $new_item['options']))
            {
                $new_item['options']['class'] = '';
            }

            $new_item['options']['class'] .= 'treeview';

        }

        return $new_item;
    }


    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {

        if (array_key_exists('icon', $item))
        {
            $options = ArrayHelper::getValue($item, 'options', []);
            $iconPrefix = ArrayHelper::getValue($options, 'iconPrefix', $this->iconPrefix);

            $item['label'] = '<span class="' . $iconPrefix . $item['icon'] . '"></span>' . $item['label'];
        }

        if (array_key_exists('items', $item))
        {
            $template = ArrayHelper::getValue($item, 'template', $this->parentTemplate);

            return strtr($template, [
                '{label}' => $item['label'],
            ]);
        }

        return parent::renderItem($item);
    }

}
