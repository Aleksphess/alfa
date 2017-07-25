<?php
//use Yii;
use yii\helpers\Url;

$this->title = $post->info->title;
$this->registerMetaTag([
    'property' => 'og:type',
    'content' => "website"
],'og_type');
$this->registerMetaTag([
    'property' => 'og:url',
    'content' => Yii::$app->request->getAbsoluteUrl()
],'og_url');
$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $post->info->title
],'og_title');
$this->registerMetaTag([
    'property' => 'og:description',
    'content' => strip_tags($post->info->description)
],'og_description');
$this->registerMetaTag([
    'property' => 'og:image',
    'content' => trim(Url::to(['/'],true),'/').($post->thumbPath ? $post->thumbPath : "/images/shedule/b-1.jpg")
],'og_image');
?>
<!-- PAGE -->
<section id="page" class="page page__post">

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
                        <a href="<?= Url::to(['/blog']) ?>" class="breadcrumbs__link" itemprop="url">
                            <span itemprop="title"><?= Yii::t('app','blog') ?></span>
                        </a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?= $post->info->title ?>
                    </li>
                </ol>
        </div>
        <!-- /breadcrumbs -->

        <h1 class="page__title title">
                <div class="title__inner is-slideInUp is-animated">
                        <div class="title__text">
                                <?= $post->info->title ?>
                                <div class="title__underline is-slideInLeft is-animated"></div>
                        </div>
                </div>
        </h1>
                
                
                <div class="page__content">
                        <div class="b-post">
                            <?= $post->info->text ?>
                        </div>
                        <h3 class="g-title title">
                                <div class="title__inner is-slideInUp is-animated slideInUp animated">
                                        <div class="title__text">
                                                <?= Yii::t('app','other_posts') ?>
                                                <div class="title__underline is-slideInLeft is-animated slideInLeft animated"></div>
                                        </div>
                                </div>
                        </h3>
                        <div class="b-posts-review__wrapper b-posts__carousel">
                                <div class="js-posts-review-carousel">
                                    
                                    <?php
                                    foreach ($lastPosts as $post): ?>
                                    <a href="<?= $post->url ?>" class="banner__readmore">
                                            <div class="b-post-review">

                                                <div class="b-post-review__inner">

                                                     <div class="b-post-review__content">
                                                                        <div class="b-post-review__title">
                                                                            <span class="is-animated is-slideInUp"><?= $post->info->title ?></span>
                                                                        </div>
                                                    <div class="divider">
                                                        <span class="divider__line is-animated is-fadeIn"></span>
                                                    </div>
                                                    <div class="b-post-review__desc">
                                                        <span class="is-animated is-slideInUp"><?= $post->info->description ?></span>
                                                    </div>
                                                    <div class="divider divider--hiding">
                                                        <span class="divider__line is-animated is-fadeIn"></span>
                                                    </div>
                                                    <div class="b-post-review__date">
                                                        <span class="is-animated is-slideInUp"><?= $post->getPubDate() ?></span>
                                                    </div>
                                                    <div class="b-post-review__action">
                                                        <?= Yii::t('app','read_more') ?>
                                                    </div>
                                            </div>
                                            <div class="b-post-review__img is-animated is-fadeIn">
                                                <img src="<?= $post->thumbPath ?>" alt="<?= $post->info->title ?>">
                                            </div>
                                                     </div>

                        </div>
                                    </a>
                    <?php
                    endforeach; ?>

                                </div>
                        </div>

                        <div class="action-block">
                                <div class="action-block__item action-block__item--centered is-fadeInDown is-animated">
                                        <a href="" class="btn btn--colored" data-modal="subscribeForm"><?= Yii::t('app','subscribe_blog') ?>!</a>
                                </div>
                        </div>
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

        <div class="layer layer-5">
                <div class="page__block page__block-5 is-modifiedFadeInRight is-animated"></div>	
        </div>
</section>
<!-- /PAGE -->