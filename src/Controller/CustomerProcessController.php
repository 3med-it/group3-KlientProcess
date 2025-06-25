// src/Controller/CustomerProcessController.php
namespace App\Controller;

use App\Entity\CustomerProcess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

class CustomerProcessController extends AbstractController
{
    #[Route('/process/{id}', methods:['GET'])]
    public function show(
        CustomerProcess $process,
        Registry $workflows
    ): Response {
        $workflow = $workflows->get($process);
        $enabled = $workflow->getEnabledTransitions($process);
        return $this->render('process/show.html.twig', [
            'process'      => $process,
            'transitions'  => $enabled,
        ]);
    }

    #[Route('/process/{id}/transition', methods:['POST'])]
    public function transition(
        CustomerProcess $process,
        Request $request,
        Registry $workflows,
        EntityManagerInterface $em
    ): Response {
        $next = $request->request->get('transition');
        $workflow = $workflows->get($process);

        // Voter prüft automatisch via isGranted()
        $this->denyAccessUnlessGranted($next, $process);

        if ($workflow->can($process, $next)) {
            $workflow->apply($process, $next);
            $em->flush();
            $this->addFlash('success', "Transition „{$next}“ durchgeführt.");
        } else {
            $this->addFlash('warning', "Übergang „{$next}“ nicht erlaubt.");
        }

        return $this->redirectToRoute('process_show', ['id' => $process->getId()]);
    }
}
