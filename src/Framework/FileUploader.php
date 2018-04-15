<?php

namespace Framework;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function uploadFiles(FileBag $files, $targetDirectory)
    {
        $filePaths = [];

        foreach ($files as $file) {
            $filePaths[] = $this->upload($file, $targetDirectory);
        }

        return $filePaths;
    }

    protected function upload(UploadedFile $file, $targetDirectory)
    {
		$fileName = md5(uniqid()).'.'.$file->guessExtension();

		$file->move($targetDirectory, $fileName);

		return $targetDirectory.$fileName;
    }
}
