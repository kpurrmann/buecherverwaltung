<?php

namespace Buecherverwaltung\Controller;

use Buecherverwaltung\Form\Book;
use HTML_QuickForm2;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

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
     * @var type 
     */
    private $em;

    /**
     *
     */
    public function __construct()
    {
        $this->request = array_merge($_GET, $_POST);
        $this->form = new Book();
        $this->setEntityManager();
        $this->resolveAction();
    }

    private function setEntityManager()
    {

        Setup::registerAutoloadPEAR();


        $paths = array(__DIR__ . "/../entities");
        $isDevMode = false;

        $dbParams = array(
           'driver' => 'pdo_mysql',
           'user' => 'root',
           'password' => 'frDBadmin',
           'dbname' => 'literature',
           'host' => 'localhost'
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $config->setProxyDir(__DIR__ . '/../../cache/');
        $config->setAutoGenerateProxyClasses(true);
        $this->em = EntityManager::create($dbParams, $config);
    }

    /**
     *
     */
    private function deleteAction()
    {
        if (isset($this->request['id']) && is_numeric($this->request['id'])) {
            $this->em->remove($this->em->getRepository('\Buecherverwaltung\Entities\Book')->find($this->request['id']));
            $this->em->flush();
        }
    }

    private function addAction()
    {
        $form = $this->getForm();

        if ($form->isSubmitted() && $form->validate()) {
            $newBook = new \Buecherverwaltung\Entities\Book($form->getValue());
            $newBook->setStatus($this->em->getRepository('\Buecherverwaltung\Entities\Status')->find($form->getElementById('status')->getValue()));
            $newBook->setRating($this->em->getRepository('\Buecherverwaltung\Entities\Rating')->find($form->getElementById('rating')->getValue()));
            $this->em->persist($newBook);
            $this->em->flush();
        }
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

    public function getEntityManager()
    {
        return $this->em;
    }

}
