<?php
if (is_file("../../../init.php")){
    require_once("../../../init.php");
}
else {
    require_once(ROOTDIR . "/init.php");
}

require_once(ROOTDIR . "/modules/addons/whmcms/vendor/autoload.php");

use \WHMCMS\Base as WHMCMS;
use \WHMCMS\Database\Capsule;

/**
 * Usage
 *
 * @param   $src    image_full_name.jpg/png/gif
 * @param   $w      Width of image:
 *                  ($w > 0) image will be resized to this width,
 *                  ($w == 0) image will be resized using settings default width,
 *                  ($w == -1) Real image will displayed
 * 
 *
 */


# Image File Name
$fileName = WHMCMS::fromGet("src");

# User Defined Width
$thumbWidth = WHMCMS::fromGet("w", "int");

# User Defined Height
$thumbHeight = WHMCMS::fromGet("h", "int");

# Source Directory
if (WHMCMS::getConfig("UploadDirectory") === "custom" && is_dir(WHMCMS::getConfig("UploadCustomDirectory")) && is_writable(WHMCMS::getConfig("UploadCustomDirectory"))){
    $sourceDir = rtrim(rtrim(WHMCMS::getConfig("UploadCustomDirectory"), "\\"), "/") . "/";
}
else {
    $sourceDir = rtrim(rtrim($attachments_dir, "\\"), "/") . "/";
}

# Target Directory
$targetDir = rtrim(rtrim($templates_compiledir, "\\"), "/") . "/";

# Enable Cache
if (WHMCMS::getConfig("UploadEnableCache") === "yes"){
    $enableCache = true;
}
else {
    $enableCache = false;
}

# Apply Default Width
if ($thumbWidth === 0 && WHMCMS::getConfig("UploadResizeWidth", "int") > 0){
    $thumbWidth = WHMCMS::getConfig("UploadResizeWidth", "int");
}

# Cache Period (Number of Hours)
$cachePeriod = WHMCMS::getConfig("UploadCachePeriod", "int");


# Image Types
$imageTypes = [
    "image/gif" => [
            "mimetype" => "image/gif",
            "ext" => "gif"
    ],
    "image/jpg" => [
            "mimetype" => "image/jpg",
            "ext" => "jpg"
    ],
    "image/jpeg" => [
            "mimetype" => "image/jpg",
            "ext" => "jpg"
    ],
    "image/png" => [
            "mimetype" => "image/png",
            "ext" => "png"
    ],
    "image/svg+xml" => [
            "mimetype" => "image/svg+xml",
            "ext" => "svg"
    ],
];

# Source File Path
$sourceFilePath = rtrim($sourceDir, "/") . "/" . $fileName;

# Validate Source Directory
if (!is_dir($sourceDir) || !is_readable($sourceDir)){
    die("Source directory not readable or does not exist!");
}

# Validate Target Directory
if (!is_dir($targetDir) || !is_writable($targetDir)){
    die("Target directory not writable or does not exist!");
}


# Check the filename is safe & check file type
if (preg_match('#^[a-z0-9-_\.]+\.(jpg|jpeg|png|svg)$#i', $fileName, $matches) && strpos($fileName, '..') === false) {
    $imageName = $matches[0];
    $imageExt = $matches[1];
    $imageRealName = str_replace("." . $imageExt, "", $imageName);
}
else {
    die("Invalid filename: " . $fileName);
}

# Check the original file exists
if (is_file($sourceFilePath) === false) {
    die("File doesn't exist");
}

# Get the current size & file type
list($sourceWidth, $sourceHeight, $sourceMimeType) = getimagesize($sourceFilePath);

# Get File MimeType
# "mime_content_type" is deprecated in specific PHP versions
# for this we use alternative function "finfo_file"
if (function_exists("mime_content_type")){
    $sourceMimeType = mime_content_type($sourceFilePath);
}
else {
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE); 
    $sourceMimeType = finfo_file($fileInfo, $sourceFilePath); 
    finfo_close($fileInfo);
}


# Width Were not provided, or Image is SVG display the original image
if ($thumbWidth<=0 || $sourceMimeType==="image/svg+xml"){
    
    header('Content-Type: ' . $imageTypes[ $sourceMimeType ]['mimetype']);
    
    readfile($sourceFilePath);
    
    exit;
    
}

# Calculate height automatically if not given
if ($thumbHeight === 0) {
    $thumbHeight = round($sourceHeight * $thumbWidth / $sourceWidth);
}

############################################
# If Target File Does not Exist, Create it

# Load the image
switch ($sourceMimeType) {
    case "image/gif":
    $sourceImage = imagecreatefromgif($sourceFilePath);
    break;
    
    case "image/jpg":
    case "image/jpeg":
    $sourceImage = imagecreatefromjpeg($sourceFilePath);
    break;
    
    case "image/png":
    $sourceImage = imagecreatefrompng($sourceFilePath);
    break;
    
    default:
    die("Invalid image type (#" . $sourceMimeType . " = " . image_type_to_extension($sourceMimeType) . ")");
}

# Get Aspect Ratios
$sourceAspectRatio = $sourceWidth / $sourceHeight;
$thumbAspectRatio = $thumbWidth / $thumbHeight;

# Calculate Thumbnail Dims.
if ($sourceWidth <= $thumbWidth && $sourceHeight <= $thumbHeight) {
    $thumbWidth = $sourceWidth;
    $thumbHeight = $sourceHeight;
}
elseif ($thumbAspectRatio > $sourceAspectRatio) {
    $thumbWidth = (int) ($thumbHeight * $sourceAspectRatio);
    $thumbHeight = $thumbHeight;
}
else {
    $thumbWidth = $thumbWidth;
    $thumbHeight = (int) ($thumbWidth / $sourceAspectRatio);
}

# Target File Name
$targetFileName = $imageRealName . "_w" . $thumbWidth . "_h" . $thumbHeight . "." . $imageTypes[ $sourceMimeType ]['ext'];

# Target File Path
$targetFilePath = rtrim($targetDir, "/") . "/" . $targetFileName;

## Cache
# If Target File Already Exist, Load it
if (is_file($targetFilePath) && is_readable($targetFilePath) && $enableCache===true){
    
    $targetFileDate = date("Y-m-d H:i", filemtime($targetFilePath));
    $targetFileDate = date("YmdHi", strtotime($targetFileDate . " + " . $cachePeriod . " hour"));
    
    $currentDate = date("YmdHi");
    
    # Cache Period Still Valid
    if ($currentDate < $targetFileDate){
        
        header('Content-Type: ' . $imageTypes[ $sourceMimeType ]['mimetype']);
        
        readfile($targetFilePath);
        
        exit;
        
    }
    
}

$thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $sourceWidth, $sourceHeight);


# Save the new image
switch ($sourceMimeType){
    case "image/gif":
    imagegif($thumbImage, $targetFilePath);
    break;
    
    case "image/jpg":
    case "image/jpeg":
    imagejpeg($thumbImage, $targetFilePath, 100);
    break;
    
    case "image/png":
    imagepng($thumbImage, $targetFilePath);
    break;
    
    default:
    die("Invalid file type!");
}

# Close the files
imagedestroy($sourceImage);
imagedestroy($thumbImage);

# Send the file header
header('Content-Type: ' . $imageTypes[ $sourceMimeType ]['mimetype']);


# Send the file to the browser
readfile($targetFilePath);