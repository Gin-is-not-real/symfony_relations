<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;

class FileUploader
{
    private $logger;
    private $uploadDir;

    public function __construct(LoggerInterface $logger, string $uploadDir)
    {
        $this->logger = $logger;
        $this->uploadDir = $uploadDir;
    }

    // public function upload($file, $filename)
    // {
    //     try {
    //         $file->move($this->uploadDir, $filename);
            
    //     } catch (FileException $e){

    //         $this->logger->error('failed to upload image: ' . $e->getMessage());
    //         throw new FileException('Failed to upload file');
    //     }
    // }

    public function upReceipt($file, $filename)
    {
        $dir = $this->uploadDir  . '/receipts';
        try {
            $file->move($dir , $filename);
            
        } catch (FileException $e){

            $this->logger->error('failed to upload receipt: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }
    }

    public function upManual($file, $filename)
    {
        $dir = $this->uploadDir  . '/manuals';
        try {
            $file->move($dir , $filename);
            
        } catch (FileException $e){

            $this->logger->error('failed to upload manual: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }
    }
}