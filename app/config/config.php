<?php
use Symfony\Component\DependencyInjection\Definition;

$container->setDefinition('UserService',new Definition('MDB\UserBundle\UserService',array('%doctrine.orm.entity_manager%')));
        

