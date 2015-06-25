<?php

namespace MDB\RedacteurBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchModelType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->setAction('create')
            ->add('pmagazine', 'checkbox', array('required' => false))
            ->add('clint', 'checkbox', array('required' => false))
            ->add('che', 'checkbox', array('required' => false))
            ->add('menzo', 'checkbox', array('required' => false))
            ->add('andereMagazines', 'checkbox', array('required' => false, 'mapped' => false))
            ->add('andereMagazinesZoekterm', 'text', array('required' => false, 'mapped' => false))
            ->add('lengte', 'text')//SLIDER
            ->add('gewicht', 'text')//SLIDER
            ->add('haarKleur', 'entity', array('class' => 'MDBModellenBundle:HaarKleur', 'property' => 'kleurnaam','placeholder'=>'kies een kleur','required'=>false))
            ->add('oogKleur', 'entity', array('class' => 'MDBModellenBundle:OogKleur', 'property' => 'kleurnaam','placeholder'=>'kies een kleur','required'=>false))
            ->add('confectieMaat', 'choice', array('choices' => array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'), 'placeholder' => 'kies een confectiemaat'))
            ->add('cupMaat', 'choice', array("choices" => array("AA", "A", "B", "C", "D", "DD", "E", "F", "FF", "G", "H"), "placeholder" => "kies een cupmaat"))
            //  ->add('borstomtrek', 'choice', array("choices" => array("65","70","75","80","85","90","95"),"placeholder"=> "kies een borstomtrek"))//silder
            ->add('borstOmtrek', 'text')//silder
            ->add('taille', 'text')//slider
            ->add('heup', 'text')//slider
            ->add('schoenMaat', 'text')//slider
            ->add('fashion', 'checkbox', array('required' => false))
            ->add('lingerie', 'checkbox', array('required' => false))
            ->add('badKledij', 'checkbox', array('required' => false))
            ->add('glamour', 'checkbox', array('required' => false))
            ->add('topLess', 'checkbox', array('required' => false))
            ->add('bedektTopless', 'checkbox', array('required' => false))
            ->add('naakt', 'checkbox', array('required' => false))
            ->add('onherkenbaarNaakt', 'checkbox', array('required' => false))
            ->add('bedektNaakt', 'checkbox', array('required' => false))
            ->add('artistiekNaakt', 'checkbox', array('required' => false))
            ->add('bodyPaint', 'checkbox', array('required' => false))
            ->add('ervaring', 'checkbox', array('required' => false))
            ->add('ervaringOmschrijving', 'text', array('required' => false))
            ->add('fotos', 'file', array('multiple' => true, 'mapped' => false))
            ->add('rating', new RatingType(), array('mapped' => false))
            ->add('zoek', 'submit');
  }

  public function getName() {
    return 'create_model_form';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'data_class' => 'MDB\ModellenBundle\Entity\Model',
    ));
  }

}
