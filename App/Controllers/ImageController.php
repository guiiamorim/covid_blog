<?php


namespace App\Controllers;

use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{
	public function store()
	{
		try {
			if (!empty($_FILES['image'])) {
				$ext = explode('.', $_FILES['image']['name']);
				$fileName = 'image_' . date('YmdHisu') . hexdec(bin2hex(openssl_random_pseudo_bytes(2))) . '.' .
					array_pop($ext);
				$img = Image::make($_FILES['image']['tmp_name'])->widen(800, function ($constraint) {
					$constraint->upsize();
				})->save("public/img/posts/{$fileName}");
				
				http_response_code(200);
				echo json_encode(['location' => $img->basePath(), 'size' => $img->filesize()]);
				
				return true;
			}
			
			http_response_code(500);
			echo "Erro";
		} catch (\Exception $e) {
			http_response_code(500);
			echo $e->getMessage();
		}
	}
	
	public function delete()
	{
		try {
			if (!empty($_POST['image'])) {
				unlink($_POST['image']);
				
				http_response_code(200);
				return true;
			}
			
			http_response_code(500);
			echo "Erro";
		} catch (\Exception $e) {
			http_response_code(500);
			echo $e->getMessage();
		}
	}
}