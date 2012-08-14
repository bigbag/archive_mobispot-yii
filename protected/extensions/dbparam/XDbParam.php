<?php
/**
 * XDbParam handles application parameters using DB
 */
class XDbParam extends CAttributeCollection implements IApplicationComponent
{
    public $connectionID;
    public $paramsTableName = 'settings';

    /**
     * @var CDbConnection the DB connection instance
     */
    protected $_db;

    /**
     * If component is initialized
     *
     * @var bool
     */
    protected $_init = false;

    /**
     * Returns if component is initialized
     *
     * @return bool
     */
    public function getIsInitialized()
    {
        return $this->_init;
    }

    public function init()
    {
        $this->_init = true;

    }

    /**
     * @return CDbConnection the DB connection instance
     * @throws CException if {@link connectionID} does not point to a valid application component.
     */
    protected function getDbConnection()
    {
        if ($this->_db !== null)
            return $this->_db;
        else if (($id = $this->connectionID) !== null) {
            if (($this->_db = Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
            else
                throw new CException(Yii::t('xparam', 'XDbParam.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
                    array('{id}' => $id)));
        }
    }

    public function __get($name)
    {
        if ($this->contains($name))
            return $this->itemAt($name);
        else {
            try {
                return $this->loadParam($name);
            } catch (CException $e) {
                return parent::__get($name);
            }
        }
    }

    public function load($param)
    {
        $value = Yii::app()->cache->get($param);

        if ($value === false) {
            $db = $this->getDbConnection();
            $sql = "SELECT value FROM settings WHERE name = :param";
            $cmd = $db->createCommand($sql);
            $cmd->bindParam(":param", $param, PDO::PARAM_STR);
            $value = $cmd->queryScalar();

            Yii::app()->cache->set($param, $value);
        }

        return $value;
    }
}
