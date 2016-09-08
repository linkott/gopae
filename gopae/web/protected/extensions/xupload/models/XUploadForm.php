<?php

class XUploadForm extends CFormModel {

    public $file;
    public $mime_type;
    public $size;
    public $name;
    public $filename;

    /**
     * @var boolean dictates whether to use sha1 to hash the file names
     * along with time and the user id to make it much harder for malicious users
     * to attempt to delete another user's file
     */
    public $secureFileNames = false;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('file', 'file'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'file' => 'Upload files',
        );
    }

    public function getReadableFileSize($retstring = null) {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($retstring === null) {
            $retstring = '%01.2f %s';
        }

        $lastsizestring = end($sizes);

        foreach ($sizes as $sizestring) {
            if ($this->size < 1024) {
                break;
            }
            if ($sizestring != $lastsizestring) {
                $this->size /= 1024;
            }
        }
        if ($sizestring == $sizes[0]) {
            $retstring = '%01d %s';
        } // Bytes aren't normally fractional
        return sprintf($retstring, $this->size, $sizestring);
    }

    /**
     * A stub to allow overrides of thumbnails returned
     * @since 0.5
     * @author acorncom
     * @return string thumbnail name (if blank, thumbnail won't display)
     */
    public function getThumbnailUrl($publicPath) {
        /* $thumb = Yii::app()->thumb;
          $thumb->image = "/var/www/escolar/web" . $publicPath . $this->filename;
          $thumb->directory = "/var/www/escolar/web/uploads/thumbs/";
          //$thumb->square = true;
          $thumb->createThumb();
          $thumb->save($this->filename);
         * 
         */
        Yii::app()->setComponents(array('ThumbsGen' => array(
                'class' => 'ext.ThumbsGen.ThumbsGen',
                'scaleResize' => null, //if it is not null $thumbWidth and $thumbHeight will be ommited. for example 'scaleResize'=>0.5 generate image with half dimension
//one of $thumbWidth or $thumbHeight is optional but not both!
                'thumbWidth' => 140, //the width of created thumbnail on pixel. if height is null the aspect ratio will be reserved
                'thumbHeight' => 140, //the height of created thumbnail on pixel. if width is null the aspect ratio will be reserved
                'baseSourceDir' => 'uploads', //the main direcory of source images. if set to null the destination dir is the <webroot>/images
                'baseDestDir' => 'uploads/thumbs', //the main direcory of thumbnails. if set to null the destination dir is the <webroot>/images/thumbs
                //'postFixThumbName' => '_thumb', //the postfix name of thumbnail for example if it set = '_thumb' then  image1.jpg become image1_thumb.jpg
                'nameImages' => array($this->filename), //the names of images into $baseSourceDir, for example ('01.jpg','03.jpg'). the asterisk means all files jpg/jpeg, png or gif
                'recreate' => true, //force to create each thumbnail either exist or not, when is set to false the tumbnails created only in the first time
        )));
        Yii::app()->ThumbsGen->createThumbnails();
        Yii::app()->ThumbsGen->getThumbsUrl();

        return "/uploads/thumbs/" . $this->filename;
    }

    /**
     * Change our filename to match our own naming convention
     * @return bool
     */
    public function beforeValidate() {

        //(optional) Generate a random name for our file to work on preventing
        // malicious users from determining / deleting other users' files
        if ($this->secureFileNames) {
            $this->filename = sha1(Yii::app()->user->id . microtime() . $this->name);
            $this->filename .= "." . $this->file->getExtensionName();
        }

        return parent::beforeValidate();
    }

}
