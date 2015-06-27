<?php

$PluginInfo['AddToHomescreen'] = [
    'Name' => 'AddToHomescreen',
    'Description' => '"Add to home screen" - Integration, idea by phreak',
    'Version' => '0.3',
    'Author' => 'Bleitivt',
    'License' => 'GNU GPL2',
    'SettingsUrl' => '/settings/addtohomescreen',
    'MobileFriendly' => true
];

class AddToHomescreenPlugin extends Gdn_Plugin {

    public function base_render_before($sender) {
        $sender->Head->addTag('meta', [
            'name' => 'apple-mobile-web-app-capable',
            'content' => 'yes'
        ]);
        $sender->Head->addTag('meta', [
            'name' => 'mobile-web-app-capable',
            'content' => 'yes'
        ]);
        $sender->Head->addTag('meta', [
            'name' => 'apple-mobile-web-app-title',
            'content' => c('AddToHomescreen.Title', c('Garden.HomepageTitle'))
        ]);
        $sender->addCssFile('addtohomescreen.css', 'plugins/AddToHomescreen');
        $sender->addJsFile('addtohomescreen.min.js', 'plugins/AddToHomescreen');
        $sender->Head->addString(
            '<script type="text/javascript">addToHomescreen({skipFirstVisit: true, maxDisplayCount: 1});</script>'
        );
    }

    public function settingsController_addToHomescreen_create($sender) {
        $sender->permission('Garden.Settings.Manage');
        $sender->title(T('AddToHomescreen Settings'));
        $sender->addSideMenu('dashboard/settings/plugins');
        $conf = new ConfigurationModule($sender);
        $conf->initialize([
            'AddToHomescreen.Title' => [
                'Control' => 'textbox',
                'LabelCode' => 'Mobile web app title (for iDevices)',
                'Default' => c('AddToHomescreen.Title', c('Garden.HomepageTitle'))
            ]
        ]);
        $conf->renderAll();
    }

}
