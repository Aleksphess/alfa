<?php
use yii\helpers\Url;
?>
<div style="display: none">
    <div class="g-modal box-modal" id="study-cosmetic">
        <div class="box-modal_close arcticmodal-close"><i class="icon-modal-close--dark"></i></div>
                <div class="g-modal__inner">
                        <div class="g-modal__title"><?= Yii::t('forms','to_order_study') ?></div>
                        <form class="f-smr xhr-form" id="smr_form" method="POST" action="<?= Url::to(['/api/forms/add']) ?>" data-modal-success="thanks" data-modal-err="server-error">
                            <div class="g-form__col--one">
                                <label class="g-hidden"><?= Yii::t('forms','your_name') ?></label>
                                <input type="text" class="g-input g-input--simple" name="name" id="smr_name" placeholder="<?= Yii::t('forms','your_name') ?>">
                            </div>
                            <div class="g-form__col--one">
                                <label class="g-hidden"><?= Yii::t('forms','phone_number') ?> *</label>
                                <input type="phone" class="g-input g-input--simple" name="phone" id="smr_phone" placeholder="<?= Yii::t('forms','phone_number') ?> *" required="required" aria-required="true">
                            </div>
                            <div class="g-form__col--one">
                                <label class="g-hidden"><?= Yii::t('forms','your_email') ?></label>
                                <input type="email" class="g-input g-input--simple" name="email" id="smr_email" placeholder="<?= Yii::t('forms','your_email') ?>">
                            </div>
                            <div class="g-form__col--one">
                                <input type="checkbox" class="" name="recaptcha" id="recaptcha" required>
                                <label for="recaptcha" style="display:inline-block">Я не робот</label>
                                <input type="checkbox" class="" name="recaptcha_in" id="recaptcha-in">
                                <label for="recaptcha-in">Я не робот</label>
                                <input type="text" value="yes" class="" name="is_recaptcha" hidden>
                                <!--div class="g-recaptcha" data-sitekey="6LeedB0UAAAAAEpsl3Y_RqkFiySCDX6L_9gSsIpT"></div-->
                            </div>
                                <input type="hidden" hidden name="form_type" value="study-cosmetic">
                                <input name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" type="hidden">
                                <div class="g-form__col--one g-text-center g-margin--none">
                                    <button type="submit" class="btn btn--colored btn--normal"><?= Yii::t('forms','send') ?></button>
                                </div>
                        </form>
                </div>
    </div>
</div>