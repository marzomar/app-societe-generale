<?php

namespace App\DataFixtures;

use App\Entity\Association;
use App\Entity\Choice;
use App\Entity\Combinaison;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $jsonAssociations = json_decode(file_get_contents('C:/Users/WO/Desktop/script-questionnaires/resultat/associations.json'), true);
        $jsonQuestions = json_decode(file_get_contents('C:/Users/WO/Desktop/script-questionnaires/resultat/questions.json'), true);
        $jsonChoices = json_decode(file_get_contents('C:/Users/WO/Desktop/script-questionnaires/resultat/textes.json'), true);
        $jsonCombinaisons = json_decode(file_get_contents('C:/Users/WO/Desktop/script-questionnaires/resultat/combinaisons.json'), true);

        foreach ($jsonAssociations as $dat) {
            $asso = new Association();
            $asso->setName($dat['text']);
            $manager->persist($asso);
            $this->addReference('asso-' . $dat['id'], $asso);
        }

        foreach ($jsonQuestions as $dat) {
            $question = new Question();
            $question->setText($dat['text']);
            $manager->persist($question);
            $this->addReference('question-' . $dat['id'], $question);
        }

        $question = new Question();
        $question->setText('Fin du questionnaire');
        $manager->persist($question);
        $this->addReference('question-5', $question);

        foreach ($jsonChoices as $dat) {
            $choice = new Choice();
            $choice->setType($dat['type']);
            $choice->setText($dat['text']);
            $choice->setGoBack($dat['goBack'] ?? null);
            $manager->persist($choice);
            $this->addReference('choice-' . $dat['id'], $choice);
        }
        
        foreach ($jsonCombinaisons as $dat) {
            $combinaison = new Combinaison();
            $combinaison->setQuestion($this->getReference('question-' . $dat['questionId']));
            if ($dat['filtre1'] !== null) $combinaison->setChoice1($this->getReference('choice-' . $dat['filtre1']));
            if ($dat['filtre2'] !== null) $combinaison->setChoice2($this->getReference('choice-' . $dat['filtre2']));
            if ($dat['filtre3'] !== null) $combinaison->setChoice3($this->getReference('choice-' . $dat['filtre3']));
            if ($dat['filtre4'] !== null) $combinaison->setChoice4($this->getReference('choice-' . $dat['filtre4']));
            if ($dat['textes']) {
                foreach ($dat['textes'] as $texte) {
                    $combinaison->addNextChoice($this->getReference('choice-' . $texte));
                }
            }
            if ($dat['associations']) {
                foreach ($dat['associations'] as $association) {
                    $combinaison->addAssociation($this->getReference('asso-' . $association));
                }
            }
            $manager->persist($combinaison);
        }
        
        $user = new User();
        $user->setEmail('admin@localhost.dev');
        $user->setPassword($this->encoder->hashPassword($user, 'admin'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@locahost.dev');
        $user->setPassword($this->encoder->hashPassword($user, 'user'));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
