<?php
namespace Craft;

class FruitAviaryImageEditor_SettingsModel extends BaseModel
{
	protected function defineAttributes()
	{
        return array(
            'aviaryApiKey' => array(AttributeType::String, 'required' => true),
            'enableCORS' => array(AttributeType::String, 'default' => false),
            'imageOverwrite' => array(AttributeType::String, 'default' => false),
            'aviaryTools' => AttributeType::Mixed,
            'aviaryTheme' => array(AttributeType::String, 'default' => 'minimum')
        );
	}
}