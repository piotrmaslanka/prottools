<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Prottools</title>
</head>
<body>
    Pass amino acid sequence to analyze (1 letter for amino acids, all other characters will be ignored): <br>
    <form action="index.php" method="post">
        <textarea rows="5" cols="40" name="protein"><?php echo @$_POST['protein']; ?></textarea><br>
        <input type="submit" value="Analyze">
    </form>
<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    include_once('proteindb.php');
    if (@$_POST['protein']) {
        $protein = $_POST['protein'];
?>

    <hr>
    Total amino acids: <?php echo proteindb_count_amino($protein); ?><br>
    Mass: <?php echo proteindb_mass($protein); ?> Da<br>
    Aromatic amino acids: <?php echo proteindb_count_with_property($protein, 'aromatic'); ?><br>
    Aliphatic amino acids: <?php echo proteindb_count_with_property($protein, 'aliphatic'); ?><br>
    Positive amino acids: <?php echo proteindb_count_with_property($protein, 'positive'); ?><br>
    Negative amino acids: <?php echo proteindb_count_with_property($protein, 'negative'); ?><br>
    Polar amino acids: <?php echo proteindb_count_with_property($protein, 'polar'); ?><br>
    Hydrophobic amino acids: <?php echo proteindb_count_with_property($protein, 'hydrophobic'); ?><br>
    Hydrophilic amino acids: <?php echo proteindb_count_with_property($protein, 'hydrophilic'); ?><br>

    <br>
    <table>
        <tr>
            <th>Amino acid (long)</th>
            <th>Amino acid (short)</th>
            <th>Count</th>
            <th>Properties</th>
    <?php
        foreach (array_keys($proteindb_proteins) as $amino) {
               $count = substr_count($protein, $amino);
               if ($count == 0) continue;
            ?><tr>
                <td><?php echo $proteindb_proteins[$amino][0]; ?></td>
                <td><?php echo $proteindb_proteins[$amino][1]; ?></td>
                <td><?php echo $count; ?></td>
                <td><?php echo $proteindb_proteins[$amino][6]; ?></td>
             </tr><?php
        }
    }
    ?></table>
<hr>
     <div style="font-size: 0.8em; width: 100%; text-align: center;">
        <a href="https://github.com/piotrmaslanka/prottools" style="color: black;">Prottools v1.0</a>
    </div>
</body>
</htm>
