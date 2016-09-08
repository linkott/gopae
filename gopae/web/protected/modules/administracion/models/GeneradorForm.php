<?php

class GeneradorForm extends CFormModel {

    public $connectionId = 'db';
    public $tablePrefix = '';
    public $tableName;
    public $modelClass;
    public $fields = array();
    public $orderBy = '';
    public $modelPath = 'models/catalogos';
    public $buildRelations = true;
    public $commentsAsLabels = false;

    /**
     * @var array list of candidate relation code. The array are indexed by AR class names and relation names.
     * Each element represents the code of the one relation in one AR class.
     */
    protected $relations;
    static $keywords = array(
        '__class__',
        '__dir__',
        '__file__',
        '__function__',
        '__line__',
        '__method__',
        '__namespace__',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'case',
        'catch',
        'cfunction',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'eval',
        'exception',
        'exit',
        'extends',
        'final',
        'final',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'interface',
        'isset',
        'list',
        'namespace',
        'new',
        'old_function',
        'or',
        'parent',
        'php_user_filter',
        'print',
        'private',
        'protected',
        'public',
        'require',
        'require_once',
        'return',
        'static',
        'switch',
        'this',
        'throw',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
    );

    public function rules() {
        return array(
            array('tableName, modelClass, connectionId, fields, orderBy', 'filter', 'filter' => 'trim'),
            array('connectionId', 'required', 'message' => '{attribute} no debe estar vacio.'),
            array('tableName, modelClass', 'required', 'message' => '{attribute} no debe estar vacio.'),
            array('fields', 'required', 'message' => '{attribute} no debe estar vacio.'),
            //array('orderBy', 'checkOrderBy'),
            array('connectionId', 'validateConnectionId'),
            array('tableName', 'validateTableName'),
            array('modelClass, tableName', 'match', 'pattern' => '/^(\w+[\w\.]*|\*?|\w+\.\*)$/', 'message' => '{attribute} solo debe contener letras.'),
                //array('baseClass', 'match', 'pattern' => '/^[a-zA-Z_][\w\\\\]*$/', 'message' => '{attribute} should only contain word characters and backslashes.'),
                //array('modelPath', 'validateModelPath', 'skipOnError'=>true),
        );
    }

    /**
     * Checks if the named class exists (in a case sensitive manner).
     * @param string $name class name to be checked
     * @return boolean whether the class exists
     */
    public function classExists($name) {

        return class_exists($name, false) && in_array($name, get_declared_classes());
    }
    
    
    /**
     * Chequea si el orderBy es válido
     * @param type $attribute
     * @param type $params
     */
    public function checkOrderBy($attribute, $params=null){
        
        if(strlen($this->fields)>0 && strlen($this->orderBy)){
            if(strpos($this->fields,$this->orderBy)===false){
                $this->addError($attribute, 'Los elementos seleccionados en el OrderBy no son válidos ya que no se encuentran entre los campos seleccionados.');
            }
        }
        
    }
    
    /**
     * Validates an attribute to make sure it is not taking a PHP reserved keyword.
     * @param string $attribute the attribute to be validated
     * @param array $params validation parameters
     */
    public function validateReservedWord($attribute, $params) {
        $value = $this->$attribute;
        if (in_array(strtolower($value), self::$keywords))
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' cannot take a reserved PHP keyword.');
    }

    public function validateConnectionId($attribute, $params) {
        if (Yii::app()->hasComponent($this->connectionId) === false || !(Yii::app()->getComponent($this->connectionId) instanceof CDbConnection))
            $this->addError('connectionId', 'La conexión a la base de datos debe ser valida.');
    }

    public function validateTableName($attribute, $params) {
        if ($this->hasErrors())
            return;

        $invalidTables = array();
        $invalidColumns = array();

        if ($this->tableName[strlen($this->tableName) - 1] === '*') {
            if (($pos = strrpos($this->tableName, '.')) !== false)
                $schema = substr($this->tableName, 0, $pos);
            else
                $schema = '';

            $this->modelClass = '';
            $tables = Yii::app()->{$this->connectionId}->schema->getTables($schema);
            foreach ($tables as $table) {
                if ($this->tablePrefix == '' || strpos($table->name, $this->tablePrefix) === 0) {
                    if (in_array(strtolower($table->name), self::$keywords))
                        $invalidTables[] = $table->name;
                    if (($invalidColumn = $this->checkColumns($table)) !== null)
                        $invalidColumns[] = $invalidColumn;
                }
            }
        }
        else {
            if (($table = $this->getTableSchema($this->tableName)) === null)
                $this->addError('tableName', "La Tabla '{$this->tableName}' no existe.");
            if ($this->modelClass === '')
                $this->addError('modelClass', 'El Nombre de la Clase no debe estart vacio.');

            if (!$this->hasErrors($attribute) && ($invalidColumn = $this->checkColumns($table)) !== null)
                $invalidColumns[] = $invalidColumn;
        }
        if ($invalidTables != array())
            $this->addError('tableName', 'Model class cannot take a reserved PHP keyword! Table name: ' . implode(', ', $invalidTables) . ".");
        if ($invalidColumns != array())
            $this->addError('tableName', 'Column names that does not follow PHP variable naming convention: ' . implode(', ', $invalidColumns) . ".");
    }

    public function checkColumns($table) {
        foreach ($table->columns as $column) {
            if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $column->name))
                return $table->name . '.' . $column->name;
        }
    }

    public function getTableSchema($tableName) {
        $connection = Yii::app()->{$this->connectionId};
        return $connection->getSchema()->getTable($tableName, $connection->schemaCachingDuration !== 0);
    }

    public function getTableColumns($tableName) {
        $resultado = array();
        $schemaName = 'public';
        $pos = '';
        if (($pos = strrpos($tableName, '.')) !== false) {
            $schema_table = explode('.', $tableName);
            $schemaName = (isset($schema_table[0])) ? $schema_table[0] : 'public';
            $tableName = (isset($schema_table[1])) ? $schema_table[1] : '';
        }

        if ($schemaName != '' AND $tableName != '' AND ! is_null($schemaName) AND ! is_null($tableName)) {
            $sql = "    SELECT column_name" .
                    "   FROM information_schema.columns" .
                    "   WHERE  table_schema=:schemaName AND table_name=:tableName" .
                    "   ORDER BY ordinal_position ASC";
            $busqueda = Yii::app()->db->createCommand($sql);
            $busqueda->bindParam(":schemaName", $schemaName, PDO::PARAM_INT);
            $busqueda->bindParam(":tableName", $tableName, PDO::PARAM_INT);
            $resultado = $busqueda->queryColumn();
        }
        return $resultado;
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'connectionId' => 'Conexión a la Base de Datos',
            'tableName' => 'Nombre de la Tabla',
            'modelClass' => 'Nombre de la Clase',
            'fields' => 'Campos a Seleccionar',
            'orderBy' => 'Campo(s) por los cuales Ordenar de Forma Ascendente',
        );
    }

    public function getBasePath() {
        return Yii::app()->basePath . '/' . $this->modelPath;
    }

    public function executeQuery(GeneradorForm $formGenerador) {
        $resultado = null;
        if (is_object($formGenerador)) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $orderByEmpty = empty($formGenerador->orderBy);
                if(is_null($formGenerador->orderBy) || $orderByEmpty){
                    $sql = " SELECT {$formGenerador->fields} FROM {$formGenerador->tableName}";
                }else{
                    $sql = " SELECT {$formGenerador->fields} FROM {$formGenerador->tableName} ORDER BY {$formGenerador->orderBy}";
                }
                $consulta = Yii::app()->db->createCommand($sql);
                $resultado = $consulta->queryAll();
            } catch (Exception $ex) {
                return $resultado;
            }
        }
        return $resultado;
    }

}
