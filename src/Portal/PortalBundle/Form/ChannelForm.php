<?php
/**
 * Created by PhpStorm.
 * User: Богдан
 * Date: 16.12.2016
 * Time: 17:52
 */

namespace Portal\PortalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChannelForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $channel, array $options)
    {
        $channel->add('name', 'text', array('label' => 'Название канала:'))
            ->add('description', 'textarea', array('label' => 'Описание:'))
            ->add('button', 'submit', array('attr' => array('class' => 'btn btn-save'), 'label' => 'Сохранить'));
    }

    public function getName()
    {
        return 'name';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Portal\PortalBundle\Entity\Channel',
        ));
    }

}