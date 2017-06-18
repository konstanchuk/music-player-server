<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Music', 'icon' => 'share', 'url' => '#',
                        'items' => [
                            ['label' => 'Genre', 'url' => ['/music/genre'],],
                            ['label' => 'List', 'url' => ['/music/list'],],
                        ],
                    ],
                    ['label' => 'System', 'icon' => 'share',
                        'items' => [
                            [
                                'label' => Yii::t('language', 'Language'),
                                'icon' => 'share',
                                'url' => '#',
                                'items' => [
                                    ['label' => Yii::t('language', 'List of languages'), 'url' => ['/translatemanager/language/list']],
                                    ['label' => Yii::t('language', 'Scan'), 'url' => ['/translatemanager/language/scann']],
                                    ['label' => Yii::t('language', 'Optimize'), 'url' => ['/translatemanager/language/optimizer']],
                                ],
                            ],
                            [
                                'label' => Yii::t('language', 'Users'), 'url' => ['/user/admin/index'],
                            ],
                            [
                                'label' => 'Settings',
                                'url' => ['/settings']
                            ],
                        ]
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Developer tools', 'icon' => 'share', 'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
