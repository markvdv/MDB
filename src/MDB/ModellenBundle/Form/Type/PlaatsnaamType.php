<?php

namespace MDB\ModellenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlaatsnaamType extends AbstractType {

 public function buildForm(FormBuilderInterface $builder,array $options){
   $builder->add('plaatsnaam','text')
   ->add('postcode',new PostcodeType());
 }
  public function getName() {
    return 'Plaatsnaam';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'MDB\ModellenBundle\Entity\Plaatsnaam',
    ));
  }

}
