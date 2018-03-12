<?php

namespace app\controllers;

use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;


class AdminController extends PrototypeController
{
    /**
     * Controller layout
     * @var string
     */
    public $layout = 'admin.php';

    /**
     * Main body class
     * @var string
     */
    public $bodyClass = 'animated_fill-none';

    /**
     * List items count
     * @var string
     */
    public $listCount = '';

    /**
     * Boolean param, fix heading on page or not
     * @var string
     */
    public $fixHeading = 'false';
}
