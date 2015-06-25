<?php
namespace MDB\RedacteurBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CreateRedacteurType extends AbstractType{
  public function buildForm(FormBuilderInterface $builder,array $options) {
    $builder ->setAction('create')
            ->add('naam','text')
            ->add('voornaam','text')
            ->add('email','text')
            ->add('paswoord','password')
            ->add('nicknaam','text')
            ->add('create redacteur', 'submit');
  }
  public function getName(){
    return 'create_model_form';
  }
  public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MDB\ModellenBundle\Entity\Model',
    ));
}
}
