<?php
use yii\helpers\Url;

$this->title = Yii::$app->page->getPageInfo('name');
?>

<!-- PAGE -->
<section id="page" class="page page__hydropeptide">

        <div class="page__inner">
                <!-- breadcrumbs -->
                <div class="breadcrumbs is-slideInLeft is-animated">
                <ol class="breadcrumbs__list">
                    <li class="breadcrumbs__item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="<?= Url::to(['/']) ?>" class="breadcrumbs__link" itemprop="url">
                            <span itemprop="title"><?= Yii::t('app','main') ?></span>
                        </a>
                    </li>
                    <li class="breadcrumbs__item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="<?= Url::to(['/services']) ?>" class="breadcrumbs__link" itemprop="url">
                            <span itemprop="title"><?= Yii::t('app','services') ?></span>
                        </a>
                    </li>
                    <li class="breadcrumbs__item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                        <a href="<?= Url::to(['/consulting']) ?>" class="breadcrumbs__link" itemprop="url">
                            <span itemprop="title"><?= Yii::t('app','consulting') ?></span>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?= Yii::$app->page->getPageInfo('name') ?>
                    </li>
                </ol>
        </div>
        <!-- /breadcrumbs -->

                <div class="page__content">
                        <div class="b-hero--huge">
                                <div class="b-hero__slide is-fadeIn is-animated" style="background-image: url('<?= Yii::$app->page->getSubBlockThumb('baner') ?>');"></div>
                                <div class="b-hero__content">
                                        <div class="b-hero__text">
                                                <h1 class="b-hero__title title">
                                                        <div class="title__inner is-slideInUp is-animated">
                                                                <div class="title__text">
                                                                        <?= Yii::$app->page->getPageInfo('name') ?>
                                                                        <div class="title__underline is-slideInLeft is-animated"></div>
                                                                </div>
                                                        </div>
                                                </h1>
                                        </div>
                                        <div class="b-hero__text">
                                            <?php
                                            if (Yii::$app->page->getSubBlockInfo('baner_title1','name')) : ?>
                                                <h3 class="b-hero__subtitle title">
                                                        <div class="title__inner is-slideInUp is-animated">
                                                                <div class="title__text g-text--smallcaps">
                                                                        <?= Yii::$app->page->getSubBlockInfo('baner_title1','name') ?>
                                                                        <div class="title__underline is-slideInLeft is-animated"></div>
                                                                </div>
                                                        </div>
                                                </h3>
                                            <?php
                                            endif; ?>
                                            <?php
                                            if (Yii::$app->page->getSubBlockInfo('baner_title2','name')) : ?>
                                                <h3 class="b-hero__subtitle title">
                                                        <div class="title__inner is-slideInUp is-animated">
                                                                <div class="title__text g-text--smallcaps">
                                                                        <?= Yii::$app->page->getSubBlockInfo('baner_title2','name') ?>
                                                                        <div class="title__underline is-slideInLeft is-animated"></div>
                                                                </div>
                                                        </div>
                                                </h3>
                                            <?php
                                            endif; ?>
                                        </div>
                                </div>
                        </div>
                        
                        <?= Yii::$app->page->getPageInfo('text') ?>
                   
                        <article class="g-block is-fadeIn is-animated">
                                    <p class="g-title--small-caps"><?= Yii::$app->page->getSubBlockInfo('two_col_img_text_title','name') ?></p>
                                    <?= Yii::$app->page->getSubBlockInfo('two_col_img_text_title','description') ?>
                        </article>

                    <?php
                    for ($i=1;$i<10;$i++) : ?>
                        <?php
                        $block = Yii::$app->page->getSubBlock('two_col_img_text'.$i,'id');
                        if ($block) : ?>
                        <article class="g-block is-fadeIn is-animated">
                                <div class="g-content">
                                        <div class="g-table g-table--responsive">
                                            <?php
                                            if ($i%2 == 1): ?>
                                                <div class="g-table__cell g-col--five-ninth">
                                                    <?= Yii::$app->page->getSubBlockInfo('two_col_img_text'.$i,'text') ?>
                                                </div>
                                                <div class="g-table__cell g-col--four-ninth">
                                                    <img src="<?= Yii::$app->page->getSubBlockThumb('two_col_img_text'.$i) ?>" alt="<?= Yii::$app->page->getSubBlockInfo('two_col_img_text'.$i,'name') ?>">
                                                </div>
                                            <?php
                                            else: ?>
                                                <div class="g-table__cell g-col--four-ninth">
                                                    <img src="<?= Yii::$app->page->getSubBlockThumb('two_col_img_text'.$i) ?>" alt="<?= Yii::$app->page->getSubBlockInfo('two_col_img_text'.$i,'name') ?>">
                                                </div>
                                                <div class="g-table__cell g-col--five-ninth">
                                                    <?= Yii::$app->page->getSubBlockInfo('two_col_img_text'.$i,'text') ?>
                                                </div>
                                            <?php
                                            endif; ?>
                                        </div>
                                </div>
                        </article>
                        <?php
                        endif; ?>
                    <?php
                    endfor; ?>



                    <?php
                    $block = Yii::$app->page->getSubBlock('more_facts1','id');
                    if ($block) : ?>
                            <div class="g-content">
                                    <p class="g-title--small-caps g-title--big is-fadeIn is-animated"><?= Yii::$app->page->getSubBlockInfo('more_facts_title','name') ?></p>
                                    <div class="g-table g-table--vtop g-table--responsive is-fadeIn is-animated">
                                        <?php
                                        for ($i=1;$i<4;$i++) : ?>
                                            <?php
                                            $block = Yii::$app->page->getSubBlock('more_facts'.$i,'id');
                                            if ($block) : ?>
                                            <div class="g-table__cell g-col--one-third">
                                                    <div class="g-block g-gutter g--center">
                                                            <div class="g-desc">
                                                                    <div class="g-desc__text">
                                                                            <?= Yii::$app->page->getSubBlockInfo('more_facts'.$i,'name') ?>
                                                                    <div class="g-desc__underline is-slideInLeft is-animated"></div>
                                                            </div>
                                                            </div>
                                                            <div class="g-picture">
                                                                    <img src="<?= Yii::$app->page->getSubBlockThumb('more_facts'.$i) ?>" alt="<?= Yii::$app->page->getSubBlockInfo('more_facts'.$i,'name') ?>">
                                                            </div>
                                                    </div>
                                            </div>
                                            <?php
                                            endif; ?>
                                        <?php
                                        endfor; ?>    
                                    </div>
                            </div>
                    <?php
                    endif; ?>

                    <?php
                    $block = Yii::$app->page->getSubBlock('wh_1','id');
                    if ($block) : ?>                    
                    
                        <div class="g-content">
                            <div class="g-title--small-caps g-title--big is-fadeIn is-animated"><?= Yii::$app->page->getSubBlockInfo('wh_title','description') ?></div>
                            <div class="g-table g-table--vtop g-table--responsive is-fadeIn is-animated">
                                <?php
                                for ($i=1;$i<4;$i++) : ?>
                                    <?php
                                    $block = Yii::$app->page->getSubBlock('wh_'.$i,'id');
                                    if ($block) : ?>
                                    <div class="g-table__cell g-col--one-third">
                                        <div class="g-block g--center">
                                            <div class="g-picture"><img alt="<?= Yii::$app->page->getSubBlockInfo('wh_'.$i,'name') ?>" src="<?= Yii::$app->page->getSubBlockThumb('wh_'.$i) ?>" /></div>
                                            <div class="g-desc">
                                                <div class="g-desc__text g-text--smallcaps">
                                                    <div class="g-desc__aboveline is-slideInLeft is-animated">&nbsp;</div>
                                                    <?= Yii::$app->page->getSubBlockInfo('wh_'.$i,'name') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    endif; ?>
                                <?php
                                endfor; ?>  
                                
                            </div>
                        </div>   
                    
                    <?php
                    endif; ?>
                    
                    
                        <div class="b-promo">
                                <div class="b-promo__slide" style="background-image: url('<?= Yii::$app->page->getSubBlockThumbOrDef('bottom_bg','/images/why/promo.jpg') ?>');">
                                        <div class="g-grid">
                                                <div class="g-col g-col--two-third">
                                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 440 240" enable-background="new 0 0 440 240" xml:space="preserve">
                                                            <defs>
                                                                    <filter id="colorFill" x="0%" y="0%">
                                                                      <feFlood flood-color="#ffffff"/>
                                                                      <feOffset dy="0">
                                                                        <animate id="animateOnLoad"
                                                                                        begin="indefinite"
                                                                                attributeName="dy" 
                                                                                from="300" 
                                                                                to="0" 
                                                                                dur="6s"
                                                                                        values = "300;140;140;65;65;0"
                                                                                        keyTimes = "0;0.2;0.45;0.65;0.8;1"
                                                                                        fill="freeze"
                                                                                />
                                                                      </feOffset>
                                                                      <feComposite operator="in" in2="SourceGraphic"/>
                                                                      <feComposite operator="over" in2="SourceGraphic"/>
                                                                    </filter>
                                                            </defs>
                                                            <g id="svgLogo" class="svg-logo">								
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.4,237.7c-0.4-0.8-0.5-1.9,0.1-2.6c0.2-0.2,2.4-0.8,3.1-1
                                                                                c2.8-1,5.7-1.9,8.7-4.3c4.5-3.7,7-6.1,9.9-9.9c6.1-7.8,14.9-19.5,24.3-28c5.4-4.9,8.1-8.3,12.7-12.1c5.9-4.9,10.5-10.7,13.5-14.3
                                                                                c18.4-21.3,33.9-40.5,51.4-60.7c3-3.4,6.9-7.4,8.4-9.1c1.7-1.9,2.8-3.3,4.3-4.5c1.8-1.5,4-2.6,7.7-3.4c1.5-0.3,4.3-0.8,7.8,0.2
                                                                                c3.5,1,13.4,8.9,21.4,19.1c13.5,17.1,28.6,39.7,34.7,47.9c-0.1-4.1-0.8-10.7-6.2-16.3c-3.6-3.8-7-9.8-9.1-14.2
                                                                                c-4.8-10.1-6.6-20.2-7.2-26.8c-0.1-1.9,0-3.4-0.3-4.5c-1.3-0.6-3.7-1.2-5.1-1.7c-4.1-1.3-6.7-3.1-8.3-5.5
                                                                                c-4.2-6.3-2.6-11.9-0.9-15.1c2.3-4.5,7.8-9.2,13.8-16.4c3.8-4.6,5.3-10.6,5.6-16.2c0.3-7-1.5-14.2-0.9-20.6
                                                                                c0.4-4.5,2.8-10.3,5-11.6c1.6,0.3,2.6,2.2,3.4,3.9c1.3,2.9,2.6,5.5,4.4,6.9l0.7,0.6c2.9,2.4,10.4-0.1,14.2-3.3
                                                                                c4.1-3.4,6.8-6.2,11.5-9c3.2-1.9,9.7-4.7,12.7-4.6c8.5,6.8,13.2,19.7,12.3,36.8c-0.7,13.3-7.9,27.1-12.5,41.2
                                                                                c-4.3,13.2-6.6,26.6-6.6,38.8c-0.1,13.6,10.7,27.9,16.3,44c2.2,6.5,4.6,15.6,4.8,22.8c0.1,6.6-0.8,19.7-7.4,27.4
                                                                                c-9.3,10.6-24.9,12.2-37.3,7.2c-13.7-5.5-24.5-23.7-32.2-35.1c-24.7-36.6-25.2-51.5-31.3-58.7c-0.7-0.9-1.9-2.1-2.9-2.3
                                                                                c-0.8,0.2-1.6,1.3-2.4,2.2c-4.5,5.2-7.1,12.1-8.9,15.8c-1.6,3.2-4.3,7.6-7.2,10.7c-6.8,7.1-14.7,11.9-22.6,16.8
                                                                                c-12.2,7.6-23.8,14.3-32.5,21.8c-3,2.6-6.4,5.8-7.6,9.9c-0.6,2-0.6,4.2-0.5,5.8c0.2,4.4,1.9,13.3-5.9,15.4c-3.4,0.9-6-0.3-8.6-0.6
                                                                                c-1.6-0.2-3.8,0-4.7,0.1c-1.5,0.3-4.6,1.2-6.9,2.9c-3.9,2.9-8.4,7.4-13.3,10.9c-3.7,2.6-8.1,1.1-11.8,3
                                                                                C10.6,239.6,4.5,239.8,3.4,237.7L3.4,237.7z"/>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M295.4,26.7c-10.1,23-23.1,45.1-26.3,70
                                                                                c-4.5,35.6,21.7,64.4,21.1,99c-0.3,14-6.6,24.3-12.5,36.4l-3.9-2.5c6.9-14.1,14.4-27.6,11.3-44.1c-5.8-30.1-24.6-57.3-20.6-89.2
                                                                                c3.2-25.6,16.6-48.4,27-72L295.4,26.7L295.4,26.7z"/>
                                                                        <polygon fill-rule="evenodd" clip-rule="evenodd" points="315,24.2 312.7,24.2 312.6,127.3 312.6,230.5 
                                                                                314.9,230.5 317.2,230.5 317.3,127.3 317.3,24.2 	"/>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M312.6,23.1c10.2,1.2,18.8,2.2,26.9,9.2
                                                                                c10,8.7,14.3,22.6,15.7,35.3c2.3,20.1-1.5,40-9.9,58.4c-6.5,14.1-15.1,27.2-25,39.1l-15.2,16.5l-3.3-3.3l28.3-34.3
                                                                                c11.9-19,21.1-40.6,21.1-63.4c0-15.4-2.4-34.1-14.8-44.9c-7.2-6.2-14.8-7.1-23.8-8.1L312.6,23.1L312.6,23.1z"/>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M409.2,230.8l-4.6,0c-0.9-21.8-2.8-48.7-5.6-70.4l-56,70.6
                                                                                l-2.3-1.4C366.2,164.2,362.9,107,373,44.1c11.9,32.1,21.6,67.5,28.9,106.1l33-41.3l2.9,2.7l-35.2,44.7
                                                                                C405.7,179.4,408.1,207.6,409.2,230.8L409.2,230.8z M350.3,215.1l48-60.6c-6.3-32-12.8-60.9-23.2-91.8
                                                                                C367.9,116.4,364.9,171.2,350.3,215.1L350.3,215.1z"/>
                                                                        <g>
                                                                                <path d="M86.1,229.8h4.7l2.4-5.9h8.8l2.3,5.9h4.7l-11.2-27.7L86.1,229.8z M97.7,212.9l2.6,6.5H95L97.7,212.9z"/>
                                                                                <polygon points="123.4,204.4 119,204.4 119,229.8 129.8,229.8 129.8,225.3 123.4,225.3 		"/>
                                                                                <polygon points="140.5,229.8 144.8,229.8 144.8,218.2 152.2,218.2 152.2,213.7 144.8,213.7 144.8,208.9 
                                                                                        152.5,208.9 152.5,204.4 140.5,204.4 		"/>
                                                                                <path d="M171.9,202.2l-11.7,27.7h4.7l2.4-5.9h8.8l2.3,5.9h4.7L171.9,202.2z M171.8,212.9l2.6,6.5h-5.3L171.8,212.9
                                                                                        z"/>
                                                                        </g>
                                                                </g>
                                                        </svg>
                                                </div>

                                                <div class="g-co g-col--one-third">
                                                        <div class="b-promo-list__list list">
                                                                <div class="b-promo-list__item item">
                                                                        <div class="b-promo-list__inner is-slideInUp is-animated">
                                                                                <div class="b-promo-list__text">
                                                                                        <strong class="qty js-qty-clients"><?= $mainPage->getSubBlockInfo('home_ww_rank_1','name') ?></strong>
                                                                                        <?= $mainPage->getSubBlockInfo('home_ww_rank_1','description',true) ?>
                                                                                        <div class="b-promo-list__underline is-slideInRight is-animated"></div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="b-promo-list__item item">
                                                                        <div class="b-promo-list__inner is-slideInUp is-animated">
                                                                                <div class="b-promo-list__text">
                                                                                        <strong class="qty js-qty-projects"><?= $mainPage->getSubBlockInfo('home_ww_rank_2','name') ?></strong>
                                                                                        <?= $mainPage->getSubBlockInfo('home_ww_rank_2','description',true) ?>
                                                                                        <div class="b-promo-list__underline is-slideInRight is-animated"></div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="b-promo-list__item item">
                                                                        <div class="b-promo-list__inner is-slideInUp is-animated">
                                                                                <div class="b-promo-list__text">
                                                                                        <strong class="qty js-qty-employee"><?= $mainPage->getSubBlockInfo('home_ww_rank_3','name') ?></strong>
                                                                                        <?= $mainPage->getSubBlockInfo('home_ww_rank_3','description',true) ?>
                                                                                        <div class="b-promo-list__underline is-slideInRight is-animated"></div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>

                        <?= \app\helpers\ContentHelper::seoText(Yii::$app->page->seoText) ?>
                </div>
        </div>

        <div class="layer layer-1">
                <div class="page__block page__block-1 is-modifiedFadeInLeft is-animated"></div>
        </div>

        <div class="layer layer-2">
                <div class="page__block page__block-2 is-modifiedFadeInRight is-animated"></div>	
        </div>

        <div class="layer layer-3">
                <div class="page__block page__block-3 is-modifiedFadeInLeft is-animated"></div>
        </div>

        <div class="layer layer-4">
                <div class="page__block page__block-4 is-modifiedFadeInRight is-animated"></div>	
        </div>
</section>
<!-- /PAGE -->