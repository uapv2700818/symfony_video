<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Message\MessageEnvoye;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        MessageBusInterface $bus
    ): Response {
        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            $bus->dispatch(
                new MessageEnvoye($message->getContenu())
            );

            $this->addFlash(
                'success',
                'Message enregistré en base. Une copie a été écrite dans var/messages.log par Messenger.'
            );

            return $this->redirectToRoute('app_message');
        }

        return $this->render('message/index.html.twig', [
            'form' => $form,
        ]);
    }
}