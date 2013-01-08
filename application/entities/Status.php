<?php

namespace Buecherverwaltung\Entities;

require_once 'Entity.php';
require_once 'Book.php';

/**
 * Satus
 *
 * @Table(name="status")
 * @Entity
 */
class Status extends Entity
{

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

}