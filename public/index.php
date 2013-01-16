<?php

/**
 * Kevin Purrmann
 *
 * @todo Entfernen der Requires Autoloading Namespaces
 *
 *
 */

require_once '../application/form/Book.php';
require_once '../application/controller/IndexController.php';
require_once __DIR__ . '/../application/entities/Book.php';

$controller = new \Buecherverwaltung\Controller\IndexController();
$form = $controller->getForm();
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
                        <th><a href="?sorting=id">ID</a></th>
                        <th><a href="?sorting=title">Title</a></th>
                        <th><a href="?sorting=author">Autor</a></th>
                        <th><a href="?sorting=isbn">ISBN</a></th>
                        <th>Status</th>
                        <th>Bewertung</th>
                        <th>Kommentar</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    /**
                     * @todo Auslagern der Views
                     */
                    $sorting = array();
                    if (isset($_GET['sorting'])) {
                        $sorting[$_GET['sorting']] = 'ASC';
                    }

                    if ($books = $controller->getEntityManager()->getRepository('\Buecherverwaltung\Entities\Book')->findBy(array(), $sorting)) :
                        foreach ($books as $book) :
                            ?>
                            <tr>
                                <td><?php echo $book->getId(); ?></td>
                                <td><?php echo $book->getTitle(); ?></td>
                                <td><?php echo $book->getAuthor(); ?></td>
                                <td><?php echo $book->getIsbn(); ?></td>
                                <td><?php echo $book->getStatus(); ?></td>
                                <td><?php echo $book->getRating(); ?></td>
                                <td><?php echo $book->getComment(); ?></td>
                                <td><a href="?action=delete&id=<?php echo $book->getId() ?>">Löschen</a></td>
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

