<?php namespace CTIMT\MyOrm\Entity;

/**
 * Description of AggregateEntity
 *
 * @author David Schoenbauer <d.schoenbauer@ctimeetingtech.com>
 */
class AggregateEntity extends AbstractEntity implements HasBoolFieldsInterface, HasDateFieldsInterface, HasNumericFieldsInterface, HasStringFieldsInterface
{
    private $boolFields = [];
    private $dateFields = [];
    private $numericFields = [];
    private $stringFields = [];
    
    
    public function import(EntityInterface $entity){
        if($entity instanceof HasBoolFieldsInterface){
            $this->setBoolFields(array_merge($this->getBoolFields(), $entity->getBoolFields()));
        }
        if($entity instanceof HasDateFieldsInterface){
            $this->setDateFields(array_merge($this->getDateFields(), $entity->getDateFields()));
        }
        if($entity instanceof HasNumericFieldsInterface){
            $this->setNumericFields(array_merge($this->getNumericFields(), $entity->getNumericFields()));
        }
        if($entity instanceof HasStringFieldsInterface){
            $this->setStringFields(array_merge($this->getStringFields(), $entity->getStringFields()));
        }
    }


    public function getBoolFields()
    {
        return $this->boolFields;
    }

    public function getDateFields()
    {
        return $this->dateFields;
    }

    public function getNumericFields()
    {
        return $this->numericFields;
    }

    public function getStringFields()
    {
        return $this->stringFields;
    }

    public function setBoolFields(array $boolFields)
    {
        $this->boolFields = $boolFields;
        return $this;
    }

    public function setDateFields(array $dateFields)
    {
        $this->dateFields = $dateFields;
        return $this;
    }

    public function setNumericFields(array $numericFields)
    {
        $this->numericFields = $numericFields;
        return $this;
    }

    public function setStringFields(array $stringFields)
    {
        $this->stringFields = $stringFields;
        return $this;
    }

}
