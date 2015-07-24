<?php

namespace atuin\menus\models;


use atuin\apps\models\AppConnections;
use cyneek\yii2\menu\models\MenuItem;

class ModelMenuItem
{

    /**
     * Deletes all menu items assigned to the App
     *
     *
     * @param integer $appId
     * @throws \Exception
     */
    public function deleteAppMenuItems($appId)
    {
        /** @var MenuItem[] $menusList */
        // 1 - we get all the menus connected to the App
        $menusList = MenuItem::find()->joinWith('appConnections', FALSE)->where(['app_id' => $appId])->all();

        foreach ($menusList as $menuItem) {
            $menuItem->delete();
        }

        AppConnections::deleteAll(['app_id' => $appId, 'type' => MenuItem::className()]);
    }

}