<?php
namespace Craft;

class FruitAviaryImageEditorService extends BaseApplicationComponent
{
    public function saveImage($folderId, $fileName, $aviaryPath, $imageOverwrite)
    {

		$folder = craft()->assets->getFolderById($folderId);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $aviaryPath);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$newImageData = curl_exec($ch);
		curl_close($ch);

		$tempPath = craft()->path->getTempPath();
		IOHelper::writeToFile($tempPath.$fileName, $newImageData);
		$success = craft()->assets->insertFileByLocalPath($tempPath.$fileName, $fileName, $folderId, $imageOverwrite);

		$this->deleteTempFiles($fileName);

		return $success;
    }

    private function deleteTempFiles($fileName){

    	$tempPath = craft()->path->getTempPath();
		IOHelper::deleteFile($tempPath.$fileName, true);
		$info = pathinfo($fileName);
		$fileNameNoExtension = $info['filename'];
		$ext  = $info['extension'];
		IOHelper::deleteFile($tempPath.$fileNameNoExtension.'-temp.'.$ext, true);
    }
}
