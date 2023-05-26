<?php
class DaysPast
{
    public static function daysPastMonth($months, $years)
    {
        $array = [];
        $first = getdate(mktime(0, 0, 0, $months, 1, $years));
        // retourne la date du 1er jour du months
        $ind = ($first['wday'] == 0 ? 6 : $first['wday'] - 1);
        // retourne le numéro d'ordre 1er jour du months
        $numberDay = date("t", mktime(0, 0, 0, $months, 1, $years));
        // retourne le nombre de jours du months

        // initialisation a blanc du tableau month 
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $month[$i][$j] = " ";
            }
        }

        // On rempli le tableau month avec les valeurs 
        $month[0] = array('Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
        $numweek = 1;
        for ($days = 1; $days <= $numberDay; $days++) {
            $month[$numweek][$ind] = $days;
            $ind++;
            if ($ind == 7) {
                $numweek++;
                $ind = 0;
            }
        }

        if ($months < 10) {
            $months = "0" . $months;
        }

        for ($week = 0; $week <= 6; $week++) {
            for ($jours = 0; $jours <= 6; $jours++) {
                $current = $month[$week][$jours];
                if (!is_string($month[$week][$jours])) {
                    if ($month[$week][$jours] < 10) {
                        $month[$week][$jours] = "0" . $month[$week][$jours];
                    }
                    $date = $years . "-" . $months . "-" . $month[$week][$jours];
                    array_push($array, $date);
                }
            }
        }
        return $array;
    }
}


?>