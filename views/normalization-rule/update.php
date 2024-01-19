<?php

use macgyer\yii2materializecss\widgets\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NormalizationRule */
/* @var $form yii\widgets\ActiveForm */

$this->params['title'] = 'Update Normalization Rule: ' . $model->ruleFileName;

?>
<div class="normalization-rule-update">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="main-actions centered-horizontal">
        <button type="submit" class="btn red darken-4" style="border-radius: 10px">Update</button>
        <a href="." class="btn grey darken-2" style="border-radius: 10px">Close</a>
    </div>


    <div class="row" style="margin-bottom: -10px;">
        <div style="margin-bottom: -10px;">
            <label>Custom rule name</label>
        </div>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="row" style="margin-bottom: 5px;">
        <div style="margin-bottom: -10px;">
            <label>Rule status</label>
        </div>
        <?= $form->field($model, 'active')->checkbox() ?>
    </div>

    <div class="row"></div>

    <div style="margin-left: -10px;">
        <label>Edit rule</label>
        <div style='border: 1px solid grey; padding: 0 5px'>
            <?= $form->field($model, 'content')->textarea(['showCharacterCounter' => true])->label(false) ?>
        </div>
    </div>

    <div class="row"></div>

    <?php ActiveForm::end(); ?>
</div>