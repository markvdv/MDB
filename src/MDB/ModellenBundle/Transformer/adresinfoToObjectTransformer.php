<?php
namespace MDB\ModellenBundle\Transformer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
class adresinfoToObjectTransformer implements DataTransformerInterface{
private $om;
public function __construct(ObjectManager $om) {
  $this->om=$om;
}
public function transform(){
  
} 
public function reverseTransform() {
  
}
}
