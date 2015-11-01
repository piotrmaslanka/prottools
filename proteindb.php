<?php
/**
* Copyright (c) Piotr Maslanka
* BSD 3-clause license
**/

    // long name - short name - mass [daltons], pI, pK1 (COOH), pK2 (NH3), attributes
    $proteindb_proteins = array(
        'A' => ['Alanine', 'Ala', 89.09404, 6.01, 2.35, 9.87, 'hydrophobic'],
        'C' => ['Cysteine', 'Cys', 121.15404, 5.05, 1.92, 10.7, 'polar'],
        'D' => ['Aspartic acid', 'Asp', 133.10384, 5.05, 1.92, 10.7, 'negative'],
        'E' => ['Glutamic acid', 'Glu', 147.13074, 3.15, 2.1, 9.47, 'negative'],
        'F' => ['Phenylalanine', 'Phe', 165.19184, 5.49, 2.2, 9.31, 'hydrophobic aromatic'],
        'G' => ['Glycine', 'Gly', 75.06714, 6.06, 2.35, 9.78, 'hydrophobic'],
        'H' => ['Histidine', 'His', 155.15634, 7.6, 1.8, 9.33, 'positive aromatic'],
        'I' => ['Isoleucine', 'Ile', 131.17464, 6.05, 2.32, 9.76, 'hydrophobic aliphatic'],
        'K' => ['Lysine', 'Lys', 146.18934, 9.6, 2.16, 9.06, 'positive'],
        'L' => ['Leucine', 'Leu', 131.117464, 6.01, 2.33, 9.74, 'hydrophobic aliphatic'],
        'M' => ['Methionine', 'Met', 149.20784, 5.74, 2.13, 9.28, 'hydrophobic'],
        'N' => ['Asparagine', 'Asn', 132.11904, 5.41, 2.14, 8.72, 'polar'],
        'O' => ['Pyrrolysine', 'Pyl', 255.31, null, null, null, ''],
        'P' => ['Proline', 'Pro', 115.13194, 6.3, 1.95, 10.64, 'hydrophobic'],
        'Q' => ['Glutamine', 'Gln', 146.14594, 5.65, 2.17, 9.13, 'polar'],
        'R' => ['Arginine', 'Arg', 174.20274, 10.76, 1.82, 8.99, 'positive'],
        'S' => ['Serine', 'Ser', 105.09344, 5.68, 2.19, 9.21, 'polar'],
        'T' => ['Threonine', 'Thr', 119.12034, 5.6, 2.09, 9.1, 'polar'],
        'U' => ['Selenocysteine', 'Sec', 168.053, 5.47, null, null, ''],
        'V' => ['Valine', 'Val', 117.14784, 6.0, 2.39, 9.74, 'hydrophobic aliphatic'],
        'W' => ['Tryptophan', 'Trp', 204.22844, 5.89, 2.46, 9.41, 'hydrophobic aromatic'],
        'Y' => ['Tyrosine', 'Tyr', 181.19124, 5.64, 2.2, 9.21, 'polar']
    );


    $proteindb_attributes = array('hydrophobic', 'hydrophilic', 'negative', 'positive',
                                  'aromatic', 'aliphatic');

    /**
    * Decides if given amino acid has property $property. $name is one-character name
    **/
    function proteindb_is($name, $property) {
        global $proteindb_proteins;

        if ($property == 'hydrophilic')
            return (proteindb_is($name, 'polar') || proteindb_is($name, 'positive') || proteindb_is($name, 'negative'));

        return (!(strpos($proteindb_proteins[$name][6], $property) === false));
    }


    /**
    * Counts the number of amino acids in sequence with given property
    **/
    function proteindb_count_with_property($protein, $property) {
        global $proteindb_proteins;
        $amount = 0;
        for ($i=0; $i<strlen($protein); $i++)
            if (proteindb_is_amino_acid($protein[$i]))
                if (proteindb_is($protein[$i], $property)) $amount++;
        return $amount;
    }

    /**
    * Calculates mass in daltons.
    * $protein is a sequence of characters
    **/
    function proteindb_mass($protein) {
        global $proteindb_proteins;
        $mass = 0.0;
        for ($i=0; $i<strlen($protein); $i++) {
            $amino = $protein[$i];
            if (proteindb_is_amino_acid($amino))
                $mass += $proteindb_proteins[$amino][2];
        }

        // this is combined mass of these amino acids, but they are linked
         // Subtract water molecules from peptide bonds.

        $mass -= (proteindb_count_amino($protein) - 1) * 18.02;

        return $mass;
    }

    /**
    * Returns whether given character is a valid amino acid
    **/
    function proteindb_is_amino_acid($amino) {
        global $proteindb_proteins;
        return array_key_exists($amino, $proteindb_proteins);
    }

    /**
    * Counts the number of amino acids in a given sequence
    **/
    function proteindb_count_amino($protein) {
        $l = 0;
        for ($i=0; $i<strlen($protein); $i++)
            if (proteindb_is_amino_acid($protein[$i])) $l++;
        return $l;
    }

?>