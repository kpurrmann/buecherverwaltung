<?php

namespace Buecherverwaltung\Controller;

use Buecherverwaltung\Form\Book;
use HTML_QuickForm2;

/**
 * Description of IndexController
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class IndexController
{

    /**
     * Merge of Get and Post Variables
     *
     * @var array
     */
    protected $request;

    /**
     *
     * @var type 
     */
    private $form;

    /**
     *
     */
    public function __construct()
    {
        $this->request = array_merge($_GET, $_POST);
        $this->form = new Book();
        $this->resolveAction();
    }

    /**
     *
     */
    private function deleteAction()
    {
        echo 'Delete Action';
    }

    private function addAction()
    {
        echo 'Add Action';
        echo 'tets';
    }

    /**
     *
     */
    private function listAction()
    {
        
    }

    /**
     *
     */
    private function resolveAction()
    {
        if (array_key_exists('action', $this->request)) {
            $method = lcfirst($this->request['action']) . 'Action';
            if (method_exists($this, $method)) {
                $this->{$method}();
            }
        } else {
            // Default Action
            $this->listAction();
        }
    }

    /**
     *
     * @return HTML_QuickForm2
     */
    public function getForm()
    {
        // Short Hotfix
        return $this->form->getForm();
    }

}
