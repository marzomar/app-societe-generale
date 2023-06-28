<?php

namespace App\Controller;

use App\Entity\Choice;
use App\Entity\Combinaison;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaire', name: 'app_questionnaire', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        /** @var App\Entity\User $user */
        $user = $this->getUser();

        $session = $request->getSession();

        $combId = $session->get('combId') ?? [
            'choice1' => null,
            'choice2' => null,
            'choice3' => null,
            'choice4' => null,
        ];

        $currentCombinaison = $entityManager->getRepository(Combinaison::class)->findOneBy($combId );
        
        return $this->render('questionnaire/index.html.twig', [
            'controller_name' => 'QuestionnaireController',
            'currentCombinaison' => $currentCombinaison,
        ]);
    }

    #[Route('/questionnaire', name: 'app_questionnaire_post', methods: ['POST'])]
    public function post(EntityManagerInterface $entityManager, Request $request): Response
    {
        /** @var App\Entity\User $user */
        $user = $this->getUser();

        $session = $request->getSession();

        $combId = $session->get('combId') ?? [
            'choice1' => null,
            'choice2' => null,
            'choice3' => null,
            'choice4' => null,
        ];

        // get choice from form
        $choiceId = $request->request->get('choice');
        $choice = $entityManager->getRepository(Choice::class)->find($choiceId);

        if (!$choice) {
            throw $this->createNotFoundException('No choice found for id '.$choiceId);
        }

        if ($choice->getGoBack()) {
            $nbStepBack = $choice->getGoBack();
            for ($i = 4; $i > 0; $i--) {
                if ($combId['choice'.$i] !== null) {
                    $combId['choice'.$i] = null;
                    $nbStepBack--;
                }
                if ($nbStepBack === 0) {
                    break;
                }
            }
        } else {
            if ($combId['choice1'] === null) {
                $combId['choice1'] = $choiceId;
            } elseif ($combId['choice2'] === null) {
                $combId['choice2'] = $choiceId;
            } elseif ($combId['choice3'] === null) {
                $combId['choice3'] = $choiceId;
            } elseif ($combId['choice4'] === null) {
                $combId['choice4'] = $choiceId;
            }
        }

        $combinaison = $entityManager->getRepository(Combinaison::class)->findOneBy($combId);

        if (!$combinaison) {
            throw $this->createNotFoundException('No combinaison found for id '.json_encode($combId));
        }

        if ($combinaison->isOver()) {
            $user->setCombinaison($combinaison);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $session->set('combId', $combId);
        
        return $this->redirectToRoute('app_questionnaire');
    }

    #[Route('/questionnaire/reset', name: 'app_questionnaire_reset', methods: ['GET'])]
    public function reset(EntityManagerInterface $entityManager, Request $request): Response
    {
        /** @var App\Entity\User $user */
        $user = $this->getUser();

        $session = $request->getSession();

        $session->set('combId', [
            'choice1' => null,
            'choice2' => null,
            'choice3' => null,
            'choice4' => null,
        ]);
        
        return $this->redirectToRoute('app_questionnaire');
    }
}
