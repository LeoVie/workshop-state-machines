<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PullRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\ExceptionInterface;
use Symfony\Component\Workflow\StateMachine;

/**
 * @Route("/pr")
 */
class PullRequestController extends AbstractController
{
    public function __construct(private StateMachine $pullRequestStateMachine, private EntityManagerInterface $em)
    {
    }

    /**
     * @Route("", name="pull_request_index")
     */
    public function indexAction()
    {
        $pullRequests = $this->get('doctrine')->getRepository(PullRequest::class)->findAll();

        return $this->render('pull_request/index.html.twig', [
            'pull_requests' => $pullRequests,
        ]);
    }

    /**
     * @Route("/create", methods={"POST"}, name="pull_request_create")
     */
    public function createAction(Request $request)
    {
        $pullRequest = new PullRequest($request->request->get('name', 'First street'));

        $em = $this->get('doctrine')->getManager();
        $em->persist($pullRequest);
        $em->flush();

        return $this->redirect($this->generateUrl('pull_request_show', ['id' => $pullRequest->getId()]));
    }

    /**
     * @Route("/show/{id}", name="pull_request_show")
     */
    public function showAction(PullRequest $pullRequest)
    {
        // TODO add security to verify that the pull request has been submitted. If it is not submitted
        // it should only be accessable by the author. (We might need a security voter

        return $this->render('pull_request/show.html.twig', [
            'pull_request' => $pullRequest,
        ]);
    }

    /**
     * @Route("/pr-apply-transition/{id}", methods={"POST"}, name="pull_request_apply_transition")
     */
    public function applyTransitionAction(Request $request, PullRequest $pullRequest)
    {
        try {
            $this->pullRequestStateMachine
                ->apply($pullRequest, $request->request->get('transition'));

            $this->em->flush();
        } catch (ExceptionInterface $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirect(
            $this->generateUrl('pull_request_show', ['id' => $pullRequest->getId()])
        );
    }
}
