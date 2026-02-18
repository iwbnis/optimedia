<?php

namespace WHMCMS;

use Illuminate\Support\Str;
use \WHMCMS\Base as WHMCMS;

class Upload {

    /**
     *
     * @params  array   $args = [
     *                      "file" => $_FILES["file-to-upload"]
     *                      "width" => (optional)(integer) maximum width allowed
     *                      "height" => (optional)(integer) maximum height allowed
     *                      "newfilename" => (optional)(string) new file name
     *                  ];
     *
     */
    public static function uploadImage($args = []){

        if (isset($args['file']['error']) && $args['file']['error'] > 0) {
            return ["result" => "error", "message" => "unkown error"];
        }

        $allowedTypes = [
            'image/jpeg' => 'jpeg',
            'image/jpg' => 'jpg',
            'image/gif' => 'gif',
            'image/png' => 'png'
        ];

        $imageData = !isset($args['file']['tmp_name']) ?: getimagesize($args['file']['tmp_name']);

        $settings = [
            "ImageWidth" => !isset($imageData[0]) ?: intval($imageData[0]),
            "ImageHeight" => !isset($imageData[1]) ?: intval($imageData[1]),
            "MaxWidth" => intval($args['width'] ?? 0),
            "MaxHeight" => intval($args['height'] ?? 0)
        ];

        if ($imageData === false){
            return ["result" => "error", "message" => "Invalid file type!"];
        }

        if (!isset($allowedTypes[ $imageData['mime'] ])){
            return ["result" => "error", "message" => "Invalid file type!"];
        }

        if ($settings['MaxWidth'] > 0 && $settings['ImageWidth'] > $settings['MaxWidth']){
            return ["result" => "error", "message" => sprintf("The image width (%d) is higher than the allowed width (%d)", $settings['ImageWidth'], $settings['MaxWidth'])];
        }

        if ($settings['MaxHeight'] > 0 && $settings['ImageHeight'] > $settings['MaxHeight']){
            return ["result" => "error", "message" => sprintf("The image height (%d) is higher than the allowed height (%d)", $settings['ImageHeight'], $settings['MaxHeight'])];
        }

        $newFileName = "WHMCMS_" . time() . "_" . rand(20, 40) . "." . $allowedTypes[ $imageData['mime'] ];

        if (WHMCMS::fromInput($args['newfilename']) !== ""){

            $newFileName = $args['newfilename'];

            foreach ($allowedTypes as $mime => $ext){
                $newFileName = str_ireplace("." . $ext, "", $newFileName);
            }

            $newFileName .= $allowedTypes[ $imageData['mime'] ];

        }


        if (move_uploaded_file($args['file']['tmp_name'], self::getUploadFolder() . $newFileName)) {
            return ["result" => "success", "filename" => $newFileName];
        }
        else {
            return ["result" => "error", "message" => $args['file']['name']];
        }

        return ["result" => "error", "message" => "unkown error"];

    }

    private static function getUploadFolder(){

        global $attachments_dir;

        # Source Directory
        if (WHMCMS::getConfig("UploadDirectory") == "custom" && is_dir(WHMCMS::getConfig("UploadCustomDirectory")) && is_writable(WHMCMS::getConfig("UploadCustomDirectory"))){
            return rtrim(rtrim(WHMCMS::getConfig("UploadCustomDirectory"), "\\"), "/") . "/";
        }

        return rtrim(rtrim($attachments_dir, "\\"), "/") . "/";

    }

    public static function uploadVideo($inputName)
    {
        // Check if a file was selected
        if (isset($_FILES[$inputName]) && strlen($_FILES[$inputName]['name']) > 0) {
            $fileName = Str::random(10) . '_' . basename($_FILES[$inputName]["name"]);
            $targetFile = ROOTDIR . '/videos/' . $fileName;
            $uploadOk = true;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file is an MP4 video
            if ($fileType != "mp4") {
                return [
                    "result" => "error",
                    "message" => "Only MP4 files are allowed.",
                ];
            }

            // Check if the file already exists
            if (file_exists($targetFile)) {
                return [
                    "result" => "error",
                    "message" => "File already exists.",
                ];
            }

            // Check file size (adjust the limit as needed)
            if ($_FILES[$inputName]["size"] > 100000000) {
                return [
                    "result" => "error",
                    "message" => "File is too large. Max size is 100MB.",
                ];
            }

            // Move the uploaded file to the target directory if all checks pass
            if ($uploadOk) {
                if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
                    return [
                        "result" => "success",
                        "file" => $fileName,
                    ];
                } else {
                    return [
                        "result" => "error",
                        "message" => "Error uploading the file.",
                    ];
                }
            }
        }

        return false;
    }

}

