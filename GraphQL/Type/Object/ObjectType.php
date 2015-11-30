<?php
/*
* This file is a part of graphql-youshido project.
*
* @author Alexandr Viniychuk <a@viniychuk.com>
* created: 11/27/15 1:24 AM
*/

namespace Youshido\GraphQL\Type\Object;


use Youshido\GraphQL\Field;
use Youshido\GraphQL\Type\AbstractType;
use Youshido\GraphQL\Type\Config\ObjectTypeConfig;
use Youshido\GraphQL\Type\TypeKind;
use Youshido\GraphQL\Validator\Exception\ResolveException;

class ObjectType extends AbstractType
{

    protected $name = "Object";

    /**
     * ObjectType constructor.
     * @param $config
     */
    public function __construct($config = [])
    {
        if (empty($config) && (get_class($this) != 'Youshido\GraphQL\Type\Object\ObjectType')) {
            $config['name'] = $this->getName();
        }

        $this->config = new ObjectTypeConfig($config, $this);
        $this->name   = $this->config->getName();

        $this->buildFields($this->config);
        $this->buildArguments($this->config);
    }

    protected function buildFields(ObjectTypeConfig $config)
    {
    }

    protected function buildArguments(ObjectTypeConfig $config)
    {
    }

    public function parseValue($value)
    {
        return $value;
    }

    final public function serialize($value)
    {
        throw new ResolveException('You can not serialize object value directly');
    }

    public function resolve($value = null, $args = [])
    {
        $callable = $this->config->getResolveFunction();

        return is_callable($callable) ? $callable($value, $args) : null;
    }

    public function getKind()
    {
        return TypeKind::ObjectKind;
    }

    /**
     * @return ObjectTypeConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Field[]
     */
    public function getFields()
    {
        return $this->config->getFields();
    }

    public function hasArgument($name)
    {
        return $this->config->hasArgument($name);
    }

    public function getArgument($name)
    {
        return $this->config->getArgument($name);
    }

    /**
     * @return Field[]
     */
    public function getArguments()
    {
        return $this->config->getArguments();
    }

    public function hasField($fieldName)
    {
        return $this->config->hasField($fieldName);
    }

    public function getField($fieldName)
    {
        return $this->config->getField($fieldName);
    }

    public function isValidValue($value)
    {
        return (get_class($value) == get_class($this));
    }

}