<?php

class EAjaxUploadAction extends CAction
{

        public function run()
        {
                Yii::import("ext.EAjaxUpload.qqFileUploader");
                /*AQUI EDITO LOS ARCHIVOS VALIDOS*/
                $allowedExtensions = array("pdf");
                $sizeLimit = 1 * 1024 * 1024;

                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                /*RUTA DE EL REPOSITORIO DE ARCHIVOS SUBIDOS*/
                $result = $uploader->handleUpload('upload/');
                // to pass data through iframe you will need to encode all html tags
                $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
                echo $result;
        }
}
