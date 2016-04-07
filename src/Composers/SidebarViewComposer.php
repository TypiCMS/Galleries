<?php

namespace TypiCMS\Modules\Galleries\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('global.menus.media'), function (SidebarGroup $group) {
            $group->id = 'media';
            $group->weight = 40;
            $group->addItem(trans('galleries::global.name'), function (SidebarItem $item) {
                $item->icon = config('typicms.galleries.sidebar.icon', 'icon fa fa-fw fa-photo');
                $item->weight = config('typicms.galleries.sidebar.weight');
                $item->route('admin::index-galleries');
                $item->append('admin::create-gallery');
                $item->authorize(
                    Gate::allows('index-galleries')
                );
            });
        });
    }
}
