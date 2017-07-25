<?php
use yii\helpers\Url;

$this->title = $tag->info->name;
?>
<!-- PAGE -->
<section id="page" class="page page__bt">

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
                        <a href="<?= Url::to(['/equipment']) ?>" class="breadcrumbs__link" itemprop="url">
                            <span itemprop="title"><?= Yii::t('app','equipment_and_furniture') ?></span>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?= $tag->info->name ?>
                    </li>
                </ol>
        </div>
        <!-- /breadcrumbs -->


                <!-- filter one-column -->
                <div class="filter is-fadeInDown is-animated">
                        <div class="filter is-fadeInDown is-animated">
                       <?= $this->render('_filter',[
                            'tags' => $tags,
                            'brands' => $brands,
                            'category' => false
                        ]) ?>
                        </div>
                </div>
               <!-- /filter one-column -->
               
        <h1 class="page__title title">
                <div class="title__inner is-slideInUp is-animated">
                        <div class="title__text">
                                <?= $tag->info->name ?>
                                <div class="title__underline is-slideInLeft is-animated"></div>
                        </div>
                </div>
        </h1> 
               
                <!-- Filtered items -->
                <!--div class="b-filtered is-fadeInDown is-animated">
                        <ul class="b-filtered__list">
                                <li class="b-filtered__item">
                                        <a href="<?= Url::to(['/equipment']) ?>" class="b-filtered__link"><?= $tag->info->name ?></a>
                                </li>
                        </ul>
                </div-->
                <!-- /Filtered items -->
                
                <?php
                if ($products) : ?>
                    <div class="b-products">
                        <ul class="b-products__list">
                            
                            <?php
                            foreach ($products as $product) : ?>

                                <li class="b-products__item is-fadeIn is-animated">
                                    <a href="<?= $product->equipmentUrl ?>" class="b-products__inner">
                                        <span class="b-products__title"><?= $product->info->name ?></span>
                                        <span class="b-products__photo">
                                        <img src="<?= $product->thumbPath ?>" alt="">
                                    </span>
                                        <span class="b-products__desc"><?= $product->info->sub_title ?></span>
                                    </a>
                                </li>

                            <?php
                            endforeach; ?>
                                
                        </ul>
                </div>
                <?php
                endif; ?>
                
                
        </div>

        <div class="layer layer-1">
                <div class="page__block page__block-1 is-modifiedFadeInLeft is-animated"></div>
        </div>

        <div class="layer layer-2">
                <div class="page__block page__block-2 is-modifiedFadeInRight is-animated"></div>	
        </div>
</section>
<!-- /PAGE -->