<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?=$this->title?></title>
  <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
  <meta name="author" content="Vincent Garreau" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" media="screen" href="/plugins/particles/style.css">
</head>
<body>
<!-- particles.js container -->
<div class="content">
    <div class="header">
      <label style="display: inline-block;margin-left: 20px;">
        <!-- <i style="display: block;font-family:SimHei; font-size:36px; font-weight:700; ">威胁检测和响应系统2.0</i> -->
        <i style="display: block;font-family:SimHei; font-size:36px; font-weight:700; ">圣博润恶意代码检测与防御系统 V2.0</i>
        <!-- <i style="display: block;font-family:Arial; font-size:18px;">Threat detection and response systems 2.0</i> -->
        <i style="display: block;font-family:Arial; font-size:18px;">LEDR V2.0</i>
      </label>
    </div>
    <div class="body">
        <div class="site-login">
            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']);?>

                        <?=$form->field($model, 'username', ['labelOptions' => ['label' => null]])
->textInput([
    'autofocus' => true,
    'placeholder' => '用户名',
])?>

                        <?=$form->field($model, 'password', ['labelOptions' => ['label' => null]])->passwordInput([
    'placeholder' => '密码',
])?>


                        <div class="form-group">
                            <?=Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button'])?>
                        </div>

                    <?php ActiveForm::end();?>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="particles-js"></div>


<!-- scripts -->
<script src="/plugins/particles/particles.min.js"></script>
<script src="/plugins/particles/app.js"></script>


</body>
</html>