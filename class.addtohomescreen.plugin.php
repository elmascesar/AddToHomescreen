<?php if (!defined('APPLICATION')) exit();

$PluginInfo['AddToHomescreen'] = array(
    'Name' => 'AddToHomescreen',
    'Description' => '"Add to home screen" - Integration, idea by phreak',
    'Version' => '0.2',
    'Author' => 'Bleitivt',
    'SettingsUrl' => '/settings/addtohomescreen',
    'MobileFriendly' => true
);

class AddToHomescreenPlugin extends Gdn_Plugin {

    public function Base_Render_Before($Sender) {
        $Sender->Head->AddTag('meta', array(
            'name' => 'apple-mobile-web-app-capable',
            'content' => 'yes'
        ));
        $Sender->Head->AddTag('meta', array(
            'name' => 'mobile-web-app-capable',
            'content' => 'yes'
        ));
        $Sender->Head->AddTag('meta', array(
            'name' => 'apple-mobile-web-app-title',
            'content' => C('AddToHomescreen.Title', C('Garden.HomepageTitle'))
        ));
        $Sender->AddCssFile('addtohomescreen.css', 'plugins/AddToHomescreen');
        $Sender->AddJsFile('addtohomescreen.min.js', 'plugins/AddToHomescreen');
        $Sender->Head->AddString(
            '<script type="text/javascript">addToHomescreen({skipFirstVisit: true, maxDisplayCount: 1});</script>'
        );
    }

    public function SettingsController_AddToHomescreen_Create($Sender) {
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->SetData('Title', T('AddToHomescreen Settings'));
        $Sender->AddSideMenu('dashboard/settings/plugins');
        $Conf = new ConfigurationModule($Sender);
        $Conf->Initialize(array(
            'AddToHomescreen.Title' => array(
                'Control' => 'textbox',
                'LabelCode' => 'Mobile web app title (for iDevices)',
                'Default' => C('AddToHomescreen.Title', C('Garden.HomepageTitle'))
            )
        ));
        $Conf->RenderAll();
    }

}
