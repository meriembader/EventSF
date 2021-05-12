<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\EvenementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/espritApi")
 */
class EspritApiController extends AbstractController
{
    /**
     * @Route("/allFormaiton", methods={"GET"})
     */
    public function allFormation()
    {

        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formations);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/allEvenement", methods={"GET"})
     */
    public function allEvent()
    {

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($evenements);
        return new JsonResponse($formatted);
    }

}
