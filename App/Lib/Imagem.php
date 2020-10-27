<?php

namespace App\Lib;

class Imagem {

    /**
     * @var int
     */
    const PHOTO_WIDTH           = 500;
    /**
     * @var int
     */
    const ICON_WIDTH            = 200;
    /**
     * @var int
     */
    const ENCODE_TYPE_BASE64    = 1;
    /**
     * @var int
     */
    const ENCODE_TYPE_FILE      = 2;
    /**
     * @var string
     */
    const PHOTO_PATH            = 'public/arquivos/';
    /**
     * @var string
     */
    const ICON_PATH             = 'public/arquivos/icones/';

    public static function resize($image, array $options = null) {
        ini_set('memory_limit', '1024M');

        $encodeType     = $options['encodeType'] ?? self::ENCODE_TYPE_BASE64;
        $photoWidth     = $options['photoWidth'] ?? self::PHOTO_WIDTH;
        $iconWidth      = $options['iconWidth'] ?? self::ICON_WIDTH;
        $photoPath      = $options['photoPath'] ?? self::PHOTO_PATH;
        $iconPath       = $options['iconPath'] ?? self::ICON_PATH;

        if ($encodeType === self::ENCODE_TYPE_FILE) {
            $type   = $options['type'];
            $image  = file_get_contents($image);
        } elseif ($encodeType === self::ENCODE_TYPE_BASE64) {
            // $data: base64,AAAFBfj42Pj4
            list($type, $data) = explode(';', $image);
            // Isolando apenas o tipo da imagem
            // $type: image/png
            list(, $type) = explode(':', $type);
            // Isolando apenas os dados da imagem
            // $data: AAAFBfj42Pj4
            list(, $data) = explode(',', $data);
            $image = base64_decode($data);
        } else {
            throw new \Exception("Operação inválida", 500);
        }

        if (!in_array($type, ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new \Exception("Formato de arquivo não suportado.", 500);
        } else {
            $type = str_replace('e', '', explode('/', $type)[1]);
        }

        $fileName       = 'doc_' . date('YmdHisu') . hexdec(bin2hex(openssl_random_pseudo_bytes(2))) . '.' . $type;
        $image          = imagecreatefromstring($image);

        $imageWidth     = imagesx($image);
        $imageHeight    = imagesy($image);
        $photoHeight    = ($photoWidth * $imageHeight)/$imageWidth;
        $photo          = imagecreatetruecolor($photoWidth, $photoHeight);

        $ok = imagecopyresampled($photo, $image, 0, 0, 0, 0, $photoWidth, $photoHeight, $imageWidth, $imageHeight);

        $iconHeight    = ($iconWidth * $imageHeight)/$imageWidth;
        $icon          = imagecreatetruecolor($iconWidth, $iconHeight);
        $ok = imagecopyresampled($icon, $image, 0, 0, 0, 0, $iconWidth, $iconHeight, $imageWidth, $imageHeight);

        $ok = imagejpeg($photo, $photoPath . $fileName,100);
        $ok = imagejpeg($icon, $iconPath . $fileName,100);


        if (!$ok) {
            throw new \Exception("Erro ao processar imagem", 500);
        }

        return $fileName;

    }

}
