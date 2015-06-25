<?php

namespace MDB\UserBundle\Form\Type;
use MDB\UserBundle\Form\Type\LoginType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends LoginType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder=parent::buildform($builder,array());
    $builder->add('voornaam', 'text', array('required' => false))
            ->add('naam', 'text', array('required' => false))
            ->add('email', 'email', array('required' => false))
            ->add('registreer', 'submit');
    return $builder;
  }

  public function getName() {
    return 'userlogin';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'MDB\UserBundle\Entity\User',
    ));
  }

}