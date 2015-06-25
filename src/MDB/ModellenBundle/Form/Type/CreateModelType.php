<?php

namespace MDB\ModellenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateModelType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder->add('pmagazine', 'checkbox', array('required' => false))
            ->add('clint', 'checkbox', array('required' => false))
            ->add('che', 'checkbox', array('required' => false))
            ->add('menzo', 'checkbox', array('required' => false))
            ->add('andereMagazines', 'checkbox', array('required' => false))
            ->add('andereMagazinesOmschrijving', 'text', array('required' => false))
            ->add('geboortedatum', 'date', array('input' => 'datetime', 'widget' => 'choice', 'years' => range(date("Y") - 40, date("Y")), 'format' => 'd M y'))
            ->add('gsm', 'text')
            ->add('adres', new AdresType())
            ->add('website', 'text')
            ->add('lengte', 'text')//SLIDER
            ->add('gewicht', 'text')//SLIDER
            ->add('haarkleur', 'entity', array('class' => 'MDBModellenBundle:HaarKleur', 'property' => 'kleurnaam'))
            ->add('oogkleur', 'entity', array('class' => 'MDBModellenBundle:OogKleur', 'property' => 'kleurnaam'))
            ->add('confectiemaat', 'choice', array('choices' => array('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'), 'placeholder' => 'kies een confectiemaat'))
            ->add('cupmaat', 'choice', array("choices" => array("AA", "A", "B", "C", "D", "DD", "E", "F", "FF", "G", "H"), "placeholder" => "kies een cupmaat"))
            ->add('borstomtrek', 'text')//silder
            ->add('taille', 'text')//slider
            ->add('heup', 'text')//slider
            ->add('schoenmaat', 'text')//slider
            ->add('fashion', 'checkbox', array('required' => false))
            ->add('lingerie', 'checkbox', array('required' => false))
            ->add('badkledij', 'checkbox', array('required' => false))
            ->add('glamour', 'checkbox', array('required' => false))
            ->add('topless', 'checkbox', array('required' => false))
            ->add('bedektTopless', 'checkbox', array('required' => false))
            ->add('naakt', 'checkbox', array('required' => false))
            ->add('onherkenbaarNaakt', 'checkbox', array('required' => false))
            ->add('bedektNaakt', 'checkbox', array('required' => false))
            ->add('artistiekNaakt', 'checkbox', array('required' => false))
            ->add('bodypaint', 'checkbox', array('required' => false))
            ->add('ervaring', 'checkbox', array('required' => false))
            ->add('ervaringOmschrijving', 'textarea', array('required' => false))
            ->add('fotos', 'file', array('multiple' => true, 'mapped' => false))
            ->add('creeerprofiel', 'submit')
            ->add('updateprofiel', 'submit');
    return $builder;
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
