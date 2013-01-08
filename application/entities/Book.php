<?php

namespace Buecherverwaltung\Entities;

require_once 'Entity.php';
require_once 'Status.php';
require_once 'Rating.php';

/**
 * @todo Autoloading to remove require Statements
 * Books
 *
 * @Entity
 * @Table(name="books")
 */
class Book extends Entity
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

    /**
     * @var integer
     *
     * @Column(name="isbn", type="integer", length=13, nullable=false)
     */
    private $isbn;

    /**
     * @var Status
     *
     * @ManyToOne(targetEntity="Status", cascade={"persist"})
     * @JoinColumns({
     *   @JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @var Rating
     *
     * @ManyToOne(targetEntity="Rating", cascade={"persist"})
     * @JoinColumns({
     *   @JoinColumn(name="rating", referencedColumnName="id")
     * })
     */
    private $rating;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getStatus()
    {
        return $this->status->getTitle();
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getRating()
    {
        return $this->rating->getTitle();
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

}