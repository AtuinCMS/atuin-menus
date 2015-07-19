<?php

namespace atuin\menus\config;

use atuin\config\models\ModelConfig;


/**
 * Class ConfigSkeleton
 * @package common\engine\module_skeleton\libraries
 *
 * Class called to install a module in the CMS.
 *
 * Here must be all the automatic changes in the system that will be necessary to install a new module.
 *
 */
class AtuinConfig extends \atuin\skeleton\config\AtuinConfig
{

    /**
     * @inheritdoc
     */
    public function upMigration()
    {

    }

    /**
     * @inheritdoc
     */
    public function downMigration()
    {

    }

    /**
     * @inheritdoc
     */
    public function upMenu()
    {

    }


    /**
     * @inheritdoc
     */
    public function downMenu()
    {

    }

    /**
     * @inheritdoc
     */
    public function upConfig()
    {
    }


    /**
     * @inheritdoc
     */
    public function downConfig()
    {
        $this->configItems->deleteConfig();
    }

    /**
     * @inheritdoc
     */
    public function upManual()
    {
        // delete neo user that automatically the migration adds

    }


    /**
     * @inheritdoc
     */
    public function downManual()
    {

    }

}