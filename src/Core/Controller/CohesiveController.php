<?php

namespace App\Core\Controller;

use yii\base\InlineAction;

abstract class CohesiveController extends ControllerBase
{
    /**
     * @inheritDoc
     */
    public function createAction($id)
    {
        return new InlineAction('handle', $this, 'handle');
    }

    /**
     * @return mixed
     */
    abstract public function handle();
}