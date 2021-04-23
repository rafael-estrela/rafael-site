<?php

class SkillUtil {
    public static function skillArrayToDict($array) {
        $skills = array();

        foreach($array as $skill) {
            $skills[$skill->category][] = $skill;
        }

        return $skills;
    }

    public static function percentToStars($percent) {
        $stars = round($percent/10);
        $strStars = '';

        for($i = 0; $i < 10; $i++) {
            if ($i < $stars) {
                $strStars .= "&#9733; ";
            } else {
                $strStars .= "&#x2606; ";
            }
        }

        return $strStars;
    }
}