<?php
namespace Craft;

/**
 * Fruit Aviary Image Editor controller
 */
class FruitAviaryImageEditorController extends BaseController
{
	protected $allowAnonymous = false;
    protected $plugin;
    protected $pluginHandle;

    public function __construct()
    {
        $this->plugin = craft()->plugins->getPlugin('fruitaviaryimageeditor');
        //$this->pluginHandle = $this->plugin->_getPluginHandle();
    }

	public function actionSaveImage()
	{

		$folderId = craft()->request->getPost('folderId');
		$fileName = craft()->request->getPost('fileName');
		$aviaryPath = craft()->request->getPost('aviaryPath');
		$imageOverwrite = craft()->request->getPost('imageOverwrite') ? true : false;
		
		if(craft()->fruitAviaryImageEditor->saveImage($folderId, $fileName, $aviaryPath, $imageOverwrite))
		{
			$this->returnJson(array(
				'success' => true, 
				'imageOverwrite' => $imageOverwrite
			));
		}
		else
		{
			$this->returnJson(array('success' => false));
		}
	}
}