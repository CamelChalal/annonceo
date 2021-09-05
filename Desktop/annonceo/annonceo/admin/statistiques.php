<?php

include_once('../include/init.php');

if (!adminConnected()) {
  header("Location:" . URL . "erreur.php?acces=interdit");
  exit;
}

$pdoStatementNote = $pdoObject->query('SELECT membre_id2 AS membre , SUM(note) / COUNT(*) AS note FROM note GROUP BY membre_id2 ORDER BY SUM(note) / COUNT(*) DESC LIMIT 5');
$notes = $pdoStatementNote->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($notes);
// echo "</pre>";
// die;

$pdoStatementAnnonceAncienne = $pdoObject->query('SELECT id_annonce, date_enregistrement, titre FROM annonce GROUP BY id_annonce ORDER BY date_enregistrement ASC LIMIT 5 ');

$dates = $pdoStatementAnnonceAncienne->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($dates);
// echo "</pre>";

$pdoStatememntCat = $pdoObject->query('SELECT * FROM categorie INNER JOIN annonce ON categorie_id = id_categorie GROUP BY id_categorie ORDER BY COUNT(*) DESC LIMIT 5');

$cats = $pdoStatememntCat->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($cats);
// echo "</pre>";

$pdoCategorie = $pdoObject->query('SELECT id_categorie, titres FROM categorie');
$categorie = $pdoCategorie->fetch(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($categorie);
// echo "</pre>";

include_once('../include/header.php');
?>

<h1 class="text-center m-4">Statistiques</h1>

<div class=" row col-md-6 justify-content-center mt-5 mx-auto">

  <h4>Top 5 des membres les mieux notés</h2>

    <table class="table table-hover table-striped  text-center mt-5">

      <thead class='thead-dark'>
        <tr>
          <?php for ($i = 0; $i < $pdoStatementNote->columnCount(); $i++) :


            $colonne = $pdoStatementNote->getColumnMeta($i);

            // echo "<pre>";
            // print_r($colonne);
            // echo "</pre>";

          ?>


            <th><?= ucfirst($colonne['name']) ?></th>

          <?php endfor; ?>

        </tr>

      </thead>

      <tbody>

        <?php foreach ($notes as $note) : ?>

          <tr>
            <?php foreach ($note as $keynote => $valuenote) : ?>

              <?php if ($keynote != "id_membre") : ?>
                <?php if ($valuenote != "melka") : ?>

                  <th class="align-middle"><?= $valuenote ?></th>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>





          </tr>
        <?php endforeach; ?>

      </tbody>


    </table>
</div>

<div class="row col-md-6 justify-content-center mt-5 mx-auto">

  <h4>Top 5 des annonces les plus anciennes</h4>

  <table class="table table-hover table-striped  text-center mt-2">

    <thead class='thead-dark'>
      <tr>
        <?php for ($i = 0; $i < $pdoStatementAnnonceAncienne->columnCount(); $i++) :


          $colonne = $pdoStatementAnnonceAncienne->getColumnMeta($i);

          // echo "<pre>";
          // print_r($colonne);
          // echo "</pre>";

        ?>


          <th><?= ucfirst($colonne['name']) ?></th>

        <?php endfor; ?>

      </tr>

    </thead>

    <tbody>

      <?php foreach ($dates as $date) : ?>

        <tr>
          <?php foreach ($date as $keydate => $valuedate) : ?>

            <th class="align-middle"><?= $valuedate ?></th>

          <?php endforeach; ?>

        </tr>
      <?php endforeach; ?>

    </tbody>


  </table>
</div>

<div class="row col-md-6 justify-content-center mt-5 mx-auto">

  <h4>Top 5 des catégories</h4>

  <table class="table table-hover table-striped  text-center mt-2">

    <thead class='thead-dark'>
      <tr>
        <?php for ($i = 0; $i < $pdoCategorie->columnCount(); $i++) :


          $colonne = $pdoCategorie->getColumnMeta($i);

          // echo "<pre>";
          // print_r($colonne);
          // echo "</pre>";

        ?>

          <th><?= ucfirst($colonne['name']) ?></th>

        <?php endfor; ?>

      </tr>

    </thead>

    <tbody>

      <?php foreach ($cats as $cat) : ?>

        <tr>
          <?php foreach ($cat as $keycat => $valuecat) : ?>

            <?php if ($keycat != "id_annonce") : ?>
              <?php if ($keycat != "titre") : ?>
                <?php if ($keycat != "motcles") : ?>
                  <?php if ($keycat != "description_courte") : ?>
                    <?php if ($keycat != "description_longue") : ?>
                      <?php if ($keycat != "prix") : ?>
                        <?php if ($keycat != "photo") : ?>
                          <?php if ($keycat != "pays") : ?>
                            <?php if ($keycat != "ville") : ?>
                              <?php if ($keycat != "adresse") : ?>
                                <?php if ($keycat != "cp") : ?>
                                  <?php if ($keycat != "membre_id") : ?>
                                    <?php if ($keycat != "photo_id") : ?>
                                      <?php if ($keycat != "categorie_id") : ?>
                                        <?php if ($keycat != "date_enregistrement") : ?>


                                          <th class="align-middle"><?= $valuecat ?></th>
                                        <?php endif; ?>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endforeach; ?>

        </tr>
      <?php endforeach; ?>

    </tbody>


  </table>
</div>

<?php

include_once('../include/footer.php');
