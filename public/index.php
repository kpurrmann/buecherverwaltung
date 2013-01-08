<?php

/**
 * Kevin Purrmann
 *
 * @todo Entfernen der Requires Autoloading Namespaces
 *
 *
 */

require_once '../application/form/Book.php';
require_once '../application/controller//IndexController.php';
require_once 'Doctrine/ORM/Tools/Setup.php';
require_once __DIR__ . '/../application/entities/Book.php';

$controller = new \Buecherverwaltung\Controller\IndexController();
$form = $controller->getForm();


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

Setup::registerAutoloadPEAR();


$paths = array(__DIR__ . "/../application/entities");
$isDevMode = false;

// the connection configuration
$dbParams = array(
   'driver' => 'pdo_mysql',
   'user' => 'root',
   'password' => 'Just@925',
   'dbname' => 'literature',
   'host' => 'localhost'
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$config->setProxyDir(__DIR__ . '/../cache/');
$config->setAutoGenerateProxyClasses(true);
$em = EntityManager::create($dbParams, $config);

/**
 * Hinzufügen
// */
if ($form->isSubmitted() && $form->validate()) {
    $newBook = new \Buecherverwaltung\Entities\Book($form->getValue());
    $newBook->setStatus($em->getRepository('\Buecherverwaltung\Entities\Status')->find($form->getElementById('status')->getValue()));
    $newBook->setRating($em->getRepository('\Buecherverwaltung\Entities\Rating')->find($form->getElementById('rating')->getValue()));
    $em->persist($newBook);
    $em->flush();
}

/**
 * Delete
 */
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $em->remove($em->getRepository('\Buecherverwaltung\Entities\Book')->find($_GET['delete']));
    $em->flush();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bücherverwaltung</title>
        <meta charset="UTF-8">
        <meta name="author" content="Kevin Purrmann">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="page container">
            <h1>Bücherverwaltung</h1>
            <?php
            echo $form;
            ?>

            <!-- Auslagern && Refactor -->

            <hr>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><a href="?sorting=title">Title</a></th>
                        <th><a href="?sorting=isbn">ISBN</a></th>
                        <th><a href="?sorting=status">Status</a></th>
                        <th><a href="?sorting=rating">Bewertung</a></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sorting = array();
                    if (isset($_GET['sorting'])) {
                        $sorting[$_GET['sorting']] = 'ASC';
                    }

                    if ($books = $em->getRepository('\Buecherverwaltung\Entities\Book')->findBy(array(), $sorting)) :
                        foreach ($books as $book) :
                            ?>
                            <tr>
                                <td><?php echo $book->getId(); ?></td>
                                <td><?php echo $book->getTitle(); ?></td>
                                <td><?php echo $book->getIsbn(); ?></td>
                                <td><?php echo $book->getStatus(); ?></td>
                                <td><?php echo $book->getRating(); ?></td>
                                <td><a href="?delete=<?php echo $book->getId() ?>">Löschen</a></td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>


                </tbody>
            </table>

        </div>

    </body>
</html>

