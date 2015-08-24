<?php
namespace Craft;

class FruitAviaryImageEditor_EditImageElementAction extends BaseElementAction
{
	public function getName()
	{
		return Craft::t('Edit image');
	}

	public function getTriggerHtml()
	{
		$settings = craft()->plugins->getPlugin('fruitAviaryImageEditor')->getSettings();
        if($settings['aviaryTheme'] == 'minimum')
        {
            craft()->templates->includeCssResource('fruitaviaryimageeditor/css/craft.css');
        }
		$fileExtensions = craft()->config->get('fileExtensions', 'fruitaviaryimageeditor');
		$fileExtensionsJSArray = '[\''.implode ("', '", $fileExtensions).'\']';

		$js = <<<EOT
(function()
{

	var trigger = new Craft.ElementActionTrigger({
		handle: '{$this->classHandle}',
		batch: false,
		validateSelection: function(\$selectedItems)
		{
			var \$element = \$selectedItems.find('.element'),
			fileExtension = \$element.data('url').split('.').pop().toLowerCase();

			if('{$settings['aviaryApiKey']}' == '')
			{
				return false;
			}
			if(\$.inArray(fileExtension, {$fileExtensionsJSArray}) != -1)
			{
				return true;
			}
			else
			{
				return false;
			}
		},
		activate: function(\$selectedItems)
		{
			var \$element = \$selectedItems.find('.element'),
				id = \$element.data('id'),
				uid = 'fruitImageEdit' + id,
				url = \$element.data('url');
		
			var img = \$('<img style="display: none;" id="' + uid + '">');
			img.attr('src', url);
			img.appendTo('body');

			var options = {
				onClose: function() { 
					$('#' + uid ).remove();
				},
				onSave: function(imageID, newURL) {
					var data = {
						folderId: Craft.elementIndex.\$source.data('key').split(':')[1],
						fileName: \$element.data('url').split('/').pop(),
						aviaryPath: newURL,
						imageOverwrite: '{$settings['imageOverwrite']}'
					};
					Craft.postActionRequest('fruitAviaryImageEditor/saveImage', data, function(response){

						if(response.success)
						{
							Craft.elementIndex.updateElements();
							Fruit.featherEditor.close();
							if(response.imageOverwrite)
							{
								location.reload(true); // To Do : Must be a better way to update the image thumbnail.
							}						
						}
						else
						{
							console.log('saveAsset Failed');
						}
					});
					
				},
			}
			Fruit.launchEditor(uid, url, options);
		}
	});
})();
EOT;
		craft()->templates->includeJs($js);
	}
}