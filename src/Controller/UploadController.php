<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\FileUploader;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Controller\ReceiptController;
use mysqli;

class UploadController extends AbstractController
{
    /**
     * @Route("/upload-index", name="upload_receipt_index")
     */
    public function index(): Response
    {
        return $this->render('upload/up_receipt.html.twig', [
        ]);
    }

    /**
     * @Route("/upload-receipt", name="upload_receipt")
     * @param Request $request
     * @param string $uploadDir
     * @param FileUploader $uploader
     * @param LoggerInterface $logger
     * @return Response
     */
    //  $uploadDir est defini dans *config/service.yaml
    public function uploadReceipt(Request $request, string $uploadDir,
        FileUploader $uploader, LoggerInterface $logger): Response {
        $token = $request->get("token");
        
        if (!$this->isCsrfTokenValid('upload', $token)) {
            $logger->info("CSRF failure");

            return $this->render('upload/up_receipt.html.twig', [
                'message' => "Operation not allowed", 
                'content-type' => 'text/plain'
            ]);  
        }

        $file = $request->files->get('myfile');

        if (empty($file)) {
            return $this->render('upload/up_receipt.html.twig', [
                'message' => "No file specified", 
                'content-type' => 'text/plain'
            ]);   
        }

        $filename = $file->getClientOriginalName();
        $uploader->upReceipt($file, $filename);
        $path = $uploadDir . "/receipts/" . $filename;

        $controller = new ReceiptController();
        $controller->up($path, $request);
        

        return $this->render('upload/up_receipt.html.twig', [
            'message' => "File uploaded", 
            'content-type' => 'text/plain',
            'file' => $path,
        ]);
    }

    public function uploadManual(Request $request, string $uploadDir,
    FileUploader $uploader, LoggerInterface $logger): Response {
    $token = $request->get("token");
    
    if (!$this->isCsrfTokenValid('upload', $token)) {
        $logger->info("CSRF failure");

        return $this->render('upload/index.html.twig', [
            'message' => "Operation not allowed", 
            'content-type' => 'text/plain'
        ]);  
    }

    $file = $request->files->get('myfile');

    if (empty($file)) {
        return $this->render('upload/index.html.twig', [
            'message' => "No file specified", 
            'content-type' => 'text/plain'
    ]);   
    }

    $filename = $file->getClientOriginalName();
    $uploader->upManual($file, $filename);

    return $this->render('upload/index.html.twig', [
        'message' => "File uploaded", 
        'content-type' => 'text/plain',
        'file' => $uploadDir . "/manuals/" . $filename,
    ]);
}
}
