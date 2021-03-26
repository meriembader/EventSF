<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/calendarA/{id}", name="evenement_indexA", methods={"GET"})
     */
    public function indexA(EvenementRepository $evenementRepository, User $id )

    {

        $events = $evenementRepository->findBy(['id_user' => $id->getId()]);

        $rdvs = [];

        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'id_user'=> $event->getIdUser(),
                'start' => $event->getDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getFin()->format('Y-m-d H:i:s'),
                'title' => $event->getTitre(),
                'descp' => $event->getDescp(),
                'allDay' => $event->getAllDay(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('evenement/calendar.html.twig', compact('data'));
    }

    /**
     * @Route("/calendar", name="evenement_indexB", methods={"GET"})
     */
    public function indexB(EvenementRepository $evenementRepository)

    {

        $events = $evenementRepository->findAll();

        $rdvs = [];

        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'id_user'=> $event->getIdUser(),
                'start' => $event->getDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getFin()->format('Y-m-d H:i:s'),
                'title' => $event->getTitre(),
                'descp' => $event->getDescp(),
                'allDay' => $event->getAllDay(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('evenement/calendar.html.twig', compact('data'));
    }
    /**
     * @Route("/searchevenement", name="evenement_search")
     */
    public function searchFormation(Request $request)
    {
        $evenement=   $request->get('evenement');
        $em=$this->getDoctrine()->getManager();
        if($evenement == ""){
            $evenements=$em->getRepository(Evenement::class)->findAll();
        }else{
            $evenements=$em->getRepository(Evenement::class)->findBy(
                ['nom'=> $evenement]
            );
        }

        return $this->render('evenement/indexR.html.twig', array(
            'evenements' => $evenements
        ));

    }

    /**
     * @Route("/calendarFront", name="evenement_indexFront", methods={"GET"})
     */
    public function indexFront(EvenementRepository $evenementRepository)

    {

        $events = $evenementRepository->findAll();

        $rdvs = [];

        foreach ($events as $event) {
            $rdvs[] = [
                'id' => $event->getId(),
                'id_user'=> $event->getIdUser(),
                'start' => $event->getDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getFin()->format('Y-m-d H:i:s'),
                'title' => $event->getTitre(),
                'descp' => $event->getDescp(),
                'allDay' => $event->getAllDay(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('evenement/calendarFrontOffice.html.twig', compact('data'));
    }





    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();

        // Paginate the results of the query
        $evenements = $paginator->paginate(
        // Doctrine Query, not results
            $evenements,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);


    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }
}
