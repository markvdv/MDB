<?php

namespace MDB\ModellenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdresType extends AbstractType {

 public function buildForm(FormBuilderInterface $builder,array $options){
   $builder->add('straatnaam','text')
           ->add('huisnummer','text')
           ->add('plaatsnaam',new PlaatsnaamType());
 }
  public function getName() {
    return 'adres';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'MDB\ModellenBundle\Entity\Adres',
    ));
  }

}
