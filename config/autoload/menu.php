<?php
declare(strict_types = 1);

return [
    // 文章菜单
    [
        'id'        => 1,
        'path'      => '/article',
        'component' => 'Layout',
        'name'      => '文章管理',
        'icon'      => 'el-icon-s-help',
        'is_button' => false,
        'children'  => [
            [
                'id'        => 2,
                'path'      => 'category',
                'component' => '/views/cms/article/category/index',
                'name'      => '文章分类',
                'icon'      => 'table',
                'is_button' => false,
                'children'  => [
                    [
                        'id'        => 3,
                        'path'      => 'list',
                        'component' => '/views/cms/article/category/list',
                        'name'      => '分类列表',
                        'icon'      => 'table',
                        'is_button' => false,
                    ],
                    [
                        'id'        => 4,
                        'path'      => 'add/:uuid?',
                        'component' => '/views/cms/article/category/add',
                        'name'      => '添加分类',
                        'icon'      => 'table',
                        'is_button' => false,
                    ],
                    [
                        'id'        => 5,
                        'path'      => 'add/:uuid?',
                        'component' => '/views/cms/article/category/add',
                        'name'      => '编辑分类',
                        'icon'      => 'table',
                        'is_button' => false,
                    ],
                    [
                        'id'        => 6,
                        'path'      => 'del',
                        'component' => '',
                        'name'      => '删除分类',
                        'icon'      => 'table',
                        'is_button' => true,
                    ],
                ]
            ]
        ]
    ]
];