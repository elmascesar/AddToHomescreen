<?php if (!defined('APPLICATION')) exit();

$PluginInfo['AddToHomescreen'] = array(
    'Name' => 'AddToHomescreen',
    'Description' => '"Add to home screen" - Integration, idea by phreak',
    'Version' => '0.1',
    'Author' => 'Bleitivt',
    'SettingsUrl' => '/settings/addtohomescreen',
    'MobileFriendly' => true
);

class AddToHomescreenPlugin extends Gdn_Plugin {

    public function Base_Render_Before($Sender) {
        if (!C('AddToHomescreen.Image') || !$Sender->Head) {
            return;
        }
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
        $Image = Gdn_Upload::Url(C('AddToHomescreen.Image'));
        $Sender->Head->AddTag('link', array(
            'rel' => 'apple-touch-icon-precomposed',
            'href' => $Image
        ));
        $Sender->Head->AddTag('link', array(
            'rel' => 'icon',
            'sizes' => '196x196',
            'href' => $Image
        ));
        $Sender->AddCssFile('addtohomescreen.css', 'plugins/AddToHomescreen');
        $Sender->AddJsFile('addtohomescreen.min.js', 'plugins/AddToHomescreen');
        $Sender->Head->AddString(
            '<script type="text/javascript">addToHomescreen();</script>'
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
                'LabelCode' => 'Title',
                'Default' => C('AddToHomescreen.Title', C('Garden.HomepageTitle'))
            ),
            'AddToHomescreen.Image' => array(
                'Control' => 'imageupload',
                'LabelCode' => T('The touch icon to be shown on the home screen')
            )
        ));
        $Conf->RenderAll();
    }

}
