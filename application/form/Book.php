<?php

namespace Buecherverwaltung\Form;

require_once 'HTML/QuickForm2.php';

/**
 * Description of Form
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Book
{

    protected $form;

    /**
     * Contrucotr for Form
     */
    public function __construct()
    {
        $this->form = new \HTML_QuickForm2('management');
        $this->form->addText('title')->setLabel('Titel')->addRule('required', 'Please enter a valid title');


        $isbn = new \HTML_QuickForm2_Element_InputText('isbn');
        $isbn->setLabel('ISBN')->addRule('regex', 'ISBN muss mindestens 10 Ziffern enthalten', '/^[0-9]{10,13}$/');
        $this->form->addElement($isbn);

        $this->form->addElement('select', 'status', array(), array(
           'options' => array(
              '1' => 'gelesen',
              '2' => 'nicht gelesen',
              '3' => 'noch zu kaufen'
           )
        ))->setLabel('Status')->setId('status');

        $this->form->addElement('select', 'rating', array(), array(
           'options' => array(
              '1' => '1 Stern',
              '2' => '2 Sterne',
              '3' => '3 Sterne',
              '4' => '4 Sterne',
              '5' => '5 Sterne',
           )
        ))->setLabel('Bewertung')->setId('rating');



        $this->form->addSubmit('Speichern')->addClass('btn btn-primary');
    }

    public function getForm()
    {
        return $this->form;
    }

}
