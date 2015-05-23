<?php

return array(
    'name'    => 'adminlte',
    'inherit' => 'default_admin', //default

    'events' => array(
        'before' => function ($theme) {
            $theme->setTitle(config('cms.core.app.site-name').' Admin Panel');

            // Breadcrumb template.
            $theme->breadcrumb()->setTemplate('
                <ol class="breadcrumb">
                @foreach ($crumbs as $i => $crumb)
                    @if ($i != (count($crumbs) - 1))
                    <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a></li>
                    @else
                    <li class="active">{{ $crumb["label"] }}</li>
                    @endif
                @endforeach
                </ol>
            ');
        },

        'asset' => function ($theme) {
            $theme->add('base', 'themes/adminlte/css/app.css');
            $theme->add('admin_lte.js', 'themes/adminlte/js/all.js');
        },

        // add dropdown-menu classes and such for the bootstrap toggle
        'beforeRenderTheme' => function ($theme) {
            Menu::handler('acp')->addClass('sidebar-menu');

            Menu::handler('acp')
                ->getAllItemLists()
                ->map(function ($itemList) {
                    if ($itemList->getParent() !== null && $itemList->hasChildren()) {
                        $itemList->getParent()->addClass('treeview');
                        $itemList->addClass('treeview-menu');
                    }

                    if ($itemList->hasActiveChild()) {
                        $itemList->addClass('active');
                    }
                });

            // add dropdown class to the li if the set has children
            Menu::handler('acp')
                ->getItemsByContentType('Menu\Items\Contents\Link')
                ->map(function ($item) {
                    if ($item->hasChildren()) {
                        $item->getValue()->addClass('header');
                        $item->getValue()->setValue('<span>'.$item->getValue()->getValue().'</span> <i class="fa fa-angle-left pull-right"></i>');
                    }

                    if (strpos(Request::url(), $item->getValue()->getUrl()) !== false) {
                        $item->getParent()->addClass('active');
                    }
                });

            // set the nav up for the sidenav
            Menu::handler('acp.config_menu')->addClass('list-group')->setElement('ul');

            Menu::handler('acp.config_menu')
                ->getItemsByContentType('Menu\Items\Contents\Link')
                ->map(function ($item) {
                    $item->addClass('list-group-item');
                });

        }
    )
);
