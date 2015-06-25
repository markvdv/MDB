<?php

namespace MDB\RedacteurBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RatingType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
            //->add('ratingNumber','number',array('attr'=> array('class'=>'rating rating-loading','min'=>0,'max'=>5,'step'=>0.5,'data-size'=>'sm'),'mapped'=>false))
            ->add('ratingNumber','number',array('attr'=> array('class'=>'rating','min'=>0,'max'=>5,'step'=>0.5,'data-size'=>'sm'),'mapped'=>false))
            ->add('ratingSubmit','submit');
  }
  public function getName(){
    return 'model_rating_form';
  }
  public function setDefaultOptions(OptionsResolverInterface $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'MDB\RedacteurBundle\Entity\Rating',
    ));
}
}
