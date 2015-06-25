<?php

namespace MDB\ModellenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostcodeType extends AbstractType {

 public function buildForm(FormBuilderInterface $builder,array $options){
   $builder->add('postcode','text');
 }
  public function getName() {
    return 'Postcode';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'MDB\ModellenBundle\Entity\Postcode',
    ));
  }

}
