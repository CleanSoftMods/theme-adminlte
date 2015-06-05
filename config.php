<?php

return [
    'name'    => 'adminlte',
    'inherit' => 'default', //default

    'events' => [
        'before' => function ($theme) {
            $theme->setTitle(config('cms.core.app.site-name').' Admin Panel');

            // Breadcrumb template.
            $theme->breadcrumb()->setTemplate(
                '<ol class="breadcrumb">
                @foreach ($crumbs as $i => $crumb)
                    @if ($i != (count($crumbs) - 1))
                    <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a></li>
                    @else
                    <li class="active">{{ $crumb["label"] }}</li>
                    @endif
                @endforeach
                </ol>'
            );
        },

        'asset' => function ($theme) {
            $themeName = config('cms.core.app.themes.backend');
            $theme->add('css', 'themes/'.$themeName.'/css/app.css');
            $theme->add('js', 'themes/'.$themeName.'/js/all.js');
        },

        // add dropdown-menu classes and such for the bootstrap toggle
        'beforeRenderTheme' => function ($theme) {
            Menu::handler('backend_sidebar')->addClass('sidebar-menu');

            Menu::handler('backend_sidebar')
                ->getAllItemLists()
                ->map(function ($itemList) {
                    if ($itemList->getParent() !== null && $itemList->hasChildren()) {
                        $itemList->getParent()->addClass('treeview');
                        $itemList->addClass('treeview-menu');
                    }
                });

            // add dropdown class to the li if the set has children
            Menu::handler('backend_sidebar')
                ->getItemsByContentType('Menu\Items\Contents\Link')
                ->map(function ($item) {
                    if ($item->hasChildren()) {
                        $item->getValue()->addClass('header');
                        $item->getValue()->setValue('<span>'.$item->getValue()->getValue().'</span> <i class="fa fa-angle-left pull-right"></i>');
                    }
                });

            // grab the inline navs
            $menuKeys = [];
            foreach (get_array_column(config('cms'), 'menus') as $module => $menus) {
                $menuKeys = array_merge($menuKeys, array_keys($menus));
            }
            $menuKeys = array_unique($menuKeys);
            $menuKeys = array_filter($menuKeys, function ($name) {
                return preg_match('/backend_([^_]+)_menu/', $name);
            });

            foreach ($menuKeys as $key) {
                Menu::handler($key)->addClass('nav nav-list');
            }
        }
    ]
];
