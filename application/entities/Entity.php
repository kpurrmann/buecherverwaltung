<?php

namespace Buecherverwaltung\Entities;

/**
 * Description of Entity
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class Entity
{

    /**
     * Constructor to fill private attributes from data array
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->{$method}($value);
                }
            }
        }
    }

}
