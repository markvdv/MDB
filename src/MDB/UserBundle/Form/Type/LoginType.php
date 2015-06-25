<?php

namespace MDB\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('nicknaam', 'text', array('required' => false))
            ->add('paswoord', 'password', array('required' => false))
            ->add('login', 'submit')
            ->add('registreer', 'submit')
            ->add('wachtwoordvergeten', 'submit',array('label'=>'Wachtwoord vergeten'));
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
