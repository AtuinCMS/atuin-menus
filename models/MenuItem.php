<?php

namespace atuin\menus\models;

use atuin\apps\models\App;
use atuin\apps\models\AppConnections;

class MenuItem extends \cyneek\yii2\menu\models\MenuItem
{

    /**
     * Returns all the connections of the Apps in the AppConnections Active Record
     *
     * Useful to retrieve all the configs, pages and extra data that Apps have
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppConnections()
    {
        return $this->hasMany(AppConnections::className(), ['reference_id' => 'id']);
    }


    /**
     * Retrieves all the Configs assigned to the filtered Apps using AppConnections
     * as junction table.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(App::className(), ['id' => 'app_id'])->
        via('appConnections', function ($query)
        {
            $query->where(['type' => \cyneek\yii2\menu\models\MenuItem::className()]);
        });
    }
}