<?php

class AceCrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $baseControllerClass='Controller';

	private $_modelClass;
	private $_table;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('model, controller, baseControllerClass', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_][\w\\\\]*$/', 'message'=>'{attribute} should only contain word characters and backslashes.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}

	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		$class=@Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		elseif(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			elseif(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
			}
		}
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		elseif(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength, 'class' => 'span-12',))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function generateActiveField($modelClass,$column)
	{

            if($column->isForeignKey && !preg_match('/^(user|usuario|usuario_ini_id|usuario_act_id|usuario_eli_id|user_ini_id|user_act_id|user_eli_id|plantel_actual_id|estudiante_id)$/i',$column->name)){

                $foreignKey = $this->getForeignKeys($modelClass, $column);
                //$object = new $modelClass();
                //$foreignAttribute = key($foreignKey);
                $foreignClass = $foreignKey[1];

                if(class_exists($foreignClass)){
                    return "\$form->dropDownList(\$model, '{$column->name}', CHtml::listData($foreignClass::model()->findAll(array('limit'=>50)), 'id', 'nombre'), array('prompt'=>'- - -', 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
                }
                else{
                    return $this->generateSimpleActiveField($modelClass,$column);
                }

            }
            else{

                return $this->generateSimpleActiveField($modelClass,$column);

            }
	}

        public function generateSimpleActiveField($modelClass,$column){

            if($column->name==='estatus'){
                return "\$form->dropDownList(\$model, '{$column->name}', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
            }
            elseif(strpos($column->name,'posee') === 0 || strpos($column->name,'tiene') === 0 || strpos($column->name,'imparte') === 0){
                return "\$form->dropDownList(\$model, '{$column->name}', array('SI'=>'Sí', 'NO'=>'No',), array('prompt'=>'- - -', 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
            }
            elseif($column->name==='sexo' || $column->name==='genero'){
                return "\$form->dropDownList(\$model, '{$column->name}', array('F'=>'Femenino', 'M'=>'Masculino',), array('prompt'=>'- - -', 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
            }
            elseif($column->type==='boolean'){
                    return "\$form->checkBox(\$model, '{$column->name}',  array(".($column->allowNull?'':'"required"=>"required",')."))";
            }
            elseif(stripos($column->dbType,'text')!==false){
                    return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
            }
            else
            {
                    if(preg_match('/^(password|pass|passwd|passcode|clave)$/i',$column->name))
                            $inputField='passwordField';
                    elseif(preg_match('/^(email)$/i',$column->name))
                            $inputField='emailField';
                    else
                            $inputField='textField';

                    if($column->type!=='string' || $column->size===null)
                            return "\$form->{$inputField}(\$model,'{$column->name}', array('class' => 'span-12',".($column->allowNull?'':'"required"=>"required",')."))";
                    else
                    {
                            if(($size=$maxLength=$column->size)>60)
                                    $size=60;
                            return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size, 'maxlength'=>$maxLength, 'class' => 'span-12', ".($column->allowNull?'':'"required"=>"required",')."))";
                    }
            }

        }

        public function generateActiveFieldToRead($modelClass,$column){

            if($column->name==='estatus'){
                return "\$form->dropDownList(\$model, '{$column->name}', array('A'=>'Activo', 'I'=>'Inactivo', 'E'=>'Eliminado'), array('prompt'=>'- - -', 'class' => 'span-12', 'disabled'=>'disabled',))";
            }
            elseif($column->name==='sexo' || $column->name==='genero'){
                return "\$form->dropDownList(\$model, '{$column->name}', array('F'=>'Femenino', 'M'=>'Masculino',), array('prompt'=>'- - -', 'class' => 'span-12', 'disabled'=>'disabled',))";
            }
            elseif($column->type==='boolean'){
                return "\$form->checkBox(\$model, '{$column->name}',  array('disabled'=>'disabled'))";
            }
            elseif(stripos($column->dbType,'text')!==false){
                return "\$form->textArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>12, 'class' => 'span-12', 'disabled'=>'disabled',))";
            }
            else
            {
                    if(preg_match('/^(password|pass|passwd|passcode|clave)$/i',$column->name))
                            $inputField='passwordField';
                    elseif(preg_match('/^(email)$/i',$column->name))
                            $inputField='emailField';
                    else
                            $inputField='textField';

                    if($column->type!=='string' || $column->size===null)
                            return "\$form->{$inputField}(\$model,'{$column->name}', array('class' => 'span-12', 'disabled'=>'disabled',))";
                    else
                    {
                            if(($size=$maxLength=$column->size)>60)
                                    $size=60;
                            return "\$form->{$inputField}(\$model,'{$column->name}',array('size'=>$size, 'maxlength'=>$maxLength, 'class' => 'span-12', 'disabled'=>'disabled',))";
                    }
            }

        }

        public function getForeignKeys($model, $field){

            $object = new $model();

            $relations = $object->relations();

            foreach ($relations as $relation => $data){
                if(isset($data[2]) && $data[2]==$field->name){
                    return $data;
                }
            }

            return null;

        }

        public function getUrlBase(){
            $baseUrl = "/";
            try {
                if($this->getModule() instanceof CWebApplication){
                    $baseUrl = "/".$this->getControllerID();
                }
                else{
                    $baseUrl = "/".$this->getModule()->getName()."/".$this->getControllerID();
                }
            } catch (Exception $exc) {
                $baseUrl = "/".$this->getControllerID();
            }
            return $baseUrl;
        }

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}
}