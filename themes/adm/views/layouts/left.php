<aside class="main-sidebar">

    <section class="sidebar">

        <?php
        function akses($menu){
            $akses = \app\models\RefUserMenu::find()->where(['kd_user' => Yii::$app->user->identity->kd_user, 'menu' => $menu])->one();
            IF($akses){
                return true;
            }else{
                return false;
            }
        }
        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Dashboard', 'icon' => 'fa fa-dashboard', 'url' => ['/'],],
                    ['label' => 'Pengaturan', 'icon' => 'circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            // ['label' => 'Pengaturan Global', 'icon' => 'circle-o', 'url' => ['/management/setting'], 'visible' => akses(405)],
                            ['label' => 'User Management', 'icon' => 'circle-o', 'url' => ['/user/index'], 'visible' => akses(102)],
                            ['label' => 'Akses Grup', 'icon' => 'circle-o', 'url' => ['/management/menu'], 'visible' => akses(401)],
                            // ['label' => 'Mapping Komponen', 'icon' => 'circle-o', 'url' => ['/globalsetting/mappingkomponen'], 'visible' => akses(104)],
                            // ['label' => 'Mapping Pendapatan', 'icon' => 'circle-o', 'url' => ['/globalsetting/mappingpendapatan'], 'visible' => akses(105)],  
                            // ['label' => 'Blog/Pengumuman', 'icon' => 'circle-o', 'url' => ['/management/pengumuman'], 'visible' => akses(106)],  
                            // ['label' => 'Seleksi Rekening', 'icon' => 'circle-o', 'url' => ['/globalsetting/selection'], 'visible' => akses(107)], 
                            // ['label' => 'Program dan Kegiatan', 'icon' => 'circle-o', 'url' => ['/globalsetting/progker'], 'visible' => akses(108)],                                                        
                        ],
                    ],                    
                    ['label' => 'Parameter', 'icon' => 'circle-o','url' => '#', 'visible' => 1,'items'  =>
                        [
                            ['label' => 'Periode', 'icon' => 'circle-o', 'url' => ['/parameter/periode'], 'visible' => akses(202)],
                            ['label' => 'Bagan Akun Standar', 'icon' => 'circle-o', 'url' => ['/parameter/bas'], 'visible' => akses(204)],
                            ['label' => 'Pemda', 'icon' => 'circle-o', 'url' => ['/parameter/pemda'], 'visible' => akses(201)],
                        ],
                    ],
                    ['label' => 'Konsolidasi', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Record Eliminasi', 'icon' => 'circle-o', 'url' => ['/konsolidasi/eliminasi'], 'visible' => akses(402)],
                            ['label' => 'Data Management', 'icon' => 'circle-o', 'url' => ['/konsolidasi/rencana'], 'visible' => akses(404)],
                        ],
                    ],
                    ['label' => 'Pelaporan', 'icon' => 'fa fa-edit', 'url' => '#', 'visible' => !Yii::$app->user->isGuest, 'items' => 
                        [
                            ['label' => 'Pelaporan', 'icon' => 'circle-o', 'url' => ['/pelaporan/pelaporansekolah'], 'visible' => akses(601)],
                            ['label' => 'Pelaporan', 'icon' => 'circle-o', 'url' => ['/pelaporan/pelaporanrekap'], 'visible' => akses(602)],
                            ['label' => 'SP3B', 'icon' => 'circle-o', 'url' => ['/pelaporan/sp3b'], 'visible' => akses(604)],
                            ['label' => 'SP2B', 'icon' => 'circle-o', 'url' => ['/pelaporan/sp2b'], 'visible' => akses(605)],
                            ['label' => 'Verifikasi SPJ', 'icon' => 'circle-o', 'url' => ['/pelaporan/verpemda'], 'visible' => akses(603)],                           
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
