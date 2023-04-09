<?php
class Battle_helpers
{

   public function make_group($army, $i, $groups)
   {
      $group_first_army = array();
      $end = false;
      foreach ($army->getWarriors() as $w1) {
         $count = 0;
         if (($i + 1) == $groups) {
            $value = $w1->getCount() - $count;
            $count += $value;
            $w1->setCount($w1->getCount() - $value);
            for ($j = 0; $j < $value; $j++) {
               $single_warrior = clone $w1;
               $single_warrior->setCount(1);
               array_push($group_first_army, $single_warrior);
            }
            $end = true;
         }
         if ($end == false) {
            $value = rand(0, (($w1->getCount() - $count)));
            $count += $value;
            $w1->setCount($w1->getCount() - $value);
            for ($j = 0; $j < $value; $j++) {
               $single_warrior = clone $w1;
               $single_warrior->setCount(1);
               array_push($group_first_army, $single_warrior);
            }
         }
      }
      //echo "V " . $i + 1 . ". skupině je " . count($group_first_army) . " válečníků. <br>";
      return ($group_first_army);
   }
   /**
    * Funkce, která dostane na vstup armádu a počet zdraví, ze kterého má vytvořit objekty vojáků.
    */
   function create_warriors_after_battle($army, $health)
   {
      $health = floor($health); //Zaokrouhlené zdraví
      $warriors_health = array();
      //Každého válečníka uloží do pole spolu s hodnotou, kolik má zdraví.
      foreach ($army->getWarriors() as $w1) {
         if (!in_array($w1->getHp(), array_keys($warriors_health))) {
            $warriors_health[$w1->getHp()] = $w1;
         }
      }
      $result = [];
      $count = 0;
      //Začne tvořit válečníky, dokud bude mít možnost přidělit zdraví.
      while ($count <= $health) {
         //Vybere náhodného válečníka
         $index = array_rand($warriors_health);
         $warrior = $warriors_health[$index];
         $new_count = $count + $warrior->getHp();
         //Pokud už není válečník s dostačujícím počtem zdraví, tak končí cyklus
         if ($new_count > $health) {
            break;
         }
         //Nastaví součet všech zdraví. (26->29), pokud přidá válečníka s 3 zdravím.
         $count = $new_count;
         //Přidá do pole výsledků válečníka
         (in_array($warrior, $result)) ? $warrior->setCount($warrior->getCount() + 1) : array_push($result, $warrior);
      }
      return ($result);
   }
   /**
    * Metoda na update armády po bitvě
    *
    * @param array $results Výsledky po bitvě
    * @param Army $army Armáda
    * @param int $number_of_army Kolikátá jest armáda
    */
   function update_single_army($results, $army, $number_of_army)
   {
      /* Inicializace nového pole */
      $army_new = array();
      /* Projde výsledky všech skupin */
      foreach ($results as $result) {
         /* Vezme jednotlivý výsledek a zaměří se na tu armádu, která je na vstupu. Začne projíždět válečníky */
         foreach ($result[$number_of_army - 1] as $survivor) {
            $found = false;
            /* Získá ID válečníka, který přežil */
            $id = $survivor->getId();
            /* Poté si vytvoří nový objekt válečníka, který odpovídá tomu v bitvě */
            $warrior_obj = $army->getWarriorById($id);
            /* A tomu také nastaví počet podle toho, kolik v bitvě zbylo válečníků */
            $warrior_obj->setCount($survivor->getCount());
            /* Začne projíždět list známých typů válečníků, takže třeba lukostřelec nebo kopiník */
            foreach ($army_new as $warrior) {
               /* Zjistí, jestli tento válečník již v poli je */
               if ($warrior->getId() === $survivor->getId()) {
                  /* Místo toho, aby ho přidal, updatne jeho počet */
                  $warrior->setCount($warrior->getCount() + $warrior_obj->getCount());
                  $found = true;
                  /* Přeruší hledání */
                  break;
               }
            }
            /* Pokud válečníka nenašel, vloží ho do pole */
            if ($found == false) {
               array_push($army_new, $warrior_obj);
            }
         }
      }
      return $army_new;
   }
}
