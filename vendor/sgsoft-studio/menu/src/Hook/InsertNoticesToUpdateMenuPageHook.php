<?php namespace WebEd\Base\Menu\Hook;

class InsertNoticesToUpdateMenuPageHook
{
    public function execute()
    {
        $currentRoute = request()->route();
        if (!$currentRoute || $currentRoute->getName() != 'admin::menus.edit.get') {
            return;
        }

        echo html()->note(trans('webed-menus::notices.refresh_menu_node_links'), 'warning');
    }
}
